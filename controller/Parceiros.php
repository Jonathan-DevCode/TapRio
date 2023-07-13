<?php

class Parceiros
{

    public function __construct()
    {
        Sessao::check();
        if (!Usuario::verifyPermission('parceiros')) {
            Http::redirect_to('/admin/?error-perm');
        }
        
    }

    public function indexAction()
    {
        $data = [
            'config' => (new Config)->get(),
            
            'mapper' => ['config'],
        ];
        Template::view('admin.parceiro.index', $data, 1);
    }

    public function lista()
    {
        (new Orm('parceiro'))
            ->select("parceiro_id, parceiro_nome,parceiro_logo, IF(parceiro_status = 1, 'Ativa', 'Inativa') AS parceiro_status_nome, parceiro_status")
            ->order('parceiro_pos ASC')
            ->get(1);
    }
    public function gravar()
    {
        if (!Usuario::verifyPermission('parceiros', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Req::post('parceiro_id', 'int');
        if (!intval($id) > 0 && intval($_FILES['parceiro_logo']['error']) > 0) 
            Http::redirect_to("/parceiros-lista/?error");
        
        $media = Media::img_upload($_FILES['parceiro_logo'], 'parceria');
        if (isset($media->url)) {
            /*REMOVE ATUAL LOGO DO PARCEIRO */
            $ds = DIRECTORY_SEPARATOR;
            $current = (new Orm('parceiro'))->find($id);
            $current_logo = Path::base() . $ds . 'media' . $ds . 'parceria' . $ds . $current->parceiro_logo;
            if (file_exists($current_logo)) {
                @system("chmod -R 777 $current_logo");
                @unlink($current_logo);
            }
            /*END REMOVE ATUAL LOGO DO PARCEIRO*/
            $_POST['parceiro_logo'] = $media->url;
        } else {
            unset($_POST['parceiro_logo']);
        }
        $parceiro = (new Orm('parceiro'))->with($_POST)->format(['parceiro_nome' => 'text', 'parceiro_link' => 'text'])->save();
        $parceiro > 0 ? Http::redirect_to("/parceiros-lista/?success") : Http::redirect_to("/parceiros-lista/?error");
    }

    public function editar()
    {
        if (!Usuario::verifyPermission('parceiros', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Http::get_in_params('id', 'int');
        if (isset($id->value) && $id->value > 0) {
            $id = $id->value;
            $escope = [
                'parceiro_nome' => 'text',
                'parceiro_profissao' => 'text',
                'parceiro_texto' => 'text',
            ];
            $parceiro = (new Orm('parceiro'))
                ->select("*")
                ->format($escope)->find($id);
            if (!empty($parceiro)) {
                $data = [
                    'parceiro' => $parceiro,
                    
                    'config' => (new Config)->get(),
                    'mapper' => ['config', 'parceiro'],
                ];
                Template::view('admin.parceiro.form', $data, 1);
            } else {
                Http::redirect_to('/parceiro-lista/');
            }
        } else {
            Http::redirect_to('/parceiro-lista/');
        }
    }

    public function altera_status()
    {
        if (!Usuario::verifyPermission('parceiros', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            if ($id > 0) {
                $status = intval($_POST['parceiro_status']);
                $status == 1 ? $status = 0 : $status = 1;
                $data = [
                    'id' => $id,
                    'parceiro_status' => $status,
                ];
                (new Orm('parceiro'))->with($data)->save();
            }
        }
    }
    public function novo()
    {
        if (!Usuario::verifyPermission('parceiros', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $parceiro = (new Orm('parceiro'))->map();
        $data = [
            'parceiro' => $parceiro,
            
            'config' => (new Config)->get(),
            'mapper' => ['config', 'parceiro'],
        ];
        Template::view('admin.parceiro.form', $data, 1);
    }

    public function remover()
    {
        if (!Usuario::verifyPermission('parceiros', 'remover')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            (new Orm('parceiro'))->drop($id);
            echo 1;
        } else {
            echo $id;
        }
    }

    public function ordenar(){
        if (!Usuario::verifyPermission('parceiros', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $parceiros = json_decode(Req::post('diff'));
        $db_slide = (new Orm('parceiro'));
         foreach ($parceiros as $parceiro){
             $id = explode('-', $parceiro->node->_prevClass);
             if(intval($id[2]) > 0 && isset($id[2])){
                 $data = [
                     'id' => $id[2],
                     'pos' => $parceiro->newPosition,
                 ];
                 $db_slide->with($data)->save();
             }
         }
     }
 
 

}
