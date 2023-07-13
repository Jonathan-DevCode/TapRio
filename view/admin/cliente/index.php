<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Clientes</title>
    @(admin.layout.maincss)
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @(admin.layout.topo)
        @(admin.layout.menu-lateral)
        <div class="content-wrapper" id="APP" data-url="cliente">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Clientes
                                <?php if (Usuario::verifyPermission('clientes', 'gerenciar')) : ?>
                                    <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/cliente/novo/"><i class="fa fa-plus"></i>Novo</a>
                                <?php endif; ?>
                            </h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar sua Imobiliária</a></li>
                                <li class="breadcrumb-item active">Clientes</li>
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
                                        Cadastre e/ou gerencie seus clientes!
                                    </h5>
                                        <table class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <?php if ($data['config']->isMobile) : ?>
                                                <div class="card" v-for="dt in dados">
                                                    <div class="card-body">
                                                        <h3 class="card-text text-primary">{{dt.cliente_nome}}</h3>
                                                        <p class="card-text">Imóvel: {{dt.cliente_tipo_imovel}}, No bairro: {{dt.cliente_bairro}}, na Faixa de {{formatMoney(dt.cliente_busca_preco_de)}} até {{formatMoney(dt.cliente_busca_preco_ate)}}</p>
                                                        <span class="badge badge-primary">{{dt.cliente_numero_quartos}} quartos</span>
                                                        <span class="badge badge-primary">{{dt.cliente_numero_vagas}} vagas</span>
                                                        <br><br>
                                                        <p class="card-text">{{dt.cliente_interesse}}</p>
                                                        <?php if (Usuario::verifyPermission('clientes', 'gerenciar')) : ?>
                                                            <div class="d-flex">
                                                                <p class="mr-2"> Status do cliente: </p>
                                                                <a v-on:click="prepare_muda_status(dt)" style="cursor: pointer" data-toggle="tooltip" :title="dt.status_nome">
                                                                    <span v-if="dt.status == 1"><i class="fa fa-2x fa-toggle-on text-primary"></i></span>
                                                                    <span v-else><i class="fa fa-toggle-off fa-2x "></i></span>
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if (Usuario::verifyPermission('clientes', 'gerenciar') || Usuario::verifyPermission('clientes', 'remover')) : ?>
                                                            <div class="d-print-none text-right" width="120">
                                                                <?php if (Usuario::verifyPermission('clientes', 'gerenciar')) : ?>
                                                                    <a class="btn btn-sm 
                                                                    btn-primary waves-effect waves-light" data-toggle="tooltip" title="editar" :href="'<?= Http::base() ?>/cliente/editar/id/'+dt.id + '/'">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (Usuario::verifyPermission('clientes', 'remover')) : ?>
                                                                    <button class="btn btn-sm btn-danger menu-access" data-toggle="tooltip" title="remover" v-on:click="remover(dt)">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="card-footer text-center bg-primary">
                                                        <h5> {{dt.corretor}} </h5>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <thead>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th class="d-none d-xl-table-cell">Interesse</th>
                                                        <th class="d-none d-xl-table-cell">Tipo Imovel</th>
                                                       
                                                        <!-- <th class="d-none d-xl-table-cell">Interesse</th> -->
                                                        
                                                        <th class="d-none d-xl-table-cell">Quartos</th>
                                                        <th class="d-none d-xl-table-cell">Vagas</th>
                                                        <th class="d-none d-xl-table-cell">Bairro</th>
                                                        <th class="d-none d-xl-table-cell">Corretor</th>
                                                      
                                                        <?php if (Usuario::verifyPermission('clientes', 'gerenciar')) : ?>
                                                            <th>Status</th>
                                                        <?php endif; ?>
                                                        <?php if (Usuario::verifyPermission('clientes', 'gerenciar') || Usuario::verifyPermission('clientes', 'remover')) : ?>
                                                            <th class="d-print-none text-right">Ações</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
        
                                                <tbody>
                                                    <tr v-for="dt in dados">
                                                        <td>{{dt.cliente_nome}}</td>
                                                        <td class="d-none d-xl-table-cell">{{dt.cliente_busca_negociacao}}: {{ formatMoney(dt.cliente_busca_preco_de)}} até {{ formatMoney(dt.cliente_busca_preco_ate)}}</td>
                                                        <td class="d-none d-xl-table-cell">{{dt.cliente_tipo_imovel}}</td>
                                                        
                                                        <!-- <td class="d-none d-xl-table-cell">{{dt.cliente_interesse}}</td> -->
                                                        
                                                        <td class="d-none d-xl-table-cell">{{dt.cliente_numero_quartos}}</td>
                                                        <td class="d-none d-xl-table-cell">{{dt.cliente_numero_vagas}}</td>
                                                        <td class="d-none d-xl-table-cell">{{dt.cliente_bairro}}</td>
                                                        <td class="d-none d-xl-table-cell">{{dt.corretor}}</td>
                                                        
                                                        <?php if (Usuario::verifyPermission('clientes', 'gerenciar')) : ?>
                                                            <td>
                                                                <a v-on:click="prepare_muda_status(dt)" style="cursor: pointer" data-toggle="tooltip" :title="dt.status_nome">
                                                                    <span v-if="dt.status == 1"><i class="fa fa-2x fa-toggle-on text-primary"></i></span>
                                                                    <span v-else><i class="fa fa-toggle-off fa-2x "></i></span>
                                                                </a>
                                                            </td>
                                                        <?php endif; ?>
                                                        <?php if (Usuario::verifyPermission('clientes', 'gerenciar') || Usuario::verifyPermission('clientes', 'remover')) : ?>
                                                            <td class="d-print-none text-right" width="120">
                                                                <?php if (Usuario::verifyPermission('clientes', 'gerenciar')) : ?>
                                                                    <a class="btn btn-sm 
                                                                    btn-primary waves-effect waves-light" data-toggle="tooltip" title="editar" :href="'<?= Http::base() ?>/cliente/editar/id/'+dt.id + '/'">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (Usuario::verifyPermission('clientes', 'remover')) : ?>
                                                                    <button class="btn btn-sm btn-danger menu-access" data-toggle="tooltip" title="remover" v-on:click="remover(dt)">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                </tbody>
                                            <?php endif; ?>
                                        </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalMudaStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Alterar status do cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Tem certeza de que deseja alterar o status do cliente <span style="color: black;">{{ postMudaStatusNome }}<span>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" v-on:click="mudar_status()">Alterar</button>
                            </div>
                        </div>
                    </div>
                </div>

                @(admin.layout.modal-remove)
            </section>
        </div>
        @(admin.layout.footer)

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/app-js/table-actions.js"></script>

    <script>
        $(".supermenu-clientes").addClass("menu-open");
        $(".menu-clientes").addClass("active");
    </script>
</body>

</html>