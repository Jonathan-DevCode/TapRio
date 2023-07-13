<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Lista completa de Imóveis</title>
    @(admin.layout.maincss)

    <style>
        html,
        body {
            width: 100%;
            overflow-x: hidden;
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

        @media screen and (max-width: 899px) {
            .btn-group {
                width: 100%;
                margin-bottom: 10px;
            }

            .flex-buttons-search {
                width: 100%;
                justify-content: space-between;
            }

            .flex-buttons-search button {
                width: 20%;
            }
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
                            <h1>Lista completa de Imóveis
                                <?php if (Usuario::verifyPermission('imoveis', 'gerenciar')) : ?>
                                    <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/imovel-novo"><i class="fa fa-plus"></i>Novo</a>
                                <?php endif; ?>
                            </h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Imóveis</a></li>
                                <li class="breadcrumb-item active">Lista completa de Imóveis</li>
                            </ol>
                        </div>
                    </div>
            </section>
            <?php if ($data['config']->isMobile) : ?>

                <div class="container">
                    <div class="row">
                        <div class="col-12 my-3">
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                                Filtros ({{countFilter}})
                            </button>
                        </div>


                        <div class="col-12" v-for="im in imoveisFiltrados">
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-12 m-2">

                                        <span style="font-size: 12px;" class="badge-imovel">{{ im.imovel_tipo_negociacao_label }}</span>
                                        <span style="font-size: 12px;" class="badge-imovel" v-if="im.categoria_imovel_nome">{{ im.categoria_imovel_nome }}</span>
                                        <span style="font-size: 12px;" class="badge-imovel" v-if="im.modelo_imovel_nome">{{ im.modelo_imovel_nome }}</span>

                                    </div>
                                    <div class="col-12">
                                        <img style="width:100%;height:200px;object-fit:cover" class="img-fluid rounded-start" alt="..." :src="(im.imovel_foto ? '${baseUri}/media/imovel/thumb_' + im.imovel_foto : foto_imovel_padrao)" alt="">

                                    </div>
                                    <div class="col-12">
                                        <div class="card-body">
                                            <div class="row">


                                                <div class="col-12 col-sm-12">
                                                    <h4 v-if="im.imovel_tipo_negociacao == 'venda'"><b>{{ formatMoney(im.imovel_valor_venda) }}<small>/venda</small> <span style="font-size: 12px;" class="badge-imovel badge-success" v-if="im.imovel_status == 1">Ativo</span>
                                                            <span class="badge-imovel badge-error" style="font-size: 12px;" v-if="im.imovel_status == 2">Inativo</span></b></h4>
                                                    <h4 v-if="im.imovel_tipo_negociacao == 'aluguel'"><b>{{ formatMoney(im.imovel_valor_locacao) }}<small>/mês</small> <span style="font-size: 12px;" class="badge-imovel badge-success" v-if="im.imovel_status == 1">Ativo</span>
                                                            <span class="badge-imovel badge-error" style="font-size: 12px;" v-if="im.imovel_status == 2">Inativo</span></b></h4>
                                                    <h4 v-if="im.imovel_tipo_negociacao == 'venda_aluguel'"><b>{{ formatMoney(im.imovel_valor_venda) }}<small>/venda</small> <span style="font-size: 12px;" class="badge-imovel badge-success" v-if="im.imovel_status == 1">Ativo</span>
                                                            <span class="badge-imovel badge-error" style="font-size: 12px;" v-if="im.imovel_status == 2">Inativo</span></b> | <b>{{ formatMoney(im.imovel_valor_locacao) }}<small>/mês</small> </b></h4>


                                                </div>

                                                <div class="col-12 col-sm-12">
                                                    <b>Referência: </b> {{ im.imovel_ref ? im.imovel_ref : "Não informado" }}
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <b>Local: </b> {{ im.imovel_cidade ? im.imovel_cidade : 'Não informado' }} <span v-if="im.imovel_uf">- {{ im.imovel_uf }}</span> <span v-if="im.imovel_bairro">({{ im.imovel_bairro }})</span>
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <b>Endereço: </b> {{ im.imovel_rua ? im.imovel_rua : "Não informado" }} <span v-if="im.imovel_num">, {{ im.imovel_num }}</span>

                                                </div>

                                            </div>
                                            <div class="row">

                                                <div class="col-12 col-sm-12">
                                                    <b>Captador: </b> {{ im.usuario_nome ? im.usuario_nome : "Não informado" }}
                                                </div>
                                                <?php if (Usuario::verifyIsAdmin() || Usuario::verifyPermissaoAcesso("imoveis", "all")) : ?>
                                                    <div class="col-12 col-sm-12">
                                                        <b>Proprietário: </b>
                                                        {{ im.imovel_proprietario_nome ? im.imovel_proprietario_nome : "Não informado" }}
                                                        <span v-if="im.imovel_proprietario_telefone"> | {{ im.imovel_proprietario_telefone }}</span>
                                                        <span v-if="im.imovel_proprietario_email"> | {{ im.imovel_proprietario_email }}</span>
                                                    </div>
                                                <?php elseif(Usuario::verifyPermissaoAcesso("imoveis", "all_permission")): ?>
                                                    <div class="col-12 col-sm-12" v-if="im.imovel_user_id == <?= Session::node('uid') ?>">
                                                        <b>Proprietário: </b>
                                                        {{ im.imovel_proprietario_nome ? im.imovel_proprietario_nome : "Não informado" }}
                                                        <span v-if="im.imovel_proprietario_telefone"> | {{ im.imovel_proprietario_telefone }}</span>
                                                        <span v-if="im.imovel_proprietario_email"> | {{ im.imovel_proprietario_email }}</span>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="col-12 col-sm-12">
                                                    <b>Cadastro: </b> {{ im.imovel_created }} &nbsp; <br><b>Atualização: </b> {{ im.imovel_updated }}
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <b>Quartos: </b> {{ im.imovel_quartos }} &nbsp;
                                                    <b>Banheiros: </b> {{ im.imovel_banheiros }} &nbsp;
                                                    <b>Suítes: </b> {{ im.imovel_suites }} &nbsp;
                                                    <b>Vagas: </b> {{ im.imovel_vagas }} &nbsp;
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <hr>
                                                    <b>Área Útil: </b> {{ im.imovel_area_util }} &nbsp;
                                                    <b>Área Total: </b> {{ im.imovel_area_total }} &nbsp;
                                                    <b>Área Construída: </b> {{ im.imovel_area_construida }} &nbsp;
                                                    <b>Ano de construção: </b> {{ im.imovel_ano_construcao }} &nbsp;
                                                    <hr>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4 gap-3 text-center px-2">
                                        <a class="btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="tooltip" title="Ver" target="_blank" :href="'<?= Http::base() ?>/imovel/ver/' + im.imovel_id">
                                            <i class="fas fa-eye"></i> Visualizar
                                        </a>
                                        <?php if (Usuario::verifyPermission('imoveis', 'gerenciar')) : ?>
                                            <a class="btn btn-sm btn-outline-primary waves-effect waves-light" data-toggle="tooltip" title="editar" :href="'<?= Http::base() ?>/imovel-editar/id/' + im.imovel_id">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        <?php endif; ?>
                                        <?php if (Usuario::verifyPermission('imoveis', 'remover')) : ?>
                                            <button class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="remover" v-on:click="remover(im)">
                                                <i class="fas fa-trash"></i> Remover permanentemente
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <?php else : ?>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5>
                                                    <i class="fa fa-info-circle"></i>
                                                    Gerencie seus imóveis em seu site
                                                </h5>
                                            </div>
                                            <div>

                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                    Filtros ({{countFilter}})
                                                </button>
                                            </div>
                                        </div>

                                        <!-- <button class="btn btn-outline-primary h-auto " data-bs-toggle="modal" data-bs-target="#exampleModal">Filtros</button> -->
                                        <table id="datatable" class="datatable display nowrap table table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="35">Foto</th>
                                                    <th width="35">Dados do imóvel</th>
                                                    <th width="35">Informações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="im in imoveisFiltrados" v-if="foto_imovel_padrao">
                                                    <td >
                                                        <img style="width:150px;" class="img-table" :src="(im.imovel_foto ? '${baseUri}/media/imovel/thumb_' + im.imovel_foto : foto_imovel_padrao)" alt="">
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 mb-2">
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
                                                                <b>Referência: </b> {{ im.imovel_ref ? im.imovel_ref : "Não informado" }}
                                                            </div>
                                                            <div class="col-12 col-sm-12">
                                                                <b>Local: </b> {{ im.imovel_cidade ? im.imovel_cidade : 'Não informado' }} <span v-if="im.imovel_uf">- {{ im.imovel_uf }}</span> <span v-if="im.imovel_bairro">({{ im.imovel_bairro }})</span>
                                                            </div>
                                                            <div class="col-12 col-sm-12">
                                                                <b>Endereço: </b> {{ im.imovel_rua ? im.imovel_rua : "Não informado" }} <span v-if="im.imovel_num">, {{ im.imovel_num }}</span>

                                                            </div>

                                                            <div class="col-12 col-sm-12 mb-4 mt-4 d-flex justify-content-between">
                                                                <a class="btn btn-sm btn-outline-info waves-effect waves-light" data-toggle="tooltip" title="Ver" target="_blank" :href="'<?= Http::base() ?>/imovel/ver/' + im.imovel_id">
                                                                    <i class="fas fa-eye"></i> Visualizar
                                                                </a>
                                                                <?php if (Usuario::verifyPermission('imoveis', 'gerenciar')) : ?>
                                                                    <a class="btn btn-sm btn-outline-primary waves-effect waves-light" data-toggle="tooltip" title="editar" :href="'<?= Http::base() ?>/imovel-editar/id/' + im.imovel_id">
                                                                        <i class="fas fa-edit"></i> Editar
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (Usuario::verifyPermission('imoveis', 'remover')) : ?>
                                                                    <button class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="remover" v-on:click="remover(im)">
                                                                        <i class="fas fa-trash"></i> Remover permanentemente
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 mb-2">
                                                                <span class="badge-imovel badge-success" v-if="im.imovel_status == 1">Status: Ativo</span>
                                                                <span class="badge-imovel badge-error" v-if="im.imovel_status == 2">Status: Inativo</span>
                                                            </div>

                                                            <div class="col-12 col-sm-12">
                                                                <b>Captador: </b> {{ im.usuario_nome ? im.usuario_nome : "Não informado" }}
                                                            </div>
                                                            <?php if (Usuario::verifyIsAdmin() || Usuario::verifyPermissaoAcesso("imoveis", "all")) : ?>
                                                                <div class="col-12 col-sm-12">
                                                                    <b>Proprietário: </b>
                                                                    {{ im.imovel_proprietario_nome ? im.imovel_proprietario_nome : "Não informado" }}
                                                                    <span v-if="im.imovel_proprietario_telefone"> | {{ im.imovel_proprietario_telefone }}</span>
                                                                    <span v-if="im.imovel_proprietario_email"> | {{ im.imovel_proprietario_email }}</span>
                                                                </div>
                                                            <?php elseif(Usuario::verifyPermissaoAcesso("imoveis", "all_permission")): ?>
                                                                <div class="col-12 col-sm-12" v-if="im.imovel_user_id == <?= Session::node('uid') ?>">
                                                                    <b>Proprietário: </b>
                                                                    {{ im.imovel_proprietario_nome ? im.imovel_proprietario_nome : "Não informado" }}
                                                                    <span v-if="im.imovel_proprietario_telefone"> | {{ im.imovel_proprietario_telefone }}</span>
                                                                    <span v-if="im.imovel_proprietario_email"> | {{ im.imovel_proprietario_email }}</span>
                                                                </div>
                                                            <?php endif; ?>

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
            <?php endif; ?>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable">
                <div class="modal-content px-0">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="exampleModalLabel">Filtros</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body px-3">
                        <div class="row">
                            <div class="col-md-6 col-12 py-1">

                                <label>Tipo de negociação</label>
                                <br>


                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-secondary active">
                                        <input type="radio" v-model="filtros.negociation" value="venda" checked name="negociationMob" @change="filtrar()" id="btnradio11"> Comprar
                                    </label>
                                    <label class="btn btn-outline-secondary">
                                        <input type="radio" v-model="filtros.negociation" value="aluguel" name="negociationMob" @change="filtrar()" id="btnradio22"> Alugar
                                    </label>

                                    <!-- <label class="btn btn-secondary">
                                        <input type="radio" v-model="filtros.negociation" value="" name="negociationMob" @change="filtrar()" id="btnradio23"> Todos
                                    </label> -->

                                </div>


                            </div>
                            <div class="col-md-6 col-12 py-1">

                                <label>Situação do imóvel</label>
                                <br>


                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-secondary active">
                                        <input type="radio" v-model="filtros.status" value="todos" name="statusMob" @change="filtrar()"> Todos
                                    </label>
                                    <label class="btn btn-outline-secondary">
                                        <input type="radio" v-model="filtros.status" value="ativo" checked name="statusMob" @change="filtrar()"> Ativo
                                    </label>
                                    <label class="btn btn-outline-secondary">
                                        <input type="radio" v-model="filtros.status" value="inativo" name="statusMob" @change="filtrar()"> Inativo
                                    </label>


                                    <!-- <label class="btn btn-secondary">
                                        <input type="radio" v-model="filtros.negociation" value="" name="negociationMob" @change="filtrar()" id="btnradio23"> Todos
                                    </label> -->

                                </div>


                            </div>

                            <div class="col-12 col-md-12 py-1">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Tipo de imóvel</label>
                                    <select class="form-control" id="exampleFormControlSelect1" @change="filtrar()" v-model="filtros.type_imovel">
                                        <option value="">Todos</option>
                                        <option v-for="typeImovel in types" :value="typeImovel.categoria_imovel_nome">{{typeImovel.categoria_imovel_nome}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 py-2">

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Corretor</label>
                                    <select v-model="filtros.user_id" @change="filtrar()" class="form-control" id="exampleFormControlSelect1">
                                        <option selected :value="null">Selecione</option>
                                        <option v-for="usuario in usuarios" :value="usuario.usuario_id">{{usuario.usuario_nome}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 pb-2 pt-0">
                                <label for="exampleFormControlInput1" class="form-label">Localização</label>
                                <input class="form-control me-2" @change="filtrar()" v-model="filtros.localization" type="search" placeholder="Digite o nome da rua, bairro ou cidade" aria-label="Search">
                            </div>

                            <div class="col-12 col-md-6 py-2">
                                <label for="exampleFormControlInput1" class="form-label">Código do Imóvel</label>
                                <input class="form-control me-2" type="search" v-model="filtros.code_imovel" @change="filtrar()" placeholder="Digite o código" aria-label="Search">
                            </div>
                            <div class="col-12 col-md-6 py-2">

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Condomínio</label>
                                    <select v-model="filtros.condominio" @change="filtrar()" class="form-control" id="exampleFormControlSelect1">
                                        <option selected :value="null">Selecione</option>
                                        <option v-for="condominio in condominios" :value="condominio.condominio_id">{{condominio.condominio_nome}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 py-2">
                                <label for="exampleFormControlInput1" class="form-label">Preço</label>
                                <div class="row ">
                                    <div class="col-6">
                                        <input class="form-control me-2 moeda-imovel" id="filtros_min_price" @change="filtrar()" type="search" placeholder="Mínimo" aria-label="Search">
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control me-2 moeda-imovel" id="filtros_max_price" @change="filtrar()" type="search" placeholder="Máximo" aria-label="Search">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 py-2">
                                <label for="exampleFormControlInput1" class="form-label">Área</label>
                                <div class="row ">
                                    <div class="col-6">
                                        <input class="form-control me-2" v-model="filtros.min_area" @change="filtrar()" type="search" placeholder="0m²" aria-label="Search">
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control me-2" v-model="filtros.max_area" @change="filtrar()" type="search" placeholder="1 tri m²" aria-label="Search">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 py-2">
                                <label for="exampleFormControlInput1" class="form-label label-flex"><span>Quartos</span> <small class="text-muted pointer clear-filter" v-if="filtros.quartos" @click="resetFiltro('quartos')">Limpar</small></label>
                                <br>
                                <div class="d-flex gap-3 flex-buttons-search">
                                    <button type="button" @click="setFiltro('quartos', 1);" :class="filtros.quartos == 1 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">1</button>&nbsp;
                                    <button type="button" @click="setFiltro('quartos', 2);" :class="filtros.quartos == 2 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">2</button>&nbsp;
                                    <button type="button" @click="setFiltro('quartos', 3);" :class="filtros.quartos == 3 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">3</button>&nbsp;
                                    <button type="button" @click="setFiltro('quartos', 4);" :class="filtros.quartos == 4 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">4+</button>&nbsp;
                                </div>
                            </div>

                            <div class="col-12 py-2">
                                <label for="exampleFormControlInput1" class="form-label label-flex"><span>Banheiros</span><small class="text-muted pointer clear-filter" v-if="filtros.banheiros" @click="resetFiltro('banheiros')">Limpar</small></label>
                                <br>
                                <div class="d-flex gap-3 flex-buttons-search">
                                    <button type="button" @click="setFiltro('banheiros', 1);" :class="filtros.banheiros == 1 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">1</button>&nbsp;
                                    <button type="button" @click="setFiltro('banheiros', 2);" :class="filtros.banheiros == 2 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">2</button>&nbsp;
                                    <button type="button" @click="setFiltro('banheiros', 3);" :class="filtros.banheiros == 3 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">3</button>&nbsp;
                                    <button type="button" @click="setFiltro('banheiros', 4);" :class="filtros.banheiros == 4 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">4+</button>&nbsp;
                                </div>
                            </div>

                            <div class="col-12 py-2">
                                <label for="exampleFormControlInput1" class="form-label label-flex"><span>Vagas</span> <small class="text-muted pointer clear-filter" v-if="filtros.vagas" @click="resetFiltro('vagas')">Limpar</small></label>
                                <br>
                                <div class="d-flex gap-3 flex-buttons-search">
                                    <button type="button" @click="setFiltro('vagas', 1);" :class="filtros.vagas == 1 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">1</button>&nbsp;
                                    <button type="button" @click="setFiltro('vagas', 2);" :class="filtros.vagas == 2 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">2</button>&nbsp;
                                    <button type="button" @click="setFiltro('vagas', 3);" :class="filtros.vagas == 3 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">3</button>&nbsp;
                                    <button type="button" @click="setFiltro('vagas', 4);" :class="filtros.vagas == 4 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">4+</button>&nbsp;
                                </div>
                            </div>





                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="clearFiltros()" class="btn">Limpar Filtros</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Buscar</button>
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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="${baseUri}/view/admin/imovel/index.js"></script>

    <script>
        $(".supermenu-imoveis").addClass("menu-open");
        $(".menu-imoveis-gerenciar").addClass("active");
        setTimeout(() => {
            $('#datatable_filter').hide()
        }, 1000);
    </script>
</body>

</html>