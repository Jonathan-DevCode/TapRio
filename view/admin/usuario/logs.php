<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Ações dos usuários</title>
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
                            <h1>Ações dos usuários</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Configurações</a></li>
                                <li class="breadcrumb-item"><a>Usuários</a></li>
                                <li class="breadcrumb-item active">Ações dos usuários</li>
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
                                        Visualize as ações dos corretores em sua plataforma
                                    </h5>
                                    <table id="" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Corretor</th>
                                                <th class="hidden-xs-down">Ação realizada</th>
                                                <th class="hidden-xs-down">Data</th>
                                                <th class="d-print-none" width="100">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="log in logs">
                                                <td>{{log.log_user_name}}</td>
                                                <td>{{log.log_msg}}</td>
                                                <td>{{log.log_created_formated}}</td>
                                                <td class="d-print-none text-left" style="min-width: 100px;" width="100">
                                                    <a class="btn btn-sm btn-primary waves-effect waves-light" data-toggle="tooltip" title="Ver ação" v-on:click="showDetail(log.log_id)">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="remover" v-on:click="remover(log)">
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
                </div>
                <div id="modal-log" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Detalhes das alterações</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12" v-if="log">
                                        <h4>Mudanças detectadas:</h4>
                                        <div class="row" v-if="log.diffs.length > 0" v-for="logg in log.diffs">
                                            <div class="col-12 col-sm-12">
                                                Alteração em: <b>{{ logg.field.replace("imovel_", "") }}</b>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                                De: {{ logg.old }}
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                                Para: {{ logg.new }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Fechar</button>
                                
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
    <script>
        $(".supermenu-log").addClass("menu-open");
        $(".menu-log").addClass("active");
        
    </script>
    <script src="${baseUri}/view/admin/usuario/logs.js"></script>
</body>

</html>