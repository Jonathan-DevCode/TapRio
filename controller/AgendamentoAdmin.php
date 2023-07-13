<?php

class AgendamentoAdmin
{
    public function __construct()
    {
        
        Sessao::check();
    }

    public function indexAction()
    {

        $data = [
            'config' => (new Config)->get(),
            'mapper' => ['config']
        ];
        Template::view('admin.agendamento.index', $data, 1);
    }
}
