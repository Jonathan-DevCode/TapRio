<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Categorias das Páginas</title>
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
                            <h1>Categoria das Páginas
                                <a id="nova-categoria" class="btn btn-primary btn-sm ml-3"><i class="fa fa-plus"></i>Novo</a>
                            </h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Meu Site</a></li>
                                <li class="breadcrumb-item active">Categoria das Páginas</li>
                            </ol>
                        </div>
                    </div>
            </section>
            
            <section class="content" id="vm">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card pr-2">
                                <div class="card-body table-responsive">
                                    <h5>
                                        <i class="fa fa-info-circle"></i>
                                        Cadastre Categorias para suas páginas estarem bem categorizadas.
                                    </h5>
                                    <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <td title="Arraste o slide para ordenar" data-toggle="tooltip"><small>
                                                        <i class="fa fa-info-circle" style="font-size:15px!important;"></i></small>
                                                    Posição </td>
                                                <th>Nome <i class="fa fa-sort" aria-hidden="true" style="cursor: pointer"></i></th>
                                                <th>Visivel no topo</th>
                                                <th>Visivel no rodapé</th>
                                                <th class="d-print-none text-right">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="cat in categoria" :class="'categoria-editar-' + cat.categoria_pagina_id" :id="'categoria-id-' + cat.categoria_pagina_id">
                                                <td class="text-center" width="110" style="cursor: crosshair "><i class="fa fa-list pt-2"></i></td>
                                                <td class="pt-4">{{cat.categoria_pagina_nome}}</td>
                                                <td class="pt-4" v-if="cat.categoria_pagina_topo == 1">Sim</td>
                                                <td class="pt-4" v-else>Não</td>
                                                <td class="pt-4" v-if="cat.categoria_pagina_rodape == 1">Sim</td>
                                                <td class="pt-4" v-else>Não</td>
                                                <td class="d-print-none text-right pt-4" width="140">
                                                    <a class="btn btn-sm text-white btn-primary waves-effect waves-light  menu-acces" title="editar" data-toggle="tooltip" data-id="PaginaAdmin:G" v-on:click="editar(cat)">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger menu-access" data-id="categoria:G" data-toggle="tooltip" title="remover" v-on:click="remover(cat)">
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

        <div id="modal-categoria" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?= Http::base() ?>/PaginaAdmin/gravar_categoria/" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel"><span class="categoria-acao">Incluir</span> categoria</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="categoria_pagina_id" id="categoria_pagina_id">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="categoria_pagina_nome">Nome da categoria <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="categoria_pagina_nome" name="categoria_pagina_nome" maxlength="200" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="categoria_pagina_topo">Visível no topo ? <span class="text-danger">*</span></label>
                                        <select name="categoria_pagina_topo" id="categoria_pagina_topo" class="form-control" required>
                                            <option value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="categoria_pagina_rodape">Visível no rodapé ? <span class="text-danger">*</span></label>
                                        <select name="categoria_pagina_rodape" id="categoria_pagina_rodape" class="form-control" required>
                                            <option value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @(admin.layout.footer)
        @(admin.layout.modal-remove)
        @(admin.layout.modal-status)


        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/pagina/categoria.js"></script>

    <script>
        $(".supermenu-home").addClass("menu-open");
        $(".menu-home").addClass("active");

        $(".menu-pagina-categorias").addClass("active");
    </script>
</body>

</html>