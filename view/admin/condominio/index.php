<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Condomínios</title>
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
                            <h1>Condomínios
                                <?php if (Usuario::verifyPermission('imoveis', 'gerenciar')) : ?>
                                    <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/condominio/nova"><i class="fa fa-plus"></i>Novo</a>
                                <?php endif; ?>
                            </h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Imóveis</a></li>
                                <li class="breadcrumb-item active">Condomínios</li>
                            </ol>
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
                                        Cadastre e gerencie seus Condomínios.
                                    </h5>
                                    <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Título</th>
                                                <th>Andares</th>
                                                <th>Unidades p/ andar</th>
                                                <th>Torres</th>
                                                <th>Construido em</th>
                                                <?php if (Usuario::verifyPermission('imoveis', 'gerenciar') || Usuario::verifyPermission('imoveis', 'remover')) : ?>
                                                    <th class="d-print-none" width="100">Ações</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="c in condominios">
                                                <td>{{c.condominio_nome}}</td>
                                                <td>{{c.condominio_qtd_andar}}</td>
                                                <td>{{c.condominio_qtd_unidades_por_andar}}</td>
                                                <td>{{c.condominio_qtd_torres}}</td>
                                                <td>{{c.condominio_ano_construcao}}</td>
                                                <?php if (Usuario::verifyPermission('imoveis', 'gerenciar') || Usuario::verifyPermission('imoveis', 'remover')) : ?>
                                                    <td class="d-print-none text-left" width="100">
                                                        <?php if (Usuario::verifyPermission('imoveis', 'gerenciar')) : ?>
                                                            <a class="btn btn-sm btn-primary waves-effect waves-light" data-toggle="tooltip" title="editar" :href="'<?= Http::base() ?>/condominio/editar/' + c.condominio_id">
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

        @(admin.layout.footer)
        @(admin.layout.modal-remove)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/condominio/index.js"></script>
    <script>
        $(".supermenu-imoveis").addClass("menu-open");
        $(".menu-imoveis-condominios").addClass("active");
    </script>
</body>

</html>