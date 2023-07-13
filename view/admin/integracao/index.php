<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Integrações</title>
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
                            <h1>Integrações
                                <?php if (Usuario::verifyPermission('imoveis', 'gerenciar')) : ?>
                                    <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/integracoes/nova"><i class="fa fa-plus"></i> Nova integração</a>
                                <?php endif; ?>
                            </h1>

                        </div>
                    </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card pr-2">
                                <div class="card-body table-responsive">
                                    <h5>
                                        <i class="fa fa-info-circle"></i>
                                        Cadastre e gerencie as Integrações em portais externos.
                                    </h5>
                                    <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Título</th>
                                                <?php if (Usuario::verifyPermission('integracoes', 'gerenciar')): ?>
                                                    <th>Situação</th>
                                                <?php endif; ?>
                                                <th>Imóveis</th>
                                                <th>Última atualização</th>
                                                <?php if (Usuario::verifyPermission('integracoes', 'gerenciar') || Usuario::verifyPermission('integracoes', 'remover')) : ?>
                                                    <th class="d-print-none" width="100">Ações</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="c in integracoes">
                                                <td>{{c.integracao_nome}}</td>
                                                <?php if (Usuario::verifyPermission('integracoes', 'gerenciar')): ?>
                                                    <td>
                                                        <a v-on:click="mudar_status(c)" style="cursor: pointer;" data-toggle="tooltip">
                                                            <span v-if="c.integracao_status == 1"><i class="fa fa-2x fa-toggle-on text-primary"></i></span>
                                                            <span v-else><i class="fa fa-toggle-off fa-2x text-primary"></i></span>
                                                        </a>
                                                    </td>
                                                <?php endif; ?>
                                                <td>{{c.qtd_imoveis}}</td>
                                                <td>{{c.integracao_updated_format}}</td>
                                                <td class="d-print-none text-left" width="100">
                                                    <a class="btn btn-sm btn-info waves-effect waves-light" target="_blank" data-toggle="tooltip" :href="'<?= Http::base() ?>/IntegracaoExterna/getXml/' + c.integracao_public_link">
                                                        <i class="fas fa-share-alt"></i> Acessar XML
                                                    </a>
                                                    <?php if (Usuario::verifyPermission('integracoes', 'gerenciar')) : ?>
                                                        <a class="btn btn-sm btn-primary waves-effect waves-light" data-toggle="tooltip" title="editar" :href="'<?= Http::base() ?>/integracoes/editar/' + c.integracao_id">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if (Usuario::verifyPermission('integracoes', 'remover')) : ?>
                                                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="remover" v-on:click="remover(c)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>

                                                </td>
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

        @(admin.layout.footer)
        @(admin.layout.modal-remove)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/integracao/index.js"></script>
    <script>
        $(".supermenu-integracoes").addClass("menu-open");
        $(".menu-integracoes").addClass("active");
    </script>
</body>

</html>