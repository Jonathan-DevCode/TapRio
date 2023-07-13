<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Ordene sua Home</title>
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
                            <h1>Ordene sua Home</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a >Gerenciar Conteudo</a></li>
                                <li class="breadcrumb-item"><a >Home</a></li>
                                <li class="breadcrumb-item active">Ordene sua Home</li>
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
                                <h5><i class="fa fa-info-circle"></i> Ordene as sessões da página inicial em sua imobiliária e deixe com a cara do seu negócio.</h5>
                                <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <td title="Arraste a sessão para ordenar" 
                                                data-toggle="tooltip"><small>
                                                <i  class="fa fa-info-circle"  style="font-size:15px!important;"></i></small>
                                                    Ordem </td>
                                                <th>Sessão</th>  
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="sessao in sessoes" :class="'sessao-editar-' + sessao.order_home_id" :id="'sessao-id-' + sessao.order_home_id">
                                                <td class="text-center" width="110" style="cursor: crosshair "><i class="fa fa-list pt-2"></i></td>
                                                <td width="100">{{ sessao.order_home_apelido }}</td>      
                                                <td width="80">
                                                    <a v-on:click="mudar_status(sessao)" style="cursor: pointer;" data-toggle="tooltip">
                                                        <span v-if="sessao.order_home_status == 1"><i class="fa fa-2x fa-toggle-on text-primary"></i></span>
                                                        <span v-else><i class="fa fa-toggle-off fa-2x text-primary"></i></span>
                                                    </a>
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
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/ordenarHome/index.js"></script>

    <script>
        $(".supermenu-home").addClass("menu-open");
        $(".menu-home").addClass("active");
        
        $(".menu-ordenar").addClass("active");
    </script>
</body>

</html>