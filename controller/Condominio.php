<?php

@session_start();

class Condominio
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
        Template::view("admin.condominio.index", $data);
    }

    public function lista()
    {
        (new Orm('condominio'))->get(1);
    }

    public function nova()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $caracteristicas_vinculadas = [];
        $data = [
            'config' => (new Config)->get(),
            'condominio' => (new Orm('condominio'))->map(),
            'caracteristica_categorias' => CaracteristicaCategoria::listaComCaracteristicas('condominio'),
            'caracteristicas_vinculadas' => $caracteristicas_vinculadas,
            'mapper' => ['config', 'condominio']
        ];

        Template::view("admin.condominio.form", $data);
    }

    public function editar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }

        $id = Http::get_in_params('editar', 'int');
        if (isset($id->value) && !empty($id->value)) {
            $condominio = (new Orm('condominio'))->find($id->value);
            if (isset($condominio->condominio_id)) {
                $caracteristicas_vinculadas = Condominio::listaCaracteristicas($condominio->condominio_id);
                $data = [
                    'config' => (new Config)->get(),
                    'condominio' => $condominio,
                    'caracteristica_categorias' => CaracteristicaCategoria::listaComCaracteristicas('condominio'),
                    'caracteristicas_vinculadas' => $caracteristicas_vinculadas,
                    'mapper' => ['config', 'condominio']
                ];
                Template::view("admin.condominio.form", $data);
            } else {
                Http::redirect_to('/condominio/?error');
            }
        } else {
            Http::redirect_to('/condominio/?error');
        }
    }

    public function rotaciona_imagens()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            echo -1;
            exit;
        }
        $id = intval($_POST['condominio_id']);
        if ($id > 0) {
            if (isset($_POST['data'])) {
                foreach ($_POST['data'] as $k) {
                    $ids[] = $k['id'];
                }
                if (sizeof($ids) > 1) {
                    $ids = implode(',', $ids);
                    $where = "foto_condominio_condominio = '$id' AND foto_condominio_id IN ($ids)";
                } else {
                    $ids = $ids[0];
                    $where = "foto_condominio_condominio = '$id' AND foto_condominio_id = $ids";
                }
                $fotos_para_girar = (new Orm('foto_condominio'))
                    ->select("foto_condominio_img as img")
                    ->where($where)
                    ->get();

                if (isset($fotos_para_girar[0])) {
                    $ds = DIRECTORY_SEPARATOR;
                    foreach ($fotos_para_girar as $img) {
                        (new Condominio)->rotaciona_img($img->img);
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

    public function gravar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $caracteristicas = $_POST['condominio_caracteristicas'];
        unset($_POST['condominio_caracteristicas']);
        $dados = Filter::parse_full($_POST);
        if (!isset($dados['condominio_nome']) || empty($dados['condominio_nome'])) {
            Http::redirect_to('/condominio/?error');
        }

        $alterou_caracteristica = $dados['alterou_caracteristica'] ?? 0;
        unset($dados['alterou_caracteristica']);


        $is_api = Http::get_in_params('gravar', 'int');
        $new_id = (new Orm('condominio'))->with($dados)->save();

        if (isset($_POST['condominio_id']) && !empty($_POST['condominio_id'])) {
            (new Orm('condominio'))->query("UPDATE condominio SET condominio_descricao = '" . addslashes($_POST['condominio_descricao']) . "' WHERE condominio_id = " . $_POST['condominio_id'] . ";", false);
        } else {
            (new Orm('condominio'))->query("UPDATE condominio SET condominio_descricao = '" . addslashes($_POST['condominio_descricao']) . "' WHERE condominio_id = " . $new_id . ";", false);
        }

        if (empty($dados['condominio_id'])) {
            // insert/save
            if (isset($caracteristicas[0])) {
                $inserts = [];
                foreach ($caracteristicas as $c) {
                    $inserts[] = "('$new_id', '$c')";
                }
                $inserts = implode(",", $inserts);
                (new Orm('condominio_caracteristica'))
                    ->query("INSERT INTO condominio_caracteristica (condominio_caracteristica_condominio_id, condominio_caracteristica_caracteristica_id) VALUES {$inserts};");
            }
        } else if ($alterou_caracteristica == '1') {
            // update/atualizar
            (new Orm('condominio_caracteristica'))
                ->where("condominio_caracteristica_condominio_id = '" . $dados['condominio_id'] . "'")
                ->drop();

            if (isset($caracteristicas[0])) {
                $inserts = [];
                foreach ($caracteristicas as $c) {
                    $inserts[] = "('" . $dados['condominio_id'] . "', '$c')";
                }
                $inserts = implode(",", $inserts);
                (new Orm('condominio_caracteristica'))
                    ->query("INSERT INTO condominio_caracteristica (condominio_caracteristica_condominio_id, condominio_caracteristica_caracteristica_id) VALUES {$inserts};");
            }
        }

        if ($is_api->value == 1) {
            echo $new_id;
            exit;
        } else {
            if (empty($dados['condominio_id'])) {
                Http::redirect_to('/condominio/editar/' . $new_id);
            } else {
                Http::redirect_to('/condominio/?success');
            }
        }
    }


    public function rotaciona_img($img = null)
    {

        if (!Usuario::verifyPermission('condominios', 'gerenciar')) {
            echo -1;
            exit;
        }
        if (empty($img)) {
            $img = $_POST['img'];
        }

        if (!empty($img)) {

            try {
                Media::img_rotaciona($img, 'condominio');
                $ds = DIRECTORY_SEPARATOR;
                $rotate_nome = 'rotate_' . $img;
                $thumb_nome = 'thumb_' . $img;
                $watermark_nome = 'watermark_' . $img;


                $path_original = Path::base() . $ds . 'media' . $ds . 'condominio' . $ds . $img;
                $path_copia_rotate = Path::base() . $ds . 'media' . $ds . 'condominio' . $ds . $rotate_nome;
                $path_copia_water = Path::base() . $ds . 'media' . $ds . 'condominio' . $ds . $watermark_nome;
                $path_copia = Path::base() . $ds . 'media' . $ds . 'condominio' . $ds . $thumb_nome;


                if (is_file($path_original)) {
                    @system("chmod -R 777 $path_original");
                    @copy($path_original, $path_copia);
                    @copy($path_original, $path_copia_water);



                    Media::img_redimensiona($thumb_nome, 'condominio', 20);
                    Media::watermark($path_copia, $thumb_nome, 'condominio');
                    Media::watermark($path_copia_water, $watermark_nome, 'condominio');
                }

                return true;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
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
            // $condominio = (new Orm('condominio'))->find($id);
            (new Orm('condominio'))->drop($id);
            (new Orm('condominio_caracteristica'))
                ->where("condominio_caracteristica_condominio_id = '" . $id . "'")
                ->drop();
            echo 1;
        } else {
            echo -1;
        }
    }

    public static function listaCaracteristicas($condominio_id = 0)
    {
        $ids = [];
        $caracteristicas = (new Orm('condominio_caracteristica'))
            ->where("condominio_caracteristica_condominio_id = '{$condominio_id}'")
            ->get();

        if (isset($caracteristicas[0])) {
            foreach ($caracteristicas as $c) {
                $ids[] = $c->condominio_caracteristica_caracteristica_id;
            }
        }

        return $ids;
    }


    public function enviar_img()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            echo -1;
            exit;
        }
        $id = intval(Http::get_in_params('id')->value);
        if ($id > 0) {
            if (isset($_FILES) && !empty($_FILES)) {


                $newname =  $id . '_' . rand(0, 999999);
                /**upload da imagem */
                $media = Media::img_upload($_FILES['file'], 'condominio', $newname);

                if (isset($media->url) && !empty($media->url)) {

                    /* ---------------------------- THUMB ----------------------- */
                    $ds = DIRECTORY_SEPARATOR;

                    $nome_arquivo_original = $media->url;
                    $thumb_nome = 'thumb_' . $nome_arquivo_original;
                    $watermark_nome = 'watermark_' . $nome_arquivo_original;

                    $path_original = Path::base() . $ds . 'media' . $ds . 'condominio' . $ds . $nome_arquivo_original;
                    $path_copia = Path::base() . $ds . 'media' . $ds . 'condominio' . $ds . $thumb_nome;
                    $path_copia_water = Path::base() . $ds . 'media' . $ds . 'condominio' . $ds . $watermark_nome;
                    if (is_file($path_original)) {
                        @system("chmod -R 777 $path_original");
                        @system("chmod -R 777 $path_copia");
                        @system("chmod -R 777 $path_copia_water");
                        @copy($path_original, $path_copia);
                        @copy($path_original, $path_copia_water);



                        Media::img_redimensiona($thumb_nome, 'condominio', 100);
                        Media::img_redimensiona($watermark_nome, 'condominio', 100);
                        Media::watermark($path_copia, $thumb_nome, 'condominio');
                        Media::watermark($path_copia_water, $watermark_nome, 'condominio');
                    }
                    /* ---------------------------- THUMB ----------------------- */
                    $data = [
                        'img' => $media->url,
                        'url' => $media->path,
                        'condominio' => $id,
                    ];
                    (new Orm('foto_condominio'))->with($data)->save();
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

    public function lista_img_condominio()
    {
        $id = intval(Http::get_in_params('id')->value);
        if ($id > 0) {
            (new Orm('foto_condominio'))->select('foto_condominio_id, foto_condominio_pos, foto_condominio_img, foto_condominio_url')
                ->where("foto_condominio_condominio = '$id'")
                ->order('foto_condominio_pos ASC')
                ->get('true');
        } else {
            echo -1;
            exit;
        }
    }

    public function ordena_img()
    {
        if (!Usuario::verifyPermission('condominios', 'gerenciar')) {
            echo -1;
            exit;
        }
        $condominio_id = intval($_POST['condominio_id']);
        if ($condominio_id > 0 && isset($_POST['data']) && !empty($_POST['data'])) {
            $db_foto = (new Orm('foto_condominio'));
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

    public function remove_all_img_condominio()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            echo -1;
            exit;
        }
        $id = intval($_POST['condominio_id']);
        if ($id > 0) {
            $fotos = (new Orm('foto_condominio'))
                ->select("foto_condominio_img as img")
                ->where("foto_condominio_condominio = $id")
                ->get();
            if (isset($fotos[0])) {
                $ds = DIRECTORY_SEPARATOR;
                $path_delete = Path::base() . $ds . 'media' . $ds . 'condominio' . $ds;
                foreach ($fotos as $foto) {
                    if (file_exists($path_delete . $foto->img)) {
                        @unlink($path_delete . $foto->img);
                        @unlink($path_delete . 'thumb_' . $foto->img);
                    }
                }
            }
            (new Orm('foto_condominio'))
                ->where("foto_condominio_condominio = $id")
                ->drop();
            echo 0;
            exit;
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
        $id = intval($_POST['condominio_id']);
        if ($id > 0) {
            if (isset($_POST['data'])) {
                foreach ($_POST['data'] as $k) {
                    $ids[] = $k['id'];
                }
                if (sizeof($ids) > 1) {
                    $ids = implode(',', $ids);
                    $where = "foto_condominio_condominio = '$id' AND foto_condominio_id IN ($ids)";
                } else {
                    $ids = $ids[0];
                    $where = "foto_condominio_condominio = '$id' AND foto_condominio_id = $ids";
                }
                $fotos_para_deletar = (new Orm('foto_condominio'))
                    ->select("foto_condominio_img as img")
                    ->where($where)
                    ->get();

                if (isset($fotos_para_deletar[0])) {
                    $ds = DIRECTORY_SEPARATOR;
                    $path_delete = Path::base() . $ds . 'media' . $ds . 'condominio' . $ds;
                    foreach ($fotos_para_deletar as $foto) {
                        if (file_exists($path_delete . $foto->img)) {
                            @unlink($path_delete . $foto->img);
                            @unlink($path_delete . 'thumb_' . $foto->img);
                        }
                    }
                }
                (new Orm('foto_condominio'))
                    ->where($where)
                    ->drop();
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
}
