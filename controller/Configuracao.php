<?php

class Configuracao
{

    public function __construct()
    {
        
        Sessao::check();
        
    }

    public function indexAction()
    {
        $this->site();exit;
        $data = [
            'config' => (new Config)->get(),
            'mapper' => ['config']
        ];
        Template::view('admin.config.config', $data, 1);
    }

    public function site()
    {
        $data = [
            'config' => (new Config)->get(),

            'mapper' => ['config']
        ];
        Template::view('admin.config.site', $data, 1);
    }


    public function email()
    {
        $data = [
            'config' => (new Config)->get(),

            'smtp' => (new Config)->getSmtp(),
            'mapper' => ['config', 'smtp']
        ];
        Template::view('admin.config.email', $data, 1);
    }

    // public function contato()
    // {
    //     $data = [
    //         'config' => (new Config)->get(),
    //         'mapper' => ['config', 'contato']
    //     ];
    //     Template::view('admin.config.contato', $data, 1);
    // }

    public function logo()
    {
        $this->layout();
    }


    public function rede()
    {
        $data = [
            'config' => (new Config)->get(),
            'rede' => (new Config)->get_rede_social(),

            'mapper' => ['config', 'rede']
        ];
        Template::view('admin.config.rede', $data, 1);
    }

    public function layout()
    {
        $cores = (new Orm('config_cores'))->get();

        $data = [
            'config' => (new Config)->get(),
            'cores' => $cores,
            'mapper' => ['config']
        ];
        Template::view('admin.config.layout', $data, 1);
    }

    public function gravar()
    {
        $this->logo_upload();
        $this->favicon_upload();
        $this->marcadagua_upload();

        $_POST['config_id'] = (new Config)->get()->config_id;
        if (isset($_POST['config_id']) && !empty($_POST['config_id']) && intval($_POST['config_id']) > 0) {            
            $return = Http::get_in_params('return');

            if (isset($return->value)) {
                $return = $return->value;
                (new Orm('config'))->with($_POST)->save();
                Http::redirect_to("/configuracao/$return/?success");
            }
        }
    }

    public function gravarSmtp()
    {
        $_POST['smtp_id'] = 1;
        if (isset($_POST['smtp_id']) && !empty($_POST['smtp_id'])) {
            $return = Http::get_in_params('return');
            if (isset($return->value)) {
                $return = $return->value;
                if (Req::is_empty('smtp_pass')) {
                    Req::drop('smtp_pass');
                }
                (new Orm('smtp'))->with($_POST)->save();
                Http::redirect_to("/configuracao/$return/?success");
            }
        }
    }

    public function  altera_cor()
    {
        $_POST['config_id'] = (new Config)->get()->config_id;
        if (isset($_POST['config_tema_color'])) {
            $data = [
                'id' => $_POST['config_id'],
                'config_tema_color' => $_POST['config_tema_color'],
            ];
            (new Orm('config'))->with($data)->save();
            echo true;
        }
    }

    // public function gravarContato()
    // {
    //     $_POST['contato_id'] = (new Config)->get_rede_social()->contato_id;
    //     if (isset($_POST['contato_id']) && !empty($_POST['contato_id'])) {
    //         $return = Http::get_in_params('return');
    //         if (isset($return->value)) {
    //             $return = $return->value;
    //             (new Orm('contato'))->with($_POST)->save();
    //             Http::redirect_to("/configuracao/$return/?success");
    //         }
    //     }
    // }

    public function gravarRede()
    {
        $_POST['rede_social_id'] = (new Config)->get_rede_social()->rede_social_id;
        if (isset($_POST['rede_social_id']) && !empty($_POST['rede_social_id'])) {
            $return = Http::get_in_params('return');
            if (isset($return->value)) {
                $return = $return->value;
                (new Orm('rede_social'))->with($_POST)->save();
                Http::redirect_to("/configuracao/$return/?success");
            }
        }
    }

