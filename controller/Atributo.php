<?php

@session_start();

class Atributo
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
        Template::view("admin.atributo.index", $data);
    }

    public function lista()
    {
        (new Orm('atributo'))
            ->select("atributo_titulo, atributo_icone, atributo_id")
            ->get(1);
    }

    public function gravar()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }  
        $dados = Filter::parse_full($_POST);
        if (!isset($dados['atributo_titulo']) || empty($dados['atributo_titulo'])) {
            Http::redirect_to('/categoria/?error');
        }
        (new Orm('atributo'))->with($dados)->save();
        Http::redirect_to('/imovel-atributo/?success');
    }

    public function gravar_api()
    {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            
            echo json_encode(['status' => 400, 'msg' => 'Permissão negada!']);exit;
        }  
        $dados = Filter::parse_full($_POST);
        if (
            !isset($dados['titulo']) || empty($dados['titulo']) || 
            !isset($dados['valor']) || intval($dados['valor']) < 0
        ) {
            echo json_encode(['status' => 400, 'msg' => 'Os campos título e valor são obrigatórios!']);exit;
        }
        $atributo = [
            'titulo' => $dados['titulo'],
            'icone' => $dados['icone']
        ];
        $id = intval((new Orm('atributo'))->with($atributo)->save());
        if($id > 0) {
            $vinculo = [
                'imovel_id' => $dados['imovel_id'],
                'atributo_id' => $id,
                'valor' => $dados['valor']                
            ];
            $newVinculo = intval((new Orm('atributo_imovel'))->with($vinculo)->save());
            if($newVinculo > 0) {
                echo json_encode(['status' => 200]);exit;
            } else {
                (new Orm('atributo'))->drop($id);
                echo json_encode(['status' => 400, 'msg' => 'Não foi possível vincular o atributo!']);exit;
            }
        } else {
            echo json_encode(['status' => 400, 'msg' => 'Não foi possível salvar o atributo!']);exit;
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
            (new Orm('atributo'))->drop($id);
            echo 1;
        } else {
            echo -1;
        }
    }

    // Uso em imoveisAdmin
    public function lista_disponivel() {
        $imovel_id = Req::post('imovel_id', 'int');
        if($imovel_id <= 0) {
            echo json_encode(['status' => 400]);exit;
        }

        $atributos = (new Orm('atributo'))
            ->select("atributo_titulo, atributo_id")
            ->where("atributo_id NOT IN (SELECT atributo_imovel_atributo_id FROM atributo_imovel WHERE atributo_imovel_imovel_id = $imovel_id)")
            ->get();
        echo json_encode(['status' => 200, 'atributos' => $atributos]);exit;
    }
    public function lista_indisponivel() {
        $imovel_id = Req::post('imovel_id', 'int');
        if($imovel_id <= 0) {
            echo json_encode(['status' => 400]);exit;
        }

        $atributos = (new Orm('atributo'))
            ->select("atributo_imovel_id, atributo_titulo, atributo_id, atributo_imovel_valor")
            ->join("atributo_imovel", 'atributo_imovel_atributo_id = atributo_id')
            ->where("atributo_imovel_imovel_id = $imovel_id")            
            ->get();
        echo json_encode(['status' => 200, 'atributos' => $atributos]);exit;
    }
    public function vincular() {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            echo json_encode(['status' => 200]);exit;
        }  
        
        $imovel_id = Req::post('imovel_id', 'int');
        $atributo_id = Req::post('atributo_id', 'int');
        $valor = Req::post('valor', 'int');

        if($atributo_id > 0 && $imovel_id > 0) {
            $with = [
                'atributo_id' => $atributo_id,
                'imovel_id' => $imovel_id,
                'valor' => $valor,
            ];
            (new Orm("atributo_imovel"))->with($with)->save();
            echo json_encode(['status' => 200]);exit;
        } else {
            echo json_encode(['status' => 400]);exit;
        }
    }
    public function desvincular() {
        if (!Usuario::verifyPermission('imoveis', 'gerenciar')) {
            echo json_encode(['status' => 200]);exit;
        }  
        $id = Req::post('id', 'int');
        if($id > 0) {
            (new Orm('atributo_imovel'))->drop($id);
            echo json_encode(['status' => 200]);exit;
        }
        echo json_encode(['status' => 400]);exit;
    }
}
