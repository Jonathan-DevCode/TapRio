<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Lista de imóveis do site</title>
    @(admin.layout.maincss)

    <style>
        html,
        body {
            width: 100%;
            overflow-x: hidden;
        }

        .img-table {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .badge-imovel {
            padding: 5px 25px;
            background-color: #494E54;
            color: white;
            font-size: 14px;
            border-radius: 5px;
        }

        .badge-imovel.badge-success {
            background-color: green;
        }

        .badge-imovel.badge-error {
            background-color: red;
        }
    </style>
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
                            <h1>Lista de imóveis anunciados por clientes</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Imóveis</a></li>
                                <li class="breadcrumb-item active">Lista de imóveis anunciados por clientes</li>
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
                                        Gerencie seus imóveis que os clientes cadastraram em seu site
                                    </h5>
                                    <table id="datatable" class="datatable display nowrap table table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="35">Dados do imóvel</th>
                                                <th width="35">Informações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="im in imoveis" v-if="foto_imovel_padrao">
                                                <td>
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 mb-2">
                                                            <span class="badge-imovel" v-if="im.imovel_site_type == 'administracao'">Administração</span>
                                                            <span class="badge-imovel" v-else>Venda ou alugue</span>

                                                            <span class="badge-imovel">{{ im.imovel_tipo_negociacao_label }}</span>
                                                            <span class="badge-imovel" v-if="im.categoria_imovel_nome">{{ im.categoria_imovel_nome }}</span>
                                                            <span class="badge-imovel" v-if="im.modelo_imovel_nome">{{ im.modelo_imovel_nome }}</span>
                                                        </div>

                                                        <div class="col-12 col-sm-12">
                                                            <h4 v-if="im.imovel_tipo_negociacao == 'venda'"><b>{{ formatMoney(im.imovel_valor_venda) }}<small>/venda</small> </b></h4>
                                                            <h4 v-if="im.imovel_tipo_negociacao == 'aluguel'"><b>{{ formatMoney(im.imovel_valor_locacao) }}<small>/mês</small> </b></h4>
                                                            <h4 v-if="im.imovel_tipo_negociacao == 'venda_aluguel'"><b>{{ formatMoney(im.imovel_valor_venda) }}<small>/venda</small> </b> | <b>{{ formatMoney(im.imovel_valor_locacao) }}<small>/mês</small> </b></h4>
                                                        </div>

                                                        <div class="col-12 col-sm-12">
                                                            <b>Local: </b> {{ im.imovel_cidade ? im.imovel_cidade : 'Não informado' }} <span v-if="im.imovel_uf">- {{ im.imovel_uf }}</span> <span v-if="im.imovel_bairro">({{ im.imovel_bairro }})</span>
                                                        </div>
                                                        <div class="col-12 col-sm-12">
                                                            <b>Endereço: </b> {{ im.imovel_rua ? im.imovel_rua : "Não informado" }} <span v-if="im.imovel_num">, {{ im.imovel_num }}</span>

                                                        </div>

                                                        <div class="col-12 col-sm-12 mb-4 mt-4 d-flex justify-content-between">
                                                            <a class="btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="tooltip" title="Ver" target="_blank" :href="'<?= Http::base() ?>/imovel-site-editar/id/' + im.imovel_id">
                                                                <i class="fas fa-eye"></i> Ver mais informações
                                                            </a>
                                                            <button class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="remover" v-on:click="remover(im)">
                                                                <i class="fas fa-trash"></i> Remover Imóvel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12">
                                                            <b>Proprietário: </b>
                                                            {{ im.imovel_proprietario_nome ? im.imovel_proprietario_nome : "Não informado" }}
                                                            <span v-if="im.imovel_proprietario_telefone"> | {{ im.imovel_proprietario_telefone }}</span>
                                                            <span v-if="im.imovel_proprietario_email"> | {{ im.imovel_proprietario_email }}</span>
                                                        </div>

                                                        <div class="col-12 col-sm-12">
                                                            <b>Cadastro: </b> {{ im.imovel_created }} &nbsp; <b>Atualização: </b> {{ im.imovel_updated }}
                                                        </div>
                                                        <div class="col-12 col-sm-12">
                                                            <b>Quartos: </b> {{ im.imovel_quartos }} &nbsp;
                                                            <b>Banheiros: </b> {{ im.imovel_banheiros }} &nbsp;
                                                            <b>Suítes: </b> {{ im.imovel_suites }} &nbsp;
                                                            <b>Vagas: </b> {{ im.imovel_vagas }} &nbsp;
                                                        </div>
                                                        <div class="col-12 col-sm-12">
                                                            <b>Área Útil: </b> {{ im.imovel_area_util }} &nbsp;
                                                            <b>Área Total: </b> {{ im.imovel_area_total }} &nbsp;
                                                            <b>Área Construída: </b> {{ im.imovel_area_construida }} &nbsp;
                                                            <b>Ano de construção: </b> {{ im.imovel_ano_construcao }} &nbsp;
                                                        </div>
                                                    </div>
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

        <div id="modal-salva" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="mySmallModalLabel">Salvar imóvel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            Tem certeza de que deseja salvar esse imóvel?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                        <button v-on:click="salvaImovel()" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Salvar</button>
                    </div>
                </div>
            </div>
        </div>

        @(admin.layout.footer)
        @(admin.layout.modal-remove)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/imovel/anuncios.js"></script>
    <script>
        $(".supermenu-imoveis").addClass("menu-open");
        $(".menu-imoveis-site").addClass("active");
    </script>
</body>

</html>