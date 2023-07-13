<?php

@session_start();

class Caracteristica
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
        Template::view("admin.caracteristica.index", $data);
    }

    public function lista()
    {
        (new Orm('caracteristica'))
            ->select("caracteristica.*, caracteristica_categoria.caracteristica_categoria_nome AS caracteristica_categoria_nome")
            ->join("caracteristica_categoria", "caracteristica_categoria.caracteristica_categoria_id = caracteristica.caracteristica_categoria_id", "LEFT")
            ->get(1);
    }

    public function nova()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }  
        $data = [
            'config' => (new Config)->get(),
            'caracteristica' => (new Orm('caracteristica'))->map(),
            'categorias' => (new Orm('caracteristica_categoria'))->get(),
            'mapper' => ['config', 'caracteristica']
        ];
        Template::view("admin.caracteristica.form", $data);
    }

    public function editar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }  
        $id = Http::get_in_params('editar', 'int');
        if (isset($id->value) && !empty($id->value)) {
            $caracteristica = (new Orm('caracteristica'))->find($id->value);
            if (isset($caracteristica->caracteristica_id)) {
                $data = [
                    'config' => (new Config)->get(),
                    'caracteristica' => $caracteristica,
                    'categorias' => (new Orm('caracteristica_categoria'))->get(),
                    'mapper' => ['config', 'caracteristica']
                ];
                Template::view("admin.caracteristica.form", $data);
            } else {
                Http::redirect_to('/caracteristica/?error');
            }
        } else {
            Http::redirect_to('/caracteristica/?error');
        }
    }

    public function gravar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }  
        $dados = Filter::parse_full($_POST);
        if (!isset($dados['caracteristica_nome']) || empty($dados['caracteristica_nome'])) {
            Http::redirect_to('/caracteristica/?error');
        }

        $is_api = Http::get_in_params('gravar', 'int');
        $new_id = (new Orm('caracteristica'))->with($dados)->save();
        if($is_api->value == 1) {
            echo $new_id;exit;
        } else {
            Http::redirect_to('/caracteristica/?success');
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
            $caracteristica = (new Orm('caracteristica'))->find($id);
            (new Orm('caracteristica'))->drop($id);
            echo 1;
        } else {
            echo -1;
        }
    }
}
