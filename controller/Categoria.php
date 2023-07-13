<?php

@session_start();

class Categoria
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
        Template::view("admin.categoria.index", $data);
    }

    public function lista()
    {
        (new Orm('categoria_imovel'))
            ->select("categoria_imovel_id, categoria_imovel_nome, categoria_imovel_img_capa, (SELECT COUNT(*) FROM imovel WHERE imovel_categoria = categoria_imovel_id) AS qtd_imoveis")
            ->get(1);
    }

    public function nova()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }  
        $modelos_vinculados = [];
        $data = [
            'config' => (new Config)->get(),
            'categoria' => (new Orm('categoria_imovel'))->map(),
            'modelos_vinculados' => $modelos_vinculados,
            'modelo_imovel' => (new Orm('modelo_imovel'))->get(),
            'mapper' => ['config', 'categoria']
        ];
        Template::view("admin.categoria.form", $data);
    }

    public static function listaModelosVinculados($categoria_id = 0)
    {
        $ids = [];
        $modelos = (new Orm('modelo_categoria'))
            ->where("modelo_categoria_categoria_id = '{$categoria_id}'")
            ->get();

        if (isset($modelos[0])) {
            foreach ($modelos as $m) {
                $ids[] = $m->modelo_categoria_modelo_id;
            }
        }

        return $ids;
    }

    public function editar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }  
        
        $id = Http::get_in_params('editar', 'int');
        if (isset($id->value) && !empty($id->value)) {
            $categoria = (new Orm('categoria_imovel'))->find($id->value);
            if (isset($categoria->categoria_imovel_id)) {
                $modelos_vinculados = Categoria::listaModelosVinculados($categoria->categoria_imovel_id);
                $data = [
                    'config' => (new Config)->get(),
                    'categoria' => $categoria,
                    'modelos_vinculados' => $modelos_vinculados,
                    'modelo_imovel' => (new Orm('modelo_imovel'))->get(),
                    'mapper' => ['config', 'categoria']
                ];
                Template::view("admin.categoria.form", $data);
            } else {
                Http::redirect_to('/categoria/?error');
            }
        } else {
            Http::redirect_to('/categoria/?error');
        }
    }

    public function lista_modelos() {
        $categoria_id = intval($_POST['categoria_id']);
        (new Orm('modelo_imovel'))
            ->join("modelo_categoria", "modelo_categoria_modelo_id = modelo_imovel_id")
            ->where("modelo_categoria_categoria_id = '". $categoria_id ."'")
            ->get(1);
    }

    public function gravar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }  
        $vinculos_modelo = $_POST['vinculos_modelo'];
        unset($_POST['vinculos_modelo']);

        $alterou_modelo = $_POST['alterou_modelo'];
        unset($_POST['alterou_modelo']);

        $dados = Filter::parse_full($_POST);
        if (!isset($dados['categoria_imovel_nome']) || empty($dados['categoria_imovel_nome'])) {
            Http::redirect_to('/categoria/?error');
        }
        if (isset($_FILES['categoria_imovel_img_capa']) && !empty($_FILES['categoria_imovel_img_capa']) && $_FILES['categoria_imovel_img_capa']['error'] == 0) {
            $foto = Media::img_upload($_FILES['categoria_imovel_img_capa'], 'categoria');
            if (isset($foto->url)) {
                if (isset($dados['categoria_imovel_img_capa']) && !empty($dados['categoria_imovel_img_capa'])) {
                    $ds = DIRECTORY_SEPARATOR;
                    $path = Path::base() . $ds . 'media' . $ds . 'categoria' . $ds . $dados['categoria_imovel_img_capa'];
                    if (is_file($path)) {
                        @system("chmod -R 777 $path");
                        @unlink($path);
                    }
                }
                $dados['categoria_imovel_img_capa'] = $foto->url;
            } else {
                unset($dados['categoria_imovel_img_capa']);
            }
        } else {
            unset($dados['categoria_imovel_img_capa']);
        }
        $is_api = Http::get_in_params('gravar', 'int');
        $new_id = (new Orm('categoria_imovel'))->with($dados)->save();

        if (empty($dados['categoria_imovel_id'])) {
            // insert/save
            if (isset($vinculos_modelo[0])) {
                $inserts = [];
                foreach ($vinculos_modelo as $c) {
                    $inserts[] = "('$c', '$new_id')";
                }
                $inserts = implode(",", $inserts);
                (new Orm('modelo_categoria'))
                    ->query("INSERT INTO modelo_categoria (modelo_categoria_modelo_id, modelo_categoria_categoria_id) VALUES {$inserts};");
            }
        } else if ($alterou_modelo == '1') {
            // update/atualizar
            (new Orm('modelo_categoria'))
                ->where("modelo_categoria_categoria_id = '" . $dados['categoria_imovel_id'] . "'")
                ->drop();

            if (isset($vinculos_modelo[0])) {
                $inserts = [];
                foreach ($vinculos_modelo as $c) {
                    $inserts[] = "('$c', '". $dados['categoria_imovel_id'] ."')";
                }
                $inserts = implode(",", $inserts);
                (new Orm('modelo_categoria'))
                    ->query("INSERT INTO modelo_categoria (modelo_categoria_modelo_id, modelo_categoria_categoria_id) VALUES {$inserts};");
            }
        }

        if($is_api->value == 1) {
            echo $new_id;exit;
        } else {
            Http::redirect_to('/categoria/?success');
        }
    }

    public function remove()
    {
        if (!Usuario::verifyPermission('imoveis', 'remover')) {
            echo -1;exit;
        }  
        $id = Req::post('id', 'int');
        if ($id > 0) {
            $categoria = (new Orm('categoria_imovel'))->find($id);
            if (isset($categoria->categoria_imovel_img_capa) && !empty($categoria->categoria_imovel_img_capa)) {
                $ds = DIRECTORY_SEPARATOR;
                $path = Path::base() . $ds . 'media' . $ds . 'categoria' . $ds . $categoria->categoria_imovel_img_capa;
                if (is_file($path)) {
                    @system("chmod -R 777 $path");
                    @unlink($path);
                }
            }
            (new Orm('categoria_imovel'))->drop($id);
            echo 1;
        } else {
            echo -1;
        }
    }
}
