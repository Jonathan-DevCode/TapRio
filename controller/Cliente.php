<?php

class Cliente
{
    public function __construct()
    {
        Sessao::check();    
        if (!Usuario::verifyPermission('clientes')) {
            Http::redirect_to('/admin/?error-perm');
        }  
          
    }
    public function indexAction()
    {
        $data = [
            'config' => (new Config)->get(),
            
            'mapper' => ['config'],
        ];
        Template::view('admin.cliente.index', $data, 1);
    }

    public function lista()
    {
        $query_permissao = "";

        if (!Usuario::verifyIsAdmin()) {
            $query_permissao = "AND cliente_user_id = '" . Session::node('uid') . "'";
        }

        $select = "
                usuario_nome as corretor,
                cliente_id AS id,
                cliente_nome,
                cliente_obs as cliente_interesse,
                IFNULL(cliente_cpf, cliente_rg) AS cliente_documento,
                cliente_busca_tipo_imovel AS cliente_tipo_imovel,
                cliente_busca_quartos AS cliente_numero_quartos,
                cliente_busca_vagas AS cliente_numero_vagas,
                cliente_busca_bairro AS cliente_bairro,
                cliente_busca_negociacao,
                cliente_busca_preco_de,
                cliente_busca_preco_ate,
                cliente_cidade,
                cliente_uf,
                cliente_status AS status,
                IF(cliente_status = 1, 'Ativo', 'Inativo') AS status_nome
        ";
        (new Orm('cliente'))
            ->select($select)
            ->join("usuario", "cliente_user_id = usuario_id")
            ->where("cliente_id > 0 {$query_permissao}")
            ->order('cliente_nome ASC')
            ->get(1);
    }

    public static function getLink($dados) {
        $paths = [];

        if(isset($dados['cliente_busca_quartos']) && !empty($dados['cliente_busca_quartos'])) {
            $paths[] = "quartos=" . $dados['cliente_busca_quartos'];
        }
        if(isset($dados['cliente_busca_suites']) && !empty($dados['cliente_busca_suites'])) {
            $paths[] = "suites=" . $dados['cliente_busca_suites'];
        }
        if(isset($dados['cliente_busca_banheiros']) && !empty($dados['cliente_busca_banheiros'])) {
            $paths[] = "banheiros=" . $dados['cliente_busca_banheiros'];
        }
        if(isset($dados['cliente_busca_vagas']) && !empty($dados['cliente_busca_vagas'])) {
            $paths[] = "vagas=" . $dados['cliente_busca_vagas'];
        }
        if(isset($dados['cliente_busca_negociacao']) && !empty($dados['cliente_busca_negociacao'])) {
            $paths[] = "negociation=" . $dados['cliente_busca_negociacao'];
        }
        if(isset($dados['cliente_busca_condominio_id']) && !empty($dados['cliente_busca_condominio_id'])) {
            $paths[] = "condominio=" . $dados['cliente_busca_condominio_id'];
        }
        if(isset($dados['cliente_busca_tipo_imovel']) && !empty($dados['cliente_busca_tipo_imovel'])) {
            $paths[] = "type=" . $dados['cliente_busca_tipo_imovel'];
        }

        // localidade
        $search_location = [];
        if(isset($dados['cliente_busca_bairro']) && !empty($dados['cliente_busca_bairro'])) {
            $search_location[] = $dados['cliente_busca_bairro'];
        }
        if(isset($dados['cliente_busca_cidade']) && !empty($dados['cliente_busca_cidade'])) {
            $search_location[] = $dados['cliente_busca_cidade'];
        }

        if(isset($search_location[0])) {
            $search_location = implode(" ", $search_location);
            $paths[] = "location=" . $search_location;
        }

        // área
        $search_area = [0,0];
        if(isset($dados['cliente_busca_area_de']) && !empty($dados['cliente_busca_area_de'])) {
            $search_area[0] = $dados['cliente_busca_area_de'];
        }
        if(isset($dados['cliente_busca_area_ate']) && !empty($dados['cliente_busca_area_ate'])) {
            $search_area[1] = $dados['cliente_busca_area_ate'];
        }
        if($search_area[0] != 0 || $search_area[1] != 0) {
            $search_area = implode(",", $search_area);
            $paths[] = "area=" . $search_area;
        }

        // preço
        $search_preco = [0,0];
        if(isset($dados['cliente_busca_preco_de']) && !empty($dados['cliente_busca_preco_de'])) {
            $search_preco[0] = $dados['cliente_busca_preco_de'];
        }
        if(isset($dados['cliente_busca_preco_ate']) && !empty($dados['cliente_busca_preco_ate'])) {
            $search_preco[1] = $dados['cliente_busca_preco_ate'];
        }
        if($search_preco[0] != 0 || $search_preco[1] != 0) {
            $search_preco = implode(",", $search_preco);
            $paths[] = "preco=" . $search_preco;
        }

        $paths = implode("&", $paths);
        if(!empty($paths)) {
            return "?searching=true&" .$paths;
        }
        return "";
        
    }

