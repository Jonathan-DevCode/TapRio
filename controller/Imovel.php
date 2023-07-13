<?php


class Imovel
{
    private $mobile_label_page = "";
    public function __construct()
    {


        // caso seja requisitado por mobile, renderiza a view mobile
        if (Browser::agent('mobile')) {
            $this->mobile_label_page = "mobile_";
        }
    }

    public function ver()
    {
        $id_imovel = Http::get_in_params("ver", 'int');
        if (!isset($id_imovel->value)) {
            http::redirect_to("/");
        }

        $imovel = (new Orm("imovel"))->where("imovel_status = 1 AND imovel_id = '" . $id_imovel->value . "'")->get();




        if (!isset($imovel[0])) {
            http::redirect_to("/");
        }
        $imovel = $imovel[0];




        $imovel->imovel_desc = strip_tags($imovel->imovel_desc);

        if($imovel->imovel_mostra_fotos == 1) {
            $imovel->imgs = (new Orm('foto_imovel'))
                ->select('foto_imovel_id, foto_imovel_pos, foto_imovel_img, foto_imovel_url')
                ->where("foto_imovel_imovel = '" . $imovel->imovel_id . "'")
                ->order('foto_imovel_pos ASC')
                ->get();

        } else {
            $imovel->imgs = null;
        }
        $config = (new Config)->get();
        $config_json = (new Config)->get();
        unset($config_json->config_site_about);
        $data = [
            "imovel_id" => $id_imovel->value,
            'config' => $config,
            'config_json' => $config_json,
            'social' => (new Config)->get_rede_social(),
            'paginasTopo' => (new Pagina())->listarPaginasTopo(),
            // Footer
            'paginasFooter' => (new Pagina())->listarPaginasFooter(),
            'SEOdata' => $imovel,
            'mapper' => ['config', 'social']
        ];
        Template::view("tema.screens.imovel.imovel", $data);
    }

    public function administracao()
    {

        $config = (new Config)->get();
        $config_json = (new Config)->get();
        unset($config_json->config_site_about);
        $data = [
            'config' => $config,
            'config_json' => $config_json,
            'social' => (new Config)->get_rede_social(),
            'paginasTopo' => (new Pagina())->listarPaginasTopo(),
            'caracteristica_categorias' => CaracteristicaCategoria::listaComCaracteristicas('imovel'),
            'categorias' => (new Orm('categoria_imovel'))->get(),
            // Footer
            'paginasFooter' => (new Pagina())->listarPaginasFooter(),
            'mapper' => ['config', 'social']
        ];
        Template::view("tema.screens.home.administracao", $data);
    }

    public function anuncie()
    {
        $config = (new Config)->get();
        $config_json = (new Config)->get();
        unset($config_json->config_site_about);
        $data = [
            'config' => $config,
            'config_json' => $config_json,
            'social' => (new Config)->get_rede_social(),
            'paginasTopo' => (new Pagina())->listarPaginasTopo(),
            'caracteristica_categorias' => CaracteristicaCategoria::listaComCaracteristicas('imovel'),
            'categorias' => (new Orm('categoria_imovel'))->get(),
            // Footer
            'paginasFooter' => (new Pagina())->listarPaginasFooter(),
            'mapper' => ['config', 'social']
        ];
        Template::view("tema.screens.home.anuncie", $data);
    }

