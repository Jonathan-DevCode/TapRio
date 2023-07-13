<?php

class Install
{



    public function __construct()
    {
        die();
    }
    // Faz uma checagem nas tabelas necessárias pro funcionamento da imobiliaria
    // Caso exista alguma irregularidade, como por exemplo, sem registro no config, reseta a mesma
    public function check_tabelas_principais()
    {
        // enviar email quando não houver tabelas
        // $config = (new Orm('config'))->get();
        // if (!isset($config[0]) || !isset($config[0]->config_id))
        //     $this->config_create();

        // $config_cores = (new Orm('config_cores'))->get();
        // if (!isset($config_cores[0]) || !isset($config_cores[0]->config_cores_id))
        //     $this->config_cores_create();

        // // ordenação da home
        // $order_home = (new Orm('order_home'))->get();
        // if (!isset($order_home[0]) || !isset($order_home[0]->order_home_id))
        //     $this->order_home_create();

        // // usuario
        // $usuario = (new Orm('usuario'))->get();
        // if (!isset($usuario[0]) || !isset($usuario[0]->usuario_id))
        //     $this->usuario_create();

        // // SMTP
        // $smtp = (new Orm('smtp'))->get();
        // if (!isset($smtp[0]) || !isset($smtp[0]->smtp_id))
        //     $this->smtp_create();
    }

    public function indexAction()
    {
    }

    public function save_conf()
    {
    }

    public function down()
    {
    }

    public function up()
    {

        Http::redirect_to('/install/?success');
    }

    public function update()
    {

        // $this->config_update();
        // Http::redirect_to('/');
    }

    public function fixCaracteristicas()
    {
        (new Orm("caracteristica"))
            ->where("caracteristica_id > 0")
            ->drop();

        $caracteristicas = IntegracaoExterna::getZapFeatures();

        $insert = [];
        foreach ($caracteristicas as $k => $v) {
            $insert[] = "('" . addslashes($k) . "', 'ambos', 1)";
        }

        $insert = implode(",", $insert);
        (new Orm("caracteristica"))
            ->query("INSERT INTO caracteristica (caracteristica_nome, caracteristica_tipo, caracteristica_categoria_id) VALUES $insert;");
    }

    public function create()
    {
        $this->agenda_create();
        $this->atributo_create();
        $this->atributo_imovel_create();
        $this->avaliacao_imovel_create();
        $this->bairro_create();
        $this->categoria_imovel_create();
        $this->cidade_create();
        $this->cliente_create();
        $this->config_create();
        $this->config_cores_create();
        $this->foto_imovel_create();
        $this->modelo_imovel_create();
        $this->caracteristica_categoria_create();
        $this->imoveis_relacionados_create();
        $this->imovel_create();
        $this->newsletter_create();
        $this->order_home_create();
        $this->parceiro_create();
        $this->rede_social_create();
        $this->slide_create();
        $this->smtp_create();
        $this->uf_create();
        $this->usuario_create();
        $this->modelo_imovel_create();
        $this->condominio_create();
        $this->condominio_caracteristica_create();
        $this->imovel_caracteristica_create();
        $this->permissao_create();
        $this->integracao_create();
        $this->integracao_imovel_create();
        $this->modelo_categoria_create();
    }

    public function migracao()
    {
        $this->log_create();
    }

