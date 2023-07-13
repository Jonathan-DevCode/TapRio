<!doctype html>
<html lang="pr-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title}</title>
    @(tema.components.header.assets)

    @(tema.components.partials_seo.meta_tags)
    @(tema.components.partials_seo.og_tags)

    <link href="${baseUri}/view/tema/screens/imoveis/imoveis.css" rel="stylesheet">
    <link href="${baseUri}/view/admin/assets/plugins/fontawesome-free/css/all.css" rel="stylesheet">
    <link href="${baseUri}/view/tema/components/menuLateralFiltros/menuLateralFiltros.css" rel="stylesheet">
</head>

<body>

    <style>
        body {
            font-family: fontAwesome !important;
        }

        .pointer {
            cursor: pointer;
        }

        .label-flex {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            margin-bottom: -15px;
        }
    </style>
    @(tema.components.header.header)

    <div id="main">
        <div class="loading" v-if="!pageready">
            <img src="${baseUri}/media/site/${config_site_logo}" class="img-loading">
        </div>
        <div class="container list-imoveis">
            <div class="row align-items-start mt-5 pt-5">
                <div class="col-3 d-none d-xl-block d-lg-block mt-5">
                    <div class="card my-0">
                        <div class="card-body texto-cor-secundaria">

                            <div class="row">
                                <div class="col-12 py-2">

                                    <label>O que você precisa? &nbsp;</label>
                                    <br>
                                    <div class="btn-group w-100 pt-3" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" v-model="filtros.negociation" class="btn-check" value="venda" @change="filtrar()" name="negociation" id="btnradio1" autocomplete="off">
                                        <label class="btn btn-outline-secondary" for="btnradio1">Comprar</label>

                                        <input type="radio" v-model="filtros.negociation" class="btn-check" value="aluguel" @change="filtrar()" name="negociation" id="btnradio2" autocomplete="off">
                                        <label class="btn btn-outline-secondary" for="btnradio2">Alugar</label>

                                    </div>

                                </div>


                                <div class="col-12 py-2">
                                    <label for="exampleFormControlInput1" class="form-label">Onde deseja morar?</label>
                                    <input class="form-control me-2" @change="filtrar()" v-model="filtros.localization" type="search" placeholder="Digite o nome da rua, bairro ou cidade" aria-label="Search">
                                </div>
                                <div class="col-12 py-2">
                                    <label for="exampleFormControlInput1" class="form-label">Tipo de imóvel</label>
                                    <select v-model="filtros.type_imovel" @change="filtrar()" class="form-select" aria-label="Default select example">
                                        <option selected :value="null">Selecione</option>
                                        <option v-for="typeImovel in types" :value="typeImovel.categoria_imovel_nome">{{typeImovel.categoria_imovel_nome}}</option>
                                    </select>
                                </div>


                                <div class="col-12 py-2">
                                    <label for="exampleFormControlInput1" class="form-label">Código do Imóvel</label>
                                    <input class="form-control me-2" type="search" v-model="filtros.code_imovel" @keyup="filtrar()" placeholder="Digite o código" aria-label="Search">
                                </div>

                                <div class="col-12 py-2">
                                    <label for="exampleFormControlInput1" class="form-label">Preço</label>
                                    <div class="row ">
                                        <div class="col-6">
                                            <input class="form-control me-2 money" inputmode='numeric' id="filtros_min_price" @change="filtrar()" type="text" placeholder="Mínimo">
                                        </div>
                                        <div class="col-6">
                                            <input class="form-control me-2 money" inputmode='numeric' id="filtros_max_price" @change="filtrar()" type="text" placeholder="Máximo">
                                        </div>
                                    </div>



                                </div>

                                <div class="col-12 py-2">
                                    <label for="exampleFormControlInput1" class="form-label label-flex"><span>Quartos</span> <small class="text-muted pointer clear-filter" v-if="filtros.quartos" @click="resetFiltro('quartos')">Limpar</small></label>
                                    <br>
                                    <div class="d-flex gap-2 justify-content-between">
                                        <button type="button" @click="setFiltro('quartos', 1);" :class="filtros.quartos == 1 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">1</button>
                                        <button type="button" @click="setFiltro('quartos', 2);" :class="filtros.quartos == 2 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">2</button>
                                        <button type="button" @click="setFiltro('quartos', 3);" :class="filtros.quartos == 3 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">3</button>
                                        <button type="button" @click="setFiltro('quartos', 4);" :class="filtros.quartos >= 4 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">4+</button>
                                    </div>
                                </div>

                                <div class="col-12 py-2">
                                    <label for="exampleFormControlInput1" class="form-label label-flex"><span>Banheiros</span><small class="text-muted pointer clear-filter" v-if="filtros.banheiros" @click="resetFiltro('banheiros')">Limpar</small></label>
                                    <br>
                                    <div class="d-flex gap-2 justify-content-between">
                                        <button type="button" @click="setFiltro('banheiros', 1);" :class="filtros.banheiros == 1 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">1</button>
                                        <button type="button" @click="setFiltro('banheiros', 2);" :class="filtros.banheiros == 2 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">2</button>
                                        <button type="button" @click="setFiltro('banheiros', 3);" :class="filtros.banheiros == 3 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">3</button>
                                        <button type="button" @click="setFiltro('banheiros', 4);" :class="filtros.banheiros >= 4 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">4+</button>
                                    </div>
                                </div>

                                <div class="col-12 py-2">
                                    <label for="exampleFormControlInput1" class="form-label label-flex"><span>Vagas</span> <small class="text-muted pointer clear-filter" v-if="filtros.vagas" @click="resetFiltro('vagas')">Limpar</small></label>
                                    <br>
                                    <div class="d-flex gap-2 justify-content-between">
                                        <button type="button" @click="setFiltro('vagas', 1);" :class="filtros.vagas == 1 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">1</button>
                                        <button type="button" @click="setFiltro('vagas', 2);" :class="filtros.vagas == 2 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">2</button>
                                        <button type="button" @click="setFiltro('vagas', 3);" :class="filtros.vagas == 3 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">3</button>
                                        <button type="button" @click="setFiltro('vagas', 4);" :class="filtros.vagas >= 4 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">4+</button>
                                    </div>
                                </div>


                                <div class="col-12 py-2">
                                    <label for="exampleFormControlInput1" class="form-label">Área</label>
                                    <div class="row ">
                                        <div class="col-6">
                                            <input class="form-control me-2" inputmode='numeric' v-model="filtros.min_area" @change="filtrar()" type="number" placeholder="m²" aria-label="Search">
                                        </div>
                                        <div class="col-6">
                                            <input class="form-control me-2" inputmode='numeric' v-model="filtros.max_area" @change="filtrar()" type="number" placeholder="m²" aria-label="Search">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 py-2">
                                    <label for="exampleFormControlInput1" class="form-label">Condomínio</label>
                                    <select v-model="filtros.condominio" @change="filtrar()" class="form-select" aria-label="Default select example">
                                        <option selected :value="null">Selecione</option>
                                        <option v-for="condominio in condominios" :value="condominio.condominio_id">{{condominio.condominio_nome}}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-12 col-12 col-12 mt-2">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-9 col-12">
                                <label class="pb-2" v-if="filtros.geral">Você pesquisou por: <b>"{{filtros.geral}}"</b> <button class="btn btn-sm pb-2" @click="filtros.geral = null;filtrar()">Limpar</button></label>
                                <h3 style="color: var(--var-text-primario) !important;"> {{imoveisFiltrados.length}} {{filtros.type_imovel ?? "imóveis"}} para {{filtros.negociation}} </h3>
                            </div>
                            <div class="col-md-3 col-6 d-block d-xl-none d-lg-none d-grid gap-2">
                                <button class="btn btn-outline-primary h-auto " data-bs-toggle="modal" data-bs-target="#exampleModal">Filtros</button>
                            </div>
                            <div class="col-md-3 col-6">
                                <select class="form-select" v-model="filtros.order" @change="filtrar()" aria-label="Default select example">
                                    <option selected :value='null'>Ordernar por</option>
                                    <option value="price_desc">Maior Preço</option>
                                    <option value="price_asc">Menor Preço</option>
                                    <option value="date_asc">Mais Recentes</option>

                                </select>
                            </div>

                            <div class="col-12">
                                <div v-for="(imovel,indexImovel) in imoveisFiltrados">

                                    <div class="d-sm-none d-md-block d-none d-sm-block">
                                        <card-imovel-horizontal :contato="contato" :imovel="imovel" :base="'${baseUri}'"></card-imovel-horizontal>
                                    </div>

                                    <div class="d-sm-block d-md-none">
                                        <card-imovel :imovel="imovel" :contato="contato" :base="'${baseUri}'"></card-imovel>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable">
                <div class="modal-content px-0">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Filtros</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-3">
                        <div class="row">
                            <div class="col-12 py-2">

                                <label>O que você precisa? &nbsp;</label>
                                <br>
                                <div class="btn-group w-100 pt-3" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" v-model="filtros.negociation" class="btn-check" value="venda" @change="filtrar()" name="negociationMob" id="btnradio11" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btnradio1">Comprar</label>

                                    <input type="radio" v-model="filtros.negociation" class="btn-check" value="aluguel" @change="filtrar()" name="negociationMob" id="btnradio22" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btnradio2">Alugar</label>

                                </div>

                            </div>


                            <div class="col-12 py-2">
                                <label for="exampleFormControlInput1" class="form-label">Onde deseja morar?</label>
                                <input class="form-control me-2" @change="filtrar()" v-model="filtros.localization" type="search" placeholder="Digite o nome da rua, bairro ou cidade" aria-label="Search">
                            </div>
                            <div class="col-12 py-2">
                                <label for="exampleFormControlInput1" class="form-label">Tipo de imóvel</label>
                                <select v-model="filtros.type_imovel" @change="filtrar()" class="form-select" aria-label="Default select example">
                                    <option selected :value='null'>Selecione</option>
                                    <option v-for="typeImovel in types" :value="typeImovel.categoria_imovel_nome">{{typeImovel.categoria_imovel_nome}}</option>
                                </select>
                            </div>


                            <div class="col-12 py-2">
                                <label for="exampleFormControlInput1" class="form-label">Preço</label>
                                <div class="row ">
                                    <div class="col-6">
                                        <input class="form-control me-2 money" inputmode='numeric' id="filtros_min_price_mob" @change="filtrar()" type="text" placeholder="Mínimo">
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control me-2 money" inputmode='numeric' id="filtros_max_price_mob" @change="filtrar()" type="text" placeholder="Máximo">
                                    </div>
                                </div>



                            </div>


                        </div>
                        <div class="col-12 py-2">
                            <label for="exampleFormControlInput1" class="form-label">Código do Imóvel</label>
                            <input class="form-control me-2" type="search" v-model="filtros.code_imovel" @change="filtrar()" placeholder="Digite o código" aria-label="Search">
                        </div>

                        <div class="col-12 py-2">
                            <label for="exampleFormControlInput1" class="form-label label-flex"><span>Quartos</span> <small class="text-muted pointer clear-filter" v-if="filtros.quartos" @click="resetFiltro('quartos')">Limpar</small></label>
                            <br>
                            <div class="d-flex gap-2 justify-content-between">
                                <button type="button" @click="setFiltro('quartos', 1);" :class="filtros.quartos == 1 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">1</button>
                                <button type="button" @click="setFiltro('quartos', 2);" :class="filtros.quartos == 2 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">2</button>
                                <button type="button" @click="setFiltro('quartos', 3);" :class="filtros.quartos == 3 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">3</button>
                                <button type="button" @click="setFiltro('quartos', 4);" :class="filtros.quartos >= 4 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">4+</button>
                            </div>
                        </div>

                        <div class="col-12 py-2">
                            <label for="exampleFormControlInput1" class="form-label label-flex"><span>Banheiros</span><small class="text-muted pointer clear-filter" v-if="filtros.banheiros" @click="resetFiltro('banheiros')">Limpar</small></label>
                            <br>
                            <div class="d-flex gap-2 justify-content-between">
                                <button type="button" @click="setFiltro('banheiros', 1);" :class="filtros.banheiros == 1 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">1</button>
                                <button type="button" @click="setFiltro('banheiros', 2);" :class="filtros.banheiros == 2 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">2</button>
                                <button type="button" @click="setFiltro('banheiros', 3);" :class="filtros.banheiros == 3 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">3</button>
                                <button type="button" @click="setFiltro('banheiros', 4);" :class="filtros.banheiros >= 4 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">4+</button>
                            </div>
                        </div>

                        <div class="col-12 py-2">
                            <label for="exampleFormControlInput1" class="form-label label-flex"><span>Vagas</span> <small class="text-muted pointer clear-filter" v-if="filtros.vagas" @click="resetFiltro('vagas')">Limpar</small></label>
                            <br>
                            <div class="d-flex gap-2 justify-content-between">
                                <button type="button" @click="setFiltro('vagas', 1);" :class="filtros.vagas == 1 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">1</button>
                                <button type="button" @click="setFiltro('vagas', 2);" :class="filtros.vagas == 2 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">2</button>
                                <button type="button" @click="setFiltro('vagas', 3);" :class="filtros.vagas == 3 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">3</button>
                                <button type="button" @click="setFiltro('vagas', 4);" :class="filtros.vagas >= 4 ? 'active' : ''" class="btn btn-filters btn-outline-secondary">4+</button>
                            </div>
                        </div>



                        <div class="col-12 py-2">
                            <label for="exampleFormControlInput1" class="form-label">Área</label>
                            <div class="row ">
                                <div class="col-6">
                                    <input class="form-control me-2" inputmode='numeric' v-model="filtros.min_area" @change="filtrar()" type="search" placeholder="0m²" aria-label="Search">
                                </div>
                                <div class="col-6">
                                    <input class="form-control me-2" inputmode='numeric' v-model="filtros.max_area" @change="filtrar()" type="search" placeholder="1 tri m²" aria-label="Search">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 py-2">
                            <label for="exampleFormControlInput1" class="form-label">Condomínio</label>
                            <select v-model="filtros.condominio" @change="filtrar()" class="form-select" aria-label="Default select example">
                                <option selected :value="null">Selecione</option>
                                <option v-for="condominio in condominios" :value="condominio.condominio_id">{{condominio.condominio_nome}}</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Buscar</button>
                    </div>
                </div>
            </div>
        </div>



        <modal-contato :contato="config"></modal-contato>
    </div>

    <!-- botão flutuante whats -->
    <?php if (!empty($data['config']->whatsNum)) : ?>
        <div class="whatsapp-button">
            <a target="_blank" href="https://api.whatsapp.com/send?phone=+55<?= $data['config']->whatsNum ?>&text=Olá,vim pelo site e gostaria de ter mais informações">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                </svg>
            </a>
        </div>
    <?php endif; ?>
    @(tema.components.footer.footer)


    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        const {
            createApp
        } = Vue

        createApp({
            data() {
                return {
                    imoveis: [],
                    types: [],
                    contato: {
                        config_site_telefone2: '${config_site_telefone2}',
                        config_site_telefone: '${config_site_telefone}'
                    },
                    pageready: false,
                    config: JSON.parse('<?= json_encode($data['config_json']) ?>'),
                    imoveisFiltrados: [],
                    condominios: [],
                    filtros: {
                        searching: null,
                        negociation: 'venda',
                        localization: null,
                        type_imovel: null,
                        quartos: null,
                        suites: null,
                        banheiros: null,
                        vagas: null,
                        code_imovel: null,
                        min_area: null,
                        max_area: null,
                        min_price: null,
                        max_price: null,
                        order: null,
                        geral: null,
                        condominio: null,
                    },
                    showAllDescription: {
                        id_imovel: null,
                        show: false
                    }
                }
            },
            components: {
                CardImovel,
                CardImovelHorizontal,
                ModalContato
            },
            methods: {
                async getCondominios() {
                    try {
                        const response = await axios.get('${baseUri}/imovel/getCondominios');
                        this.condominios = response.data;


                    } catch (error) {
                        console.error(error);
                    }
                },
                setButtonNegociation() {
                    if (this.filtros.negociation == 'venda') {
                        $(`#btnradio1`).trigger("click");
                        $(`#btnradio11`).trigger("click");
                    }



                    if (this.filtros.negociation == 'aluguel') {
                        $(`#btnradio2`).trigger("click");
                        $(`#btnradio22`).trigger("click");

                    }
                },

                verifyShowAllDescription(id_imovel) {
                    if (id_imovel == this.showAllDescription.id_imovel && this.showAllDescription.show) {
                        return true;
                    }
                },
                setFiltro(filtro, value) {
                    if (this.filtros[filtro] == value) {
                        this.filtros[filtro] = null
                    } else {
                        this.filtros[filtro] = value;
                    }

                    this.filtrar();
                },
                resetFiltro(filtro) {
                    this.filtros[filtro] = null;
                    this.filtrar();
                },
                async getTypesImoveis() {
                    try {
                        const response = await axios.get('${baseUri}/imovel/getTypes');
                        this.types = response.data;
                    } catch (error) {
                        console.error(error);
                    }
                },

                setShowAllDescription(id_imovel, status) {
                    this.showAllDescription.id_imovel = id_imovel;
                    this.showAllDescription.show = status;
                },

                async getImoveis() {
                    try {
                        const response = await axios.get('${baseUri}/imovel/get');
                        this.imoveis = response.data;
                        this.imoveisFiltrados = response.data;

                    } catch (error) {
                        console.error(error);
                    }
                },

                filterByTypeImovel(imovel) {
                    if (imovel.categoria_imovel_nome == this.filtros.type_imovel)
                        return true

                    return false;
                },
                filterByNegociation(imovel) {
                    if (imovel.imovel_tipo_negociacao == "venda_aluguel" || imovel.imovel_tipo_negociacao == this.filtros.negociation)
                        return true

                    return false;
                },
                filterByLocalization(imovel) {

                    if (this.filtros.localization) {
                        let endereco = imovel.imovel_bairro + ' ' + imovel.imovel_cidade + ' ' + imovel.imovel_rua + ' ' + imovel.imovel_uf;

                        endereco = endereco.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase();
                        this.filtros.localization = this.filtros.localization.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase();

                        if (endereco.includes(this.filtros.localization))
                            return true

                        return false;

                    }
                },
                filterByMinPrice(imovel) {
                    if (this.filtros.negociation == 'aluguel') {
                        if (imovel.imovel_valor_locacao >= this.filtros.min_price && imovel.imovel_valor_locacao > 0)
                            return true

                        return false;
                    }


                    if (this.filtros.negociation == 'venda') {
                        if (imovel.imovel_valor_venda >= this.filtros.min_price && imovel.imovel_valor_venda > 0)
                            return true

                        return false;

                    }

                },
                filterByMaxPrice(imovel) {

                    if (this.filtros.negociation == 'aluguel') {
                        if (imovel.imovel_valor_locacao <= this.filtros.max_price)
                            return true

                        return false;
                    }


                    if (this.filtros.negociation == 'venda') {
                        if (imovel.imovel_valor_venda <= this.filtros.max_price)
                            return true

                        return false;

                    }

                },
                filterByQuartos(imovel) {

                    if(this.filtros.searching) {
                        if (Number(imovel.imovel_quartos) >= Number(this.filtros.quartos))
                            return true;

                        return false;

                    } else {
                        if (this.filtros.quartos == 4) {
                            if (Number(imovel.imovel_quartos) >= Number(this.filtros.quartos))
                                return true;

                            return false;

                        } else {

                            if (Number(imovel.imovel_quartos) == Number(this.filtros.quartos))
                                return true;

                            return false;
                        }
                    }




                },
                filterByVagas(imovel) {

                    if(this.filtros.searching) {
                        if (Number(imovel.imovel_vagas) >= Number(this.filtros.vagas))
                            return true;

                        return false;

                    } else {
                        if (this.filtros.vagas == 4) {

                            if (Number(imovel.imovel_vagas) >= Number(this.filtros.vagas))
                                return true;

                            return false;

                        } else {
                            if (Number(imovel.imovel_vagas) === Number(this.filtros.vagas))
                                return true;

                            return false;
                        }

                    }

                },
                filterByCondominio(imovel) {

                    if (Number(imovel.imovel_condominio_id) === Number(this.filtros.condominio))
                        return true;

                    return false;
                },
                filterByBanheiros(imovel) {

                    if(this.filtros.searching) {
                        if (Number(imovel.imovel_banheiros) >= Number(this.filtros.banheiros))
                            return true;

                        return false;
                    } else {
                        if (this.filtros.banheiros == 4) {
                            if (Number(imovel.imovel_banheiros) >= Number(this.filtros.banheiros))
                                return true;

                            return false;

                        } else {
                            if (Number(imovel.imovel_banheiros) === Number(this.filtros.banheiros))
                                return true;

                            return false;
                        }
                    }


                },
                filterBySuites(imovel) {

                    if(this.filtros.searching) {
                        if (Number(imovel.imovel_suites) >= Number(this.filtros.suites))
                            return true;

                        return false;
                    } else {
                        if (this.filtros.banheiros == 4) {
                            if (Number(imovel.imovel_banheiros) >= Number(this.filtros.banheiros))
                                return true;

                            return false;

                        } else {
                            if (Number(imovel.imovel_banheiros) === Number(this.filtros.banheiros))
                                return true;

                            return false;
                        }

                    }



                },
                filterByMinArea(imovel) {
                    if (Number(imovel.imovel_area_util) >= Number(this.filtros.min_area))
                        return true;

                    return false;
                },
                filterByMaxArea(imovel) {
                    if (Number(imovel.imovel_area_util) <= Number(this.filtros.max_area))
                        return true;

                    return false;
                },
                filterByCode(imovel) {

                    var codigo = this.filtros.code_imovel.toString().toLowerCase().trim();
                    var pesquisa = imovel.imovel_ref.toString().toLowerCase().trim();

                    if (pesquisa.includes(codigo)) {
                        return true;
                    }


                    return false
                },

                filterGeral(imovel) {

                    var search = this.filtros.geral.toString().toLowerCase().trim();

                    if (imovel.imovel_ref.toString().toLowerCase().trim().includes(search)) {
                        this.filtros.negociation = imovel.imovel_tipo_negociacao;

                        if(imovel.imovel_tipo_negociacao == "venda_aluguel") {
                            this.filtros.negociation = 'venda';
                        }

                        this.filtros.type_imovel = imovel.categoria_imovel_nome;
                        this.filtros.code_imovel = imovel.imovel_ref;

                        this.setButtonNegociation();
                        return true;
                    }


                    let endereco = imovel.imovel_bairro + ' ' + imovel.imovel_cidade + ' ' + imovel.imovel_rua + ' ' + imovel.imovel_uf;

                    endereco = endereco.toString().toLowerCase().trim();

                    if (endereco.includes(search)) {
                        this.filtros.localization = this.filtros.geral;
                        return true;
                    }

                    if (imovel.condominio_nome && imovel.condominio_nome.toString().toLowerCase().trim().includes(search)) {
                        this.filtros.condominio = imovel.condominio_id;
                        return true;
                    }

                    if (imovel.imovel_titulo.toString().toLowerCase().trim().includes(search)) {
                        return true;
                    }

                    return false;

                },


                filtrar() {

                    console.log(this.filtros)

                    this.filtros.min_price = Number($("#filtros_min_price").val().trim().split(".").join("").replace(",", "."));
                    this.filtros.max_price = Number($("#filtros_max_price").val().trim().split(".").join("").replace(",", "."));

                    if(window.innerWidth <= 991){
                        this.filtros.min_price = Number($("#filtros_min_price_mob").val().trim().split(".").join("").replace(",", "."));
                        this.filtros.max_price = Number($("#filtros_max_price_mob").val().trim().split(".").join("").replace(",", "."));
                    }

                       this.imoveisFiltrados = this.imoveis;

                    if (this.filtros.geral)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterGeral);

                    if (this.filtros.code_imovel)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByCode);

                    if (this.filtros.negociation)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByNegociation);

                    if (this.filtros.localization)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByLocalization);

                    if (this.filtros.type_imovel)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByTypeImovel);

                    if (this.filtros.min_price)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByMinPrice);

                    if (this.filtros.max_price)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByMaxPrice);

                    if (this.filtros.quartos)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByQuartos);

                    if (this.filtros.suites)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterBySuites);

                    if (this.filtros.vagas)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByVagas);

                    if (this.filtros.banheiros)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByBanheiros);

                    if (this.filtros.min_area)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByMinArea);

                    if (this.filtros.max_area)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByMaxArea);

                    if (this.filtros.condominio)
                        this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByCondominio);




                    if (this.filtros.order == 'price_desc') {
                        if (this.filtros.negociation == 'aluguel') {
                            this.imoveisFiltrados.sort((firstItem, secondItem) => secondItem.imovel_valor_locacao - firstItem.imovel_valor_locacao);
                        }

                        if (this.filtros.negociation == 'venda') {
                            this.imoveisFiltrados.sort((firstItem, secondItem) => secondItem.imovel_valor_venda - firstItem.imovel_valor_venda);
                        }
                    }

                    if (this.filtros.order == 'price_asc') {
                        if (this.filtros.negociation == 'aluguel') {
                            this.imoveisFiltrados.sort((firstItem, secondItem) => firstItem.imovel_valor_locacao - secondItem.imovel_valor_locacao);
                        }

                        if (this.filtros.negociation == 'venda') {
                            this.imoveisFiltrados.sort((firstItem, secondItem) => firstItem.imovel_valor_venda - secondItem.imovel_valor_venda);
                        }
                    }

                    if (this.filtros.order == 'date_asc')
                        this.imoveisFiltrados.sort((firstItem, secondItem) => firstItem.imovel_created - secondItem.imovel_date_create);

                    if (this.filtros.order == 'destaque_asc')
                        this.imoveisFiltrados.sort((firstItem, secondItem) => firstItem.imovel_destaque - secondItem.imovel_destaque);

                    let inners = $('.carousel-inner');

                    inners.each((index, inner) => {
                        let itens = $(inner).find('.carousel-item');
                        $(itens[0]).addClass('active');
                    });

                },


                getParamsUrl() {
                    this.filtros.searching = new URLSearchParams(window.location.search).get('searching');

                    this.filtros.negociation = new URLSearchParams(window.location.search).get('negociation');

                    this.filtros.localization = new URLSearchParams(window.location.search).get('location');

                    this.filtros.type_imovel = new URLSearchParams(window.location.search).get('type');

                    this.filtros.geral = new URLSearchParams(window.location.search).get('search');

                    this.filtros.condominio = new URLSearchParams(window.location.search).get('condominio');

                    this.filtros.quartos = new URLSearchParams(window.location.search).get('quartos');

                    this.filtros.banheiros = new URLSearchParams(window.location.search).get('banheiros');

                    this.filtros.vagas = new URLSearchParams(window.location.search).get('vagas');

                    this.filtros.suites = new URLSearchParams(window.location.search).get('suites');




                    var precos = new URLSearchParams(window.location.search).get('preco');


                    if(precos){
                        precos = precos.split(',');

                        if(precos[0] && precos[0] > 0)
                            this.filtros.min_price = precos[0];

                        if(precos[1] && precos[1] > 0)
                            this.filtros.max_price = precos[1];


                            $("#filtros_min_price").val(this.filtros.min_price)
                            $("#filtros_max_price").val(this.filtros.max_price)

                    }


                    var areas = new URLSearchParams(window.location.search).get('area');

                    if(areas){
                        areas = areas.split(',');

                        if(areas[0] && areas[0] > 0)
                            this.filtros.min_area = areas[0];

                        if(areas[1] && areas[1] > 0)
                            this.filtros.max_area = areas[1];
                    }


                    if (!this.filtros.negociation) {
                        this.filtros.negociation = 'venda'
                    }

                    this.setButtonNegociation();
                    this.filtrar();

                }
            },

            mounted() {
                this.getImoveis();
                this.getTypesImoveis();
                this.getCondominios();



                setTimeout(() => {
                    this.getParamsUrl();


                    this.pageready = true;
                     $(".money").mask('000.000.000.000.000', {
                    reverse: true
                });

                }, 2000);
            },
        }).mount('#main')
    </script>

</body>

</html>