    public function logo_upload()
    {        
        $config_site_logo_formato = Req::post('config_site_logo_formato', 'int');
        $logo = [
            'id' => (new Config)->get()->config_id,
            'site_logo_formato' => $config_site_logo_formato
        ];
        if (!empty($_FILES['logo']['name'])) {
            $file = $_FILES['logo'];
            $img = Media::upload($file, 'site', 'img');

            if (is_object($img)) {
                /*REMOVE ATUAL LOGO */
                $current = (new Orm('config'))->get();
                $current = $current[0];
                $current_logo = Path::base() . "/media/site/$current->config_site_logo";
                if (file_exists($current_logo)) {
                    @unlink($current_logo);
                }
                /*END REMOVE ATUAL LOGO */
                /*ATUALIZA LOGO*/
                $logo['site_logo'] = $img->url;
            }
        };
        (new Orm('config'))->with($logo)->save();
    }

    public function favicon_upload()
    {
        $config_id = (new Config)->get()->config_id;
        if (!empty($_FILES['favicon']['name'])) {
            $file = $_FILES['favicon'];
            $img = Media::upload($file, 'site', 'img');

            if (is_object($img)) {

                /*REMOVE ATUAL LOGO */
                $current = (new Orm('config'))->get();
                $current = $current[0];
                $current_logo = Path::base() . "/media/site/$current->config_site_favicon";
                if (file_exists($current_logo)) {
                    @unlink($current_logo);
                }
                /*END REMOVE ATUAL LOGO */
                /*ATUALIZA LOGO*/
                $logo = ['site_favicon' => $img->url, 'id' => $config_id];
                (new Orm('config'))->with($logo)->save();
            }
        };

        if (!empty($_FILES['favicon']['name'])) {
            $file = $_FILES['favicon'];
            $img = Media::upload($file, 'site', 'img');
        };
        
    }



    public function marcadagua_upload()
    {
        $config_id = (new Config)->get()->config_id;
        if (!empty($_FILES['marcadagua']['name'])) {
            $file = $_FILES['marcadagua'];
            $img = Media::upload($file, 'site', 'img');

            if (is_object($img)) {

                /*REMOVE ATUAL LOGO */
                $current = (new Orm('config'))->get();
                $current = $current[0];
                $current_logo = Path::base() . "/media/site/$current->config_site_marcadagua";
                if (file_exists($current_logo)) {
                    @unlink($current_logo);
                }
                /*END REMOVE ATUAL LOGO */
                /*ATUALIZA LOGO*/
                $logo = ['site_marcadagua' => $img->url, 'id' => $config_id];
                (new Orm('config'))->with($logo)->save();
            }
        };

        if (!empty($_FILES['marcadagua']['name'])) {
            $file = $_FILES['marcadagua'];
            $img = Media::upload($file, 'site', 'img');
        };
        
    }

    public function login_upload()
    {
        $_POST['config_id'] = (new Config)->get()->config_id;
        if (!empty($_FILES['login'])) {
            $file = $_FILES['login'];
            $img = Media::upload($file, 'site', 'img');
            if (is_object($img)) {
                /*REMOVE ATUAL LOGO */
                $current = (new Orm('config'))->get();
                $current_login = Path::base() . "/media/site/$current->config_site_loginscreen";
                if (file_exists($current_login)) {
                    @unlink($current_login);
                }
                /*END REMOVE ATUAL LOGO */
                /*ATUALIZA LOGO*/
                $screen = ['site_loginscreen' => $img->url, 'id' => $_POST['config_id']];
                (new Orm('config'))->with($screen)->save();
            }
        }
        Http::redirect_to("/configuracao/logo/?success");
    }

