<?php

@session_start();

class Modelo
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
        Template::view("admin.modelo.index", $data);
    }

    public function lista()
    {
        (new Orm('modelo_imovel'))->get(1);
    }

    public function nova()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }

        $categorias_vinculadas = [];
        $data = [
            'config' => (new Config)->get(),
            'modelo' => (new Orm('modelo_imovel'))->map(),
            'categorias_vinculadas' => $categorias_vinculadas,
            'categoria_imovel' => (new Orm('categoria_imovel'))->get(),
            'mapper' => ['config', 'modelo']
        ];
        Template::view("admin.modelo.form", $data);
    }

    public function editar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Http::get_in_params('editar', 'int');
        if (isset($id->value) && !empty($id->value)) {
            $modelo = (new Orm('modelo_imovel'))->find($id->value);
            if (isset($modelo->modelo_imovel_id)) {
                $categorias_vinculadas = Modelo::listaCategorias($modelo->modelo_imovel_id);
                $data = [
                    'config' => (new Config)->get(),
                    'modelo' => $modelo,
                    'categorias_vinculadas' => $categorias_vinculadas,
                    'categoria_imovel' => (new Orm('categoria_imovel'))->get(),
                    'mapper' => ['config', 'modelo']
                ];
                Template::view("admin.modelo.form", $data);
            } else {
                Http::redirect_to('/modelo/?error');
            }
        } else {
            Http::redirect_to('/modelo/?error');
        }
    }

    public function gravar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $categorias = $_POST['modelo_categorias'];
        unset($_POST['modelo_categorias']);

        $alterou_categoria = $_POST['alterou_categoria'];
        unset($_POST['alterou_categoria']);

        $dados = Filter::parse_full($_POST);
        if (!isset($dados['modelo_imovel_nome']) || empty($dados['modelo_imovel_nome'])) {
            Http::redirect_to('/modelo/?error');
        }

        $is_api = Http::get_in_params('gravar', 'int');
        $new_id = (new Orm('modelo_imovel'))->with($dados)->save();

        if (empty($dados['modelo_imovel_id'])) {
            // insert/save
            if (isset($categorias[0])) {
                $inserts = [];
                foreach ($categorias as $c) {
                    $inserts[] = "('$new_id', '$c')";
                }
                $inserts = implode(",", $inserts);
                (new Orm('modelo_categoria'))
                    ->query("INSERT INTO modelo_categoria (modelo_categoria_modelo_id, modelo_categoria_categoria_id) VALUES {$inserts};");
            }
        } else if ($alterou_categoria == '1') {
            // update/atualizar
            (new Orm('modelo_categoria'))
                ->where("modelo_categoria_modelo_id = '" . $dados['modelo_imovel_id'] . "'")
                ->drop();

            if (isset($categorias[0])) {
                $inserts = [];
                foreach ($categorias as $c) {
                    $inserts[] = "('$new_id', '$c')";
                }
                $inserts = implode(",", $inserts);
                (new Orm('modelo_categoria'))
                    ->query("INSERT INTO modelo_categoria (modelo_categoria_modelo_id, modelo_categoria_categoria_id) VALUES {$inserts};");
            }
        }

        if ($is_api->value == 1) {
            echo $new_id;
            exit;
        } else {
            Http::redirect_to('/modelo/?success');
        }
    }

    public function remove()
    {
        if (!Usuario::verifyPermission('imoveis', 'remover')) {
            echo -1;
            exit;
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            $modelo = (new Orm('modelo_imovel'))->find($id);
            (new Orm('modelo_imovel'))->drop($id);
            echo 1;
        } else {
            echo -1;
        }
    }

    public static function listaCategorias($modelo_id = 0)
    {
        $ids = [];
        $categorias = (new Orm('modelo_categoria'))
            ->where("modelo_categoria_modelo_id = '{$modelo_id}'")
            ->get();

        if (isset($categorias[0])) {
            foreach ($categorias as $c) {
                $ids[] = $c->modelo_categoria_categoria_id;
            }
        }

        return $ids;
    }
}
