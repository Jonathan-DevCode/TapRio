<?php

@session_start();

class Integracoes
{

    public function __construct()
    {
        Sessao::check();
        if (!Usuario::verifyPermission('integracoes')) {
            Http::redirect_to('/admin/?error-perm');
        }

    }

    public function indexAction()
    {
        $data = [
            'config' => (new Config)->get(),
            'mapper' => ['config']
        ];
        Template::view("admin.integracao.index", $data);
    }

    public function lista()
    {
        (new Orm('integracao'))
            ->select("
                *,
                (SELECT COUNT(*) FROM integracao_imovel WHERE integracao_imovel_integracao_id = integracao_id) AS qtd_imoveis,
                DATE_FORMAT(integracao_updated, '%d/%m/%Y às %h:%i') AS integracao_updated_format,
                CASE integracao_status
                WHEN 0 THEN 'Desabilitada'
                WHEN 1 THEN 'Ativa'
                END AS integracao_status_nome
            ")
            ->get(1);
    }

    public static function listaImoveisIntegradosPadrao() {
        $lista = (new Orm('imovel'))
            ->select("
                imovel_id, imovel_ref, imovel_titulo, categoria_imovel_nome, bairro_titulo, cidade_titulo, uf_sigla, imovel_proprietario_nome,
                CASE imovel_tipo_negociacao
                WHEN 'venda' THEN 'Venda'
                WHEN 'aluguel' THEN 'Locação'
                WHEN 'venda_aluguel' THEN 'Venda e Locação'
                END AS imovel_tipo_negociacao_label
            ")
            ->join("bairro", 'bairro_id = imovel_bairro_id', 'left')
            ->join("cidade", "cidade_id = bairro_cidade", 'left')
            ->join("uf", 'uf_id = cidade_uf', 'left')
            ->join("categoria_imovel", 'imovel_categoria = categoria_imovel_id', 'left')
            ->get();

        $retorno = [];
        if(isset($lista[0])) {
            foreach($lista as $imovel) {
                $retorno[$imovel->imovel_id] = [
                    "is_checked" => '0',
                    'destaque' => 'padrao',
                    'endereco' => 'completo'
                ];
            }
        }
        return $retorno;
    }

    public function listaImoveisIntegrados() {
        $integracao_id = intval($_POST['integracao_id']);

        $lista_padrao = Integracoes::listaImoveisIntegradosPadrao();

        if($integracao_id <= 0) {
            echo json_encode($lista_padrao);
            exit;
        }

        $imoveis = (new Orm("integracao_imovel"))
            ->where("integracao_imovel_integracao_id = '". $integracao_id ."'")
            ->get();


        // formata reotnro
        if(isset($imoveis[0])) {
            foreach($imoveis as $imovel) {
                $lista_padrao[$imovel->integracao_imovel_imovel_id] = [
                    "is_checked" => '1',
                    'destaque' => $imovel->integracao_imovel_destaque,
                    'endereco' => $imovel->integracao_imovel_endereco
                ];
            }
        }

        echo json_encode($lista_padrao);
        exit;
    }

    public function altera_status()
    {
        if (!Usuario::verifyPermission('integracoes', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            $status = intval($_POST['integracao_status']);
            $status == 1 ? $status = 0 : $status = 1;
            $data = [
                'id' => $id,
                'integracao_status' => $status
            ];
            (new Orm('integracao'))->with($data)->save();
        }
    }

    public function nova()
    {
        if (!Usuario::verifyPermission('integracoes', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $data = [
            'config' => (new Config)->get(),
            'integracao' => (new Orm('integracao'))->map(),
            'mapper' => ['config', 'integracao']
        ];
        Template::view("admin.integracao.form", $data);
    }

    public function editar()
    {
        if (!Usuario::verifyPermission('integracoes', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Http::get_in_params('editar', 'int');
        if (isset($id->value) && !empty($id->value)) {
            $integracao = (new Orm('integracao'))->find($id->value);
            if (isset($integracao->integracao_id)) {
                $data = [
                    'config' => (new Config)->get(),
                    'integracao' => $integracao,
                    'mapper' => ['config', 'integracao']
                ];
                Template::view("admin.integracao.form", $data);
            } else {
                Http::redirect_to('/integracoes/?error');
            }
        } else {
            Http::redirect_to('/integracoes/?error');
        }
    }

    public function gravar()
    {
        if (!Usuario::verifyPermission('integracoes', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }

        $imoveis_changed = $_POST['imoveis_changed'];
        unset($_POST['imoveis_changed']);
        $integracao_imoveis = $_POST['integracao_imovel_imovel_id'];

        if(!isset($integracao_imoveis[0])) {
            Http::redirect_to('/integracoes/?error-imoveis');
        }

        // salva os dados do imovel da integracao
        $dados_imoveis_integracao = [];
        foreach($integracao_imoveis as $imovel_id) {

            $destaque = $_POST["integracao_imovel_destaque_{$imovel_id}"];
            $endereco = "";
            $dados_imoveis_integracao[] = "('{integracao_id}', '{$imovel_id}', '{$destaque}', '{$endereco}')";
        }

        // como já montou os dados de integração, limpa o post
        $dados = $_POST;
        foreach($dados as $k => $v) {
            if(strpos($k, "integracao_imovel") !== false) {
                unset($_POST[$k]);
            }
        }

        // Filter::pre($dados_imoveis_integracao, 1);


        $dados = Filter::parse_full($_POST);
        if (!isset($dados['integracao_nome']) || empty($dados['integracao_nome'])) {
            Http::redirect_to('/integracoes/?error');
        }

        if(empty($dados['integracao_id'])) {
            $dados['integracao_status'] = 1;
        }

        if(empty($dados['integracao_id'])) {
            $dados['integracao_public_link'] = md5(uniqid(time()));
        }

        $integracao_old = (array) (new Orm('integracao'))->find($dados['integracao_id']);

        $new_id = (new Orm('integracao'))->with($dados)->save();

        if(!empty($dados['integracao_id'])) {
            // edit



            if($imoveis_changed == '1') {
                // estrutura para salvar os logs
                $old_imoveis = (new Orm("integracao_imovel"))
                    ->where("integracao_imovel_integracao_id = '". $dados['integracao_id'] ."'")
                    ->get();

                $imoveis_removidos = [];
                $imoveis_adicionados = [];
                $imoveis_ids = [];
                if(isset($old_imoveis[0])) {
                    foreach($old_imoveis as $old_imovel) {
                        $imoveis_ids[] = $old_imovel->integracao_imovel_imovel_id;
                        if(!in_array($old_imovel->integracao_imovel_imovel_id, $integracao_imoveis)) {
                            // imovel removido
                            $imoveis_removidos[] = $old_imovel->integracao_imovel_imovel_id;
                        }
                    }
                }

                if(isset($integracao_imoveis[0])) {
                    foreach($integracao_imoveis as $novo_imovel_id) {
                        if(!in_array($novo_imovel_id, $imoveis_ids)) {
                            // imovel novo
                            $imoveis_adicionados[] = $novo_imovel_id;
                        }
                    }
                }

                (new Orm("integracao_imovel"))
                    ->where("integracao_imovel_integracao_id = '". $dados['integracao_id'] ."'")
                    ->drop();
                if(isset($dados_imoveis_integracao[0])) {
                    $dados_imoveis_integracao_join = join(",", $dados_imoveis_integracao);
                    $dados_imoveis_integracao_join = str_replace("{integracao_id}", $dados['integracao_id'], $dados_imoveis_integracao_join);
                    (new Orm("integracao_imovel"))
                    ->query("INSERT INTO integracao_imovel (integracao_imovel_integracao_id, integracao_imovel_imovel_id, integracao_imovel_destaque, integracao_imovel_endereco) VALUES {$dados_imoveis_integracao_join};");
                }

                if(isset($imoveis_adicionados[0])) {
                    $integracao_old['imoveis_adicionados'] = "";
                    $dados['imoveis_adicionados'] = implode(",", $imoveis_adicionados);
                }

                if(isset($imoveis_removidos[0])) {
                    $integracao_old['imoveis_removidos'] = "";
                    $dados['imoveis_removidos'] = implode(",", $imoveis_removidos);
                }
            }


            Log::add([
                "entity" => "integracao_imovel",
                "action" => "edit",
                "msg" => "Alterou dados de integração xml: " . Http::base() . "/integracoes/editar/" . $dados["integracao_id"],
                "entity_id" => $dados["integracao_id"],
                "old_data" => $integracao_old,
                "new_data" => $dados,
            ]);
        } else {
            // new
            if(isset($dados_imoveis_integracao[0])) {
                $dados_imoveis_integracao_join = join(",", $dados_imoveis_integracao);
                $dados_imoveis_integracao_join = str_replace("{integracao_id}", $new_id, $dados_imoveis_integracao_join);
                (new Orm("integracao_imovel"))
                ->query("INSERT INTO integracao_imovel (integracao_imovel_integracao_id, integracao_imovel_imovel_id, integracao_imovel_destaque, integracao_imovel_endereco) VALUES {$dados_imoveis_integracao_join};");
            }
            Log::add([
                "entity" => "integracao_imovel",
                "action" => "insert",
                "msg" => "Inseriu uma nova integração xml:" . HTTP::base() . "/integrações/nova/",
                "new_data" => $dados
            ]);
        }

        Http::redirect_to('/integracoes/?success');
    }

    public function remove()
    {
        if (!Usuario::verifyPermission('integracoes', 'remover')) {
            echo -1;exit;
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            (new Orm('integracao_imovel'))
                ->where("integracao_imovel_integracao_id = '". $id ."'")
                ->drop();
            (new Orm('integracao'))->drop($id);
            echo 1;

            Log::add([
                "entity" => "integracao_imovel",
                "action" => "remove",
                "msg" => "Removeu a integração xml: " . Http::base() . "/integracoes/editar/" . $id,
                "entity_id" => $id,
            ]);
        } else {
            echo -1;
        }
    }
}
