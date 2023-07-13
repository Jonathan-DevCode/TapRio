<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Bairros</title>
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
                            <h1>Bairros
                                <?php if (Usuario::verifyPermission('localidades', 'gerenciar')) : ?>
                                    <a class="btn btn-primary btn-sm ml-3" v-on:click="show_novo()"><i class="fa fa-plus"></i>Novo</a>
                                <?php endif; ?>
                            </h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Localidades</a></li>
                                <li class="breadcrumb-item active">Bairros</li>
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
                                        Cadastre e gerencie os bairros dos quais você possui imóvel disponível no sistema.
                                    </h5>
                                    <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Bairro</th>
                                                <th>Cidade</th>
                                                <th class="hidden-xs-down">UF</th>
                                                <th class="hidden-xs-down">Imóveis</th>
                                                <?php if (Usuario::verifyPermission('localidades', 'gerenciar') || Usuario::verifyPermission('localidades', 'remover')) : ?>
                                                    <th class="d-print-none" width="100">Ações</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="b in bairros">
                                                <td>{{b.bairro_titulo}}</td>
                                                <td>{{b.cidade_titulo}}</td>
                                                <td class="hidden-xs-down">{{b.uf_sigla}}</td>
                                                <td class="hidden-xs-down">{{b.qtd_imoveis}}</td>
                                                <?php if (Usuario::verifyPermission('localidades', 'gerenciar') || Usuario::verifyPermission('localidades', 'remover')) : ?>
                                                    <td class="d-print-none text-left" width="100">
                                                        <?php if (Usuario::verifyPermission('localidades', 'gerenciar')) : ?>
                                                            <a class="btn btn-sm btn-primary waves-effect waves-light" data-toggle="tooltip" title="editar" v-on:click="show_edit(b)">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if (Usuario::verifyPermission('localidades', 'remover')) : ?>
                                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="remover" v-on:click="remover(b)">
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
                        <h4 class="modal-title" id="mySmallModalLabel">Adicionar Bairro</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form action="<?= Http::base() ?>/local/adicionar_bairro" method="post">
                        <input type="hidden" name="bairro_id" id="bairro_id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="">Cidade</label>
                                    <select name="bairro_cidade" id="bairro_cidade" required class="form-control">
                                        <option value="0">Selecione uma Cidade</option>
                                        <option v-if="cidades != null" v-for="c in cidades" :value="c.cidade_id">{{c.cidade_titulo}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <label for="">Nome do Bairro <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" required id="bairro_titulo" name="bairro_titulo">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Atualizar</button>
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
    <script src="${baseUri}/view/admin/local/bairros.js"></script>
    <script>
        $(".supermenu-localidade").addClass("menu-open");
        $(".menu-bairros").addClass("active");
    </script>
</body>

</html>