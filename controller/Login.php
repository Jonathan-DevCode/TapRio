<?php

class Login
{
    public function __construct()
    {
        
        Session::start();
    }

    public function indexAction()
    {
        $email = '';
        $lembrar = '';
        if (Browser::cookie('umail')) {
            $email = Browser::cookie('umail');
            $lembrar = 'checked';
        }
        $data = [
            'config' => (new Config)->get(),
            
            'lembrar' => ['email' => $email, 'lembrar_ipt' => $lembrar],
            'mapper' => ['config', 'lembrar']
        ];
        Template::View("admin.login.index", $data);
    }


    public function auth()
    {
        $user = Req::post('login', 'string');
        $pass = Req::post('pass', 'string');
        if (isset($user) && !empty($user) && isset($pass) && !empty($pass)) {
            $pass = Parser::crypt($pass);
            $user = (new Orm('usuario'))->where("usuario_email = '$user' AND usuario_pass = '$pass'")->get();
            
            if (isset($user[0])) {
                $u = $user[0];
                
                $is_admin = $u->usuario_is_admin == '1' ? "sim" : "nao";
                Session::init();
                Session::node('uid', $u->usuario_id);
                Session::node('unome', $u->usuario_nome);
                Session::node('umail', $u->usuario_email);                                
                Session::node('uis_admin', $is_admin);
                Session::node('upermissions', Usuario::listaPermissoes($u->usuario_id));
                Session::node('uip', (new Browser)->get_ip());
                //(new Log)->add();
                if ($u->usuario_status == 0) {
                    Http::redirect_to("/login/?desativado");
                    exit;
                }
                if (Req::post('lembrar')) {
                    //Browser::cookie('umail', $u->usuario_email);
                    setcookie('umail', $u->usuario_email, time() + (86400 * 30), '/');
                } else {
                    //Browser::cookie('umail', 'drop');
                    setcookie('umail', '', time() - 3600, '/');
                }
                Http::redirect_to("/admin/");
            } else {
                Http::redirect_to("/login/?incorreto");
            }
        } else {
            Http::redirect_to("/login/?incorreto");
        }
    }


    public function logout()
    {
        Session::destroy();
        Http::redirect_to("/admin/");
    }


    public function gera_token()
    {
        $email = Req::post('email', 'string');
        if (isset($email) && !empty($email)) {
            $cliente = (new Orm('usuario'))
                ->select('usuario_id as id, usuario_nome as nome, usuario_token as token')
                ->find_by('usuario_email', $email);

            if (isset($cliente) && !empty($cliente)) {
                $token = md5(time());
                $url = Http::base() . '/login/muda_senha/' . $token;
                $mensagem = '<h1>Olá mundo</h1>';
                $data = ['id' => $cliente->id, 'token' => $token];
                (new Orm('usuario'))->with($data)->save();
                $mensagem = $url;
                $msg = [
                    'assunto' => "solicitacao de mudança de senha",
                    'nome' => $cliente->nome,
                    'email' => $email,
                    'mensagem' => $mensagem,
                ];
                Sender::mail($msg);
                Http::redirect_to('/?recupera-send');
            } else {
                Http::redirect_to('/?email-invalido');
            }
        } else {
            Http::redirect_to('/?email-invalido');
        }
    }

    public function muda_senha()
    {

        $token = Http::get_param('2', 'string');
        if (isset($token) && !empty($token)) {
            $usuario = (new Orm('usuario'))
                ->select('usuario_id as id_rec, usuario_nome as nome, usuario_token as token')
                ->find_by('usuario_token', $token);
            if (isset($usuario->id_rec) && !empty($usuario->id_rec)) {
                $conf = (new Orm('config'))->get()[0];
                $data = [
                    'config' => (new Config)->get(),
                    'usuario' => $usuario,
                    
                    'mapper' => ['config', 'usuario'],
                ];
                Template::View("admin.login.nova-senha", $data);
            } else {
                Http::redirect_to('/home/');
            }
        } else {
            Http::redirect_to('/home/');
        }
    }

    public function nova_senha()
    {
        $cliente_id = Req::post('usuario_id', 'int');
        $nova_senha = Req::post('nova_senha', 'string');

        if (isset($cliente_id) && $cliente_id > 0 && isset($nova_senha) && !empty($nova_senha)) {
            $token = md5(time(uniqid()));
            $data = [
                'id' => $cliente_id,
                'token' => $token,
                'pass' => md5($nova_senha),
            ];

            (new Orm('usuario'))->with($data)->save();
            Http::redirect_to('/home/');
        } else {
            Http::redirect_to('/home/');
        }
    }
}
