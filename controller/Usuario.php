<?php

@session_start();

class Usuario
{

    public function __construct()
    {
        Sessao::check();
        if (!Usuario::verifyPermission('usuarios')) {
            Http::redirect_to('/admin/?error-perm');
        }

    }

    public function indexAction()
    {
        $usuario = (new Orm('usuario'))->get();
        $data = [
            'config' => (new Config)->get(),
            'usuario' => $usuario,

            'mapper' => ['config']
        ];
        Template::view("admin.usuario.index", $data);
    }

    public function novo()
    {
        if (!Usuario::verifyPermission('usuarios', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $permissoes = Usuario::getPermissoesPadrao(1);
        $data = [
            'config' => (new Config)->get(),
            'permissoes' => $permissoes,
            'usuario' => (new Orm('usuario'))->map(),
            'mapper' => ['config', 'usuario']
        ];
        Template::view("admin.usuario.form", $data);
    }

    public function lista()
    {
        (new Orm('usuario'))
            ->select("usuario_id, usuario_nome, usuario_email, usuario_status, usuario_level,
                IF(usuario_is_admin = 1, 'Administrador', 'Corretor') AS level_nome , IF(usuario_status = 1, 'Ativo', 'Inativo') AS status_nome")
            ->get(1);
    }

    public function editar()
    {
        if (!Usuario::verifyPermission('usuarios', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }

        $id = Http::get_in_params('id', 'int');
        if (isset($id->value) && $id->value > 0) {
            $id = $id->value;
            $usu = (new Orm('usuario'))->find($id);
            Http::back_on_false($usu);
            if ($usu->usuario_is_admin == '1') {
                $permissoes = Usuario::getPermissoesPadrao(1);
            } else {
                $permissoes = Usuario::listaPermissoes($usu->usuario_id);
            }
            $data = [
                'config' => (new Config)->get(),
                'usuario' => $usu,
                'permissoes' => $permissoes,
                'mapper' => ['config', 'usuario']
            ];

            Template::view('admin.usuario.form', $data);
        }
    }

    public function log()
    {
        if (!Usuario::verifyIsAdmin()) {
            Http::redirect_to('/admin/?error-perm');
        }

        $data = [
            'config' => (new Config)->get(),
            'mapper' => ['config']
        ];

        Template::view('admin.usuario.logs', $data);
    }

    public function listLogs() {

        (new Orm('log'))
            ->select("*, DATE_FORMAT(log_created, '%d/%m/%Y às %H:%i') as log_created_formated")
            ->order("log_id DESC")
            ->get(1);
    }
    public function getLog() {
        $log_id = Req::post("log_id", 'int');
        $log = (new Orm('log'))
            ->select("*, DATE_FORMAT(log_created, '%d/%m/%Y às %H:%i') as log_created_formated")
            ->find($log_id);

        $log->log_msg      =   stripslashes($log->log_msg);
        $log->log_new_data =   json_decode(stripslashes($log->log_new_data));
        $log->log_old_data =   json_decode(($log->log_old_data));
        $log->diffs = [];

        if(!empty($log->log_new_data) && !empty($log->log_old_data)) {
            $new_data = (array) $log->log_new_data;
            $old_data = (array) $log->log_old_data;
            $diffs = [];

            foreach($new_data as $campo => $valor) {
                if($campo != "imovel_desc" && trim($new_data[$campo]) != trim($old_data[$campo])) {
                    $diffs[] = [
                        "field" => $campo,
                        "old" => $old_data[$campo],
                        "new" => $new_data[$campo],
                    ];
                }
            }

            $log->diffs = $diffs;
        }


        echo json_encode($log);
    }

    public static function listaPermissoes($usuario_id = 0)
    {
        $permissoes = (new Orm('permissao'))
            ->where("permissao_usuario_id = '" . intval($usuario_id) . "'")
            ->get();

        $permissoes = Usuario::ajustaPermissoes($permissoes);
        return $permissoes;
    }

    public static function ajustaPermissoes($permissoes = [])
    {

        $permissoes_retorno = Usuario::getPermissoesPadrao(0);
        if (!isset($permissoes[0])) {
            return $permissoes_retorno;
        }

        foreach ($permissoes as $permissao) {
            if(isset($permissoes_retorno[$permissao->permissao_slug])) {
                $permissoes_retorno[$permissao->permissao_slug] = [
                    "name" => $permissoes_retorno[$permissao->permissao_slug]['name'],
                    "visualizar" => $permissao->permissao_visualizar,
                    "gerenciar" => $permissao->permissao_gerenciar,
                    "remover" => $permissao->permissao_remover,
                    "acesso" => $permissao->permissao_acesso,
                ];
            }
        }

        return $permissoes_retorno;
    }

    public static function getPermissoesPadrao($value = 0)
    {
        $acesso = "self";
        if($value == 1) {
            $acesso = "all";
        }
        return [
            "imoveis" => [
                "name" => "Imóveis",
                "visualizar" => $value,
                "gerenciar" => $value,
                "remover" => $value,
                "acesso" => $acesso
            ],
            "slides" => [
                "name" => "Slides e Banners",
                "visualizar" => $value,
                "gerenciar" => $value,
                "remover" => $value,
                "acesso" => $acesso
            ],
            // "parceiros" => [
            //     "name" => "Parceiros",
            //     "visualizar" => $value,
            //     "gerenciar" => $value,
            //     "remover" => $value,
            //     "acesso" => $acesso
            // ],
            "paginas" => [
                "name" => "Páginas",
                "visualizar" => $value,
                "gerenciar" => $value,
                "remover" => $value,
                "acesso" => $acesso
            ],
            "integracoes" => [
                "name" => "Integrações XML",
                "visualizar" => $value,
                "gerenciar" => $value,
                "remover" => $value,
                "acesso" => $acesso
            ],
            "clientes" => [
                "name" => "Clientes",
                "visualizar" => $value,
                "gerenciar" => $value,
                "remover" => $value,
                "acesso" => $acesso
            ],
            // "localidades" => [
            //     "name" => "Localidades",
            //     "visualizar" => $value,
            //     "gerenciar" => $value,
            //     "remover" => $value,
            //     "acesso" => $acesso
            // ],
            "usuarios" => [
                "name" => "Usuarios",
                "visualizar" => $value,
                "gerenciar" => $value,
                "remover" => $value,
                "acesso" => $acesso
            ],
            "chaves" => [
                "name" => "Chaves",
                "visualizar" => $value,
                "gerenciar" => $value,
                "remover" => $value,
                "acesso" => $acesso
            ],

        ];
    }


    public function gravar()
    {
        if (!Usuario::verifyPermission('usuarios', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }

        $keys_permission = [];

        $default_permission = Usuario::getPermissoesPadrao(0);

        foreach ($default_permission as $permissao => $values) {
            $keys_permission[] = "permissao_visualizar_{$permissao}";
            $keys_permission[] = "permissao_gerenciar_{$permissao}";
            $keys_permission[] = "permissao_remover_{$permissao}";
            $keys_permission[] = "permissao_acesso_{$permissao}";
        }

        if(!isset($_POST['usuario_is_admin']) && $_POST['usuario_id'] != Session::node('uid')) {
            $_POST['usuario_is_admin'] = '0';
        }

        $dados_permissoes = [];
        foreach ($keys_permission as $key) {
            if (!isset($_POST[$key])) {
                $_POST[$key] = '0';
            }

            $key_explode = explode("_", $key);
            $acao = $key_explode[1];
            $slug = $key_explode[2];

            $dados_permissoes[$slug][$acao] = $_POST[$key];
            unset($_POST[$key]);
        }

        $permission_changed = $_POST['permission_changed'];
        unset($_POST['permission_changed']);

        // Filter::pre($dados_permissoes, 1);

        if (isset($_POST['usuario_nome']) && !empty($_POST['usuario_nome'])) {
            if (trim($_POST['usuario_pass']) != "" && Req::post('usuario_pass') != "") {
                Req::crypt('usuario_pass');
            } else {
                unset($_POST['usuario_pass']);
            }
            $save = (new Orm('usuario'))->with($_POST)->save();
            Http::back_on_false($save);

            if (isset($_POST['usuario_id']) && !empty($_POST['usuario_id'])) {
                // edit
                if ($permission_changed == 1) {
                    $user_id = $_POST['usuario_id'];
                    (new Orm('permissao'))
                        ->where("permissao_usuario_id = '" . $user_id . "'")
                        ->drop();
                    Usuario::gravaPermissoes($user_id, $dados_permissoes);
                }
            } else {
                // new
                $user_id = $save;
                Usuario::gravaPermissoes($user_id, $dados_permissoes);
            }

            Http::redirect_to('/usuario/?success');
        }
    }

    public static function gravaPermissoes($user_id, $dados_permissoes)
    {
        $inserts = [];
        foreach ($dados_permissoes as $slug => $permissao) {
            $inserts[] = "('". $slug ."', '". $permissao['visualizar'] ."', '". $permissao['gerenciar'] ."', '". $permissao['remover'] ."', '". $permissao['acesso'] ."', '". $user_id ."')";
        }
        $inserts = implode(",", $inserts);
        (new Orm('permissao'))
            ->query("INSERT INTO permissao (permissao_slug, permissao_visualizar, permissao_gerenciar, permissao_remover, permissao_acesso, permissao_usuario_id) VALUES {$inserts};");
    }

    public function remove()
    {
        if (!Usuario::verifyPermission('usuarios', 'remover')) {
            echo -1;
            exit;
        }
        $usuarios = (new Orm('usuario'))->get();
        if(sizeof($usuarios) <= 1) {
            echo -1;
            exit;
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            (new Orm('usuario'))->drop($id);
            echo 1;
        } else {
            echo -1;
        }
    }


    public function altera_status()
    {
        if (!Usuario::verifyPermission('usuarios', 'gerenciar')) {
            return false;
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            $status = intval($_POST['status']);
            $status == 1 ? $status = 0 : $status = 1;
            $data = [
                'id' => $id,
                'status' => $status
            ];
            (new Orm('usuario'))->with($data)->save();
        }
    }

    public function avatar_upload()
    {
        if (!Usuario::verifyPermission('usuarios', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        if (!empty($_FILES['avatar']) && !empty($_POST['usuario_id']) && isset($_POST['usuario_id']) && isset($_FILES['avatar'])) {
            $file = $_FILES['avatar'];
            $id = intval($_POST['usuario_id']);
            $img = Media::img_upload($file, 'avatar');
            if (is_object($img)) {
                $current = (new Orm('usuario'))->select('usuario_avatar')->find($id);
                $current_login = Path::base() . "/media/avatar/$current->usuario_avatar";
                if (file_exists($current_login)) {
                    @unlink($current_login);
                }
                $data = ['avatar' => $img->url, 'id' => $id];
                (new Orm('usuario'))->with($data)->save();

                Http::redirect_to("/usuario/editar/id/$id/?success");
            } else {
                $current = (new Orm('usuario'))->select('usuario_avatar')->find($id);
                $current_login = Path::base() . "/media/avatar/$current->usuario_avatar";
                if (file_exists($current_login)) {
                    @unlink($current_login);
                }
                $data = ['avatar' => $current->usuario_avatar ?? "", 'id' => $id];
                (new Orm('usuario'))->with($data)->save();

                Http::redirect_to("/usuario/editar/id/$id/?success");
            }
        } else {
            Http::redirect_to("/usuario/?erro");
        }
    }


    public function avatar_upload_profile()
    {
        if (!Usuario::verifyPermission('usuarios', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        if (!empty($_FILES['avatar']) && !empty($_POST['usuario_id']) && isset($_POST['usuario_id']) && isset($_FILES['avatar'])) {
            $file = $_FILES['avatar'];
            $id = $_SESSION['node']['uid'];
            $img = Media::img_upload($file, 'avatar');
            if (is_object($img)) {
                $current = (new Orm('usuario'))->select('usuario_avatar')->find($id);
                $current_login = Path::base() . "/media/avatar/$current->usuario_avatar";
                if (file_exists($current_login)) {
                    @unlink($current_login);
                }
                $data = ['avatar' => $img->url, 'id' => $id];
                (new Orm('usuario'))->with($data)->save();

                Http::redirect_to("/usuario/editar/id/$id/?success");
            } else {
                $current = (new Orm('usuario'))->select('usuario_avatar')->find($id);
                $current_login = Path::base() . "/media/avatar/$current->usuario_avatar";
                if (file_exists($current_login)) {
                    @unlink($current_login);
                }
                $data = ['avatar' => $current, 'id' => $id];
                (new Orm('usuario'))->with($data)->save();

                Http::redirect_to("/usuario/editar/id/$id/?success");
            }
        } else {
            Http::redirect_to("/usuario/?erro");
        }
    }

    public static function verifyPermission($slug = "", $action = "visualizar") {
        $is_admin = Session::node('uis_admin');
        $permissoes = Session::node('upermissions');

        if(!$permissoes) {
            return false;
        }

        if($is_admin == 'sim') return true;

        if(isset($permissoes[$slug]) && isset($permissoes[$slug][$action])) {
            return $permissoes[$slug][$action] == '1';
        }
        return false;
    }

    public static function verifyIsAdmin() {
        $is_admin = Session::node('uis_admin');

        return $is_admin == 'sim';
    }

    public static function verifyPermissaoAcesso($slug, $acesso) {
        $is_admin = Session::node('uis_admin');

        if($is_admin == 'sim') {
            return true;
        }

        $permissoes = Session::node('upermissions');

        if(!$permissoes) {
            return false;
        }

        return $permissoes[$slug]['acesso'] == $acesso;
    }
}
