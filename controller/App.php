<?php

class App
{
    public function __construct()
    {
    }

    public function login()
    {
        $email = Req::post('email', 'string');
        $pass = Req::post('pass', 'string');
        if (isset($email) && !empty($email) && isset($pass) && !empty($pass)) {
            $pass = Parser::crypt($pass);
            $user = (new Orm('usuario'))->where("usuario_email = '$email' AND usuario_pass = '$pass'")->get();

            if (!isset($user[0])) {
                AppTools::errorResponse("Usuário não encontrado");
            }

            $user = $user[0];

            if ($user->usuario_access_app != 1) {
                AppTools::errorResponse("Usuário não possui acesso ao app");
            }

            $token = md5(uniqid(time()));

            $with = [
                'id' => $user->usuario_id,
                'token_app' => $token
            ];
            (new Orm('usuario'))->with($with)->save();

            AppTools::successResponse("Login realizado com sucesso!", ['token' => $token]);
        } else {
            AppTools::errorResponse("Dados de login não enviados.");
        }
    }

    public function getImoveis()
    {
        AppTools::verifyToken();


        $imoveis = (new Orm('imovel'))
            ->select("
                *,
                DATE_FORMAT(imovel_created, '%d/%m/%Y Às %H:%i') AS imovel_created,
                DATE_FORMAT(imovel_updated, '%d/%m/%Y Às %H:%i') AS imovel_updated,
                CASE imovel_tipo_negociacao
                WHEN 'venda' THEN 'Venda'
                WHEN 'aluguel' THEN 'Locação'
                WHEN 'venda_aluguel' THEN 'Venda e Locação'
                END AS imovel_tipo_negociacao_label,
                (SELECT foto_imovel_img FROM foto_imovel where foto_imovel_imovel = imovel_id ORDER BY foto_imovel_pos ASC limit 1) AS imovel_foto,
                CONCAT('" . Http::base() . "/media/imovel/', (SELECT foto_imovel_img FROM foto_imovel where foto_imovel_imovel = imovel_id ORDER BY foto_imovel_pos ASC limit 1)) AS link_foto_imovel
            
                ")
            ->join("bairro", 'bairro_id = imovel_bairro_id', 'left')
            ->join("cidade", "cidade_id = bairro_cidade", 'left')
            ->join("uf", 'uf_id = cidade_uf', 'left')
            ->join("usuario", 'usuario_id = imovel_user_id', 'left')
            ->join("categoria_imovel", 'imovel_categoria = categoria_imovel_id', 'left')
            ->join("modelo_imovel", 'imovel_modelo_id = modelo_imovel_id', 'left')
            ->get();

        if (isset($imoveis[0])) {
            foreach ($imoveis as $k => $v) {
                unset($imoveis[$k]->imovel_desc);
            }
        }


        AppTools::successResponse("Sucesso!", ['lista' => $imoveis]);
    }

    public function getImovel()
    {
        AppTools::verifyToken();

        $imovel_id = Req::post('imovel_id', 'int');

        $imovel = (new Orm('imovel'))
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
            ->where("imovel_id = '{$imovel_id}'")
            ->get();

        $modelos = (new Orm('modelo_imovel'))->get();

        if(isset($modelos[0])) {
            foreach($modelos as $k => $v) {
                $ids = [];
                $categorias = (new Orm('modelo_categoria'))
                    ->where("modelo_categoria_modelo_id = '{$v->modelo_imovel_id}'")
                    ->get();
        
                if (isset($categorias[0])) {
                    foreach ($categorias as $c) {
                        $ids[] = $c->modelo_categoria_categoria_id;
                    }
                }

                $modelos[$k]->categorias_vinculadas_id = $ids;
            }
        }

        $data = [
            'categorias' => (new Orm('categoria_imovel'))->get(),
            'modelos' => $modelos,
            'users' => (new Orm('usuario'))->select("usuario_id, usuario_nome")->get(),
            'condominios' => (new Orm('condominio'))->get(),
            'caracteristica_categorias' => AppTools::listaComCaracteristicas('imovel'),
            'cidades' => (new Orm('cidade'))->get(),
            'bairros' => (new Orm('bairro'))->get(),
        ];
        if (!isset($imovel[0])) {
            AppTools::successResponse('Sucesso', ['imovel' => null, 'dados_complementares' => $data]);
        }

        $imovel = $imovel[0];

        $imovel->imovel_valor_venda = number_format($imovel->imovel_valor_venda, 2, ',', ' ');
        $imovel->imovel_valor_locacao = number_format($imovel->imovel_valor_locacao, 2, ',', ' ');
        $imovel->imovel_desc = stripslashes($imovel->imovel_desc);
        $imovel->caracteristicas_vinculadas = AppTools::listaCaracteristicasVinculadas($imovel->imovel_id);

        $imovel->fotos = (new Orm('foto_imovel'))
            ->where("foto_imovel_imovel = '{$imovel_id}'")
            ->order("foto_imovel_pos")
            ->get();

        $imovel->arquivos = (new Orm('imovel_arquivo'))
            ->where("imovel_arquivo_imovel_id = '{$imovel_id}'")
            ->get();



        AppTools::successResponse('Sucesso', ['imovel' => $imovel, 'dados_complementares' => $data]);
    }

    public function newImovel()
    {
        AppTools::verifyToken();

        $caracteristicas = $_POST['imovel_caracteristicas'] ?? [];
        unset($_POST['imovel_caracteristicas']);

        $arquivo_titulo = $_POST['arquivo_titulo'] ?? "";
        unset($_POST['arquivo_titulo']);


        $dados = Filter::parse_full($_POST, 0);

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

        if ($dados['imovel_isento_iptu'] == '1') {
            $dados['imovel_valor_iptu'] = '0.00';
        }
        if ($dados['imovel_isento_condominio'] == '1') {
            $dados['imovel_valor_condominio'] = '0.00';
        }


        $dados['imovel_valor_venda'] = Filter::money_to_double($dados['imovel_valor_venda']);
        if (empty($dados['imovel_valor_venda'])) {
            $dados['imovel_valor_venda'] = '0.00';
        }
        $dados['imovel_valor_locacao'] = Filter::money_to_double($dados['imovel_valor_locacao']);
        if (empty($dados['imovel_valor_locacao'])) {
            $dados['imovel_valor_locacao'] = '0.00';
        }

        $alterou_caracteristica = $dados['alterou_caracteristica'];
        unset($dados['alterou_caracteristica']);


        $uf = (new Orm('cidade'))->select("cidade_uf")->find($dados['imovel_cidade_id']);
        if (isset($uf->cidade_uf)) {
            $dados['imovel_uf_id'] = $uf->cidade_uf;
        }

        $id = (new Orm('imovel'))->with($dados)->save();
        if (isset($dados['imovel_id']) && !empty($dados['imovel_id'])) {
            AppTools::atualiza_informacoes_dinamicas($dados['imovel_id']);

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
        } else {
            AppTools::atualiza_informacoes_dinamicas($id);
            (new Orm('imovel'))->query("UPDATE imovel SET imovel_desc = '" . addslashes($_POST['imovel_desc']) . "' WHERE imovel_id = " . $id . ";", false);
        }

        AppTools::successResponse('Imóvel salvo com sucesso');
    }

    public function enviarImagemImovel()
    {
        AppTools::verifyToken();

        $id = Req::post('imovel_id', 'int');

        if ($id > 0) {
            if (isset($_FILES) && !empty($_FILES)) {
                $media = Media::img_upload($_FILES['file'], 'imovel');
                if (isset($media) && !empty($media)) {
                    $data = [
                        'img' => $media->url,
                        'url' => $media->path,
                        'imovel' => $id,
                    ];
                    (new Orm('foto_imovel'))->with($data)->save();

                    $fotos = (new Orm('foto_imovel'))
                        ->where("foto_imovel_imovel = '{$id}'")
                        ->order("foto_imovel_pos")
                        ->get();

                    AppTools::successResponse('Sucesso', ['fotos' => $fotos]);
                } else {
                    AppTools::errorResponse('Não foi possível salvar a imagem.');
                }
            }
        } else {
            AppTools::errorResponse('ID do Imóvel não enviado');
        }
    }

    // usuario
    public function getUserData()
    {
        $usuario = AppTools::verifyToken();

        AppTools::successResponse('Sucesso', ['usuario' => $usuario]);
    }

    public function editUserData()
    {
        $usuario = AppTools::verifyToken();

        $nome = Req::post('usuario_nome');
        $email = Req::post('usuario_email');
        $pass = Req::post('usuario_pass');

        $with = [
            'id' => $usuario->usuario_id,
            'nome' => $nome,
            'email' => $email,
        ];

        $trocou_senha = false;
        if (!empty($pass)) {
            $with['pass'] = md5($pass);
            $trocou_senha = true;
        }

        (new Orm('usuario'))->with($with)->save();



        /**save avatar */

        $file = $_FILES['avatar'];

        $id = intval($usuario->usuario_id);
        $img = Media::img_upload($file, 'avatar');
        
        if (is_object($img)) {
            $current = (new Orm('usuario'))->select('usuario_avatar')->find($id);
            $current_login = Path::base() . "/media/avatar/$current->usuario_avatar";
            if (file_exists($current_login)) {
                @unlink($current_login);
            }
            $data = ['avatar' => $img->url, 'id' => $id];
            (new Orm('usuario'))->with($data)->save();
        } else {
            $current = (new Orm('usuario'))->select('usuario_avatar')->find($id);
            $current_login = Path::base() . "/media/avatar/$current->usuario_avatar";
            if (file_exists($current_login)) {
                @unlink($current_login);
            }
            $data = ['avatar' => $current->usuario_avatar ?? "", 'id' => $id];
            (new Orm('usuario'))->with($data)->save();
        }

        AppTools::successResponse('Sucesso', ['trocou_senha' => $trocou_senha]);
    }
}