    public function imovel_arquivo()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(200)'],
            ['name' => 'url', 'type' => 'varchar(200)'],
            ['name' => 'imovel_id', 'type' => 'varchar(200)'],
        ];
        (new DB)->create_table('imovel_arquivo', $columns);
    }

    public function categoria_pagina_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(200)'],
            ['name' => 'url', 'type' => 'varchar(200)'],
            ['name' => 'topo', 'type' => 'int(1)'],
            ['name' => 'rodape', 'type' => 'int(1)'],
            ['name' => 'icone', 'type' => 'varchar(200)'],
            ['name' => 'pos', 'type' => 'int(11)'],
            ['name' => 'cor', 'type' => 'varchar(200)'],
        ];
        (new DB)->create_table('categoria_pagina', $columns);
    }

    public function migration_imgs()
    {

        $path = "media/imovel";
        $diretorio = dir($path);

        echo "Lista de Arquivos do diretório '<strong>" . $path . "</strong>':<br />";
        while ($arquivo = $diretorio->read()) {
            if ($arquivo == "." || $arquivo == "..") continue;

            if (strpos($arquivo, "thumb_") === false && strpos($arquivo, "watermark_") === false) {
                // é um original
                $ds = DIRECTORY_SEPARATOR;

                $nome_arquivo_original = $arquivo;
                $thumb_nome = 'thumb_' . $nome_arquivo_original;
                $watermark_nome = 'watermark_' . $nome_arquivo_original;

                $ds = DIRECTORY_SEPARATOR;
                $path_original = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds . $nome_arquivo_original;

                if(!is_file($path . "/" . $thumb_nome)) {
                    // não tem thumb
                    $path_copia_thumb = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds . $thumb_nome;



                    if (is_file($path_original)) {
                        @system("chmod -R 777 $path_original");
                        @system("chmod -R 777 $path_copia_thumb");
                        @copy($path_original, $path_copia_thumb);
                        Media::img_redimensiona($thumb_nome, 'imovel', 20);
                        Media::watermark($path_copia_thumb, $thumb_nome, 'imovel');
                    }
                }
                if(!is_file($path . "/" . $watermark_nome)) {
                    // não tem marca dagua

                    $path_copia_water = Path::base() . $ds . 'media' . $ds . 'imovel' . $ds . $watermark_nome;
                    @system("chmod -R 777 $path_copia_water");
                    @copy($path_original, $path_copia_water);
                    Media::img_redimensiona($watermark_nome, 'imovel', 20);
                    Media::watermark($path_copia_water, $watermark_nome, 'imovel');
                }
            }
        }
        $diretorio->close();
    }

    public function log_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'entity', 'type' => 'varchar(255)'],
            ['name' => 'entity_id', 'type' => 'int(11)'],
            ['name' => 'action', 'type' => 'varchar(16)'],
            ['name' => 'msg', 'type' => 'varchar(255)'],
            ['name' => 'user_id', 'type' => 'int(11)'],
            ['name' => 'user_name', 'type' => 'varchar(255)'],
            ['name' => 'old_data', 'type' => 'longtext'],
            ['name' => 'new_data', 'type' => 'longtext']
        ];
        (new DB)->create_table('log', $columns);
    }

    public function subcategoria_pagina_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(200)'],
            ['name' => 'categoria', 'type' => 'varchar(200)'],
            ['name' => 'url', 'type' => 'varchar(200)'],
        ];
        (new DB)->create_table('subcategoria_pagina', $columns);
    }

    public function pagina_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'categoria', 'type' => 'int(11)'],
            ['name' => 'subcategoria', 'type' => 'int(11)'],
            ['name' => 'url', 'type' => 'varchar(200)'],
            ['name' => 'titulo', 'type' => 'varchar(200)'],
            ['name' => 'desc', 'type' => 'text'],
            ['name' => 'status', 'type' => 'int(1)', 'default' => 1],
            ['name' => 'texto', 'type' => 'longtext'],
            ['name' => 'capa', 'type' => 'varchar(255)'],
            ['name' => 'acessos', 'type' => 'varchar(200)'],
            ['name' => 'keywords', 'type' => 'varchar(200)'],
        ];
        (new DB)->create_table('pagina', $columns);
    }

    public function modelo_categoria_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'modelo_id', 'type' => 'int(11)'],
            ['name' => 'categoria_id', 'type' => 'int(11)'],
        ];
        (new DB)->create_table('modelo_categoria', $columns);
    }


    public function integracao_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(255)'],
            ['name' => 'public_link', 'type' => 'varchar(255)'],
            ['name' => 'status', 'type' => 'int(1)'],
        ];
        (new DB)->create_table('integracao', $columns);
    }

    public function integracao_imovel_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'integracao_id', 'type' => 'int(11)'],
            ['name' => 'imovel_id', 'type' => 'int(11)'],
            ['name' => 'destaque', 'type' => 'varchar(24)'],
            ['name' => 'endereco', 'type' => 'varchar(24)']
        ];
        (new DB)->create_table('integracao_imovel', $columns);
    }

    public function permissao_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'slug', 'type' => 'varchar(255)'],
            ['name' => 'visualizar', 'type' => 'int(1)'],
            ['name' => 'gerenciar', 'type' => 'int(1)'],
            ['name' => 'remover', 'type' => 'int(1)'],
            ['name' => 'usuario_id', 'type' => 'int(11)'],
        ];
        (new DB)->create_table('permissao', $columns);
    }

    public function imovel_caracteristica_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'imovel_id', 'type' => 'int(11)'],
            ['name' => 'caracteristica_id', 'type' => 'int(11)'],
        ];
        (new DB)->create_table('imovel_caracteristica', $columns);
    }

    public function condominio_caracteristica_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'condominio_id', 'type' => 'int(11)'],
            ['name' => 'caracteristica_id', 'type' => 'int(11)'],
        ];
        (new DB)->create_table('condominio_caracteristica', $columns);
    }

    public function condominio_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(255)'],
            ['name' => 'qtd_andar', 'type' => 'int(3)'],
            ['name' => 'qtd_unidades_por_andar', 'type' => 'int(3)'],
            ['name' => 'qtd_torres', 'type' => 'int(3)'],
            ['name' => 'ano_construcao', 'type' => 'int(4)'],
            ['name' => 'uf_id', 'type' => 'int'],
            ['name' => 'cidade_id', 'type' => 'int'],
            ['name' => 'bairro_id', 'type' => 'int'],
            ['name' => 'cep', 'type' => 'varchar(16)'],
            ['name' => 'rua', 'type' => 'varchar(255)'],
            ['name' => 'num', 'type' => 'varchar(16)'],
            ['name' => 'destaque', 'type' => 'int(1)', 'default' => '0'],
            ['name' => 'status', 'type' => 'int(1)', 'default' => 1],

        ];
        (new DB)->create_table('condominio', $columns);
    }

    public function caracteristica_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(255)'],
            ['name' => 'diferencial', 'type' => 'int(1)', 'default' => '0'],
            ['name' => 'tipo', 'type' => 'varchar(16)', 'default' => '"imovel"'],
            ['name' => 'categoria_id', 'type' => 'int(11)'],
        ];
        (new DB)->create_table('caracteristica', $columns);
    }

    public function modelo_imovel_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(255)'],
        ];
        (new DB)->create_table('modelo_imovel', $columns);
    }

    public function caracteristica_categoria_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(255)'],
        ];
        (new DB)->create_table('caracteristica_categoria', $columns);
    }

    public function agenda_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'imovel', 'type' => 'int'],
            ['name' => 'cliente', 'type' => 'int'],
            ['name' => 'usuario', 'type' => 'int'],
            ['name' => 'horario', 'type' => 'datetime'],
            ['name' => 'status', 'type' => 'int'],
            ['name' => 'obs', 'type' => 'longtext'],


        ];
        (new DB)->create_table('agenda', $columns);
    }

    public function uf_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'estado', 'type' => 'varchar(32)'],
            ['name' => 'sigla', 'type' => 'varchar(2)'],

        ];

        $add = [
            [
                'estado' => 'Acre',
                'sigla' => 'AC',
            ],
            [
                'estado' => 'Alagoas',
                'sigla' => 'AL',
            ],
            [
                'estado' => 'Amapá',
                'sigla' => 'AP',
            ],
            [
                'estado' => 'Amazonas',
                'sigla' => 'AM',
            ],
            [
                'estado' => 'Bahia',
                'sigla' => 'BA',
            ],
            [
                'estado' => 'Ceará',
                'sigla' => 'CE',
            ],
            [
                'estado' => 'Distrito Federal',
                'sigla' => 'DF',
            ],
            [
                'estado' => 'Espirito Santo',
                'sigla' => 'ES',
            ],
            [
                'estado' => 'Goiás',
                'sigla' => 'GO',
            ],
            [
                'estado' => 'Maranhão',
                'sigla' => 'MA',
            ],
            [
                'estado' => 'Mato Grosso',
                'sigla' => 'MT',
            ],
            [
                'estado' => 'Mato Grosso do Sul',
                'sigla' => 'MS',
            ],
            [
                'estado' => 'Minas Gerais',
                'sigla' => 'MG',
            ],
            [
                'estado' => 'Pará',
                'sigla' => 'PA',
            ],
            [
                'estado' => 'Paraíba',
                'sigla' => 'PB',
            ],
            [
                'estado' => 'Paraná',
                'sigla' => 'PR',
            ],
            [
                'estado' => 'Pernambuco',
                'sigla' => 'PE',
            ],
            [
                'estado' => 'Piauí',
                'sigla' => 'PI',
            ],
            [
                'estado' => 'Rio de Janeiro',
                'sigla' => 'RJ',
            ],
            [
                'estado' => 'Rio Grande do Norte',
                'sigla' => 'RN',
            ],
            [
                'estado' => 'Rio Grande do Sul',
                'sigla' => 'RS',
            ],
            [
                'estado' => 'Rondônia',
                'sigla' => 'RO',
            ],
            [
                'estado' => 'Roraima',
                'sigla' => 'RR',
            ],
            [
                'estado' => 'Santa Catarina',
                'sigla' => 'SC',
            ],
            [
                'estado' => 'São Paulo',
                'sigla' => 'SP',
            ],
            [
                'estado' => 'Sergipe',
                'sigla' => 'SE',
            ],
            [
                'estado' => 'Tocantins',
                'sigla' => 'TO',
            ]
        ];

        (new DB)->create_table('uf', $columns, $add);
    }

    public function cidade_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'titulo', 'type' => 'varchar(225)'],
            ['name' => 'uf', 'type' => 'int'],

        ];
        (new DB)->create_table('cidade', $columns);
    }

    public function bairro_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'titulo', 'type' => 'varchar(225)'],
            ['name' => 'cidade', 'type' => 'int'],

        ];
        (new DB)->create_table('bairro', $columns);
    }

    public function imovel_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'titulo', 'type' => 'varchar(255)'],
            ['name' => 'desc', 'type' => 'longtext'],
            ['name' => 'categoria', 'type' => 'int'],
            ['name' => 'ref', 'type' => 'varchar(255)'],
            ['name' => 'temporada', 'type' => 'int(1)', 'default' => '0'],
            ['name' => 'valor_venda', 'type' => 'double'],
            ['name' => 'valor_locacao', 'type' => 'double'],
            ['name' => 'uf_id', 'type' => 'int'],
            ['name' => 'cidade_id', 'type' => 'int'],
            ['name' => 'bairro_id', 'type' => 'int'],
            ['name' => 'rua', 'type' => 'varchar(255)'],
            ['name' => 'num', 'type' => 'varchar(16)'],
            ['name' => 'cep', 'type' => 'varchar(16)'],
            ['name' => 'proprietario_nome', 'type' => 'varchar(255)'],
            ['name' => 'proprietario_telefone', 'type' => 'varchar(20)'],
            ['name' => 'proprietario_email', 'type' => 'varchar(255)'],
            ['name' => 'destaque', 'type' => 'int(1)', 'default' => '0'],
            ['name' => 'status', 'type' => 'int(1)', 'default' => 1],

        ];
        (new DB)->create_table('imovel', $columns);
    }

    public function atributo_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'titulo', 'type' => 'varchar(255)'],
            ['name' => 'icone', 'type' => 'varchar(255)'],

        ];
        (new DB)->create_table('atributo', $columns);
    }

    public function atributo_imovel_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'imovel_id', 'type' => 'int'],
            ['name' => 'atributo_id', 'type' => 'int'],
            ['name' => 'valor', 'type' => 'varchar(255)'],

        ];
        (new DB)->create_table('atributo_imovel', $columns);
    }

    public function cliente_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(255)'],
            ['name' => 'cpf', 'type' => 'varchar(20)'],
            ['name' => 'rg', 'type' => 'varchar(20)'],
            ['name' => 'sexo', 'type' => 'int(1)'],
            ['name' => 'telefone', 'type' => 'varchar(20)'],
            ['name' => 'telefone2', 'type' => 'varchar(20)'],
            ['name' => 'celular', 'type' => 'varchar(20)'],
            ['name' => 'celular2', 'type' => 'varchar(20)'],
            ['name' => 'email', 'type' => 'varchar(255)'],
            ['name' => 'email2', 'type' => 'varchar(255)'],
            ['name' => 'password', 'type' => 'varchar(255)'],
            ['name' => 'token', 'type' => 'varchar(255)'],
            ['name' => 'cep', 'type' => 'varchar(15)'],
            ['name' => 'rua', 'type' => 'varchar(200)'],
            ['name' => 'num', 'type' => 'varchar(20)'],
            ['name' => 'bairro', 'type' => 'varchar(255)'],
            ['name' => 'cidade', 'type' => 'varchar(255)'],
            ['name' => 'uf', 'type' => 'varchar(2)'],
            ['name' => 'nascimento', 'type' => 'date'],
            ['name' => 'complemento', 'type' => 'varchar(200)'],
            ['name' => 'obs', 'type' => 'text'],
            ['name' => 'status', 'type' => 'int(1)', 'default' => 1],

        ];
        (new DB)->create_table('cliente', $columns);
    }

    public function smtp_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'host', 'type' => 'varchar(200)'],
            ['name' => 'email', 'type' => 'varchar(200)'],
            ['name' => 'pass', 'type' => 'varchar(200)'],
            ['name' => 'port', 'type' => 'varchar(200)'],
            ['name' => 'secure', 'type' => 'varchar(200)'],
            ['name' => 'nome', 'type' => 'varchar(200)'],

        ];
        $add = [
            'host' => 'host.com.br',
            'email' => 'email@host.com.br',
            'pass' => '123senha',
            'port' => '587',
            'secure' => '1',
            'nome' => 'Teste',

        ];
        (new DB)->create_table('smtp', $columns, $add);
    }

    public function rede_social_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'facebook', 'type' => 'varchar(200)'],
            ['name' => 'twitter', 'type' => 'varchar(200)'],
            ['name' => 'instagram', 'type' => 'varchar(200)'],
            ['name' => 'linkedin', 'type' => 'varchar(200)'],
            ['name' => 'youtube', 'type' => 'varchar(200)'],

        ];
        $add = [
            'facebook' => 'http://facebook.com/',
            'twitter' => 'http://twitter.com/',
            'instagram' => '',
            'linkedin' => 'http://linkedin.com/',
            'youtube' => 'https://www.youtube.com/',

        ];
        (new DB)->create_table('rede_social', $columns, $add);
    }

    public function usuario_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(200)'],
            ['name' => 'telefone', 'type' => 'varchar(20)'],
            ['name' => 'email', 'type' => 'varchar(255)'],
            ['name' => 'pass', 'type' => 'varchar(255)'],
            ['name' => 'avatar', 'type' => 'varchar(255)'],
            ['name' => 'token', 'type' => 'varchar(200)'],
            ['name' => 'level', 'type' => 'int(1)', 'default' => 1],
            ['name' => 'status', 'type' => 'int(1)', 'default' => 1],


        ];
        $add = ['nome' => 'Admin', 'email' => 'admin@admin.com', 'pass' => md5('admin'),];
        (new DB)->create_table('usuario', $columns, $add);
    }

    public function slide_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'img', 'type' => 'varchar(255)'],
            ['name' => 'status', 'type' => 'int(1)', 'default' => 1],
            ['name' => 'pos', 'type' => 'int(3)', 'default' => 999],
            ['name' => 'url', 'type' => 'varchar(255)'],
            ['name' => 'tipo', 'type' => 'int(1)', 'default' => 1],

        ];
        (new DB)->create_table('slide', $columns);
    }

    public function config_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'site_title', 'type' => 'varchar(200)'],
            ['name' => 'site_logo', 'type' => 'varchar(200)'],
            ['name' => 'site_tema_categoria', 'type' => 'int(1)', 'default' => '1'],
            ['name' => 'config_site_tema_imovel', 'type' => 'int(1)', 'default' => '1'],
            ['name' => 'site_tema_search', 'type' => 'int(1)', 'default' => '1'],
            ['name' => 'site_top_gradient', 'type' => 'int(1)', 'default' => '1'],
            ['name' => 'site_titulo_lading', 'type' => 'text'],
            ['name' => 'site_text_lading', 'type' => 'text'],
            ['name' => 'site_fundo_search', 'type' => 'varchar(255)'],
            ['name' => 'site_altura_search', 'type' => 'int(1)', 'default' => '1'],
            ['name' => 'site_search_posicao', 'type' => 'int(1)', 'default' => '1'],
            ['name' => 'site_color_search', 'type' => 'varchar(255)'],
            ['name' => 'site_slogan', 'type' => 'varchar(200)'],
            ['name' => 'site_favicon', 'type' => 'varchar(200)'],

            ['name' => 'site_author', 'type' => 'varchar(200)'],
            ['name' => 'site_description', 'type' => 'text'],
            ['name' => 'site_about', 'type' => 'longtext'],
            ['name' => 'site_keywords', 'type' => 'text'],
            ['name' => 'site_ga_id', 'type' => 'varchar(200)'],
            ['name' => 'site_ga_code', 'type' => 'varchar(255)'],
            ['name' => 'site_tm_code', 'type' => 'varchar(255)'],
            ['name' => 'site_chat_code', 'type' => 'longtext'],

            ['name' => 'site_funcionamento', 'type' => 'varchar(200)'],
            ['name' => 'tema_id', 'type' => 'int(2)', 'default' => 1],

            ['name' => 'site_telefone', 'type' => 'varchar(16)'],
            ['name' => 'site_telefone2', 'type' => 'varchar(16)'],
            ['name' => 'site_email', 'type' => 'varchar(200)'],
            ['name' => 'site_cnpj', 'type' => 'varchar(30)'],
            ['name' => 'site_creci', 'type' => 'varchar(30)'],

            ['name' => 'site_cep', 'type' => 'varchar(16)'],
            ['name' => 'site_rua', 'type' => 'varchar(200)'],
            ['name' => 'site_num', 'type' => 'varchar(16)'],
            ['name' => 'site_bairro', 'type' => 'varchar(200)'],
            ['name' => 'site_cidade', 'type' => 'varchar(200)'],
            ['name' => 'site_uf', 'type' => 'varchar(3)'],

            ['name' => 'lgpd_texto', 'type' => 'varchar(255)'],
            ['name' => 'lgpd_link', 'type' => 'varchar(255)'],

            ['name' => 'site_modo', 'type' => 'int(2)', 'default' => "1"],
            ['name' => 'site_layout', 'type' => 'int(2)', 'default' => "1"],
            ['name' => 'site_logo_formato', 'type' => 'int(2)', 'default' => "1"],

        ];
        $seed = [
            "site_title" => "Imobiliária",

            "site_slogan" => "Plataforma de Imobiliária",
            "site_author" => "Miles Agência criativa",
            "site_description" => "",
            "site_about" => ".",
            "site_keywords" => "",
            "site_ga_id" => "",
            "site_ga_code" => "",
            "site_tm_code" => "",
            "site_funcionamento" => "",
            "tema_id" => "1",
            "site_telefone" => "",
            "site_telefone2" => "",
            "site_email" => "",
            "site_cnpj" => "",
            "site_creci" => "",
            "site_cep" => "",
            "site_rua" => "",
            "site_num" => "",
            "site_bairro" => "",
            "site_cidade" => "",
            "site_uf" => "",
            "lgpd_texto" => "Ao acessar nosso site, você concorda com os nossos termos de privacidade.",
            "lgpd_link" => "",
            "site_modo" => "1",
            "site_layout" => "1",

        ];
        (new DB)->create_table('config', $columns, $seed);
    }
    public function categoria_imovel_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(200)'],
            ['name' => 'url', 'type' => 'varchar(200)'],
            ['name' => 'img_capa', 'type' => 'text'],

        ];
        (new DB)->create_table('categoria_imovel', $columns);
    }

    public function foto_imovel_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'imovel', 'type' => 'int(11)'],
            ['name' => 'img', 'type' => 'varchar(255)'],
            ['name' => 'url', 'type' => 'text'],
            ['name' => 'pos', 'type' => 'int(11)', 'default' => 9999],

        ];
        (new DB)->create_table('foto_imovel', $columns);
    }

    public function imoveis_relacionados_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'imovel1', 'type' => 'int(11)'],
            ['name' => 'imovel2', 'type' => 'int(11)'],

        ];
        (new DB)->create_table('imoveis_relacionados', $columns);
    }

    public function avaliacao_imovel_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'imovel', 'type' => 'int(11)'],
            ['name' => 'status', 'type' => 'int(1)'],
            ['name' => 'descricao', 'type' => 'varchar(255)'],
            ['name' => 'cliente', 'type' => 'int(11)'],
            ['name' => 'nota', 'type' => 'int(1)'],

        ];
        (new DB)->create_table('avaliacao_imovel', $columns);
    }

    public function newsletter_create()
    {
        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'email', 'type' => 'varchar(360)'],
            ['name' => 'nome', 'type' => 'varchar(360)'],
            ['name' => 'status', 'type' => 'int(1)'],

        ];
        (new DB)->create_table('newsletter', $columns);
    }

    public function parceiro_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'nome', 'type' => 'varchar(200)'],
            ['name' => 'logo', 'type' => 'varchar(200)'],
            ['name' => 'link', 'type' => 'varchar(200)'],
            ['name' => 'pos', 'type' => 'int(11)'],
            ['name' => 'status', 'type' => 'int(1)'],

        ];

        (new DB)->create_table('parceiro', $columns);
    }

    public function config_cores_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'local', 'type' => 'varchar(40)'],
            ['name' => 'fundo', 'type' => 'varchar(16)'],
            ['name' => 'texto', 'type' => 'varchar(16)'],
            ['name' => 'hover_fundo', 'type' => 'varchar(16)'],
            ['name' => 'hover_texto', 'type' => 'varchar(16)'],

        ];

        // $seeds[] = [
        //     'local' => 'Topo',
        //     'fundo' => '#0a0a0a',
        //     'texto' => '#e6e6e6',
        //     'hover_fundo' => '#000',
        //     'hover_texto' => '#b0b0b0',

        // ];


        (new DB)->create_table('config_cores', $columns);
    }

    public function order_home_create()
    {

        $columns = [
            ['name' => 'id', 'type' => 'int(11)', 'key' => true],
            ['name' => 'view', 'type' => 'varchar(255)'],
            ['name' => 'apelido', 'type' => 'varchar(255)'],
            ['name' => 'order', 'type' => 'int(11)'],
            ['name' => 'status', 'type' => 'int(2)', 'default' => 1],

        ];

        // $seeds[] = [
        //     'view' => 'slide-superior',
        //     'apelido' => 'Slide 1',
        //     'order' => 1,
        //     'status' => 1,
        // ];
        (new DB)->create_table('order_home', $columns);
    }

    #endregion Creates

    #region Migrates
    public function migrate()
    {
        exit;

        Http::redirect_to('/install/?success');
    }

    public function generic_migrate()
    {
        exit;
        $columns = [
            ['name' => 'forma', 'type' => 'int(3)']
        ];
        (new DB)->add_columns('movimentacao', $columns);
    }
    #endregion Migrates

    #region Métodos para ajudar no desenvolvimento

    // Gerador de SEEDS para install
    // Insira o nome da tabela e ele gera os seeds para inserir no install com os produtos cadastrados atualmente
    public function geraSeed($table = false)
    {
        exit;
        if ($table) {
            $rows = (new Orm($table))->get();
            $seed = '[';
            foreach ($rows as $indice) {
                $seed .= '[ <br>';
                foreach ($indice as $campo => $valor) {
                    if ($campo != $table . "_created" && $campo != $table . "_updated" && $campo != $table . "_id") {
                        $campo = str_replace($table . "_", "", $campo);
                        $seed .= '  "' . $campo . '" => "' . $valor . '", <br>';
                    }
                }
                $seed .= '], <br>';
            }
            $seed .= "]";
            echo $seed;
            exit;
            return (array) $seed;
        }
    }

    public function show_seed()
    {
        exit;
        $table = Http::get_in_params('show_seed', 'string');
        if (isset($table->value) && !empty($table->value)) {
            $this->geraSeed($table->value);
        }
    }

    // Método para ajudar a criar o install de uma tabela, passando ela no construct do factory
    public function map()
    {
        exit;
        //  $map = (new Orm('pedido'))->map(1);
        $map = (new DB)->show_table('produto');
        foreach ($map as $k => $v) {
            $k = str_replace("produto_", "", $k);
            echo '["name" => "' . $k . '", "type" => "' . $v . '"], <br>';
        }
    }

    public function mapRows()
    {
        exit;
        $tabela = "categoria_produto";
        $rows = (new Orm($tabela))->get();

        $seed = '$seed = ';
        foreach ($rows as $indice) {
            $seed .= '[ <br>';
            foreach ($indice as $campo => $valor) {
                if ($campo != $tabela . "_created" && $campo != $tabela . "_updated" && $campo != $tabela . "_id") {
                    $campo = str_replace($tabela . "_", "", $campo);
                    $seed .= '  ["' . $campo . '" => "' . $valor . '"], <br>';
                }
            }

            $seed .= '],';
        }
        $seed .= '];';
        Filter::pre($seed, 1);
    }

    public function clear_tables_dev()
    {

        exit;
    }
    #endregion Métodos para ajudar no desenvolvimento
}
