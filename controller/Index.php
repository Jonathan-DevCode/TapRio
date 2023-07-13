<?php

class Index
{
    private $mobile_label_page = "";
    public function __construct()
    {


        // caso seja requisitado por mobile, renderiza a view mobile
        if (Browser::agent('mobile')) {
            $this->mobile_label_page = "mobile_";
        }


    }

    public function indexAction()
    {
        $config = (new Config)->get();
        $config_json = (new Config)->get();
        unset($config_json->config_site_about);
        $data = [
            'config' => $config,
            'config_json' => $config_json,
            'paginasTopo' => (new Pagina())->listarPaginasTopo(),
            // Footer
            'paginasFooter' => (new Pagina())->listarPaginasFooter(),
            'social' => (new Config)->get_rede_social(),
            'mapper' => ['config', 'social']
        ];
        Template::view("tema.screens.home.index", $data);
        exit;
    }
}