    public function gravar()
    {
        if (!Usuario::verifyPermission('clientes', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        if (isset($_POST['cliente_nome']) && !empty($_POST['cliente_nome'])) {
            // Req::drop_blank();
            $_POST = Filter::parse_full($_POST, false);

            $_POST['cliente_busca_preco_de'] = Filter::money_to_double($_POST['cliente_busca_preco_de']);
            $_POST['cliente_busca_preco_ate'] = Filter::money_to_double($_POST['cliente_busca_preco_ate']);
            
            

            $_POST['cliente_busca_preco_de'] = intval($_POST['cliente_busca_preco_de']);
            $_POST['cliente_busca_preco_ate'] = intval($_POST['cliente_busca_preco_ate']);

            $_POST['cliente_busca_link'] = Cliente::getLink($_POST);

            // if(empty($_POST['cliente_nascimento'])) {
            //     unset($_POST['cliente_nascimento']);
            // }

            
            $save = (new Orm('cliente'))->with($_POST)->save();
            // Filter::pre($_POST, 1);


            Http::back_on_false($save);
            Http::redirect_to('/cliente/editar/id/'. $save .'?success');
        }
    }

    public function novo()
    {
        if (!Usuario::verifyPermission('clientes', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $data = [
            'config' => (new Config)->get(),
            'cliente' => (new Orm('cliente'))->map(), 
            'users' => (new Orm('usuario'))->get(),           
            'categoria_imovel' => (new Orm('categoria_imovel'))->get(),           
            'condominio' => (new Orm('condominio'))->get(),           
            'mapper' => ['config', 'cliente'],
        ];
        Template::view('admin.cliente.form', $data, 1);
    }

    public function editar()
    {
        if (!Usuario::verifyPermission('clientes', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Http::get_in_params('id', 'int');
        $cli = (new Orm('cliente'))->find($id->value);
        Http::back_on_false($cli);
        $data = [
            'config' => (new Config)->get(),
            'cliente' => $cli,
            'users' => (new Orm('usuario'))->get(),
            'categoria_imovel' => (new Orm('categoria_imovel'))->get(),           
            'condominio' => (new Orm('condominio'))->get(),   
            'mapper' => ['config', 'cliente'],
        ];

        Template::view('admin.cliente.form', $data, 1);
    }

    public function remover()
    {
        if (!Usuario::verifyPermission('clientes', 'remover')) {
            
            echo -1;
            exit;
        }
        $id = Req::post('id', 'int');
        if ($id > 0) {
            (new Orm('cliente'))->drop($id);
            echo 1;
        } else {
            echo -1;
        }
    }

    public function checa_cpf()
    {
        $cpf = Req::post('cpf', 'string');

        if (isset($cpf) && !empty($cpf)) {
            $resp = (new Orm('cliente'))->select('cliente_cpf')
                ->where("cliente_cpf = '$cpf' ")->limit(1)->get();
            if ($resp) {
                echo -1;
                exit;
            } else {
                echo 1;
                exit;
            }
        } else {
            echo 0;
            exit;
        }
    }

    public function checa_cnpj()
    {
        $cnpj = Req::post('cnpj', 'string');
        if (isset($cnpj) && !empty($cnpj)) {
            $resp = (new Orm('cliente'))->select('cliente_cnpj')->find_by('cliente_cnpj', $cnpj);
            if ($resp) {
                echo -1;
                exit;
            } else {
                echo 1;
                exit;
            }
        } else {
            echo 0;
            exit;
        }
    }

    public function checa_email()
    {
        $email = Req::post('email', 'string');
        if (isset($email) && !empty($email)) {
            $resp = (new Orm('cliente'))->select('cliente_email')->find_by('cliente_email', $email);
            if ($resp) {
                echo -1;
                exit;
            } else {
                echo 1;
                exit;
            }
        } else {
            echo 0;
            exit;
        }
    }

    public function get_json()
    {
        (new Orm('cliente'))
            ->select('*, IFNULL(cliente_nome,cliente_razao) as cliente_nome')
            ->where('cliente_status = 1')
            ->order('cliente_nome ASC')->get(1, true);
    }

    public function altera_status()
    {
        if (!Usuario::verifyPermission('clientes', 'gerenciar')) {
            Http::redirect_to('/admin/?error-perm');
        }
        $id = Req::post('id', 'int');

        if ($id > 0) {
            $status = Req::post('status', null);
            $status == 1 ? $status = 0 : $status = 1;
            $data = [
                'id' => $id,
                'status' => $status,
            ];

            (new Orm('cliente'))->with($data)->save();
        } else {
            echo -1;
        }
    }
}
