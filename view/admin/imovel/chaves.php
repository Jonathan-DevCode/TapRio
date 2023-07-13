<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Lista de chaves</title>
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
                            <h1>Lista de chaves</h1>

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
                                        Gerencie as chaves de sua imobiliária
                                    </h5>
                                    <table id="datatable" class="datatable display nowrap table table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="35">Chave</th>
                                                <th width="35">Imóvel</th>
                                                <th width="35">Endereço</th>
                                                <th width="35">Situação</th>
                                                <th width="35">Previsão de entrega</th>
                                                <th width="35">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="im in imoveis">
                                                <td>{{ im.imovel_chave_num }}</td>
                                                <td>{{im.imovel_ref}}</td>
                                                <td>
                                                <div class="col-12 col-sm-12">
                                                                <b>Endereço: </b> {{ im.imovel_rua ? im.imovel_rua : "Não informado" }} <span v-if="im.imovel_num">, {{ im.imovel_num }}</span>

                                                            </div>
                                                <div class="col-12 col-sm-12">
                                                                <b>Local: </b> {{ im.imovel_cidade ? im.imovel_cidade : 'Não informado' }} <span v-if="im.imovel_uf">- {{ im.imovel_uf }}</span> <span v-if="im.imovel_bairro">({{ im.imovel_bairro }})</span>
                                                            </div>
                                          
                                                
                                                <!-- <a target="_blank" :href="'${baseUri}/imovel-editar/id/' + im.imovel_id"><i class="fa fa-share"></i> {{ im.imovel_titulo }}</a></td> -->
                                                <td>
                                                    <span v-if="im.imovel_chave_status == 'imobiliaria'">Na imobiliária</span>
                                                    <span v-if="im.imovel_chave_status == 'emprestada'">Emprestada para: {{ im.imovel_chave_portador }}</span>
                                                </td>
                                                <td>
                                                    <span v-if="im.imovel_chave_status == 'emprestada'">
                                                        {{ im.imovel_chave_retorno_formated }}
                                                        
                                                        <span v-if="im.dias_para_devolucao >= 0">(em {{ im.dias_para_devolucao }} dia(s))</span>
                                                        <span v-if="im.dias_para_devolucao < 0">(atrasada em {{ im.dias_para_devolucao * -1 }} dia(s))</span>
                                                    </span>  
                                                    <span v-if="im.imovel_chave_status == 'imobiliaria'">Na imobiliária</span>
                                                </td>
                                                <td>
                                                    <a target="_blank" :href="'${baseUri}/imovel-editar/id/' + im.imovel_id" class="btn btn-primary">Ver Imóvel</a>
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
    <script src="${baseUri}/view/admin/imovel/chaves.js"></script>
    <script>
        $(".supermenu-imoveis").addClass("menu-open");
        $(".menu-imoveis-chaves").addClass("active");
    </script>
</body>

</html>