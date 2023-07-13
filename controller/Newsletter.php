<?php
class Newsletter
{
    public function __construct()
    {
        
    }

    public function indexAction()
    {
        $data = [
            'config' => (new Config)->get(),
            
            'mapper' => ['config']
        ];
        Template::view('admin.newsletter.index', $data, 1);
    }

    public function gravar() {
        $email = Req::post('email', 'string');

        if(isset($email) && !empty($email)) {
            // verifica se já existe esse email
            $res = (new Orm('newsletter'))->find_by('newsletter_email', $email);
            if(isset($res->newsletter_id)) {
                echo 'E-mail já cadastrado!';
            } else {
                $with = [
                    'newsletter_email' => $email,
                    'newsletter_status' => 1
                ];
                $save = (new Orm('newsletter'))->with($with)->save();

                if(isset($save) && !empty($save) && intval($save) > 0) {
                    echo trim('1');
                } else {
                    echo 'Não foi possível salvar este email';
                }
            }
        }
    }

    public function alteraStatus() {
        $id = Req::post('id', 'int');
        $status = Req::post('status', 'int');

        if($status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        if($id > 0) {
            $with = [
                "newsletter_id" => $id,
                "newsletter_status" => $status
            ];
            (new Orm('newsletter'))->with($with)->save();
            echo 1;
        } else {
            echo 0;
        }
    }

    public function remover() {
        $id = Req::post('id', 'int');
        if($id > 0) {
            (new Orm('newsletter'))->drop($id);
            echo 1;
        } else {
            echo 0;
        }
    }

    public function getAll() {
        (new Orm('newsletter'))->get('json');
    }
}
