<?php

class PaginaAdmin
{

    public function __construct()
    {
        Sessao::check();
        if (!Usuario::verifyPermission('paginas')) {
            Http::redirect_to('/admin/?error-perm');
        }
    }

    public function indexAction()
    {
        $data = [
            'config' => (new Config)->get(),

            'mapper' => ['config']
        ];
        Template::view('admin.pagina.index', $data, 1);
    }
    public function categoria()
    {
        $data = [
            'config' => (new Config)->get(),

            'mapper' => ['config']
        ];
        Template::view('admin.pagina.categoria', $data, 1);
    }
    public function subcategoria()
    {
        $data = [
            'config' => (new Config)->get(),

            'mapper' => ['config']
        ];
        Template::view('admin.pagina.subcategoria', $data, 1);
    }

    public function lista()
    {
        (new Orm('pagina'))
            ->select("pagina_id, pagina_titulo, IF(pagina_status = 1, 'Ativa', 'Inativa') AS pagina_status_nome, pagina_status, pagina_categoria, categoria_pagina_nome, pagina_capa")
            ->join('categoria_pagina', 'categoria_pagina_id = pagina_categoria', 'LEFT')
            ->order('pagina_id DESC')
            ->get(1);
    }

    public function lista_categoria()
    {
        (new Orm('categoria_pagina'))
            ->select("categoria_pagina_id, categoria_pagina_nome, categoria_pagina_cor, categoria_pagina_icone, categoria_pagina_topo, categoria_pagina_rodape")
            ->order('categoria_pagina_pos ASC')
            ->get(1);
    }
    public function gravar_categoria()
    {
        if (!Usuario::verifyPermission('paginas', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        if (isset($_POST['categoria_pagina_nome']) && !empty($_POST['categoria_pagina_nome'])) {
            $_POST['categoria_pagina_url'] = Filter::slug($_POST['categoria_pagina_nome']);
            $format = ['categoria_pagina_nome' => 'text', 'categoria_pagina_url' => 'text'];
            (new Orm('categoria_pagina'))->with($_POST)->format($format)->save();
            if (Req::get('return')) {
                Http::redirect_to("/" . Req::get('return'));
            } else {
                Http::redirect_to("/pagina-categoria/?success");
            }
        } else {
            Http::redirect_to("/pagina-categoria");
        }
    }
    public function remover_categoria()
    {
        if (!Usuario::verifyPermission('paginas', 'remover')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            (new Orm('categoria_pagina'))->drop($id);
            echo 1;
        } else {
            echo -1;
        }
    }


    public function gravar()
    {

        if (!Usuario::verifyPermission('paginas', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        if (isset($_POST['pagina_titulo']) && !empty($_POST['pagina_titulo'])) {
            Req::drop('_wysihtml5_mode');
            Req::drop_blank();
            if (isset($_FILES['files'])) {
                unset($_FILES['files']);
            }



            $id = Req::post('pagina_id');
            if (!empty($_FILES['pagina_capa']['name'])) {
                $media = Media::img_upload($_FILES['pagina_capa'], 'pagina');
            }

            if (!empty($media)) {
                $_POST['pagina_capa'] = $media->url;
                if (intval($id) > 0) {
                    $excluir = (new Orm('pagina'))->select('pagina_capa as url')->find($id);
                    $ds = DIRECTORY_SEPARATOR;
                    $path = Path::base() . $ds . 'media' . $ds . 'pagina' . $ds . $excluir->url;
                    if (is_file($path)) {
                        @system("chmod -R 777 $path");
                        //                    @chmod("$path", 775);
                        @unlink($path);
                    }
                }
            }
            $escope = [
                'pagina_desc' => 'text',
                'pagina_keywords' => 'text',
            ];
            // $_POST['pagina_status'] = 1;
            if (isset($_POST['pagina_titulo'])) {
                $_POST['pagina_url'] = Filter::slug($_POST['pagina_titulo']);
            }
            $pagina = (new Orm('pagina'))->with($_POST)->save();
            if ($pagina > 0) {
                Http::redirect_to('/pagina-lista/?success');
            } else {
                Http::redirect_to('/pagina-lista/?error');
            }
        }
    }
    public function editar()
    {
        if (!Usuario::verifyPermission('paginas', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Http::get_in_params('id', 'int');

        if (isset($id->value) && $id->value > 0) {
            $id = $id->value;
            $base_uri = Http::base();
            $pagina = (new Orm('pagina'))
                ->select("*,DATE_FORMAT(pagina_updated, '%d de %M de %Y') as pagina_updated,IF(pagina_capa IS NOT NULL,
                    CONCAT('$base_uri/media/pagina/', pagina_capa), '') AS pagina_capa")
                ->join("categoria_pagina", "categoria_pagina_id = pagina_categoria", 'LEFT')
                ->where("pagina_id = $id")
                ->get();
            if (isset($pagina)) {
                $data = [
                    'pagina' => $pagina[0],

                    'config' => (new Config)->get(),
                    'mapper' => ['config', 'pagina']
                ];
                Template::view('admin.pagina.form', $data, 1);
            } else {
                Http::redirect_to('/pagina-lista/');
            }
        } else {
            Http::redirect_to('/pagina-lista/');
        }
    }
    public function novo()
    {
        if (!Usuario::verifyPermission('paginas', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $pagina = (new Orm('pagina'))
            ->join("categoria_pagina", "categoria_pagina_id = pagina_categoria", 'INNER')
            ->map();
        $data = [
            'pagina' => $pagina,
            'config' => (new Config)->get(),

            'mapper' => ['config', 'pagina']
        ];
        $data['pagina']->categoria_pagina_url = '';
        Template::view('admin.pagina.form', $data);
    }

    public function remover()
    {

        if (!Usuario::verifyPermission('paginas', 'remover')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Req::post('id', 'int');
        $img = Req::post('img');
        $ds = DIRECTORY_SEPARATOR;
        $path = Path::base() . $ds . 'media' . $ds . 'pagina' . $ds . $img;
        if ($id > 0) {
            (new Orm('pagina'))->drop($id);
            if (is_file($path)) {
                @system("chmod -R 777 $path");
                @unlink($path);
            }
            echo 1;
        } else {
            echo -1;
        }
    }

    public function altera_status()
    {
        if (!Usuario::verifyPermission('paginas', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            $status = intval($_POST['pagina_status']);
            $status == 1 ? $status = 0 : $status = 1;
            $data = [
                'id' => $id,
                'pagina_status' => $status
            ];
            (new Orm('pagina'))->with($data)->save();
        }
    }

    public function url()
    {
        if (isset($_POST['value'])) {
            $_POST['value'] = Filter::slug($_POST['value']);
        }
        echo $_POST['value'];
    }

    public function ordenar()
    {
        if (!Usuario::verifyPermission('paginas', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $cats = json_decode(Req::post('diff'));
        $db_cat = (new Orm('categoria_pagina'));

        foreach ($cats as $cat) {
            $id = explode('-', $cat->node->_prevClass);
            if (intval($id[2]) > 0 && isset($id[2])) {
                $data = [
                    'id' => $id[2],
                    'pos' => $cat->newPosition,
                ];
                $db_cat->with($data)->save();
            }
        }
    }
}
