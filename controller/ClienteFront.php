<?php

class ClienteFront
{
    public function __construct()
    {
        @session_start();
        
        
    }

    public function login()
    {
        $email = Req::post('email', 'string');
        $senha = Req::post('senha', 'string');

        if(isset($email) && !empty($email) && isset($senha) && !empty($senha)) {
            $senha = Parser::crypt($senha);

            $cliente = (new Orm('cliente'))->select("cliente_id, cliente_nome, cliente_email")->where("cliente_email = '$email' && cliente_password = '$senha'")->get();
    
            if (isset($cliente[0]) && !empty($cliente[0])) {
                $cliente = $cliente[0];
    
                Session::init();
                Session::client_node('uid', $cliente->cliente_id);
                Session::client_node('unome', $cliente->cliente_nome);
                Session::client_node('umail', $cliente->cliente_email);
    
                Http::redirect_to('/area-cliente');
            } else {
                Http::redirect_to('/login-cliente/?inexistente');
            }
        }
        
    }

    public function logout()
    {
        if (isset($_SESSION['clientNode'])) {
            unset($_SESSION['clientNode']);
        }
        Http::redirect_to('/');
    }

    static function sessionValidator()
    {
        if ((!isset($_SESSION['clientNode']) && empty($_SESSION['clientNode'])) || !Session::check()) {
            self::logout();
        }
    }

    public function viewLogin()
    {
        $data = [
            // Menu Superior
            'categorias' => (new CategoriasProdutosFront())->listar(),
            'destaques' => (new CategoriasProdutosFront())->listaSubcategoriasDestaque(),
            'slideSuperior' => (new SlideFront())->listarSlidePrincipal(),
            'paginasTopo' => (new Pagina())->listarPaginasTopo(),
            // Footer
            'paginasFooter' => (new Pagina())->listarPaginasFooter(),
            // Principal
            'config' => (new Config)->get(),
            'social' => (new Config)->getRedesSociais(),
            'mapper' => ['config', 'social'],
        ];        
        Template::view("tema.loja.cliente.login", $data, 1);
    }

    public function indexAction()
    {
        self::sessionValidator();
        // Validação para saber se o cliente fez o login através do checkout
        if(isset($_SESSION['cliente_checkout_redirect']) && !empty($_SESSION['cliente_checkout_redirect'])) {
            unset($_SESSION['cliente_checkout_redirect']);
            Http::redirect_to('/checkout');
        }

        $data = [
            // Menu Superior
            'categorias' => (new CategoriasProdutosFront())->listar(),
            'destaques' => (new CategoriasProdutosFront())->listaSubcategoriasDestaque(),
            'slideSuperior' => (new SlideFront())->listarSlidePrincipal(),
            'paginasTopo' => (new Pagina())->listarPaginasTopo(),
            // Footer
            'paginasFooter' => (new Pagina())->listarPaginasFooter(),
            // Principal
            'config' => (new Config)->get(),
            'social' => (new Config)->getRedesSociais(),
            'mapper' => ['config', 'social'],
        ];

        
        Template::view("tema.loja.cliente.area", $data, 1);
    }

    public function getCliente()
    {
        $id = intval(Session::client_node('uid'));
        if (isset($id) && !empty($id) && $id > 0) {
            echo (new Orm('cliente'))
                ->select('cliente_id, cliente_nome, cliente_cpf, DATE_FORMAT(cliente_nascimento,"%Y-%m-%d") as cliente_nascimento, cliente_celular, cliente_whats, cliente_email2, cliente_email, cliente_ie, cliente_telefone')
                ->find($id, 1);
        } else {
            $this->logout();
        }
    }

    public function gravar()
    {
        if(isset($_POST['cliente_nome']) && !empty($_POST['cliente_nome'])) {
            Req::drop_blank();
            $base = Http::base();
            $conf = (new Config)->get();
            $base = Http::base();
            $conf->url =  $base;
    
            if (Req::post('cliente_password') != "") {
                Req::crypt('cliente_password');
            }
    
            $cliente_id = Req::post('cliente_id', 'int');
            if ($cliente_id  <= 0) {
                $verify = (new Orm('cliente'))->select('cliente_id')->where('cliente_email = "' . $_POST['cliente_email'] . '"')->get();
    
                if (isset($verify) && !empty($verify)) {
                    Http::redirect_to('/login-cliente/?existente');
                }
            }
            $save = (new Orm('cliente'))->with($_POST)->save();
    
            if (intval($save) > 0) {
                Session::init();
                Session::client_node('uid', $save);
                Session::client_node('unome', $_POST['cliente_nome']);
                Session::client_node('umail', $_POST['cliente_email']);
    
                Http::redirect_to('/area-cliente/?success');
            }
        }
        
    }

