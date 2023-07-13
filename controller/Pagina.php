<?php

class Pagina
{
    public function __construct()
    {

    }

    public function listarPaginasTopo()
    {
        $cat = (new Orm('categoria_pagina'))
            ->select('categoria_pagina_id, categoria_pagina_nome, categoria_pagina_url, categoria_pagina_topo, categoria_pagina_pos')
            ->where('categoria_pagina_topo = "1" AND categoria_pagina_id IN (SELECT pagina_categoria FROM pagina WHERE pagina_status = 1)')
            ->get();
        if ($cat) {
            foreach ($cat as $k => $v) {
                $pag = (new Orm('pagina'))
                    ->select('pagina_id, pagina_url, pagina_titulo, pagina_status')
                    ->where('pagina_status = 1 AND pagina_categoria = ' . $cat[$k]->categoria_pagina_id)
                    ->get();

                if ($pag)
                    $cat[$k]->paginas = $pag;
                else
                    unset($cat[$k]);
            }
        }
        return $cat;
    }

    public function listarPaginasFooter()
    {
        $cat = (new Orm('categoria_pagina'))
            ->select('categoria_pagina_id, categoria_pagina_nome, categoria_pagina_url, categoria_pagina_rodape, categoria_pagina_pos')
            ->where('categoria_pagina_rodape = "1" AND categoria_pagina_id IN (SELECT pagina_categoria FROM pagina WHERE pagina_status = 1)')
            ->get();
        if ($cat) {
            foreach ($cat as $k => $v) {
                $pag = (new Orm('pagina'))
                    ->select('pagina_id, pagina_url, pagina_titulo, pagina_status')
                    ->where('pagina_status = 1 AND pagina_categoria = ' . $cat[$k]->categoria_pagina_id)
                    ->get();

                if ($pag)
                    $cat[$k]->paginas = $pag;
                else
                    unset($cat[$k]);
            }
        }
        return $cat;
    }

    public function ver()
    {

        $cat = Http::get_param(2, 'string');
        $nome = Http::get_param(3, 'string');
        $cat = Http::get_in_params("pagina");
        if (!isset($cat->value) || empty($cat->value)) {
            Http::redirect_to('/');
        }
        $cat = $cat->value;
        $nome = Http::get_in_params($cat);
        if (!isset($nome->value) || empty($nome->value)) {
            Http::redirect_to('/');
        }
        $nome = $nome->value;

        $pagina = (new Orm('pagina'))->select('pagina_id, pagina_titulo,pagina_desc,pagina_keywords, pagina_texto, pagina_capa, categoria_pagina_nome, categoria_pagina_url')
            ->join('categoria_pagina', 'categoria_pagina_id = pagina_categoria')
            ->where("pagina_url = '$nome' AND categoria_pagina_url = '$cat' ")
            ->limit(1)
            ->get();
        $pagina = !empty($pagina[0]) ? $pagina[0] : '';
        $data = [
            'paginasTopo' => (new Pagina())->listarPaginasTopo(),
            'social' => (new Config)->get_rede_social(),
            // Footer
            'paginasFooter' => (new Pagina())->listarPaginasFooter(),
            // Principal
            'config' => (new Config)->get(),
            'pagina' => $pagina,
            'mapper' => ['config', 'pagina', 'social']
        ];
        Template::view("tema.screens.pagina.index", $data, 1);
    }
}