    public function gravar_modo()
    {
        $config_id = (new Config)->get()->config_id;
        $config_site_modo = Req::post('config_site_modo', 'int');
        $config_desconta_estoque = Req::post('config_desconta_estoque', 'int');

        if ($config_id > 0 && $config_site_modo > 0) {
            $with = [
                'id' => $config_id,
                'site_modo' => $config_site_modo,
                'desconta_estoque' => $config_desconta_estoque
            ];
            (new Orm('config'))->with($with)->save();
            Http::redirect_to('/configuracao/?success');
        } else {
            Http::redirect_to('/configuracao/?error');
        }
    }

    public function gravar_layout()
    {
        $config_id = (new Config)->get()->config_id;
        $config_site_layout = Req::post('config_site_layout', 'int');
        $config_logo_margin_top = Req::post('config_logo_margin_top', 'int');
        $config_logo_margin_left = Req::post('config_logo_margin_left', 'int');
        $config_logo_tamanho = Req::post('config_logo_tamanho', 'int');
        $config_logo_altura = Req::post('config_logo_altura', 'int');
        $config_menu_alinhamento = Req::post('config_menu_alinhamento');
        $config_layout_foto_oferta = Req::post('config_layout_foto_oferta');
        $config_layout_foto_destaque = Req::post('config_layout_foto_destaque');
        $config_layout_foto_novos = Req::post('config_layout_foto_novos');
        $config_layout_preenchimento_fotos = Req::post('config_layout_preenchimento_fotos');

        if ($config_id > 0 && $config_site_layout > 0) {
            $with = [
                'id' => $config_id,
                'site_layout' => $config_site_layout,
                'logo_margin_top' => $config_logo_margin_top,
                'logo_margin_left' => $config_logo_margin_left,
                'logo_tamanho' => $config_logo_tamanho,
                'logo_altura' => $config_logo_altura,
                'menu_alinhamento' => $config_menu_alinhamento,
                'layout_foto_oferta' => $config_layout_foto_oferta,
                'layout_foto_destaque' => $config_layout_foto_destaque,
                'layout_foto_novos' => $config_layout_foto_novos,
                'layout_preenchimento_fotos' => $config_layout_preenchimento_fotos,
            ];
            (new Orm('config'))->with($with)->save();
            Http::redirect_to('/configuracao/layout/?success');
        } else {
            Http::redirect_to('/configuracao/layout/?error');
        }
    }

    public function gravar_cores()
    {
        foreach ($_POST['config_cores_id'] as $k => $v) {
            $id = $_POST['config_cores_id'][$k];
            $local = $_POST['config_cores_local'][$k];
            $fundo = $_POST['config_cores_fundo'][$k];
            $texto = $_POST['config_cores_texto'][$k];
            $hover_fundo = $_POST['config_cores_hover_fundo'][$k];
            $hover_texto = $_POST['config_cores_hover_texto'][$k];

            $with = [
                'id' => $id,
                'local' => $local,
                'fundo' => $fundo,
                'texto' => $texto,
                'hover_fundo' => $hover_fundo,
                'hover_texto' => $hover_texto
            ];
            (new Orm('config_cores'))->with($with)->save();
        }

        Http::redirect_to("/configuracao/layout/?success");
    }

    public function slide_config()
    {
        $slide_altura_imagens = Req::post('slide_altura_imagens');
        $slide_preenchimento_imagens = Req::post('slide_preenchimento_imagens');
        $multiplo_altura_imagens = Req::post('multiplo_altura_imagens');
        $multiplo_preenchimento_imagens = Req::post('multiplo_preenchimento_imagens');

        $config_id = (new Config)->get()->config_id;
        $config_slide_comum_config = $slide_altura_imagens;
        if (!empty($slide_preenchimento_imagens)) {
            $config_slide_comum_config .= $slide_preenchimento_imagens;
        }

        $config_slide_multiplo_config = $multiplo_altura_imagens;
        if (!empty($multiplo_preenchimento_imagens)) {
            $config_slide_multiplo_config .= $multiplo_preenchimento_imagens;
        }

        $with = [
            'id' => $config_id,
            'slide_comum_config' => $config_slide_comum_config,
            'slide_multiplo_config' => $config_slide_multiplo_config,
        ];
        (new Orm('config'))->with($with)->save();
        Http::redirect_to('/slide/?success');
    }