    public function salvar_anuncio()
    {

        $caracteristicas = $_POST['imovel_caracteristicas'] ?? [];
        unset($_POST['imovel_caracteristicas']);

        $dados = Filter::parse_full($_POST, 0);

        $dados['imovel_valor_iptu'] = Filter::money_to_double($dados['imovel_valor_iptu']);
        $dados['imovel_valor_condominio'] = Filter::money_to_double($dados['imovel_valor_condominio']);




        $dados['imovel_valor'] = Filter::money_to_double($dados['imovel_valor']);
        if (empty($dados['imovel_valor'])) {
            $dados['imovel_valor'] = '0.00';
        }

        if($dados['imovel_tipo_negociacao'] == "venda") {
            $dados['imovel_valor_venda'] = $dados['imovel_valor'];
        } else {
            $dados['imovel_valor_locacao'] = $dados['imovel_valor'];
        }

        unset($dados['imovel_valor']);

        $dados['imovel_is_client'] = 1;


        $id = (new Orm('imovel'))->with($dados)->save();
        if (isset($caracteristicas[0])) {
            $inserts = [];
            foreach ($caracteristicas as $c) {
                $inserts[] = "('" . $id . "', '$c')";
            }
            $inserts = implode(",", $inserts);
            (new Orm('imovel_caracteristica'))
                ->query("INSERT INTO imovel_caracteristica (imovel_caracteristica_imovel_id, imovel_caracteristica_caracteristica_id) VALUES {$inserts};");
        }

        $link_imovel = Http::base() . "/imovel-site-editar/id/" . $id;

        if($dados['imovel_site_type'] == "venda_alugue") {

            Sender::mail([
                'destinatario' => (new Config)->get()->config_site_email,
                'assunto' => "Imobiliária - Novo imóvel para análise",
                'mensagem' => "
                    <h3><b>Um novo imóvel foi enviado para análise</b></h3>
                    <b>Origem: Formulário de Venda ou Alugue </b> <br>
                    <b>Link: <a href='$link_imovel'>$link_imovel</a></b> <br>
                ",
            ]);

            Http::redirect_to("/imovel/anuncie?success=1");
        } else {
            Sender::mail([
                'destinatario' => (new Config)->get()->config_site_email,
                'assunto' => "Imobiliária - Novo imóvel para análise",
                'mensagem' => "
                    <h3><b>Um novo imóvel foi enviado para análise</b></h3>
                    <b>Origem: Formulário de Administração </b> <br>
                    <b>Link: <a href='$link_imovel'>$link_imovel</a></b> <br>
                ",
            ]);
            Http::redirect_to("/imovel/administracao?success=1");
        }
    }



    public function getSlide()
    {
        echo (new Orm('slide'))
            ->select("*")
            ->order('slide_pos DESC')
            ->where('slide_status = 1 AND slide_tipo = 1')
            ->get(1);
    }
    public function getSlideAdministracao()
    {
        echo (new Orm('slide'))
            ->select("*")
            ->order('slide_pos DESC')
            ->where('slide_status = 1 AND slide_tipo = 4')
            ->get(1);
    }

    public function getSlideVendaOuAlugue()
    {
        echo (new Orm('slide'))
            ->select("*")
            ->order('slide_pos DESC')
            ->where('slide_status = 1 AND slide_tipo = 3')
            ->get(1);
    }

    public function getSlideMiddle()
    {
        echo (new Orm('slide'))
            ->select("*")
            ->order('slide_pos DESC')
            ->where('slide_status = 1 AND slide_tipo = 2')
            ->get(1);
    }



    public function lista()
    {
        $config = (new Config)->get();
        $config_json = (new Config)->get();
        unset($config_json->config_site_about);
        $data = [
            'config' => $config,
            'config_json' => $config_json,
            'social' => (new Config)->get_rede_social(),
            'paginasTopo' => (new Pagina())->listarPaginasTopo(),
            // Footer
            'paginasFooter' => (new Pagina())->listarPaginasFooter(),
            'mapper' => ['config', 'social']
        ];
        return Template::view("tema.screens.imoveis.imoveis", $data);
    }


    public function get()
    {
        $query = (new Orm('imovel'))
            ->join("bairro", 'bairro_id = imovel_bairro_id', 'left')
            ->join("cidade", "cidade_id = bairro_cidade", 'left')
            ->join("condominio", "condominio_id = imovel_condominio_id", 'left')
            ->join("uf", 'uf_id = cidade_uf', 'left')
            ->where("imovel_status = 1 AND imovel_is_client = 0");


        $imoveis = $query->join("categoria_imovel", 'imovel_categoria = categoria_imovel_id')->get();

        $imoveis = json_decode(json_encode($imoveis), true);

        foreach ($imoveis as $key => &$imovel) {
            $imovel['imovel_desc'] = strip_tags($imovel['imovel_desc']);

            if(empty($imovel['imovel_titulo'])) {
                if(!empty($imovel['categoria_imovel_nome']) && !empty($imovel['cidade_titulo'])) {
                    $imovel['imovel_titulo'] = $imovel['categoria_imovel_nome'] . " em " . $imovel['cidade_titulo'];
                } else if(!empty($imovel['cidade_titulo'])) {
                    $imovel['imovel_titulo'] = "Imóvel em " . $imovel['cidade_titulo'];
                }
            }

            if($imovel['imovel_mostra_fotos'] == 1) {
                $imovel['imgs'] = (new Orm('foto_imovel'))
                    ->select('foto_imovel_id, foto_imovel_pos, foto_imovel_img, foto_imovel_url')
                    ->where("foto_imovel_imovel = '" . $imovel['imovel_id'] . "'")
                    ->order('foto_imovel_pos ASC')
                    ->limit(3)
                    ->get();



            } else {
                $imovel['imgs'] = null;
            }


            $imovel['atributos'] = (new Orm('atributo'))
                ->select("*")
                ->join("atributo_imovel", "atributo_imovel_atributo_id = atributo_id")
                ->where("atributo_imovel_imovel_id = " . $imovel['imovel_id'])
                ->get();
        }
        echo json_encode($imoveis);
    }


