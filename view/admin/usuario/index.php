<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Usuários</title>
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
                            <h1>Usuários
                                <?php if (Usuario::verifyPermission('usuarios', 'gerenciar')) : ?>
                                    <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/usuario/novo/"><i class="fa fa-plus"></i>Novo</a>
                                <?php endif; ?>
                            </h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Configurações</a></li>
                                <li class="breadcrumb-item active">Usuários</li>
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
                                        Cadastre e gerencie usuários que vão ter acesso ao <b>PAINEL ADMINISTRATIVO</b> de sua imobiliária.
                                    </h5>
                                    <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th class="hidden-xs-down">Email</th>
                                                <th class="hidden-xs-down">Nível de Acesso</th>
                                                <?php if (Usuario::verifyPermission('usuarios', 'gerenciar')) : ?>
                                                    <th class="hidden-xs-down">Status</th>
                                                <?php endif; ?>
                                                <?php if (Usuario::verifyPermission('usuarios', 'gerenciar') || Usuario::verifyPermission('usuarios', 'remover')) : ?>
                                                    <th class="d-print-none" width="100">Ações</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="usu in usuario">
                                                <td>{{usu.usuario_nome}}</td>
                                                <td class="hidden-xs-down">{{usu.usuario_email}}</td>
                                                <td class="hidden-xs-down">{{usu.level_nome}}</td>
                                                <?php if (Usuario::verifyPermission('usuarios', 'gerenciar')) : ?>
                                                    <td>

                                                        <a v-if="usu.usuario_id == <?= Session::node('uid') ?>" style="cursor: not-allowed" data-toggle="tooltip" :title="usu.status_nome">
                                                            <span><i class="fa fa-2x fa-toggle-on text-primary"></i></span>

                                                        </a>
                                                        <a v-else v-on:click="mudar_status(usu)" style="cursor: pointer" data-toggle="tooltip" :title="usu.status_nome">
                                                            <span v-if="usu.usuario_status == 1"><i class="fa fa-2x fa-toggle-on text-primary"></i></span>
                                                            <span v-else><i class="fa fa-toggle-off fa-2x"></i></span>
                                                        </a>
                                                    </td>
                                                <?php endif; ?>
                                                <?php if (Usuario::verifyPermission('usuarios', 'gerenciar') || Usuario::verifyPermission('usuarios', 'remover')) : ?>
                                                    <td class="d-print-none text-left" width="100">
                                                       
                                                        <?php if (Usuario::verifyPermission('usuarios', 'gerenciar')) : ?>
                                                            <a class="btn btn-sm btn-primary waves-effect waves-light" data-toggle="tooltip" title="editar" :href="'<?= Http::base() ?>/usuario/editar/id/'+usu.usuario_id + '/'">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if(Usuario::verifyIsAdmin()): ?>
                                                            <!-- <a class="btn btn-sm btn-outline-primary waves-effect waves-light" data-toggle="tooltip" title="Ver ações do usuário" :href="'<?= Http::base() ?>/usuario/log/id/'+usu.usuario_id + '/'">
                                                                <i class="fas fa-eye"></i>
                                                            </a> -->
                                                        <?php endif; ?>

                                                        <?php if (Usuario::verifyPermission('usuarios', 'remover')) : ?>
                                                            <button v-if="usu.usuario_id != <?= Session::node('uid') ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" title="remover" v-on:click="remover(usu)">
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
    <script src="${baseUri}/view/admin/usuario/index.js"></script>
    <script>
        $(".supermenu-usuarios").addClass("menu-open");
        $(".menu-usuarios").addClass("active");
    </script>
</body>

</html>