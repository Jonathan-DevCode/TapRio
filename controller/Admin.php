<?php

class Admin
{
    public function __construct()
    {
        
        Sessao::check();
    }

    public function indexAction()
    {

        Http::redirect_to("/imovel-lista");
        
        $data = [
            'config' => (new Config)->get(),
            'mapper' => ['config']
        ];
        Template::view('admin.default', $data, 1);
    }
}