    public function getHighlights()
    {
        $imoveis = (new Orm('imovel'))
            ->select("*")
            ->join("bairro", 'bairro_id = imovel_bairro_id', 'left')
            ->join("cidade", "cidade_id = bairro_cidade", 'left')
            ->join("uf", 'uf_id = cidade_uf', 'left')
            ->join("categoria_imovel", 'imovel_categoria = categoria_imovel_id', 'left')
            ->join("condominio", "condominio_id = imovel_condominio_id", 'left')
            ->where("imovel_status = 1 AND imovel_is_client = 0 AND imovel_destaque = 1")
            ->limit(8)
            ->get();


        $imoveis = json_decode(json_encode($imoveis), true);

        foreach ($imoveis as $key => &$imovel) {

            if(empty($imovel['imovel_titulo'])) {
                if(!empty($imovel['categoria_imovel_nome']) && !empty($imovel['cidade_titulo'])) {
                    $imovel['imovel_titulo'] = $imovel['categoria_imovel_nome'] . " em " . $imovel['cidade_titulo'];
                } else if(!empty($imovel['cidade_titulo'])) {
                    $imovel['imovel_titulo'] = "Imóvel em " . $imovel['cidade_titulo'];
                }
            }


            $imovel['atributos'] = (new Orm('atributo'))
                ->select("atributo_titulo, atributo_icone, atributo_imovel_valor")
                ->join("atributo_imovel", "atributo_imovel_atributo_id = atributo_id")
                ->where("atributo_imovel_imovel_id = '" . $imovel['imovel_id'] . "'")
                ->get();


            if($imovel['imovel_mostra_fotos'] == 1) {
                $imovel['imgs'] = (new Orm('foto_imovel'))
                    ->select('foto_imovel_id, foto_imovel_pos, foto_imovel_img, foto_imovel_url')
                    ->where("foto_imovel_imovel = '" . $imovel['imovel_id'] . "'")
                    ->order('foto_imovel_pos ASC')
                    ->limit(3)
                    ->get();
            } else {
                $imovel['imgs'] = null;
                $imovel['qtd_fotos'] = null;
            }
        }

        echo json_encode($imoveis);
    }

    public function getNews()
    {
        $imoveis = (new Orm('imovel'))
            ->select("*")
            ->join("bairro", 'bairro_id = imovel_bairro_id', 'left')
            ->join("cidade", "cidade_id = bairro_cidade", 'left')
            ->join("uf", 'uf_id = cidade_uf', 'left')
            ->join("categoria_imovel", 'imovel_categoria = categoria_imovel_id', 'left')
            ->join("condominio", "condominio_id = imovel_condominio_id", 'left')
            ->where("imovel_status = 1 AND imovel_is_client = 0")
            ->order('imovel_created DESC')
            ->limit(8)
            ->get();



        $imoveis = json_decode(json_encode($imoveis), true);

        foreach ($imoveis as $key => &$imovel) {

            if(empty($imovel['imovel_titulo'])) {
                if(!empty($imovel['categoria_imovel_nome']) && !empty($imovel['cidade_titulo'])) {
                    $imovel['imovel_titulo'] = $imovel['categoria_imovel_nome'] . " em " . $imovel['cidade_titulo'];
                } else if(!empty($imovel['cidade_titulo'])) {
                    $imovel['imovel_titulo'] = "Imóvel em " . $imovel['cidade_titulo'];
                }
            }

            $imovel['atributos'] = (new Orm('atributo'))
                ->select("atributo_titulo, atributo_icone, atributo_imovel_valor")
                ->join("atributo_imovel", "atributo_imovel_atributo_id = atributo_id")
                ->where("atributo_imovel_imovel_id = '" . $imovel['imovel_id'] . "'")
                ->get();

            if($imovel['imovel_mostra_fotos'] == 1) {
                $imovel['imgs'] = (new Orm('foto_imovel'))
                    ->select('foto_imovel_id, foto_imovel_pos, foto_imovel_img, foto_imovel_url')
                    ->where("foto_imovel_imovel = '" . $imovel['imovel_id'] . "'")
                    ->order('foto_imovel_pos ASC')
                    ->limit(4)
                    ->get();
            } else {
                $imovel['imgs'] = null;
            }
        }

        echo json_encode($imoveis);
    }



