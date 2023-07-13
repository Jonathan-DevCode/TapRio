<?php

class Slide
{

    public function __construct()
    {
        Sessao::check();
        if (!Usuario::verifyPermission('slides')) {
            Http::redirect_to('/admin/?error-perm');
        }
    }

    public function indexAction()
    {
        $config = (new Config)->get();
        $data = [
            'config' => $config,
            'mapper' => ['config']
        ];
        Template::view('admin.slide.index', $data, 1);
    }

    public function lista()
    {
        (new Orm('slide'))
            ->select("
                slide_id, slide_url, slide_img, 
                IF(slide_status = 1, 'Ativo', 'Inativo') AS slide_status_nome, 
                CASE slide_tipo 
                WHEN '1' THEN 'Slide Topo' 
                WHEN '2' THEN 'Slide Site' 
                WHEN '3' THEN 'Slide Venda ou Alugue' 
                WHEN '4' THEN 'Slide Administração' 
                END AS slide_tipo, 
                slide_status, slide_pos")
            ->order('slide_pos ASC')
            ->get(1);
    }


    public function gravar()
    {
        if (!Usuario::verifyPermission('slides', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }

        if (!intval($_POST['slide_id']) > 0 && intval($_FILES['slide_img']['error']) > 0) {
            Http::redirect_to("/slide/?error");
        }

        $media = Media::img_upload($_FILES['slide_img'], 'slides');
        if (isset($media->url)) {
            $ds = DIRECTORY_SEPARATOR;
            $path = Path::base() . $ds . 'media' . $ds . 'slides' . $ds . $_POST['slide_img'];
            if (is_file($path)) {
                @system("chmod -R 777 $path");
                @unlink($path);
            }
            $_POST['slide_img'] = $media->url;
        } else {
            unset($_POST['slide_img']);
        }
        $slide = (new Orm('slide'))->with($_POST)->format(['slide_url' => 'text'])->save();
        $slide > 0 ? Http::redirect_to("/slide/?success") : Http::redirect_to("/slide/?error");
    }


    public function altera_status()
    {
        if (!Usuario::verifyPermission('slides', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            $status = intval($_POST['slide_status']);
            $status == 1 ? $status = 0 : $status = 1;
            $data = [
                'id' => $id,
                'slide_status' => $status
            ];
            (new Orm('slide'))->with($data)->save();
        }
    }

    public function novo()
    {
        if (!Usuario::verifyPermission('slides', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $slide = (new Orm('slide'))->map();
        $data = [
            'slide' => $slide,
            'config' => (new Config)->get(),
            'mapper' => ['config', 'slide']
        ];
        Template::view('admin.slide.form', $data, 1);
    }
    public function editar()
    {
        if (!Usuario::verifyPermission('slides', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Http::get_in_params('id', 'int');
        if (isset($id->value) && $id->value > 0) {
            $id = $id->value;
            $escope = [
                'slide_url' => 'text',
                'slide_img' => 'text',
                'slide_status' => 'text',
            ];
            $slide = (new Orm('slide'))
                ->select("*")
                ->format($escope)->find($id);
            if (!empty($slide)) {
                $data = [
                    'slide' => $slide,

                    'config' => (new Config)->get(),
                    'mapper' => ['config', 'slide']
                ];
                Template::view('admin.slide.form', $data, 1);
            } else {
                Http::redirect_to('/slide-lista/');
            }
        } else {
            Http::redirect_to('/slide-lista/');
        }
    }

    public function remover()
    {
        if (!Usuario::verifyPermission('slides', 'remover')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Req::post('id', 'int');
        $img = Req::post('img');
        $ds = DIRECTORY_SEPARATOR;
        $path = Path::base() . $ds . 'media' . $ds . 'slides' . $ds . $img;
        if ($id > 0) {
            (new Orm('slide'))->drop($id);
            if (is_file($path)) {
                @system("chmod -R 777 $path");
                @unlink($path);
            }
            echo 1;
        } else {
            echo -1;
        }
    }

    public function ordenar()
    {
        if (!Usuario::verifyPermission('slides', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $slides = json_decode(Req::post('diff'));
        $db_slide = (new Orm('slide'));
        foreach ($slides as $slide) {
            $id = explode('-', $slide->node->_prevClass);
            if (intval($id[2]) > 0 && isset($id[2])) {
                $data = [
                    'id' => $id[2],
                    'pos' => $slide->newPosition,
                ];
                $db_slide->with($data)->save();
            }
        }
    }
}