    public function search_foto_upload() {
        $with = [
            'site_color_search' => Req::post('config_site_color_search', 'string'),
            'site_altura_search' => Req::post('config_site_altura_search', 'int'),
            'site_search_posicao' => Req::post('config_site_search_posicao', 'int'),
            'id' => (new Config)->get()->config_id
        ];     
        if(isset($_FILES['foto']) && intval($_FILES['foto']['error']) == 0) {
            $file = $_FILES['foto'];
            $img = Media::upload($file, 'site', 'img');
            if (is_object($img)) {
                /*REMOVE ATUAL LOGO */
                $current = (new Orm('config'))->get();
                $current = $current[0];
                $current_login = Path::base() . "/media/site/$current->config_site_fundo_search";
                if (file_exists($current_login)) {
                    @unlink($current_login);
                }
                /*END REMOVE ATUAL LOGO */
                /*ATUALIZA LOGO*/
                $with['site_fundo_search'] = $img->url;                
            }
        } 
        (new Orm('config'))->with($with)->save();  
        Http::redirect_to("/configuracao/layout/?success");      
    }

    public function search_foto_upload_lading() {
        $with = [
            'site_color_search' => Req::post('config_site_color_search', 'string'),
            'site_titulo_lading' => Req::post('config_site_titulo_lading', 'string'),
            'site_text_lading' => Req::post('config_site_text_lading', 'string'),
            'site_search_posicao' => Req::post('config_site_search_posicao', 'int'),
            'site_top_gradient' => Req::post('config_site_top_gradient', 'int'),
            'id' => (new Config)->get()->config_id
        ];     
        if(isset($_FILES['foto']) && intval($_FILES['foto']['error']) == 0) {
            $file = $_FILES['foto'];
            $img = Media::upload($file, 'site', 'img');
            if (is_object($img)) {
                /*REMOVE ATUAL LOGO */
                $current = (new Orm('config'))->get();
                $current = $current[0];
                $current_login = Path::base() . "/media/site/$current->config_site_fundo_search";
                if (file_exists($current_login)) {
                    @unlink($current_login);
                }
                /*END REMOVE ATUAL LOGO */
                /*ATUALIZA LOGO*/
                $with['site_fundo_search'] = $img->url;                
            }
        } 
        (new Orm('config'))->with($with)->save();  
        Http::redirect_to("/configuracao/layout/?success");      
    }

    public function set_tema_form() {
        $tema = Req::post('tema', 'string');
        $with = [
            'id' => (new Config)->get()->config_id,
            'site_tema_search' => 1
        ];
        if($tema == 'quarzar') {
            $with['site_tema_search'] = 1;
        }
        if($tema == "landing") {
            $with['site_tema_search'] = 2;
        }
        (new Orm('config'))->with($with)->save();
        Http::redirect_to('/configuracao/layout/?success');
    }

    public function set_tema_categorias() {
        $tema = Req::post('tema', 'string');
        $with = [
            'id' => (new Config)->get()->config_id,
            'site_tema_categoria' => 1
        ];
        if($tema == 'simple') {
            $with['site_tema_categoria'] = 1;
        }
        if($tema == "background") {
            $with['site_tema_categoria'] = 2;
        }
        (new Orm('config'))->with($with)->save();
        Http::redirect_to('/configuracao/layout/?success');
    }

    public function set_tema_imoveis() {
        $tema = Req::post('tema', 'string');
        $with = [
            'id' => (new Config)->get()->config_id,
            'site_tema_imovel' => 1
        ];
        if($tema == 'grid') {
            $with['site_tema_imovel'] = 1;
        }
        if($tema == "list") {
            $with['site_tema_imovel'] = 2;
        }
        (new Orm('config'))->with($with)->save();
        Http::redirect_to('/configuracao/layout/?success');
    }
}
