<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Newsletter</title>
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
                            <h1>Newsletter</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a >Gerenciar sua Imobiliária</a></li>
                                <li class="breadcrumb-item active">Newsletter</li>
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
                                        Os clientes/visitantes de sua Imobiliária que optaram por receber ofertas e novidades cadastrando seu e-mail estarão aqui. Use essas informações para <b>E-mail Marketing</b> e recursos neste sentido.
                                    </h5>
                                    <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="">E-mail <i class="fa fa-sort" aria-hidden="true" style="cursor: pointer"></i></th>
                                                <th class="">Status <i class="fa fa-sort" aria-hidden="true" style="cursor: pointer"></i></th>
                                                <th class="d-print-none text-right">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="emails != null" v-for="post in emails" :class="'newsletter-editar-' + post.newsletter_id" :id="'newsletter-id-' + post.newsletter_id">
                                                <td class="">{{post.newsletter_email}}</td>
                                                <td>
                                                    <a v-on:click="mudar_status(post.newsletter_id, post.newsletter_status)" style="cursor: pointer" data-toggle="tooltip" :title="post.newsletter_status_nome">
                                                        <span v-if="post.newsletter_status == 1"><i class="fa fa-2x fa-toggle-on text-primary"></i></span>
                                                        <span v-else><i class="fa fa-toggle-off fa-2x "></i></span>
                                                    </a>
                                                </td>
                                                <td class="d-print-none text-right">
                                                    <button class="btn btn-sm btn-danger menu-access" data-id="ProdutosAdmin:G" data-toggle="tooltip" title="remover" v-on:click="remover(post)">
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
            </section>
        </div>
        @(admin.layout.footer)
        @(admin.layout.modal-remove)
        @(admin.layout.modal-status)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/newsletter/index.js"></script>
    <script>
        $(".supermenu-newsletter").addClass("menu-open");
        $(".menu-newsletter").addClass("active");
    </script>
</body>

</html>