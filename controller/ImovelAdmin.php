<?php

@session_start();

class ImovelAdmin
{

    public function __construct()
    {
        Sessao::check();
        if (!Usuario::verifyPermission('imoveis')) {
            Http::redirect_to('/admin/?error-perm');
        }
    }

    public function indexAction()
    {
        $data = [
            'config' => (new Config)->get(),
            'mapper' => ['config']
        ];
        Template::view("admin.imovel.index", $data);
    }

    public function listaCorretores()
    {
        (new Orm('usuario'))
            ->select("usuario_id, usuario_nome, usuario_email, usuario_status, usuario_level,
                IF(usuario_is_admin = 1, 'Administrador', 'Corretor') AS level_nome , IF(usuario_status = 1, 'Ativo', 'Inativo') AS status_nome")
            ->get(1);
    }

    public function indexActionSite()
    {
        if (!Usuario::verifyIsAdmin()) {
            http::redirect_to("/imovel-lista");
        }
        $data = [
            'config' => (new Config)->get(),
            'mapper' => ['config']
        ];
        Template::view("admin.imovel.anuncios", $data);
    }

    public function indexActionChaves()
    {
        if (!Usuario::verifyPermission('chaves')) {
            http::redirect_to("/imovel-lista");
        }
        $data = [
            'config' => (new Config)->get(),
            'mapper' => ['config']
        ];
        Template::view("admin.imovel.chaves", $data);
    }

    public function listaSite()
    {

        (new Orm('imovel'))
            ->select("
                *,
                DATE_FORMAT(imovel_created, '%d/%m/%Y Às %H:%i') AS imovel_created,
                DATE_FORMAT(imovel_updated, '%d/%m/%Y Às %H:%i') AS imovel_updated,
                CASE imovel_tipo_negociacao
                WHEN 'venda' THEN 'Venda'
                WHEN 'aluguel' THEN 'Locação'
                WHEN 'venda_aluguel' THEN 'Venda e Locação'
                END AS imovel_tipo_negociacao_label,
                (SELECT foto_imovel_img FROM foto_imovel where foto_imovel_imovel = imovel_id ORDER BY foto_imovel_pos ASC limit 1) AS imovel_foto
            ")
            ->join("bairro", 'bairro_id = imovel_bairro_id', 'left')
            ->join("cidade", "cidade_id = bairro_cidade", 'left')
            ->join("uf", 'uf_id = cidade_uf', 'left')
            ->join("usuario", 'usuario_id = imovel_user_id', 'left')
            ->join("categoria_imovel", 'imovel_categoria = categoria_imovel_id', 'left')
            ->join("modelo_imovel", 'imovel_modelo_id = modelo_imovel_id', 'left')
            ->where("imovel_is_client = 1")
            ->get(1);
    }

    public function listaChaves()
    {

        (new Orm('imovel'))
            ->select("
                *,
                DATE_FORMAT(imovel_chave_retorno, '%d/%m/%Y') AS imovel_chave_retorno_formated,
                DATEDIFF(DATE(imovel_chave_retorno), CURDATE()) AS dias_para_devolucao
            ")
            ->where("imovel_chave_num IS NOT NULL AND imovel_chave_num <> ''")
            ->get(1);
    }

    public function lista()
    {
        $query_permissao = "";

        if (!Usuario::verifyIsAdmin() && Usuario::verifyPermissaoAcesso("imoveis", "self")) {
            $query_permissao = "AND imovel_user_id = '" . Session::node('uid') . "'";
        }

        (new Orm('imovel'))
            ->select("
                *,
                DATE_FORMAT(imovel_created, '%d/%m/%Y Às %H:%i') AS imovel_created,
                DATE_FORMAT(imovel_updated, '%d/%m/%Y Às %H:%i') AS imovel_updated,
                CASE imovel_tipo_negociacao
                WHEN 'venda' THEN 'Venda'
                WHEN 'aluguel' THEN 'Locação'
                WHEN 'venda_aluguel' THEN 'Venda e Locação'
                END AS imovel_tipo_negociacao_label,
                (SELECT foto_imovel_img FROM foto_imovel where foto_imovel_imovel = imovel_id ORDER BY foto_imovel_pos ASC limit 1) AS imovel_foto
            ")
            ->join("bairro", 'bairro_id = imovel_bairro_id', 'left')
            ->join("cidade", "cidade_id = bairro_cidade", 'left')
            ->join("uf", 'uf_id = cidade_uf', 'left')
            ->join("usuario", 'usuario_id = imovel_user_id', 'left')
            ->join("categoria_imovel", 'imovel_categoria = categoria_imovel_id', 'left')
            ->join("modelo_imovel", 'imovel_modelo_id = modelo_imovel_id', 'left')
            ->where("imovel_is_client = 0 {$query_permissao}")
            ->order("imovel_status", "ASC")
            ->get(1);
    }

    public function lista_full()
    {
        (new Orm('imovel'))
            ->select("
                *,
                DATE_FORMAT(imovel_created, '%d/%m/%Y Às %H:%i') AS imovel_created,
                DATE_FORMAT(imovel_updated, '%d/%m/%Y Às %H:%i') AS imovel_updated,
                CASE imovel_tipo_negociacao
                WHEN 'venda' THEN 'Venda'
                WHEN 'aluguel' THEN 'Locação'
                WHEN 'venda_aluguel' THEN 'Venda e Locação'
                END AS imovel_tipo_negociacao_label,
                (SELECT foto_imovel_img FROM foto_imovel where foto_imovel_imovel = imovel_id ORDER BY foto_imovel_pos ASC limit 1) AS imovel_foto
            ")
            ->join("bairro", 'bairro_id = imovel_bairro_id', 'left')
            ->join("cidade", "cidade_id = bairro_cidade", 'left')
            ->join("uf", 'uf_id = cidade_uf', 'left')
            ->join("usuario", 'usuario_id = imovel_user_id', 'left')
            ->join("categoria_imovel", 'imovel_categoria = categoria_imovel_id', 'left')
            ->join("modelo_imovel", 'imovel_modelo_id = modelo_imovel_id', 'left')
            ->where("imovel_is_client = 0")
            ->order("imovel_status", "ASC")
            ->get(1);
    }

    public function novo()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $data = [
            'config' => (new Config)->get(),
            'imovel' => (new Orm('imovel'))->map(),
            'modelos' => (new Orm('modelo_imovel'))->get(),
            'users' => (new Orm('usuario'))->get(),
            'condominios' => (new Orm('condominio'))->get(),
            'mapper' => ['imovel', 'config']
        ];
        Template::view("admin.imovel.form", $data);
    }

    public function editar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Http::get_in_params('id', 'int');
        if (!isset($id->value) || empty($id->value)) {
            Http::redirect_to('/imovel-lista/?error');
        }
        $imovel = (new Orm('imovel'))->find($id->value);
        if (isset($imovel->imovel_id) && !empty($imovel->imovel_id)) {

            if (!Usuario::verifyIsAdmin() && Usuario::verifyPermissaoAcesso("imoveis", "self") && $imovel->imovel_user_id != Session::node('uid')) {
                Http::redirect_to('/imovel-lista/?error');
            }

            $imovel->imovel_valor_venda = number_format($imovel->imovel_valor_venda, 2, ',', ' ');
            $imovel->imovel_valor_locacao = number_format($imovel->imovel_valor_locacao, 2, ',', ' ');
            $imovel->imovel_valor_iptu = number_format($imovel->imovel_valor_iptu, 2, ',', ' ');
            $imovel->imovel_valor_condominio = number_format($imovel->imovel_valor_condominio, 2, ',', ' ');
            $imovel->imovel_desc = stripslashes($imovel->imovel_desc);
            $caracteristicas_vinculadas = ImovelAdmin::listaCaracteristicas($imovel->imovel_id);
            $data = [
                'config' => (new Config)->get(),
                'imovel' => $imovel,
                'modelos' => (new Orm('modelo_imovel'))->get(),
                'condominios' => (new Orm('condominio'))->get(),
                'users' => (new Orm('usuario'))->get(),
                'caracteristica_categorias' => CaracteristicaCategoria::listaComCaracteristicas('imovel'),
                'caracteristicas_vinculadas' => $caracteristicas_vinculadas,
                'mapper' => ['imovel', 'config', 'imovel']
            ];
            Template::view("admin.imovel.form-edit", $data);
        }
    }

    public function editarSite()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Http::get_in_params('id', 'int');
        if (!isset($id->value) || empty($id->value)) {
            Http::redirect_to('/imovel-lista/?error');
        }
        $imovel = (new Orm('imovel'))->find($id->value);
        if (isset($imovel->imovel_id) && !empty($imovel->imovel_id)) {
            $imovel->imovel_valor_venda = number_format($imovel->imovel_valor_venda, 2, ',', ' ');
            $imovel->imovel_valor_locacao = number_format($imovel->imovel_valor_locacao, 2, ',', ' ');
            $imovel->imovel_valor_iptu = number_format($imovel->imovel_valor_iptu, 2, ',', ' ');
            $imovel->imovel_valor_condominio = number_format($imovel->imovel_valor_condominio, 2, ',', ' ');
            $imovel->imovel_desc = stripslashes($imovel->imovel_desc);
            $caracteristicas_vinculadas = ImovelAdmin::listaCaracteristicas($imovel->imovel_id);
            $data = [
                'config' => (new Config)->get(),
                'imovel' => $imovel,
                'modelos' => (new Orm('modelo_imovel'))->get(),
                'condominios' => (new Orm('condominio'))->get(),
                'users' => (new Orm('usuario'))->get(),
                'caracteristica_categorias' => CaracteristicaCategoria::listaComCaracteristicas('imovel'),
                'caracteristicas_vinculadas' => $caracteristicas_vinculadas,
                'mapper' => ['imovel', 'config', 'imovel']
            ];
            Template::view("admin.imovel.form-edit", $data);
        }
    }

    public static function listaCaracteristicas($imovel_id = 0)
    {
        $ids = [];
        $caracteristicas = (new Orm('imovel_caracteristica'))
            ->where("imovel_caracteristica_imovel_id = '{$imovel_id}'")
            ->get();

        if (isset($caracteristicas[0])) {
            foreach ($caracteristicas as $c) {
                $ids[] = $c->imovel_caracteristica_caracteristica_id;
            }
        }

        return $ids;
    }

    public function gravar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $redirect = '';
        if (isset($_POST['redirect'])) {
            $redirect = $_POST['redirect'];
            unset($_POST['redirect']);
        }
        $caracteristicas = $_POST['imovel_caracteristicas'] ?? [];
        unset($_POST['imovel_caracteristicas']);

        $arquivo_titulo = $_POST['arquivo_titulo'] ?? "";
        unset($_POST['arquivo_titulo']);


        $dados = Filter::parse_full($_POST, 0);

        if (isset($dados['imovel_video']) && !empty($dados['imovel_video'])) {
            $thumb = Media::get_video_thumbnail($dados['imovel_video']);
            $dados['imovel_thumb_video'] = $thumb['img'];
        } else {
            $dados['imovel_thumb_video'] = NULL;
        }


        if (!isset($dados['imovel_rua_view'])) {
            $dados['imovel_rua_view'] = '0';
        }
        if (!isset($dados['imovel_num_view'])) {
            $dados['imovel_num_view'] = '0';
        }
        if (!isset($dados['imovel_bairro_view'])) {
            $dados['imovel_bairro_view'] = '0';
        }
        if (!isset($dados['imovel_cidade_view'])) {
            $dados['imovel_cidade_view'] = '0';
        }
        if (!isset($dados['imovel_uf_view'])) {
            $dados['imovel_uf_view'] = '0';
        }
        if (!isset($dados['imovel_complemento_view'])) {
            $dados['imovel_complemento_view'] = '0';
        }

        if(isset($dados['imovel_valor_iptu'])) {
            $dados['imovel_valor_iptu'] = Filter::money_to_double($dados['imovel_valor_iptu']);
            if ($dados['imovel_isento_iptu'] == '1') {
                $dados['imovel_valor_iptu'] = '0.00';
            }
        }

        if(isset($dados['imovel_valor_condominio'])) {
            $dados['imovel_valor_condominio'] = Filter::money_to_double($dados['imovel_valor_condominio']);
            if ($dados['imovel_isento_condominio'] == '1') {
                $dados['imovel_valor_condominio'] = '0.00';
            }
        }

        if(isset($dados['imovel_chave_status'])) {
            if ($dados['imovel_chave_status'] == 'imobiliaria') {
                $dados['imovel_chave_portador'] = "";
                $dados['imovel_chave_retorno'] = "0000-00-00";
            }
        }


        if(isset($dados['imovel_valor_venda'])) {
            $dados['imovel_valor_venda'] = Filter::money_to_double($dados['imovel_valor_venda']);
            if (empty($dados['imovel_valor_venda'])) {
                $dados['imovel_valor_venda'] = '0.00';
            }
        }

        if(isset($dados['imovel_valor_locacao'])) {
            $dados['imovel_valor_locacao'] = Filter::money_to_double($dados['imovel_valor_locacao']);
            if (empty($dados['imovel_valor_locacao'])) {
                $dados['imovel_valor_locacao'] = '0.00';
            }
        }

        if(isset($dados['alterou_caracteristica'])) {
            $alterou_caracteristica = $dados['alterou_caracteristica'];
            unset($dados['alterou_caracteristica']);
        } else {
            $alterou_caracteristica = 0;
        }


        if (!isset($dados['imovel_id']) || empty($dados['imovel_id'])) {
            $dados['imovel_isento_iptu'] = 1;
            $dados['imovel_isento_condominio'] = 1;
            $dados['imovel_temporada'] = 2;
            $dados['imovel_user_id'] = Session::node('uid');
        } else {
            $imovel_old = (new Orm('imovel'))->find($dados['imovel_id']);
            Log::add([
                "entity" => "imovel",
                "action" => "edit",
                "msg" => "Alterou dados do imóvel de ID " . $dados['imovel_id'] . ": " . Http::base() . "/imovel-editar/id/" . $dados['imovel_id'],
                "entity_id" => $dados['imovel_id'],
                "old_data" => (array) $imovel_old,
                "new_data" => $dados
            ]);
        }

        $id = (new Orm('imovel'))->with($dados)->save();
        if (isset($dados['imovel_id']) && !empty($dados['imovel_id'])) {
            ImovelAdmin::atualiza_informacoes_dinamicas($dados['imovel_id']);
            (new Orm('imovel'))->query("UPDATE imovel SET imovel_desc = '" . addslashes($_POST['imovel_desc']) . "' WHERE imovel_id = " . $dados['imovel_id'] . ";", false);

            if ($alterou_caracteristica == '1') {
                // update/atualizar
                (new Orm('imovel_caracteristica'))
                    ->where("imovel_caracteristica_imovel_id = '" . $dados['imovel_id'] . "'")
                    ->drop();

                if (isset($caracteristicas[0])) {
                    $inserts = [];
                    foreach ($caracteristicas as $c) {
                        $inserts[] = "('" . $dados['imovel_id'] . "', '$c')";
                    }
                    $inserts = implode(",", $inserts);
                    (new Orm('imovel_caracteristica'))
                        ->query("INSERT INTO imovel_caracteristica (imovel_caracteristica_imovel_id, imovel_caracteristica_caracteristica_id) VALUES {$inserts};");
                }
            }

            if (isset($_FILES['arquivo_file']) && $_FILES['arquivo_file'] && $_FILES['arquivo_file']['error'] == 0) {
                ImovelAdmin::salvaArquivo($dados['imovel_id'], $arquivo_titulo, $_FILES['arquivo_file']);
            }

            Http::redirect_to('/imovel-editar/id/' . $dados['imovel_id'] . '/?success/' . $redirect);
        } else {
            Log::add([
                "entity" => "imovel",
                "action" => "new",
                "msg" => "Adicionou o imóvel de ID " . $id . ": " . Http::base() . "/imovel-editar/id/" . $id,
                "entity_id" => $id,
                "new_data" => $dados
            ]);
            ImovelAdmin::atualiza_informacoes_dinamicas($id);
            if(isset($_POST['imovel_desc'])) {
                (new Orm('imovel'))->query("UPDATE imovel SET imovel_desc = '" . addslashes($_POST['imovel_desc']) . "' WHERE imovel_id = " . $id . ";", false);
            }
            Http::redirect_to('/imovel-editar/id/' . $id . '/?success');
        }
    }

    public static function salvaArquivo($imovel_id = 0, $arquivo_titulo = "", $file = null)
    {
        $media = Media::file_upload($file, 'arquivos');
        if (isset($media) && !empty($media)) {
            $with = [
                "imovel_id" => $imovel_id,
                "nome" => $arquivo_titulo,
                "url" => $media->name
            ];
            (new Orm('imovel_arquivo'))->with($with)->save();

            Log::add([
                "entity" => "imovel_arquivo",
                "action" => "new",
                "msg" => "Adicionou o arquivo '" . $media->name . "' de título '" . $arquivo_titulo . "' ao imóvel de ID " . $imovel_id . ": " . Http::base() . "/imovel-editar/id/" . $imovel_id,
                "entity_id" => $imovel_id,
            ]);
        }
    }

    public static function atualiza_informacoes_dinamicas($imovel_id = 0)
    {
        $imovel = (new Orm('imovel'))->find($imovel_id);
        if (!isset($imovel->imovel_id)) {
            return false;
        }

        $codigo_imovel = "T";
        $titulo_imovel = "";
        if (isset($imovel->imovel_categoria) && !empty($imovel->imovel_categoria)) {
            $categoria = (new Orm("categoria_imovel"))->find($imovel->imovel_categoria);
            if (isset($categoria->categoria_imovel_id)) {
                $codigo_imovel .= $categoria->categoria_imovel_code;
                $titulo_imovel .= $categoria->categoria_imovel_nome . " com ";
            }
        }
        $titulo_imovel .= $imovel->imovel_quartos;
        if ($imovel->imovel_quartos <= 1) {
            $titulo_imovel .= " Quarto";
        } else {
            $titulo_imovel .= " Quartos";
        }

        $codigo_imovel .= $imovel->imovel_quartos;
        $codigo_imovel .= $imovel->imovel_vagas;
        if ($imovel->imovel_tipo_negociacao == "venda" || $imovel->imovel_tipo_negociacao == "venda_aluguel") {
            $codigo_imovel .= "V";
            $titulo_imovel .= " à venda";
        } else {
            $codigo_imovel .= "A";
            $titulo_imovel .= " para aluguel";
        }

        $titulo_imovel .= ", " . $imovel->imovel_area_util . "m²";

        if ($imovel->imovel_bairro_view == 1 && $imovel->imovel_bairro) {
            $titulo_imovel .= " - " . $imovel->imovel_bairro;
        }

        if ($imovel->imovel_uf_view == 1 && $imovel->imovel_uf) {
            $titulo_imovel .= " - " . $imovel->imovel_uf;
        }

        if ($imovel_id < 10) {
            $codigo_imovel .= "00" . $imovel_id;
        } else if ($imovel_id < 100) {
            $codigo_imovel .= "0" . $imovel_id;
        } else {
            $codigo_imovel .=  $imovel_id;
        }

        $corretor = (new Orm('usuario'))->find($imovel->imovel_user_id);
        if (isset($corretor->usuario_id)) {
            $codigo_imovel .=  $corretor->usuario_code;
        }

        $with = [
            "id" => $imovel_id,
            'titulo' => $titulo_imovel,
            "ref" => strtoupper($codigo_imovel)
        ];
        (new Orm('imovel'))->with($with)->save();
    }

    public function remove()
    {
        if (!Usuario::verifyPermission('imoveis', 'remover')) {
            echo -1;
            exit;
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            (new Orm('atributo_imovel'))->where("atributo_imovel_imovel_id = $id")->drop();
            (new Orm('foto_imovel'))->where("foto_imovel_imovel = $id")->drop();
            (new Orm('imovel_caracteristica'))->where("imovel_caracteristica_imovel_id = '" . $id . "'")->drop();
            (new Orm('imovel'))->drop($id);

            Log::add([
                "entity" => "arquivo",
                "action" => "remove",
                "msg" => "Removeu o imóvel de ID " . $id,
                "entity_id" => $id,
            ]);
            echo 1;
        } else {
            echo -1;
        }
    }

    public function enviar_img()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            echo -1;
            exit;
        }