    public function getCitiesNeighbor()
    {

        $cidades = (new Orm('imovel'))
            ->select("imovel_bairro, imovel_cidade")
            ->where('imovel_bairro is not null')
            ->group_by('imovel_bairro')
            ->get();

            $cities = [];

            foreach ($cidades as $key => $cidade) {
                $cities[$cidade->imovel_cidade][] = $cidade->imovel_bairro;
            }



        echo json_encode($cities);
    }


    public function getCondominios()
    {

        $condominios = (new Orm('condominio'))
        ->select("*")
        ->join('foto_condominio','condominio_id = foto_condominio_condominio','LEFT')
        ->group_by('condominio_id')
        ->get();

    echo json_encode($condominios);
    }


    public function getTypes()
    {
        return (new Orm('categoria_imovel'))
            ->select("categoria_imovel_nome, categoria_imovel_id")
            ->get(1);
    }

    public function getImovelById()
    {

        try {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                return json_encode([]);
            }


            $id = intval($_GET['id']);

            $imovel = (new Orm('imovel'))
                ->select("*")
                ->join("bairro", 'bairro_id = imovel_bairro_id', 'left')
                ->join("cidade", "cidade_id = bairro_cidade", 'left')
                ->join("uf", 'uf_id = cidade_uf', 'left')
                ->join("condominio", "condominio_id = imovel_condominio_id", 'left')
                ->join("categoria_imovel", 'imovel_categoria = categoria_imovel_id', 'left')
                ->where("imovel_status = 1 AND imovel_id = {$id} AND imovel_is_client = 0")
                ->get();





            if (!isset($imovel[0])) {
                return json_encode([]);
            }
            $imovel = $imovel[0];




            $imovel->atributos = (new Orm('atributo'))
                ->select("atributo_titulo, atributo_icone, atributo_imovel_valor")
                ->join("atributo_imovel", "atributo_imovel_atributo_id = atributo_id")
                ->where("atributo_imovel_imovel_id = {$imovel->imovel_id}")
                ->get();


            $imovel->caracteristicas_ids = (new Orm('imovel_caracteristica'))
                ->select("imovel_caracteristica_id, imovel_caracteristica_imovel_id,caracteristica_categoria.caracteristica_categoria_id,caracteristica_categoria_nome,imovel_caracteristica_caracteristica_id,caracteristica_nome,caracteristica_diferencial,caracteristica_tipo ")
                ->where("imovel_caracteristica_imovel_id = {$imovel->imovel_id}")
                ->join("caracteristica", "imovel_caracteristica_caracteristica_id = caracteristica_id")
                ->join("caracteristica_categoria", "caracteristica_categoria.caracteristica_categoria_id = caracteristica.caracteristica_categoria_id")
                ->order('caracteristica_diferencial desc')
                ->get();

            $imovel->caracteristicas_imóvel_pesquisa = (new Orm('imovel_caracteristica'))
                ->select("imovel_caracteristica_id, imovel_caracteristica_imovel_id,caracteristica_categoria.caracteristica_categoria_id,caracteristica_categoria_nome,imovel_caracteristica_caracteristica_id,caracteristica_nome,caracteristica_diferencial,caracteristica_tipo ")
                ->where("imovel_caracteristica_imovel_id = {$imovel->imovel_id} and caracteristica_categoria_nome = 'Características do imóvel' ")
                ->join("caracteristica", "imovel_caracteristica_caracteristica_id = caracteristica_id")
                ->join("caracteristica_categoria", "caracteristica_categoria.caracteristica_categoria_id = caracteristica.caracteristica_categoria_id")
                ->get();



            if($imovel->imovel_mostra_fotos == 1) {
                $imovel->fotos = (new Orm("foto_imovel"))->select("foto_imovel_img")->where("foto_imovel_imovel = {$imovel->imovel_id}")->order("foto_imovel_pos")->get();



                $imovel->fotos_cond = (new Orm('foto_condominio'))
                ->select('foto_condominio_id, foto_condominio_pos, foto_condominio_img, foto_condominio_url')
                ->where("foto_condominio_condominio = '" . $imovel->imovel_condominio_id . "'")
                ->order('foto_condominio_pos ASC')
                ->get();

            } else {
                $imovel->fotos = null;
            }


            if (is_array($imovel->caracteristicas_ids) && sizeof($imovel->caracteristicas_ids) > 0) {
                foreach ($imovel->caracteristicas_ids as $key => $caracteristica) {
                    $imovel->caracteristicas_ids[$caracteristica->caracteristica_categoria_nome][] = $caracteristica;

                    unset($imovel->caracteristicas_ids[$key]);
                }
            }

            if(isset($imovel->condominio_nome) && !empty($imovel->condominio_nome)) {
                $imovel->condominio_caracteristicas_ids = (new Orm('condominio_caracteristica'))
                    ->select("condominio_caracteristica_id, condominio_caracteristica_condominio_id,caracteristica_categoria.caracteristica_categoria_id,caracteristica_categoria_nome,condominio_caracteristica_caracteristica_id,caracteristica_nome,caracteristica_diferencial,caracteristica_tipo ")
                    ->where("condominio_caracteristica_condominio_id = {$imovel->condominio_id}")
                    ->join("caracteristica", "condominio_caracteristica_caracteristica_id = caracteristica_id")
                    ->join("caracteristica_categoria", "caracteristica_categoria.caracteristica_categoria_id = caracteristica.caracteristica_categoria_id")
                    ->order('caracteristica_diferencial desc')
                    ->get();

                if (is_array($imovel->condominio_caracteristicas_ids) && sizeof($imovel->condominio_caracteristicas_ids) > 0) {
                    foreach ($imovel->condominio_caracteristicas_ids as $key => $caracteristica) {
                        $imovel->condominio_caracteristicas_ids[$caracteristica->caracteristica_categoria_nome][] = $caracteristica;

                        unset($imovel->condominio_caracteristicas_ids[$key]);
                    }
                }
            }
            echo json_encode($imovel);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }


