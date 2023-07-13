<?php

@session_start();

class Local
{

    public function __construct()
    {
        if (!Usuario::verifyPermission('localidades')) {
            Http::redirect_to('/admin/?error-perm');
        }
        
    }

    public function indexAction()
    {
        Sessao::check();
        Http::redirect_to('/local/cidades');
    }

    public function cidades()
    {
        Sessao::check();
        $data = [
            'config' => (new Config)->get(),
            'mapper' => ['config']
        ];
        Template::view("admin.local.cidades", $data);
    }

    public function bairros()
    {
        Sessao::check();
        $data = [
            'config' => (new Config)->get(),
            'mapper' => ['config']
        ];
        Template::view("admin.local.bairros", $data);
    }


    public function lista_ufs()
    {
        (new Orm('uf'))->select("uf_id, uf_sigla, uf_estado")->get(1);
    }

    public function lista_cidades()
    {
        (new Orm('cidade'))
            ->select("cidade_id, cidade_titulo, cidade_uf, uf_sigla, (SELECT COUNT(*) FROM imovel WHERE imovel_cidade_id = cidade_id) AS qtd_imoveis")
            ->join("uf", 'uf_id = cidade_uf')
            ->get(1);
    }

    public function lista_bairros()
    {
        (new Orm('bairro'))
            ->select("bairro_id, bairro_titulo, bairro_cidade, cidade_titulo, uf_sigla, (SELECT COUNT(*) FROM imovel WHERE imovel_bairro_id = bairro_id) AS qtd_imoveis")
            ->join("cidade", 'cidade_id = bairro_cidade')
            ->join("uf", 'uf_id = cidade_uf')
            ->get(1);
    }

    public function lista_bairros_por_cidade()
    {
        $cidade = Req::post('cidade_id', 'int');
        if ($cidade > 0) {
            (new Orm('bairro'))
                ->select("bairro_id, bairro_titulo, bairro_cidade, cidade_titulo, uf_sigla, (SELECT COUNT(*) FROM imovel WHERE imovel_bairro_id = bairro_id) AS qtd_imoveis")
                ->join("cidade", 'cidade_id = bairro_cidade')
                ->join("uf", 'uf_id = cidade_uf')
                ->where("cidade_id = {$cidade}")
                ->get(1);
        }
    }


    public function adicionar_cidade()
    {
        Sessao::check();
        if (!Usuario::verifyPermission('localidades', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $dados = Filter::parse_full($_POST);
        if (!isset($dados['cidade_titulo']) || empty($dados['cidade_titulo']) || !isset($dados['cidade_uf']) || empty($dados['cidade_uf'])) {
            Http::redirect_to('/cidades/?error');
        }
        $new_id = (new Orm('cidade'))->with($dados)->save();
        $is_api = Http::get_in_params('adicionar_cidade', 'int');
        if ($is_api->value == 1) {
            echo $new_id;
            exit;
        } else {
            Http::redirect_to('/cidades/?success');
        }
    }

    public function adicionar_bairro()
    {
        Sessao::check();
        if (!Usuario::verifyPermission('localidades', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $dados = Filter::parse_full($_POST);
        if (!isset($dados['bairro_titulo']) || empty($dados['bairro_titulo']) || !isset($dados['bairro_cidade']) || empty($dados['bairro_cidade'])) {
            Http::redirect_to('/bairros/?error');
        }
        $is_api = Http::get_in_params('adicionar_bairro', 'int');
        $new_id = (new Orm('bairro'))->with($dados)->save();
        if ($is_api->value == 1) {
            echo $new_id;
            exit;
        } else {
            Http::redirect_to('/bairros/?success');
        }
    }

    public function cidade_remove()
    {
        Sessao::check();
        if (!Usuario::verifyPermission('localidades', 'remover')) {
            echo -1;
            exit;
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            (new Orm('cidade'))->drop($id);
            (new Orm('bairro'))->where("bairro_cidade = $id")->drop();
            echo 1;
        } else {
            echo -1;
        }
    }
    public function bairro_remove()
    {
        Sessao::check();
        if (!Usuario::verifyPermission('localidades', 'remover')) {
            echo -1;
            exit;
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            (new Orm('bairro'))->drop($id);
            echo 1;
        } else {
            echo -1;
        }
    }
}
