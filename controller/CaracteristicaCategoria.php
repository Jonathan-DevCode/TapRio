<?php

@session_start();

class CaracteristicaCategoria
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
        Template::view("admin.caracteristica_categoria.index", $data);
    }

    public function lista()
    {
        (new Orm('caracteristica_categoria'))->get(1);
    }

    public static function listaComCaracteristicas($tipo_caracteristica = "ambos")
    {
        $categorias = (new Orm('caracteristica_categoria'))->get();

        $categorias_retorno = [];

        if(isset($categorias[0])) {
            foreach($categorias as $cat) {
                $caracteristicas = (new Orm("caracteristica"))
                    ->where("(caracteristica_tipo = 'ambos' OR caracteristica_tipo = '{$tipo_caracteristica}') AND caracteristica_categoria_id = '". intval($cat->caracteristica_categoria_id) ."'")
                    ->order("caracteristica_diferencial DESC, caracteristica_nome")
                    ->get();
                
                if(isset($caracteristicas[0])) {
                    $cat->caracteristicas = $caracteristicas;
                    $categorias_retorno[] = $cat;
                }
            }
        }

        return $categorias_retorno;
    }

    public function nova()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }  
        $data = [
            'config' => (new Config)->get(),
            'caracteristica_categoria' => (new Orm('caracteristica_categoria'))->map(),
            'mapper' => ['config', 'caracteristica_categoria']
        ];
        Template::view("admin.caracteristica_categoria.form", $data);
    }

    public function editar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }  
        $id = Http::get_in_params('editar', 'int');
        if (isset($id->value) && !empty($id->value)) {
            $caracteristica_categoria = (new Orm('caracteristica_categoria'))->find($id->value);
            if (isset($caracteristica_categoria->caracteristica_categoria_id)) {
                $data = [
                    'config' => (new Config)->get(),
                    'caracteristica_categoria' => $caracteristica_categoria,
                    'mapper' => ['config', 'caracteristica_categoria']
                ];
                Template::view("admin.caracteristica_categoria.form", $data);
            } else {
                Http::redirect_to('/caracteristicaCategoria/?error');
            }
        } else {
            Http::redirect_to('/caracteristicaCategoria/?error');
        }
    }

    public function gravar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }  
        $dados = Filter::parse_full($_POST);
        if (!isset($dados['caracteristica_categoria_nome']) || empty($dados['caracteristica_categoria_nome'])) {
            Http::redirect_to('/caracteristicaCategoria/?error');
        }

        $is_api = Http::get_in_params('gravar', 'int');
        $new_id = (new Orm('caracteristica_categoria'))->with($dados)->save();
        if($is_api->value == 1) {
            echo $new_id;exit;
        } else {
            Http::redirect_to('/caracteristicaCategoria/?success');
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
            $caracteristica_categoria = (new Orm('caracteristica_categoria'))->find($id);
            (new Orm('caracteristica_categoria'))->drop($id);
            echo 1;
        } else {
            echo -1;
        }
    }
}
