<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Características</title>
    @(admin.layout.maincss)
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="vm">
        @(admin.layout.topo)
        @(admin.layout.menu-lateral)
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Características
                                <?php if (Usuario::verifyPermission('imoveis', 'gerenciar')) : ?>
                                    <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/caracteristica/nova"><i class="fa fa-plus"></i>Novo</a>
                                <?php endif; ?>
                            </h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Imóveis</a></li>
                                <li class="breadcrumb-item active">Características</li>
                            </ol>
                        </div>
                    </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5>
                                        <i class="fa fa-info-circle"></i>
                                        Cadastre e gerencie as Características que seus imóveis irão possuir.
                                    </h5>
                                    <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Título</th>
                                                <th>Categoria</th>
                                                <th>Destaque</th>
                                                <?php if (Usuario::verifyPermission('imoveis', 'gerenciar') || Usuario::verifyPermission('imoveis', 'remover')) : ?>
                                                    <th class="d-print-none" width="100">Ações</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="c in caracteristicas">
                                                <td>{{c.caracteristica_nome}}</td>
                                                <td>{{ c.caracteristica_categoria_nome }}</td>
                                                <td>{{ c.caracteristica_diferencial == 1 ? "Sim" : "Não" }}</td>
                                                <?php if (Usuario::verifyPermission('imoveis', 'gerenciar') || Usuario::verifyPermission('imoveis', 'remover')) : ?>
                                                    <td class="d-print-none text-left" width="100">
                                                        <?php if (Usuario::verifyPermission('imoveis', 'gerenciar')) : ?>
                                                            <a class="btn btn-sm btn-primary waves-effect waves-light" data-toggle="tooltip" title="editar" :href="'<?= Http::base() ?>/caracteristica/editar/' + c.caracteristica_id">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if (Usuario::verifyPermission('imoveis', 'remover')) : ?>
                                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="remover" v-on:click="remover(c)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        <?php endif; ?>

                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div id="modalAdd" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="mySmallModalLabel">Adicionar caracteristica</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form action="<?= Http::base() ?>/caracteristica/gravar" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="caracteristica_id" id="caracteristica_id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="">Nome da caracteristica <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" required id="caracteristica_nome" name="caracteristica_nome">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @(admin.layout.footer)
        @(admin.layout.modal-remove)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/caracteristica/index.js"></script>
    <script>
        $(".supermenu-imoveis").addClass("menu-open");
        $(".menu-imoveis-caracteristicas").addClass("active");
    </script>
</body>

</html>