    public function getDadosContato()
    {
        echo json_encode((new Config)->get());
    }

    public function sendContact()
    {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $mensagem = $_POST['mensagem'];
        $imovel_id = $_POST['imovel_id'];

        $imovel = (new Orm("imovel"))->find($imovel_id);

        $config = (new Config)->get();

        $msg = "
            <h3><b>Contato recebido via Site</b></h3>
            <b>Nome: </b> {$nome} <br>
            <b>E-mail: </b> {$email} <br>
            <b>Telefone: </b> {$telefone} <br>
            <b>Imóvel: </b> #{$imovel->imovel_ref} (" . Http::base() . "/imovel/ver/{$imovel_id}) <br>
            <b>Mensagem: </b> <br>
            {$mensagem}
        ";

        $send = Sender::mail([
            'destinatario' => $config->config_site_email,
            'assunto' => "Imobiliária - Contato via Site",
            'mensagem' => $msg,
        ]);

        echo json_encode($send);
    }

    public function water()
    {
        $baseUri =  http::base();
        $conf = (new Config)->get();
        $img =  Req::get('img');

        // print_r($img);
        // exit;

        $status =  Req::get('status');
        $config = (new Config)->get();

        $logo = Http::base() .'/media/site/'. $config->config_site_marcadagua;

        // print_r($logo);
        // exit;

        $typeImage = strtolower(substr($img, strlen($img) - 3));
        $opacity = 0.3;
        $transparency = 1 - $opacity;
        header('content-type: image/jpeg');
        $watermark = imagecreatefrompng($logo);
        $size = getimagesize($img);
        $watermark = imagescale($watermark , (($size[0] / 100) * 25) , (($size[1] /100) * 25));
        imagealphablending($watermark, false); // imagesavealpha can only be used by doing this for some reason
        imagesavealpha($watermark, true);
        imagefilter($watermark, IMG_FILTER_COLORIZE, 0, 0, 0, 127 * $transparency);
        $watermark_width = imagesx($watermark);
        $watermark_height = imagesy($watermark);
        $image = imagecreatetruecolor($watermark_width, $watermark_height);
        ($typeImage == 'jpg' || $typeImage == 'peg' || $typeImage == 'fif') ?
            $image = imagecreatefromjpeg($img) :
            $image = imagecreatefrompng($img);

        $size = getimagesize($img);

        $dest_x = ($size[0]) - ($watermark_width + 20);
        $dest_y = ($size[1]) - ($watermark_height + 20);;

        imagecopy($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);
        imagejpeg($image, NULL, 80);
        imagedestroy($image);
        imagedestroy($watermark);
    }
}