    public function remover()
    {
        
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


    // Endereços

    public function viewNovoEndereco()
    {
        $id = intval(Session::client_node('uid'));
        if ($id > 0) {
            $data = [
                'categorias' => (new CategoriasProdutosFront())->listar(),
                'destaques' => (new CategoriasProdutosFront())->listaSubcategoriasDestaque(),
                'slideSuperior' => (new SlideFront())->listarSlidePrincipal(),
                'paginasTopo' => (new Pagina())->listarPaginasTopo(),

                'cliente_id' => ['endereco_cliente_cliente' => $id],
                'endereco' => (new Orm('endereco_cliente'))->map(),
                'paginasFooter' => (new Pagina())->listarPaginasFooter(),
                // Principal
                'config' => (new Config)->get(),
                'social' => (new Config)->getRedesSociais(),
                'mapper' => ['config', 'endereco']
            ];
            Template::view('tema.loja.cliente.endereco', $data, 1);
        } else {
            Http::redirect_to('/area-cliente/?error');
        }
    }

    public function viewEditarEndereco()
    {
        $id = Http::get_in_params('id', 'int');
        if (isset($id->value) && !empty($id->value) && intval($id->value) > 0) {
            $id = $id->value;
            $end = (new Orm('endereco_cliente'))->where('endereco_cliente_cliente = ' . Session::client_node('uid') . ' AND endereco_cliente_id = ' . $id)->get();
            if (isset($end[0])) {
                $end = $end[0];
                $data = [
                    'categorias' => (new CategoriasProdutosFront())->listar(),
                    'destaques' => (new CategoriasProdutosFront())->listaSubcategoriasDestaque(),
                    'slideSuperior' => (new SlideFront())->listarSlidePrincipal(),
                    'paginasTopo' => (new Pagina())->listarPaginasTopo(),
                    'endereco' => $end,
                    'cliente_id' => ['cliente_id' => $end->endereco_cliente_cliente],
                    'paginasFooter' => (new Pagina())->listarPaginasFooter(),
                    // Principal
                    'config' => (new Config)->get(),
                    'social' => (new Config)->getRedesSociais(),
                    'mapper' => ['config', 'social'],
                    'mapper' => ['config', 'endereco']
                ];
                Template::view('tema.loja.cliente.endereco', $data, 1);
            } else {
                Http::redirect_to('/area-cliente/?error');
            }
        } else {
            Http::redirect_to('/area-cliente/?error');
        }
    }
    public function listarEndereco()
    {
        $id = intval(Session::client_node('uid'));
        if (isset($id) && !empty($id) && $id > 0) {
            (new Orm('endereco_cliente'))
                ->where('endereco_cliente_cliente = ' . $id)
                ->get(1);
        }
    }

    public function listarEnderecoById()
    {
        $endereco_id = Req::post('endereco_id', 'int');
        if ($endereco_id > 0) {
            (new Orm('endereco_cliente'))
                ->where('endereco_cliente_id = ' . $endereco_id)
                ->get(1);
        }
    }

    public function gravarEndereco()
    {
        if(isset($_POST['endereco_cliente_titulo']) && !empty($_POST['endereco_cliente_titulo'])) {
            $_POST = Filter::parse_full($_POST);

            // VERIFICA SE EXISTE UM ENDEREÇO, CASO NÃO EXISTA, CADASTRA COMO CORRESPONDENCIA
    
            $res = (new Orm('endereco_cliente'))->where('endereco_cliente_cliente = ' . Session::client_node('uid') . ' AND endereco_cliente_tipo = 1')->get();
    
            if (!$res) {
                $_POST['endereco_cliente_tipo'] = '1';
            }
    
            $_POST['endereco_cliente_cliente'] = Session::client_node('uid');
    
            // Filter::pre($_POST);EXIT;
            (new Orm('endereco_cliente'))->with($_POST)->save();
    
            if(isset($_SESSION['cliente_frete_redirect']) && !empty($_SESSION['cliente_frete_redirect'])) {
                unset($_SESSION['cliente_frete_redirect']);
                Http::redirect_to('/checkout/?success');;
            }
            Http::redirect_to('/area-cliente/?success');
        }
        
    }

    public function removerEndereco()
    {
        $id = Req::post('id', 'int');
        if ($id > 0) {
            (new Orm('endereco_cliente'))->drop($id);
            echo '1';
        } else {
            echo '0';
        }
    }

    public function listaPedidos()
    {
        $cliente_id = intval(Session::client_node('uid'));

        if (isset($cliente_id) && !empty($cliente_id) && $cliente_id > 0) {
            (new Orm('pedido'))
                ->select("pedido_id, pedido_total_parcelado,
                    CASE pedido_status
                        WHEN 1 THEN 'Aguardando Pagamento'
                        WHEN 2 THEN 'Em análise'
                        WHEN 3 THEN 'Aprovado'
                        WHEN 4 THEN 'Disponível'
                        WHEN 5 THEN 'Em disputa'
                        WHEN 6 THEN 'Devolvido'
                        WHEN 7 THEN 'Cancelado'            
                    END AS pedido_status,
                    CASE pedido_status
                        WHEN 1 THEN 'warning'
                        WHEN 2 THEN 'info'
                        WHEN 3 THEN 'success'
                        WHEN 4 THEN 'success'
                        WHEN 5 THEN 'warning'
                        WHEN 6 THEN 'danger'
                        WHEN 7 THEN 'danger'            
                    END AS pedido_status_badge,
                    DATE_FORMAT(pedido_created, '%d/%m/%Y às %h:%i:%s') AS pedido_data,
                    lista_pedido_produto_titulo, lista_pedido_foto                    
                ")
                ->join('cliente', 'cliente_id = pedido_cliente')
                ->join('lista_pedido', 'lista_pedido_pedido = pedido_id')
                ->where('pedido_cliente = ' . $cliente_id)
                ->order('pedido_id DESC')
                ->group_by('pedido_id')
                ->get(1);
        }
    }

    public function listarRetirada() {
        (new Orm('retirada'))
            ->get(1);
    }
}
