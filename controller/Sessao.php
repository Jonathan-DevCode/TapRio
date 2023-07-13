<?php

class Sessao
{

    static public function check($inactivity = false)
    {
        // if (!(new DB)->check("SELECT * FROM config")) {
        //     Http::redirect_to('/install');
        // }
        Session::start();
        //considera tempo de atividade definida em Session::init
        // verificação se está autenticado naquele dominio
        if(Session::node('uid')) {
            if ($inactivity) {
                if (!Session::node('uid') || Session::time_activity_end()) {
                    Http::redirect_to('/login');
                }
            } else {
                if (!Session::node('uid')) {
                    Http::redirect_to('/login');
                }
            }
        } else {
            Http::redirect_to('/login');
        }
    }

    static public function perms($type = null, $ajax = null)
    {
        if (debug_backtrace()[1]) {
            $class = ucfirst(strtolower(debug_backtrace()[1]['class']));
            $meth = debug_backtrace()[1]['function'];
            $perms = explode(',', Session::node('perms'));
            $user = Session::node('unome');
            $excep = ['Admin'];
            //C R U D <- possibilidades futuras
            $class_vars[] = $class . ":*";
            $class_vars[] = $class . ":L";
            $class_vars[] = $class . ":G";
            $class_vars[] = $class . ":R";
            $access = false;

            if ($perms[0] != '*') {
                if ($type != null) {
                    $class_type = $class . ':' . $type;
                    $class_total = $class . ':*';
                    if (in_array($class_type, $perms) || in_array($class_total, $perms) || in_array($class, $excep)) {
                        $access = true;
                    }
                    if (!$access) {
                        $meth = ($meth == 'indexAction' || $meth == '__construct') ? '' : $meth;
                        $msg = "Olá $user, você não possui acesso ao recurso " . strtoupper("$meth $class");
                        if ($ajax != null) {
                            echo $msg;
                            exit;
                        } else {
                            (new Page)->_perm($msg)->_and_stop();
                        }
                    }
                } else {
                    foreach ($class_vars as $classr) {
                        if (in_array($classr, $perms) || in_array($classr, $excep)) {
                            $access = true;
                        }
                    }
                    if (!$access) {
                        $msg = "Olá $user, você não possui acesso ao recurso " . ucfirst("$class");
                        if ($ajax != null) {
                            echo $msg;
                            exit;
                        } else {
                            (new Page)->_perm($msg)->_and_stop();
                        }
                    }
                }
            }
        }
    }

    public function perms_list()
    {
        echo json_encode(explode(',', Session::node('perms')));
    }
}
