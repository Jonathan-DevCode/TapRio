<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Parceiros</title>
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
                            <h1>Seus Parceiros
                                <?php if (Usuario::verifyPermission('parceiros', 'gerenciar')) : ?>
                                    <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/parceiros-novo/"><i class="fa fa-plus"></i>Novo</a>
                                <?php endif; ?>
                            </h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar Conteudo</a></li>
                                <li class="breadcrumb-item"><a>Home</a></li>
                                <li class="breadcrumb-item active">Seus Parceiros</li>
                            </ol>
                        </div>
                    </div>
            </section>
            <section class="content" id="vm">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5>
                                        <i class="fa fa-info-circle"></i>
                                        Cadastre Parceiros de sua imobiliária caso queira que os mesmos fiquem a mostra em sua página inicial
                                    </h5>
                                    <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <?php if (Usuario::verifyPermission('parceiros', 'gerenciar')) : ?>
                                                    <td title="Arraste o slide para ordenar" data-toggle="tooltip">
                                                    <?php endif; ?>
                                                    <small>
                                                        <i class="fa fa-info-circle" style="font-size:15px!important;"></i>
                                                    </small> Posição
                                                    </td>
                                                    <th class="" width="50">Foto</th>
                                                    <th class="">Nome <i class="fa fa-sort" aria-hidden="true" style="cursor: pointer"></i></th>
                                                    <?php if (Usuario::verifyPermission('parceiros', 'gerenciar')) : ?>
                                                        <th class="hidden-xs-down">Status</th>
                                                    <?php endif; ?>
                                                    <?php if (Usuario::verifyPermission('parceiros', 'gerenciar') || Usuario::verifyPermission('parceiros', 'remover')) : ?>
                                                        <th class="d-print-none text-right">Ações</th>
                                                    <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="post in parceiros" :id="'parceiro-id-' + post.parceiro_id" :class="'parceiro-editar-' + post.parceiro_id" :id="'parceiro-id-' + post.parceiro_id">
                                                <?php if (Usuario::verifyPermission('parceiros', 'gerenciar')) : ?>
                                                    <td class="text-center" width="110" style="cursor: crosshair "><i class="fa fa-list pt-2"></i></td>
                                                <?php endif; ?>
                                                <td><img :src="'${baseUri}/media/parceria/' + post.parceiro_logo" :alt="post.parceiro_nome" width="100" height="50"></td>
                                                <td class="">{{post.parceiro_nome}}</td>

                                                <?php if (Usuario::verifyPermission('parceiros', 'gerenciar')) : ?>
                                                    <td width="50" class="text-center">
                                                        <a v-on:click="mudar_status(post)" style="cursor: pointer" data-toggle="tooltip" :title="post.parceiro_status_nome">
                                                            <span v-if="post.parceiro_status == 1"><i class="fa fa-2x fa-toggle-on text-primary"></i></span>
                                                            <span v-else><i class="fa fa-toggle-off fa-2x text-primary"></i></span>
                                                        </a>
                                                    </td>
                                                <?php endif; ?>
                                                <?php if (Usuario::verifyPermission('parceiros', 'gerenciar') || Usuario::verifyPermission('parceiros', 'remover')) : ?>
                                                    <td class="d-print-none text-right" width="140">
                                                        <?php if (Usuario::verifyPermission('parceiros', 'gerenciar')) : ?>
                                                            <a class="btn btn-sm text-white btn-primary waves-effect waves-light  menu-acces" title="editar" data-toggle="tooltip" :href="'<?= Http::base() ?>/parceiros-editar/id/' + post.parceiro_id">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (Usuario::verifyPermission('parceiros', 'remover')) : ?>
                                                            <button class="btn btn-sm btn-danger menu-access" data-toggle="tooltip" title="remover" v-on:click="remover(post)">
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
        @(admin.layout.modal-status)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/parceiro/index.js"></script>

    <script>
        $(".supermenu-home").addClass("menu-open");
        $(".menu-home").addClass("active");

        $(".menu-parceiros").addClass("active");
    </script>
</body>

</html>