        $id = intval(Http::get_in_params('id')->value);


        $imovel_ref = (new Orm('imovel'))
            ->select("imovel_ref")
            ->where("imovel_id", $id)->get();


        if ($id > 0) {
            if (isset($_FILES) && !empty($_FILES)) {
                $newname =  $imovel_ref[0]->imovel_ref . rand(0, 999999);

                /**upload da imagem */
                $media = Media::img_upload($_FILES['file'], 'imovel', $newname);


                if (isset($media->url) && !empty($media->url)) {


                    /* ---------------------------- THUMB ----------------------- */
                    $ds = DIRECTORY_SEPARATOR;

                    $nome_arquivo_original = $media->url;
                    $thumb_nome = 'thumb_' . $nome_arquivo_original;
                    $watermark_nome = 'watermark_' . $nome_arquivo_original;

                    $path_original = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds . $nome_arquivo_original;
                    $path_copia = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds . $thumb_nome;
                    $path_copia_water = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds . $watermark_nome;
                    if (is_file($path_original)) {
                        @system("chmod -R 777 $path_original");
                        @system("chmod -R 777 $path_copia");
                        @system("chmod -R 777 $path_copia_water");
                        @copy($path_original, $path_copia);
                        @copy($path_original, $path_copia_water);

                        Media::img_redimensiona($thumb_nome, 'imovel', 100);
                        Media::img_redimensiona($watermark_nome, 'imovel', 100);
                        Media::watermark($path_copia, $thumb_nome, 'imovel');
                        Media::watermark($path_copia_water, $watermark_nome, 'imovel');
                    }

                    /* ---------------------------- THUMB ----------------------- */
                    $data = [
                        'img' => $nome_arquivo_original,
                        'url' =>  $path_original,
                        'imovel' => $id,
                    ];
                    (new Orm('foto_imovel'))->with($data)->save();
                    echo 0;
                    exit;
                } else {
                    echo -1;
                    exit;
                }
            }
        } else {
            echo -1;
            exit;
        }
    }



    public function lista_img_imovel()
    {
        $id = intval(Http::get_in_params('id')->value);
        if ($id > 0) {
            (new Orm('foto_imovel'))->select('foto_imovel_id, foto_imovel_pos, foto_imovel_img, foto_imovel_url')
                ->where("foto_imovel_imovel = '$id'")
                ->order('foto_imovel_pos ASC')
                ->get('true');
        } else {
            echo -1;
            exit;
        }
    }

    public function ordena_img()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            echo -1;
            exit;
        }
        $imovel_id = intval($_POST['imovel_id']);
        if ($imovel_id > 0 && isset($_POST['data']) && !empty($_POST['data'])) {
            $db_foto = (new Orm('foto_imovel'));
            foreach ($_POST['data'] as $k) {
                $data = [
                    'id' => $k['foto_id'],
                    'pos' => $k['pos'],
                ];
                $db_foto->with($data)->save();
            }
            echo 0;
            exit;
        } else {
            echo -1;
        }
    }



    public function rotaciona_img($img = null)
    {

        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            echo -1;
            exit;
        }

        if (empty($img)) {
            $img = $_POST['img'];
        }

        if (!empty($img)) {

            Media::img_rotaciona($img, 'imovel');
            $ds = DIRECTORY_SEPARATOR;
            $rotate_nome = 'rotate_' . $img;
            $thumb_nome = 'thumb_' . $img;
            $watermark_nome = 'watermark_' . $img;


            $path_original = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds . $img;
            $path_copia_rotate = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds . $rotate_nome;
            $path_copia_water = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds . $watermark_nome;
            $path_copia = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds . $thumb_nome;


            if (is_file($path_original)) {
                @system("chmod -R 777 $path_original");
                @copy($path_original, $path_copia);
                @copy($path_original, $path_copia_water);



                Media::img_redimensiona($thumb_nome, 'imovel', 20);
                Media::watermark($path_copia, $thumb_nome, 'imovel');
                Media::watermark($path_copia_water, $watermark_nome, 'imovel');
            }

            return true;
        }
    }
    public function remove_all_img_imovel()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            echo -1;
            exit;
        }
        $id = intval($_POST['imovel_id']);
        if ($id > 0) {
            $fotos = (new Orm('foto_imovel'))
                ->select("foto_imovel_img as img")
                ->where("foto_imovel_imovel = $id")
                ->get();
            if (isset($fotos[0])) {
                $ds = DIRECTORY_SEPARATOR;
                $path_delete = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds;
                foreach ($fotos as $foto) {
                    if (file_exists($path_delete . $foto->img)) {
                        @unlink($path_delete . $foto->img);
                        @unlink($path_delete . 'thumb_' . $foto->img);
                    }
                }
            }
            (new Orm('foto_imovel'))
                ->where("foto_imovel_imovel = $id")
                ->drop();

            Log::add([
                "entity" => "imovel_foto",
                "action" => "remove",
                "msg" => "Removeu todas as fotos do imóvel de ID " . $id,
                "entity_id" => $id,
            ]);

            echo 0;
            exit;
        } else {
            echo -1;
            exit;
        }
    }

    public function rotaciona_imagens()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            echo -1;
            exit;
        }
        $id = intval($_POST['imovel_id']);
        if ($id > 0) {
            if (isset($_POST['data'])) {
                foreach ($_POST['data'] as $k) {
                    $ids[] = $k['id'];
                }
                if (sizeof($ids) > 1) {
                    $ids = implode(',', $ids);
                    $where = "foto_imovel_imovel = '$id' AND foto_imovel_id IN ($ids)";
                } else {
                    $ids = $ids[0];
                    $where = "foto_imovel_imovel = '$id' AND foto_imovel_id = $ids";
                }
                $fotos_para_girar = (new Orm('foto_imovel'))
                    ->select("foto_imovel_img as img")
                    ->where($where)
                    ->get();

                if (isset($fotos_para_girar[0])) {
                    $ds = DIRECTORY_SEPARATOR;
                    foreach ($fotos_para_girar as $img) {
                        (new ImovelAdmin)->rotaciona_img($img->img);
                    }
                }

                echo 0;
                exit;
            } else {
                echo -2;
            }
        } else {
            echo -1;
            exit;
        }
    }

    public function remove_img()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            echo -1;
            exit;
        }
        $id = intval($_POST['imovel_id']);
        if ($id > 0) {
            if (isset($_POST['data'])) {
                foreach ($_POST['data'] as $k) {
                    $ids[] = $k['id'];
                }
                if (sizeof($ids) > 1) {
                    $ids = implode(',', $ids);
                    $where = "foto_imovel_imovel = '$id' AND foto_imovel_id IN ($ids)";
                } else {
                    $ids = $ids[0];
                    $where = "foto_imovel_imovel = '$id' AND foto_imovel_id = $ids";
                }
                $fotos_para_deletar = (new Orm('foto_imovel'))
                    ->select("foto_imovel_img as img")
                    ->where($where)
                    ->get();

                if (isset($fotos_para_deletar[0])) {
                    $ds = DIRECTORY_SEPARATOR;
                    $path_delete = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds;
                    foreach ($fotos_para_deletar as $foto) {
                        if (file_exists($path_delete . $foto->img)) {
                            @unlink($path_delete . $foto->img);
                            @unlink($path_delete . 'thumb_' . $foto->img);
                        }
                    }
                }
                (new Orm('foto_imovel'))
                    ->where($where)
                    ->drop();

                Log::add([
                    "entity" => "imovel_foto",
                    "action" => "remove",
                    "msg" => "Removeu a foto '" . $foto->img . "' do imóvel de ID " . $id,
                    "entity_id" => $id,
                ]);
                echo 0;
                exit;
            } else {
                echo -1;
            }
        } else {
            echo -1;
            exit;
        }
    }

    public function lista_arquivos()
    {

        $imovel_id = intval($_POST['imovel_id']);

        if ($imovel_id <= 0) {
            echo json_encode([]);
            exit;
        }

        $arquivos = (new Orm('imovel_arquivo'))
            ->where("imovel_arquivo_imovel_id = {$imovel_id}")
            ->get();

        echo json_encode($arquivos);
        exit;
    }

    public function remove_arquivo()
    {
        $arquivo_id = intval($_POST['arquivo_id']);
        $imovel_id = intval($_POST['imovel_id']);

        if ($arquivo_id <= 0) {
            echo json_encode(['status' => 400]);
            exit;
        }

        (new Orm("imovel_arquivo"))->drop($arquivo_id);

        Log::add([
            "entity" => "imovel_foto",
            "action" => "remove",
            "msg" => "Removeu um arquivo do imóvel de ID " . $imovel_id,
            "entity_id" => $imovel_id,
        ]);

        echo json_encode(['status' => 200]);
        exit;
    }
}
