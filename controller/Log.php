<?php

class Log
{

    /**
     * @example
     * Log::add([
     *     "entity" => "imovel",
     *     "entity_id" => 26,
     *     "action" => "add", // add, edit, view, remove
     *     "msg" => "acessou blabla",
     *     "old_data" => [],
     *     "new_data" => [],
     * ])
     */
    public static function add($data) {
        $data = Log::cleanLogData($data);


        $data['user_id'] = Session::node('uid');
        $data['user_name'] = Session::node('unome');

        $has_change = false;
        if(is_array($data['new_data']) && sizeof($data['new_data']) > 0) {
            foreach($data['new_data'] as $campo => $valor) {
                if($campo != "imovel_desc" && isset($data['new_data'][$campo]) && isset($data['old_data'][$campo]) && trim($data['new_data'][$campo]) != trim($data['old_data'][$campo])) {
                    $has_change = true;
                }
            }

        }
        // Filter::pre($data, 1);

        $data['new_data'] = json_encode($data['new_data']);
        $data['old_data'] = json_encode($data['old_data']);


        if(!$has_change && $data['action'] == 'edit') return false;

        (new Orm('log'))
            ->with($data)
            ->save();
    }

    public static function cleanLogData($data) {
        if(!isset($data['entity']) || empty($data['entity'])) {
            $data['entity'] = "imovel";
        }
        if(!isset($data['entity_id']) || empty($data['entity_id'])) {
            $data['entity_id'] = "0";
        }
        if(!isset($data['action']) || empty($data['action'])) {
            $data['action'] = "add";
        }
        if(!isset($data['old_data']) || empty($data['old_data'])) {
            $data['old_data'] = "";
        }
        if(!isset($data['new_data']) || empty($data['new_data'])) {
            $data['new_data'] = "";
        }

        return $data;
    }

    public function remove()
    {
        if (!Usuario::verifyPermission('logs', 'remover')) {
            echo -1;exit;
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            (new Orm('log'))
                ->where("log_id = '". $id ."'")
                ->drop();
            (new Orm('log'))->drop($id);
            echo 1;
        } else {
            echo -1;
        }
    }

}
