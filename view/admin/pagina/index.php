<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Páginas</title>
    @(admin.layout.maincss)
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @(admin.layout.topo)
        @(admin.layout.menu-lateral)
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Páginas
                                <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/nova-pagina/"><i class="fa fa-plus"></i>Novo</a>
                            </h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Meu Site</li>
                                <li class="breadcrumb-item active"><a>Páginas</a></li>
                            </ol>
                        </div>
                    </div>
            </section>
            <section class="content" id="vm">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h5>
                                        <i class="fa fa-info-circle"></i>
                                        Cadastre páginas com conteúdos personalizados
                                    </h5>
                                    <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="">Título <i class="fa fa-sort" aria-hidden="true" style="cursor: pointer"></i></th>
                                                <th class="">Categoria</th>
                                                <th class="hidden-xs-down">Status</th>
                                                <th class="d-print-none text-right">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="post in posts" :class="'slide-editar-' + post.slide_id" :id="'slide-id-' + post.slide_id">
                                                <td class="">{{post.pagina_titulo}}</td>
                                                <td class="">{{post.categoria_pagina_nome}}</td>
                                                <td class="">
                                                    <a v-on:click="mudar_status(post)" style="cursor: pointer" data-id="Paginas:G" data-toggle="tooltip" :title="post.pagina_status_nome">
                                                        <span v-if="post.pagina_status == 1"><i class="fa fa-2x fa-toggle-on text-primary"></i></span>
                                                        <span v-else><i class="fa fa-toggle-off fa-2x text-primary"></i></span>
                                                    </a>
                                                </td>
                                                <td class="d-print-none text-right" width="140">
                                                    <a class="btn btn-sm text-white btn-primary waves-effect waves-light  menu-acces" title="editar" data-toggle="tooltip" data-id="PaginaAdmin:G" :href="'<?= Http::base() ?>/editar-pagina/id/' + post.pagina_id">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger menu-access" data-id="PaginaAdmin:G" data-toggle="tooltip" title="remover" v-on:click="remover(post)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
        @(admin.layout.footer)
        @(admin.layout.modal-remove)
        @(admin.layout.modal-status)


        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/pagina/index.js"></script>

    <script>
         $(".supermenu-home").addClass("menu-open");
        $(".menu-home").addClass("active");

        $(".menu-pagina-gerenciar").addClass("active");
    </script>
</body>

</html>