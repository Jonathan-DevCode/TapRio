<?php

class OrdenarHome
{

    public function __construct()
    {
        
        
    }

    public function indexAction()
    {
        Sessao::check();
        $data = [
            'config' => (new Config)->get(),            
            'mapper' => ['config']
        ];
        Template::view('admin.ordenarHome.index', $data, 1);
    }

    public function lista()
    {
        (new Orm('order_home'))            
            ->order('order_home_order ASC')
            ->get(1);
    }

    public function listaHome()
    {
        return (new Orm('order_home')) 
            ->select("order_home_view AS view")           
            ->where('order_home_status = 1')
            ->order('order_home_order ASC')
            ->get();
    }


    public function altera_status()
    {
        Sessao::check();
        
        $id = Req::post('id', 'int');
        if ($id > 0) {
            $status = intval($_POST['status']);
            $status == 1 ? $status = 0 : $status = 1;
            $data = [
                'id' => $id,
                'status' => $status
            ];
            (new Orm('order_home'))->with($data)->save();    
            echo json_encode(['status' => 200]);
        } else {
            echo json_encode(['status' => 401]);
        }
    }

    public function ordenar()
    {
        Sessao::check();
        $sessoes = json_decode(Req::post('diff'));
        $db_order = (new Orm('order_home'));
        foreach ($sessoes as $sessao) {
            $id = explode('-', $sessao->node->_prevClass);
            if (intval($id[2]) > 0 && isset($id[2])) {
                $data = [
                    'id' => $id[2],
                    'order' => $sessao->newPosition,
                ];
                $db_order->with($data)->save();
            }
        }
    }
}
