<?php
/* Configuração de Rotas Alternativas da Aplicação */
/* ROTEAMENTO URL x Controller <-> Action */
$routes = [
    // ADMIN
    "logout" => "Login:logout",
    "slide-lista" => "Slide:indexAction",
    "slide-novo" => "Slide:novo",
    "slide-editar" => "Slide:editar",

    "parceiros-lista" => "Parceiros:indexAction",
    "parceiros-novo" => "Parceiros:novo",
    "parceiros-editar" => "Parceiros:editar",

    "cidades" => "Local:cidades",
    "bairros" => "Local:bairros",
    
    "imovel-categoria" => "Categoria:indexAction",
    
    "imovel-atributo" => "Atributo:indexAction",

    "imovel-lista" => "ImovelAdmin:indexAction",
    "imovel-chaves" => "ImovelAdmin:indexActionChaves",
    "imovel-lista-site" => "ImovelAdmin:indexActionSite",
    "imovel-novo" => "ImovelAdmin:novo",
    "imovel-editar" => "ImovelAdmin:editar",
    "imovel-site-editar" => "ImovelAdmin:editarSite",

    "agenda-lista" => "AgendamentoAdmin:indexAction",

    
    //    PAGINA ADMIN
    "pagina-lista" => "PaginaAdmin:indexAction",
    "nova-pagina" => "PaginaAdmin:novo",
    "editar-pagina" => "PaginaAdmin:editar",
    "pagina-categoria" => "PaginaAdmin:categoria",
    "pagina-subcategoria" => "PaginaAdmin:subcategoria",

     //    PAGINA TEMPLATE
     "pagina" => "Pagina:ver",

    // SITEMAP
    "sitemap" => "Sitemap:indexAction"
];

/* URLS IGNORADAS PELO LOADER/GETROUTE/REGISTRY */
$ignore = ["page"];

/*PATHS OPCIONAIS*/
$paths = ['fotos' => DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'foto'];
