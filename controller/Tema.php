<?php

// Controller usado para setar temas configurados pelo Painel Admin
class Tema
{
    public $styleLayout = "";

    public function __construct()
    {
        // 
        // $qtd = count((new Orm('config_cores'))->get());
        // if ($qtd != 8) {
        //     (new DB)->drop_table('config_cores');
        //     (new Install)->config_cores_create();
        // }
    }

    public function indexAction()
    {
    }

    public function layout()
    {
        $layout = (new Orm('config'))
            ->get()[0];
        if (isset($layout->config_site_layout)) {
            $config = $layout;
            $layout = intval($layout->config_site_layout);

            switch ($layout) {
                case 1:
                    // Layout Full
                    $this->getLayoutFull();
                    break;
                case 2:
                    // Layout Boxed
                    $this->getLayoutBoxed();
                    break;
                default:
                    // Layout Full
                    $this->getLayoutFull();
                    break;
            }

            // Faltando setar as cores
            $this->getColors();

             // seta as configurações de slides
             $styleSlides = "
             @media screen and (min-width: 799px) {
                 .multiplos-config {
                     width: 100% !important;
                     $config->config_slide_multiplo_config
                 }
                 .slide-config {
                     width: 100% !important;
                     $config->config_slide_comum_config
                 }
             }
         ";
         $this->styleLayout .= $styleSlides;

            $this->render();
        }
    }

    public function getLayoutFull()
    {
        $style = "
            .menu-direito-nav {
                margin-right: 45px !important;
            }

            .force-height-400 {
                min-height: 45vh !important;
            }
        ";

        $this->styleLayout .= $style;
    }

    public function getLayoutBoxed()
    {
        
    }

    public function getColors()
    {
        $cores = (new Orm('config_cores'))->get();

        $style = "
            .custom_topo_fundo { background-color: {$cores[0]->config_cores_fundo} !important; }
            .custom_topo_texto { color: {$cores[0]->config_cores_texto} !important; }
            .custom_topo_texto:hover { color: {$cores[0]->config_cores_hover_texto} !important; }

            .custom_menu_fundo, .navbar-expand-lg.navbar-light .navbar-nav .dropdown:hover .nav-link { background-color: {$cores[1]->config_cores_fundo} !important; border: 1px solid transparent !important; }
            .custom_menu_texto { color: {$cores[1]->config_cores_texto} !important; }
            .custom_menu_texto_no_hover { color: {$cores[1]->config_cores_texto} !important; }
            .custom_menu_texto_border {border-bottom: 1px solid {$cores[1]->config_cores_texto} !important;}
            .custom_menu_texto:hover { color: {$cores[1]->config_cores_hover_texto} !important; }

            .custom_loja_fundo, body { background-color: {$cores[2]->config_cores_fundo} !important; }
            .custom_loja_texto { color: {$cores[2]->config_cores_texto} !important; }

            .custom_redesSociais_fundo { background-color: {$cores[3]->config_cores_fundo} !important; border: 1px solid transparent !important;}
            .custom_redesSociais_texto { color: {$cores[3]->config_cores_texto} !important; }
            .custom_redesSociais_texto:hover { color: {$cores[3]->config_cores_texto} !important; }

            .custom_rodapeInformacoes_fundo { background-color: {$cores[4]->config_cores_fundo} !important; border: 1px solid transparent !important}
            .custom_rodapeInformacoes_texto { color: {$cores[4]->config_cores_texto} !important; }
            .custom_rodapeInformacoes_texto_no_hover { color: {$cores[4]->config_cores_texto} !important; }
            .custom_rodapeInformacoes_texto:hover { color: {$cores[4]->config_cores_hover_texto} !important; }

            .custom_rodape_fundo { background-color: {$cores[5]->config_cores_fundo} !important; }
            .custom_rodape_texto { color: {$cores[5]->config_cores_texto} !important; }

            .custom_botoesPrincipais_fundo { background-color: {$cores[6]->config_cores_fundo} !important; }
            .custom_botoesPrincipais_texto { color: {$cores[6]->config_cores_texto} !important; }

            .custom_botoesSucesso_fundo { background-color: {$cores[7]->config_cores_fundo} !important; }
            .custom_botoesSucesso_texto { color: {$cores[7]->config_cores_texto} !important; }

            .nav-tabs .nav-link.active { border-color: {$cores[6]->config_cores_texto} !important; }

            .btn-primary, .bg-primary {
                background-color: {$cores[6]->config_cores_fundo} !important;
                border: 1px solid {$cores[6]->config_cores_fundo} !important;
                color: {$cores[6]->config_cores_texto} !important;
            }

            .btn-primary:hover {
                background-color: {$cores[6]->config_cores_hover_fundo} !important;
                border: 1px solid {$cores[6]->config_cores_hover_fundo} !important;
                color: {$cores[6]->config_cores_hover_texto} !important;
            }

            .btn-outline-primary {
                background-color: transparent !important;
                border: 1px solid {$cores[6]->config_cores_fundo} !important;
                color: {$cores[6]->config_cores_fundo} !important;
            }

            .btn-outline-primary:hover {
                background-color: {$cores[6]->config_cores_fundo} !important;
                border: 1px solid {$cores[6]->config_cores_fundo} !important;
                color: {$cores[6]->config_cores_texto} !important;
            }

            .btn-info {
                background-color: {$cores[7]->config_cores_fundo} !important;
                border: 1px solid {$cores[7]->config_cores_fundo} !important;
                color: {$cores[7]->config_cores_texto} !important;
            }

            .btn-info:hover {
                background-color: {$cores[7]->config_cores_hover_fundo} !important;
                border: 1px solid {$cores[7]->config_cores_hover_fundo} !important;
                color: {$cores[7]->config_cores_hover_texto} !important;
            }

            .owl-carousel .owl-dots .owl-dot {background-color: {$cores[6]->config_cores_fundo} !important;}

            .loader span {
                background-color: {$cores[2]->config_cores_texto} !important;
            }

            .loader-div {
                background-color: {$cores[2]->config_cores_fundo} !important;       
            }
            
            .shadow-custom {                
                -webkit-box-shadow: 0px 3px 0px 0px {$cores[0]->config_cores_fundo}aa;
                -moz-box-shadow: 0px 3px 0px 0px {$cores[0]->config_cores_fundo}aa;
                box-shadow: 0px 3px 0px 0px {$cores[0]->config_cores_fundo}aa;
                margin-bottom: 0.36rem !important;
            }
        ";
        $this->styleLayout .= $style;
    }

    public function render()
    {
        header("Content-type: text/css");
        echo preg_replace('/\s+/', ' ', $this->styleLayout);
    }
}
