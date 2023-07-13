<?php

@session_start();

class IntegracaoExterna
{

    public function __construct()
    {
    }

    public function getXml()
    {
        $hash = Http::get_in_params("getXml");
        $hash = $hash->value ?? "";

        if (empty($hash)) {
            echo "Integração inválida. Code: 01";
            exit;
        }



        $xml = IntegracaoExterna::generateXml($hash);
        if ($xml['status'] != "success") {
            echo $xml['msg'];
            exit;
        }

        @header('Content-Type: application/xml; charset=utf-8');
        echo utf8_encode($xml['content']);
    }

    public static function generateXml($hash)
    {
        try {
            $config = (new Config)->get();

            $integracao = (new Orm("integracao"))
                ->where("integracao_status = 1 AND integracao_public_link = '" . $hash . "'")
                ->get();

            if (!isset($integracao[0])) {
                throw new Exception("Integração inválida. Code: 02");
            }

            $integracao = $integracao[0];

            $imoveis = (new Orm("integracao_imovel"))
                ->select("*,
                    CASE integracao_imovel_destaque
                    WHEN 'padrao' THEN 'STANDARD'
                    WHEN 'destaque' THEN 'PREMIUM'
                    WHEN 'super_destaque' THEN 'SUPER_PREMIUM'
                    WHEN 'destaque_especial' THEN 'PREMIERE_1'
                    END AS integracao_imovel_destaque_zap
                ")
                ->join("imovel", "imovel_id = integracao_imovel_imovel_id")
                ->join("bairro", 'bairro_id = imovel_bairro_id', 'left')
                ->join("condominio", 'condominio_id = imovel_condominio_id', 'left')
                ->join("cidade", "cidade_id = bairro_cidade", 'left')
                ->join("uf", 'uf_id = cidade_uf', 'left')
                ->join("categoria_imovel", 'imovel_categoria = categoria_imovel_id', 'left')
                ->where("integracao_imovel_integracao_id = '" . $integracao->integracao_id . "' AND imovel_status = 1")
                ->get();

            if (!isset($imoveis[0])) {
                throw new Exception("Integração inválida. Code: 03");
            }

            $url = Http::base();
            $rota_imovel = $url . "/imovel/ver/";

            $conteudo = "";
            $conteudo .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<ListingDataFeed xmlns=\"http://www.vivareal.com/schemas/1.0/VRSync\"
                 xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
                 xsi:schemaLocation=\"http://www.vivareal.com/schemas/1.0/VRSync  http://xml.vivareal.com/vrsync.xsd\">\n
                <Header>
                <Provider>" . utf8_decode($config->config_site_title) . "</Provider>
                <Email>" . utf8_decode($config->config_site_email) . "</Email>
                <ContactName>" . utf8_decode($config->config_site_title) . "</ContactName>
                <Logo>$url/media/default/{$config->config_site_logo}</Logo>
                <Telephone>{$config->config_site_telefone}</Telephone>
                </Header>\n
                <Listings>\n\n";

            foreach ($imoveis as $imovel) {

                $fotos = (new Orm('foto_imovel'))
                    ->where("foto_imovel_imovel = $imovel->imovel_id")
                    ->order("foto_imovel_pos ASC")
                    ->get();

                $fotos_cond = (new Orm('foto_condominio'))
                    ->select('foto_condominio_id, foto_condominio_pos, foto_condominio_img, foto_condominio_url')
                    ->where("foto_condominio_condominio = '" . $imovel->imovel_condominio_id . "'")
                    ->order('foto_condominio_pos ASC')
                    ->get();

                $atributos = (new Orm('atributo_imovel'))
                    ->join("atributo", "atributo_id = atributo_imovel_atributo_id")
                    ->where("atributo_imovel_imovel_id = $imovel->imovel_id")
                    ->get();

                $caracteristicas = (new Orm('imovel_caracteristica'))
                    ->join("caracteristica", "caracteristica_id = imovel_caracteristica_caracteristica_id")
                    ->where("imovel_caracteristica_imovel_id = $imovel->imovel_id")
                    ->get();

                // condominio
                if(!empty($imovel->imovel_condominio_id)) {
                    $caracteristicas_condominio = (new Orm('condominio_caracteristica'))
                        ->join("caracteristica", "caracteristica_id = condominio_caracteristica_caracteristica_id")
                        ->where("condominio_caracteristica_condominio_id = $imovel->imovel_condominio_id")
                        ->get();

                    if(isset($caracteristicas_condominio[0])) {
                        // $caracteristicas = array_merge($caracteristicas, $caracteristicas_condominio);
                        foreach($caracteristicas_condominio as $car) {
                            $caracteristicas[] = $car;
                        }
                    }
                }




                $caracteristicas_traducao = IntegracaoExterna::getZapFeatures();
                $caracteristicas_originais = IntegracaoExterna::getNewZapFeatures();

                $caracteristicas_traduzidas = [];

                if (isset($caracteristicas[0])) {
                    foreach ($caracteristicas as $c) {
                        if (isset($caracteristicas_traducao[trim($c->caracteristica_nome)])) {
                            // && isset($caracteristicas_originais[$caracteristicas_traducao[$c->caracteristica_nome]])
                            $caracteristicas_traduzidas[] = $caracteristicas_traducao[trim($c->caracteristica_nome)];
                        }
                    }
                }

                // Filter::pre($caracteristicas_traduzidas, 1);

                $quartos = $imovel->imovel_quartos;
                $suites = $imovel->imovel_suites;
                $banheiros = $imovel->imovel_banheiros;
                $vagas = $imovel->imovel_vagas;

                $area_util = $imovel->imovel_area_util;
                $area_total = $imovel->imovel_area_total;

                // if (isset($atributos[0])) {
                //     foreach ($atributos as $atributo) {
                //         if (strtolower($atributo->atributo_nome) == "quartos") {
                //             $quartos = intval($atributo->atributo_imovel_valor);
                //         }
                //         if (strtolower($atributo->atributo_nome) == "suites") {
                //             $suites = intval($atributo->atributo_imovel_valor);
                //         }
                //         if (strtolower($atributo->atributo_nome) == "banheiros") {
                //             $banheiros = intval($atributo->atributo_imovel_valor);
                //         }
                //         if (strtolower($atributo->atributo_nome) == "vagas") {
                //             $vagas = intval($atributo->atributo_imovel_valor);
                //         }
                //         if (strtolower($atributo->atributo_nome) == "área útil") {
                //             $area_util = floatval($atributo->atributo_imovel_valor);
                //         }
                //         if (strtolower($atributo->atributo_nome) == "área total") {
                //             $area_total = floatval($atributo->atributo_imovel_valor);
                //         }
                //     }
                // }

                $featured = ($imovel->imovel_destaque == 0) ? 'false' : 'true';
                $conteudo .= '  <Listing>' . "\n";
                $conteudo .= '<PublicationType>'. $imovel->integracao_imovel_destaque_zap .'</PublicationType>' . "\n";
                if($imovel->imovel_link_tour) {
                    $conteudo .= '<VirtualTourLink>'. $imovel->imovel_link_tour .'</VirtualTourLink>' . "\n";
                }

                $conteudo .= '<Title><![CDATA[' . utf8_decode($imovel->imovel_titulo) . ']]></Title>' . "\n";
                $conteudo .= '<ListingID>' . $imovel->imovel_ref . '</ListingID>' . "\n";
                if ($imovel->imovel_tipo_negociacao == "venda") {
                    $conteudo .= '<TransactionType>For Sale</TransactionType>' . "\n";
                } else if ($imovel->imovel_tipo_negociacao == "venda") {
                    $conteudo .= '<TransactionType>For Sale</TransactionType>' . "\n";
                } else {
                    $conteudo .= '<TransactionType>Sale/Rent</TransactionType>' . "\n";
                }

                $conteudo .= '     <Featured>' . $featured . '</Featured>' . "\n";
                $conteudo .= '     <DetailViewUrl>' . $rota_imovel . $imovel->imovel_id . '</DetailViewUrl>' . "\n";






                if (isset($fotos[0]) && $imovel->imovel_mostra_fotos == 1) {
                    $conteudo .= ' <Media>' . "\n";
                    if($imovel->imovel_video) {
                        $conteudo .= '<Item medium="video">' . $imovel->imovel_video . '</Item>' . "\n";
                    }
                    foreach ($fotos as $k => $foto) {
                        if($k == 0) {
                            // $conteudo .= '<Item medium="image" caption="' . $foto->foto_imovel_img . '" primary="true">' . $url . '/media/imovel/watermark_' . $foto->foto_imovel_img . '?cache=' . rand(0, 5000) . '</Item>' . "\n";
                            $conteudo .= '<Item medium="image" caption="' . $foto->foto_imovel_img . '" primary="true">' . $url . '/media/imovel/watermark_' . $foto->foto_imovel_img . '</Item>' . "\n";
                        } else {
                            // $conteudo .= '<Item medium="image" caption="' . $foto->foto_imovel_img . '">' . $url . '/media/imovel/watermark_' . $foto->foto_imovel_img . '?cache=' . rand(0, 50000) . '</Item>' . "\n";
                            $conteudo .= '<Item medium="image" caption="' . $foto->foto_imovel_img . '">' . $url . '/media/imovel/watermark_' . $foto->foto_imovel_img . '</Item>' . "\n";
                        }
                    }

                    if(isset($fotos_cond[0])) {
                        foreach ($fotos_cond as $k => $foto) {
                            // $conteudo .= '<Item medium="image" caption="' . $foto->foto_condominio_img . '">' . $url . '/media/condominio/watermark_' . $foto->foto_condominio_img . '?cache=' . rand(0, 50000) . '</Item>' . "\n";
                            $conteudo .= '<Item medium="image" caption="' . $foto->foto_condominio_img . '">' . $url . '/media/condominio/watermark_' . $foto->foto_condominio_img . '</Item>' . "\n";
                        }
                    }
                    $conteudo .= '</Media>' . "\n";
                }

                // negociação
                // switch ($imovel->imovel_tipo_negociacao) {
                //     case "venda":
                //         $conteudo .= '<TransactionType>For Sale</TransactionType>' . "\n";
                //         break;
                //     case "aluguel":
                //         $conteudo .= '<TransactionType>For Rent</TransactionType>' . "\n";
                //         break;
                //     case "venda_aluguel":
                //         $conteudo .= '<TransactionType>Sale/Rent</TransactionType>' . "\n";
                //         break;
                // }

                $conteudo .= '<Details>' . "\n";

                switch ($imovel->categoria_imovel_nome) {
                    case 'Apartamento':
                        $conteudo .= '<PropertyType>Residential / Apartment</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    case 'Casa':
                        $conteudo .= '<PropertyType>Residential / Home</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    case 'Casa de Condomínio':
                        $conteudo .= '<PropertyType>Residential / Condo</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    case 'Casa de Vila':
                        $conteudo .= '<PropertyType>Residential / Condo</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    case 'Cobertura':
                        $conteudo .= '<PropertyType>Residential / Penthouse</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;

                    case 'Fazenda/Sítio/Chácara':
                        $conteudo .= '<PropertyType>Commercial / Agricultural</PropertyType>' . "\n";
                        $conteudo .= '<LotArea unit="square metres">' . $area_util . '</LotArea>' . "\n";
                        break;
                    case 'Flat':
                        $conteudo .= '<PropertyType>Residential / Flat</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    case 'Kitnet/Conjugado':
                        $conteudo .= '<PropertyType>Residential / Kitnet</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    case 'Loft':
                        $conteudo .= '<PropertyType>Residential / Loft</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    case 'Prédio/Edifício':
                        $conteudo .= '<PropertyType>Commercial / Residential Income</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    case 'Studio':
                        $conteudo .= '<PropertyType>Studio</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    case 'Escritório':
                        $conteudo .= '<PropertyType>Commercial / Building</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    case 'Galpão/Depósito/Armazém':
                        $conteudo .= '<PropertyType>Commercial / Industrial</PropertyType>' . "\n";
                        $conteudo .= '<LotArea unit="square metres">' . $area_util . '</LotArea>' . "\n";
                        break;
                    case 'Garagem':
                        $conteudo .= '<PropertyType>Commercial / Industrial</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;

                    case 'Hotel/Motel/Pousada':
                        $conteudo .= '<PropertyType>Commercial / Loja</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    case 'Lote/Terreno':
                        $conteudo .= '<PropertyType>Residential / Land Lot</PropertyType>' . "\n";
                        $conteudo .= '<LotArea unit="square metres">' . $area_util . '</LotArea>' . "\n";
                        break;
                    case 'Ponto comercial/Loja/Box':
                        $conteudo .= '<PropertyType>Commercial / Loja</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                    default:
                        $conteudo .= '<PropertyType>Residential / Apartment</PropertyType>' . "\n";
                        $conteudo .= '<LivingArea unit="square metres">' . $area_util . '</LivingArea>' . "\n";
                        break;
                }

                if (empty($imovel->imovel_desc)) {
                    $imovel->imovel_desc = "Imóvel disponível";
                }
                $conteudo .= '<Description><![CDATA[' . utf8_decode(self::cut(trim($imovel->imovel_desc), 2900, '...')) . ']]></Description>' . "\n";
                // valor da negociação
                // switch ($imovel->imovel_tipo_negociacao) {
                //     case "venda":
                //         $conteudo .= '<ListPrice currency="BRL">' . $imovel->imovel_valor_venda . '</ListPrice>' . "\n";
                //         break;
                //     case "aluguel":
                //         $conteudo .= '<RentalPrice currency="BRL" period="Monthly">' . $imovel->imovel_valor_locacao . '</RentalPrice>' . "\n";
                //         break;
                //     case "venda_aluguel":
                //         $conteudo .= '<ListPrice currency="BRL">' . $imovel->imovel_valor_venda . '</ListPrice>' . "\n";
                //         $conteudo .= '<RentalPrice currency="BRL" period="Monthly">' . $imovel->imovel_valor_locacao . '</RentalPrice>' . "\n";
                //         break;
                // }
                if ($imovel->imovel_tipo_negociacao == "venda") {
                    if ($imovel->imovel_valor_venda <= 0) {
                        $imovel->imovel_valor_venda = 1;
                    }
                    $conteudo .= '<ListPrice currency="BRL">' . $imovel->imovel_valor_venda . '</ListPrice>' . "\n";
                } else if($imovel->imovel_tipo_negociacao == "aluguel") {
                    if ($imovel->imovel_valor_locacao <= 0) {
                        $imovel->imovel_valor_locacao = 1;
                    }
                    $periodo = "Monthly";
                    if($imovel->imovel_temporada == 1) {
                        $periodo = "Daily";
                    }
                    $conteudo .= '<RentalPrice currency="BRL" period="'. $periodo .'">' . $imovel->imovel_valor_locacao . '</RentalPrice>' . "\n";
                } else {
                    // ambos
                    if ($imovel->imovel_valor_venda <= 0) {
                        $imovel->imovel_valor_venda = 1;
                    }
                    $conteudo .= '<ListPrice currency="BRL">' . $imovel->imovel_valor_venda . '</ListPrice>' . "\n";
                    if ($imovel->imovel_valor_locacao <= 0) {
                        $imovel->imovel_valor_locacao = 1;
                    }
                    $periodo = "Monthly";
                    if($imovel->imovel_temporada == 1) {
                        $periodo = "Daily";
                    }
                    $conteudo .= '<RentalPrice currency="BRL" period="'. $periodo .'">' . $imovel->imovel_valor_locacao . '</RentalPrice>' . "\n";
                }

                // $conteudo .= '<PropertyAdministrationFee currency="BRL"></PropertyAdministrationFee>' . "\n";
                // $conteudo .= '<YearlyTax currency="BRL"></YearlyTax>' . "\n";
                $conteudo .= '<Bedrooms>' . $quartos . '</Bedrooms>' . "\n";
                $conteudo .= '<Bathrooms>' . $banheiros . '</Bathrooms>' . "\n";
                $conteudo .= '<Suites>' . $suites . '</Suites>' . "\n";
                $conteudo .= '<UnitFloor>' . $imovel->imovel_andar . '</UnitFloor>' . "\n";
                if($imovel->condominio_qtd_andar) {
                    $conteudo .= '<Floors>' . $imovel->condominio_qtd_andar . '</Floors>' . "\n";
                }
                if($imovel->condominio_qtd_torres) {
                    $conteudo .= '<Buildings>' . $imovel->condominio_qtd_torres . '</Buildings>' . "\n";
                }
                $conteudo .= '<YearBuilt>' . $imovel->imovel_ano_construcao . '</YearBuilt>' . "\n";
                if($imovel->imovel_isento_condominio == 0 && $imovel->imovel_valor_condominio > 0) {
                    $conteudo .= '<PropertyAdministrationFee currency="BRL">' . $imovel->imovel_valor_condominio . '</PropertyAdministrationFee>' . "\n";
                }
                if($imovel->imovel_isento_iptu == 0 && $imovel->imovel_valor_iptu > 0) {
                    $conteudo .= '<YearlyTax currency="BRL">' . $imovel->imovel_valor_iptu . '</YearlyTax>' . "\n";
                }

                $conteudo .= '<Garage type="Parking Space">' . $vagas . '</Garage>' . "\n";

                if (isset($caracteristicas_traduzidas[0])) {
                    $conteudo .= '<Features>' . "\n";
                    foreach ($caracteristicas_traduzidas as $c) {
                        $conteudo .= "   <Feature>" . $c . "</Feature>" . "\n";
                    }
                    $conteudo .= '</Features>' . "\n";
                }

                if ($imovel->imovel_num_view == 0) {
                    $imovel->imovel_num = "";
                }
                if ($imovel->imovel_complemento_view == 0) {
                    $imovel->imovel_complemento = "";
                }

                if (empty($imovel->imovel_cep)) {
                    $imovel->imovel_cep = $config->config_site_cep;
                }

                $conteudo .= '</Details>' . "\n";
                $conteudo .= '<Location displayAddress="All">' . "\n";
                $conteudo .= '<Country abbreviation="BR">Brasil</Country>' . "\n";
                $conteudo .= '<State abbreviation="' . $imovel->imovel_uf . '"><![CDATA[' . self::get_estado_by_uf($imovel->imovel_uf) . ']]></State>' . "\n";
                $conteudo .= '<City><![CDATA[' . $imovel->imovel_cidade . ']]></City>' . "\n";
                $conteudo .= '<Neighborhood><![CDATA[' . $imovel->imovel_bairro . ']]></Neighborhood>' . "\n";
                $conteudo .= '<Address><![CDATA[' . $imovel->imovel_rua . ']]></Address>' . "\n";
                $conteudo .= '<StreetNumber>' . $imovel->imovel_num . '</StreetNumber>' . "\n";
                $conteudo .= '<Complement><![CDATA[' . $imovel->imovel_complemento . ']]></Complement>' . "\n";
                $conteudo .= '<PostalCode>' . $imovel->imovel_cep . '</PostalCode>' . "\n";
                $conteudo .= '<Latitude>' . $imovel->imovel_latitude . '</Latitude>' . "\n";
                $conteudo .= '<Longitude>' . $imovel->imovel_longitude . '</Longitude>' . "\n";
                $conteudo .= '</Location>' . "\n";
                $conteudo .= '<ContactInfo>' . "\n";
                $conteudo .= '<Name><![CDATA[' . $config->config_site_title . ']]></Name>' . "\n";
                $conteudo .= '<Email>' . $config->config_site_email . '</Email>' . "\n";
                $conteudo .= '<Website>' . $url . '</Website>' . "\n";
                $conteudo .= '<Photo>' . $url . '/media/site/' . $config->config_site_logo . '</Photo>' . "\n";
                $conteudo .= '<Logo>' . $url . '/media/site/' . $config->config_site_logo . '</Logo>' . "\n";
                $conteudo .= '<OfficeName>' . $config->config_site_title . '</OfficeName>' . "\n";
                $conteudo .= '<Telephone>' . $config->config_site_telefone . '</Telephone>' . "\n";
                $conteudo .= '<Location>' . "\n";
                $conteudo .= '<Country abbreviation="BR">Brasil</Country>' . "\n";
                $conteudo .= '<State abbreviation="' . $config->config_site_uf . '">' .  self::get_estado_by_uf($config->config_site_uf) . '</State>' . "\n";
                $conteudo .= '<City><![CDATA[' . $config->config_site_cidade . ']]></City>' . "\n";
                $conteudo .= '<Neighborhood><![CDATA[' . $config->config_site_bairro . ']]></Neighborhood>' . "\n";
                $conteudo .= '<Address><![CDATA[' . $config->config_site_rua . ']]></Address>' . "\n";
                $conteudo .= '<PostalCode>' . $imovel->imovel_cep . '</PostalCode>' . "\n";
                // $conteudo .= '<Latitude>' . $config->config_lat . '</Latitude>' . "\n";
                // $conteudo .= '<Longitude>' . $config->config_lon . '</Longitude>' . "\n";
                $conteudo .= '</Location>' . "\n";
                $conteudo .= '</ContactInfo>' . "\n";
                $conteudo .= '</Listing>' . "\n";
            }
            $conteudo .= "\n</Listings></ListingDataFeed>";
            return ['status' => 'success', 'content' => $conteudo];
        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }
    }

    public static function cut($str, $chars, $info)
    {
        try {
            $str = strip_tags($str);
            if (strlen($str) >= $chars) {
                $str = preg_replace('/\s\s+/', ' ', $str);
                $str = preg_replace('/\s\s+/', ' ', $str);
                $str = substr($str, 0, $chars);
                $str = preg_replace('/\s\s+/', ' ', $str);
                $arr = explode(' ', $str);
                array_pop($arr);
                $final = implode(' ', $arr) . $info;
            } else {
                $final = $str;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        return $final;
    }

    public static function get_estado_by_uf($uf)
    {
        if(empty($uf)) {
            return "RJ";
        }
        $estados = [
            "AC" => "Acre",
            "AL" => "Alagoas",
            "AM" => "Amazonas",
            "AP" => "Amapá",
            "BA" => "Bahia",
            "CE" => "Ceará",
            "DF" => "Distrito Federal",
            "ES" => "Espírito Santo",
            "GO" => "Goiás",
            "MA" => "Maranhão",
            "MT" => "Mato Grosso",
            "MS" => "Mato Grosso do Sul",
            "MG" => "Minas Gerais",
            "PA" => "Pará",
            "PB" => "Paraíba",
            "PR" => "Paraná",
            "PE" => "Pernambuco",
            "PI" => "Piauí",
            "RJ" => "Rio de Janeiro",
            "RN" => "Rio Grande do Norte",
            "RO" => "Rondônia",
            "RS" => "Rio Grande do Sul",
            "RR" => "Roraima",
            "SC" => "Santa Catarina",
            "SE" => "Sergipe",
            "SP" => "São Paulo",
            "TO" => "Tocantins"
        ];
        return $estados["$uf"];
    }

    public static function getNewZapFeatures()
    {
        return ['Fully Wired', 'Generator', 'RV Parking', 'BBQ', 'Bar', 'Backyard', 'Alarm System', 'Gated Community', '24 Hour Security', 'TV Security', 'Doorman', 'Fire Alarm', 'Kitchen', 'Basement', 'Living Room', 'Dining Room', 'Study', 'Storage Room', 'Rooms', 'Hard Wood Floor', 'Carpeted Floor', 'Ceramic Tile', 'Steam Room', 'Internet Connection', 'Satellite Television', 'Cable Television', "Maid's Quarters", 'Exterior View', 'Natural Gas', 'Private Elevator', 'Elevator', 'Heating', 'Air Conditioning', 'Cooling', 'Ceiling Fan', 'Intercom', 'Marble/Granite', 'Parking Places', 'Parking Garage', 'Garden', 'Jacuzzi/Hot Tub', 'Balcony/Terrace', 'Pool', 'Fireplace', 'Wet Bar', 'Deck', 'Lawn', 'Front Porch', 'Corner Lot', 'Landscaping', 'Lake View', 'Mountain View', 'Ocean View', 'Golf Course', 'Water View', 'Estrato', 'Close to main roads/avenues', 'Close to shopping centers', 'Close to public transportation', 'Close to schools', 'Close to hospitals', 'Gravel', 'Balcony', 'Warehouse', 'Furnished', 'Laundry', 'Home Office', 'Reflective Pool', 'Number of stories', 'Pay-per-use Services', 'Controlled Access', 'Security Guard on Duty', 'Fenced Yard', 'Gym', 'Garden Area', 'Party Room', 'Gourmet Area', 'Playground', 'Sports Court', 'Media Room', 'Tennis court', 'Green space / Park', 'Game room', 'Reception room', 'Band Practice Room', 'Massage', 'Sauna', 'Jogging track', 'Spa', 'Squash', 'Veranda', 'Gourmet Balcony', 'Edicule', 'Meeting Room', 'Geminada', 'Barbecue Balcony', 'Recreation Area', 'Gourmet Kitchen', 'Lunch Room', 'Massage Room', 'Paved Street', 'Patrol', 'Water Tank', 'Indoor Soccer', 'Square', 'Mezzanine', 'Stair', 'Administration', 'Eco Garbage Collector', 'Smart Condominium', 'Eco Condominium', 'Solar Energy', 'Beauty Room', 'Fitness Room', 'Digital Locker', 'Armored Security Cabin', 'Stores', 'Valet Parking', 'Semi Olympic Pool', 'Sand Pit', 'Caretaker', 'Caretaker House', 'Smart Apartment', 'Bicycles Place', 'Large Kitchen', 'Integrated Environments', 'Pet Space', 'Large Window', 'Bar', 'Bathtub'];
    }

    public static function getZapFeatures()
    {
        return [
            "Administração" => "Administration",
            "Sistema de alarme" => "Alarm System",
            "Guarita blindada" => "Armored Security Cabin",
            "Quintal" => "Backyard",
            "Varanda" => "Balcony",
            "Garage band" => "Band Practice Room",
            "Banheira" => "Bathtub",
            "Bar" => "Bar",
            "Churrasqueira na varanda" => "Barbecue Balcony",
            "Churrasqueira" => "BBQ",
            "Espaço de beleza" => "Beauty Room",
            "Bicicletário" => "Bicycles Place",
            "Armário embutido" => "Builtin Wardrobe",
            "Zelador" => "Caretaker",
            "Casa de caseiro" => "Caretaker House",
            "TV a cabo" => "Cable Television",
            "Perto de hospitais" => "Close to hospitals",
            "Perto de vias de acesso" => "Close to main roads/avenues",
            "Perto de transporte público" => "Close to public transportation",
            "Perto de Escolas" => "Close to schools",
            "Perto de Shopping Center" => "Close to shopping centers",
            "Closet" => "Closet",
            "Vigia" => "Controlled Access",
            "Ar condicionado" => "Cooling",
            "Copa" => "Copa",
            "Fechadura digital" => "Digital Locker",
            "Sala de jantar" => "Dinner Room",
            "Condomínio sustentável" => "Eco Condominium",
            "Coleta seletiva de lixo" => "Eco Garbage Collector",
            "Edícula" => "Edicule",
            "Carregador eletrônico para carro e bicicleta" => "Eletric Charger",
            "Elevador" => "Elevator",
            "Vista exterior" => "Exterior View",
            "Condomínio fechado" => "Fenced Yard",
            "Lareira" => "Fireplace",
            "Espaço fitness" => "Fitness Room",
            "Mobiliado" => "Furnished",
            "Salão de jogos" => "Game room",
            "Jardim" => "Garden Area",
            "Geminada" => "Geminada",
            "Espaço gourmet" => "Gourmet Area",
            "Varanda gourmet" => "Gourmet Balcony",
            "Cozinha Gourmet" => "Gourmet Kitchen",
            "Cascalho" => "Gravel",
            "Espaço verde / Parque" => "Green space / Park",
            "Academia" => "Gym",
            "Aquecimento" => "Heating",
            "Escritório" => "Home Office",
            "Quadra de futebol" => "Indoor Soccer",
            "Ambientes integrados" => "Integrated Environments",
            "Interfone" => "Intercom",
            "Conexão à internet" => "Internet Connection",
            "Pista de cooper" => "Jogging track",
            "Cozinha" => "Kitchen",
            "Armário na cozinha" => "Kitchen Cabinets",
            "Vista para lago" => "Lake View",
            "Terra" => "Land",
            "Cozinha grande" => "Large Kitchen",
            "Janela grande" => "Large Window",
            "Lavanderia" => "Laundry",
            "Gramado" => "Lawn",
            "Sala de almoço" => "Lunch Room",
            "Área de serviço" => "Maid's Quarters",
            "Sala de massagem" => "Massage Room",
            "Cinema" => "Media Room",
            "Sala de reunião" => "Meeting Room",
            "Mezanino" => "Mezzanine",
            "Vista para a montanha" => "Mountain View",
            "Mais de um andar" => "Number of stories",
            "Vista para o mar" => "Ocean View",
            "Garagem" => "Parking Garage",
            "Salão de Festas" => "Party Room",
            "Ronda/Vigilância" => "Patrol",
            "Rua asfaltada" => "Paved Street",
            "Serviço pay per use" => "Pay-per-use Services",
            "Permite animais" => "Pets Allowed",
            "Espaço Pet" => "Pet Space",
            "Playground" => "Playground",
            "Piscina" => "Pool",
            "Recepção" => "Reception room",
            "Área de lazer" => "Recreation Area",
            "Espelhos d'água" => "Reflective Pool",
            "Quadra de areia" => "Sand Pit",
            "Sauna" => "Sauna",
            "Segurança 24h" => "Security Guard on Duty",
            "Piscina semi-olímpica" => "Semi Olympic Pool",
            "Apartamento inteligente" => "Smart Apartment",
            "Condomínio inteligente" => "Smart Condominium",
            "Energia solar" => "Solar Energy",
            "Spa" => "Spa",
            "Quadra poliesportiva" => "Sports Court",
            "Praça" => "Square",
            "Quadra de squash" => "Squash",
            "Escada" => "Stair",
            "Loja" => "Stores",
            "Quadra de tênis" => "Tennis court",
            "Circuito de segurança" => "TV Security",
            "públicos essenciais" => "Utilities",
            "Manobrista" => "Valet Parking",
            "Depósito" => "Warehouse",
            "Reservatório de água" => "Water Tank",
        ];
    }

    public static function migrationFeatures()
    {

        $caracteristicas_zap = self::getZapFeatures();

        $caracteristicas_atuais = (new Orm('caracteristica'))->where("caracteristica_tipo = 'imovel'")->get();


        foreach ($caracteristicas_atuais as $key => $caracteristica) {
            //se não existir essa caracteristica atual na lista de caracteristicas do zap, dropa-la
            if (!isset($caracteristicas_zap[$caracteristica->caracteristica_nome])) {

                //tabela de caracteristicas
                (new Orm('caracteristica'))
                    ->where("caracteristica_id = '" . $caracteristica->caracteristica_id . "'")
                    ->drop();

                //tabela de ligação caracteristicas imoveis
                (new Orm('imovel_caracteristica'))
                    ->where("imovel_caracteristica_caracteristica_id = '" . $caracteristica->caracteristica_id  . "'")
                    ->drop();
            }
        }

        foreach ($caracteristicas_zap as $key => $caracteristica) {
            $caracteristica_atual = (new Orm('caracteristica'))
                ->where("caracteristica_nome = '" . Filter::parse_string($key) . "' and caracteristica_tipo = 'imovel'")
                ->get();

            //se nao existir a caracteristica do zap do banco inseri-la

            if (!isset($caracteristica_atual[0])) {
                (new Orm('caracteristica'))->with(["caracteristica_nome" => Filter::parse_string($key), 'caracteristica_categoria_id' => 1])->save();
            }
        }
        return $caracteristicas_atuais;
    }
}
