<!doctype html>
<html lang="pr-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title}</title>
    @(tema.components.header.assets)

    <link href="${baseUri}/view/tema/screens/imovel/imovel.css" rel="stylesheet">
    <link href="${baseUri}/view/admin/assets/plugins/fontawesome-free/css/all.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <meta name="keywords" content="imoveis, apartamentos, venda, aluguel, alugar, <?= $data['SEOdata']->imovel_titulo ?>">
    <meta property="og:url" content="${baseUri}/imovel/ver/<?= $data['imovel_id'] ?>" />
    <meta property="og:title" content="<?= $data['SEOdata']->imovel_titulo ?>" />
    <meta property="title" content="<?= $data['SEOdata']->imovel_titulo ?>" />
    <meta property="og:description" content="<?= $data['SEOdata']->imovel_desc ?>" />
    <meta name="description" content="<?= $data['SEOdata']->imovel_desc ?>">
    <meta property="og:image" content="${baseUri}/media/imovel/thumb_<?= $data['SEOdata']->imgs[0]->foto_imovel_img ?? '' ?>?cache=<?= rand(0, 999999) ?>" />
    <meta property="image" content="${baseUri}/media/imovel/thumb_<?= $data['SEOdata']->imgs[0]->foto_imovel_img ?? '' ?>?cache=<?= rand(0, 999999) ?>" />
    <meta name="robots" content="index,follow">
    <meta http-equiv="content-language" content="pt-br">
</head>

<body>

    <style>
        body {
            font-family: fontAwesome !important;
        }

        .spin {
            animation-name: spin;
            animation-duration: 2000ms;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }


        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .thumb-video-carousel {
            height: 370px;
            width: 460px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .play-section {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background-color: #111111dd;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }
    </style>

    @(tema.components.header.header)
    <div class="loading">
        <img src="${baseUri}/media/site/${config_site_logo}" class="img-loading">
    </div>

    <div id="main">

        <div>
            <div v-if="imovel" class="topo-imovel pb-5" style="min-height:375px">
                <div class="imovel-slide" v-if="imovel.imovel_tipo_fotos_first == 'imovel'">

                    <div class="masonry_thum" v-if="imovel.imovel_thumb_video && imovel.imovel_video">
                        <a :href="imovel.imovel_video" class="glightbox" data-gallery="gallery" style="text-decoration: none;">
                            <div class="thumb-video-carousel" :style="'background-image: url(' + imovel.imovel_thumb_video + ')'">
                                <div class="play-section">
                                    <i class="fa fa-play fa-2x text-white" style="    padding-left: 5px;"></i>
                                </div>
                            </div>
                        </a>

                    </div>
                    <div class="masonry_thum" v-for="(image,index) in imovel.fotos">
                        <a :href="'${baseUri}/media/imovel/watermark_'+ image.foto_imovel_img" class="glightbox" data-gallery="gallery">

                            <img :src="'${baseUri}/media/imovel/watermark_' + image.foto_imovel_img" class="img-fluid" alt="image">
                            <!-- <img :src="'${baseUri}/media/imovel/'+ image.foto_imovel_img" class="img-fluid" alt="image" /> -->
                        </a>

                    </div>

                    <div class="masonry_thum" v-for="(image_cond,index) in imovel.fotos_cond">
                        <a :href="'${baseUri}/media/condominio/watermark_'+ image_cond.foto_condominio_img" class="glightbox" data-gallery="gallery">

                            <img :src="'${baseUri}/media/condominio/watermark_' + image_cond.foto_condominio_img" class="img-fluid" alt="image">
                            <!-- <img :src="'${baseUri}/media/imovel/'+ image.foto_imovel_img" class="img-fluid" alt="image" /> -->
                        </a>

                    </div>
                </div>
                <div class="imovel-slide" v-if="imovel.imovel_tipo_fotos_first == 'condominio'">
                    <div class="masonry_thum" v-for="(image_cond,index) in imovel.fotos_cond">
                        <a :href="'${baseUri}/media/condominio/watermark_'+ image_cond.foto_condominio_img" class="glightbox" data-gallery="gallery">

                            <img :src="'${baseUri}/media/condominio/watermark_' + image_cond.foto_condominio_img" class="img-fluid" alt="image">
                            <!-- <img :src="'${baseUri}/media/imovel/'+ image.foto_imovel_img" class="img-fluid" alt="image" /> -->
                        </a>

                    </div>
                    <div class="masonry_thum" v-for="(image,index) in imovel.fotos">
                        <a :href="'${baseUri}/media/imovel/watermark_'+ image.foto_imovel_img" class="glightbox" data-gallery="gallery">

                            <img :src="'${baseUri}/media/imovel/watermark_' + image.foto_imovel_img" class="img-fluid" alt="image">
                            <!-- <img :src="'${baseUri}/media/imovel/'+ image.foto_imovel_img" class="img-fluid" alt="image" /> -->
                        </a>

                    </div>


                </div>
            </div>

            <div class="container desc-imovel" style="min-height:375px">
                <div class="row " v-if="imovel">


                    <div class="col-lg-8 col-xl-8 col-md-12 col-12 texto-cor-primaria correct-icons">

                        <h3 v-text="imovel.imovel_titulo"></h3>
                        <b class=" mt-0 pt-0 " style="font-size:14px;">Cód. {{imovel.imovel_ref}}</b>
                        <br>
                        <label class="py-2 mb-3">

                            <span v-text="imovel.categoria_imovel_nome"></span> para
                            <span v-if="imovel.imovel_tipo_negociacao == 'venda'">Venda</span>
                            <span v-if="imovel.imovel_tipo_negociacao == 'aluguel'">Locação</span>
                            <span v-if="imovel.imovel_tipo_negociacao == 'venda_aluguel'">Venda e Locação</span>

                            <span v-if="getAddress()">
                                em<br>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                </svg>
                                <span v-text="getAddress()"></span>
                            </span>
                        </label>

                        <div v-if="imovel.imovel_tipo_negociacao == 'venda'">
                            <label>Venda</label>
                            <h2 v-text="toCurrency(imovel.imovel_valor_venda)"></h2>
                        </div>

                        <div v-if="imovel.imovel_tipo_negociacao == 'aluguel'">
                            <label>Locação</label>
                            <h2 v-text="toCurrency(imovel.imovel_valor_locacao)"></h2>
                        </div>

                        <div v-if="imovel.imovel_tipo_negociacao == 'venda_aluguel'">
                            <h2>
                                <span v-text="toCurrency(imovel.imovel_valor_venda)"></span> /
                                <span v-text="toCurrency(imovel.imovel_valor_locacao)"></span>
                            </h2>
                        </div>




                        <span class="">
                            <label class="label-price" v-if="imovel.imovel_isento_condominio == 0 && imovel.imovel_valor_condominio > 0" v-text="'Condomínio ' + toCurrency(imovel.imovel_valor_condominio)"> </label>
                            <span class="label-price" v-if="imovel.imovel_isento_condominio == 0 && imovel.imovel_isento_iptu == 0">&nbsp;&#8226;&nbsp;</span>
                            <label class="label-price pe-1" v-if="imovel.imovel_isento_iptu == 0 && imovel.imovel_valor_iptu > 0" v-text="'IPTU ' + toCurrency(imovel.imovel_valor_iptu)"> </label></span>

                        <div class="row text-muted icons-attr align-items-center mt-4 d-none d-md-flex">
                            <div class="col-6 col-md-3 mb-2" v-if="imovel.imovel_quartos > 0">
                                <i class="fa fa-bed" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_quartos +' Quarto(s)'"></span>
                            </div>
                            <div class="col-6 col-md-3 mb-2" v-if="imovel.imovel_suites > 0">
                                <i class="fa fa-bath" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_suites +' Suíte(s)'"></span>
                            </div>
                            <div class="col-6 col-md-3 mb-2" v-if="imovel.imovel_banheiros > 0">
                                <i class="fa fa-shower" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_banheiros +' Banheiro(s)'"></span>
                            </div>
                            <div class="col-6 col-md-3 mb-2" v-if="imovel.imovel_vagas > 0">
                                <i class="fa fa-car" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_vagas +' Vaga(s)'"></span>
                            </div>
                            <div class="col-6 col-md-3 mb-2" v-if="imovel.imovel_andar">
                                <i class="fa fa-building" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_andar +'º Andar'"></span>
                            </div>
                            <div class="col-6 col-md-3 mb-2" v-if="imovel.imovel_area_total > 0">
                                <i class="fa fa-clone" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_area_total + ' m²'"></span>
                            </div>
                        </div>

                        <div class="row text-muted icons-attr align-items-center p-0 mt-4 d-md-none">
                            <div class="col-2 mb-2" v-if="imovel.imovel_quartos > 0">
                                <i class="fa fa-bed" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_quartos"></span>
                            </div>
                            <div class="col-2 mb-2" v-if="imovel.imovel_suites > 0">
                                <i class="fa fa-bath" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_suites"></span>
                            </div>
                            <div class="col-2 mb-2" v-if="imovel.imovel_banheiros > 0">
                                <i class="fa fa-shower" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_banheiros"></span>
                            </div>
                            <div class="col-2 mb-2" v-if="imovel.imovel_vagas > 0">
                                <i class="fa fa-car" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_vagas"></span>
                            </div>
                            <div class="col-2 mb-2" v-if="imovel.imovel_andar">
                                <i class="fa fa-building" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_andar"></span>
                            </div>
                            <div class="col-3 mb-2 text-nowrap" v-if="imovel.imovel_area_total > 0">
                                <i class="fa fa-clone" aria-hidden="true"></i> &nbsp;<span v-text="imovel.imovel_area_total + ' m²'"></span>
                            </div>
                        </div>


                        <hr>
                        <!-- <div class="d-block d-lg-none d-xl-none">
                            <div class="row">
                                <div class="col-6" v-if="imovel.imovel_tipo_negociacao == 'venda' || imovel.imovel_tipo_negociacao == 'venda_aluguel'">
                                    <b>Venda</b>
                                </div>
                                <div class="col-6 text-end" v-if="imovel.imovel_tipo_negociacao == 'venda' || imovel.imovel_tipo_negociacao == 'venda_aluguel'">
                                    <label v-text="toCurrency(imovel.imovel_valor_venda)"></label>
                                </div>

                                <div class="col-6" v-if="imovel.imovel_tipo_negociacao == 'aluguel' || imovel.imovel_tipo_negociacao == 'venda_aluguel'">
                                    <b>Locação</b>
                                </div>
                                <div class="col-6 text-end" v-if="imovel.imovel_tipo_negociacao == 'aluguel' || imovel.imovel_tipo_negociacao == 'venda_aluguel'">
                                    <label v-text="toCurrency(imovel.imovel_valor_locacao)"></label>
                                </div>
                                <div class="col-6" v-if="imovel.imovel_isento_condominio == 0"><label>Condominio </label></div>
                                <div class="col-6 text-end" v-if="imovel.imovel_isento_condominio == 0"><label v-text="toCurrency(imovel.imovel_valor_condominio)"></label></div>
                                <div class="col-6" v-if="imovel.imovel_isento_iptu == 0 && imovel.imovel_valor_iptu > 0"><label>IPTU </label></div>
                                <div class="col-6 text-end" v-if="imovel.imovel_isento_iptu == 0 && imovel.imovel_valor_iptu > 0"><label v-text="toCurrency(imovel.imovel_valor_iptu)"></label></div>

                            </div>
                        </div> -->
                        <div class="d-grid d-md-flex gap-2 mt-5">
                            <a tabindex="0" class="btn btn-primary" role="button" data-bs-trigger="focus" @click="copyText('${baseUri}/imovel/ver/<?= $data['imovel_id'] ?>')" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Link Copiado!">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
                                    <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z" />
                                </svg>
                                Compartilhar
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3 col-12 text-md-end d-none d-lg-bloc d-xl-block">
                        <div class="column">

                            <div class="meu-sticky">
                                <div class="card formulario-fixed-imovel px-2 sticky">
                                    <div class="card-body">
                                        <h4>Entre em contato</h4>
                                        <hr>

                                        <div class="text-center" v-if="contato"> <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                            </svg>
                                            &nbsp;
                                            <span v-text="contato.config_site_telefone"></span>
                                            &nbsp;
                                            &#8226;
                                            &nbsp;

                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                            </svg>
                                            &nbsp;
                                            <span v-text="contato.config_site_telefone2"></span>
                                            <br>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                                            </svg>&nbsp;
                                            <span v-text="contato.config_site_email"></span>

                                        </div>


                                        <div class="row pt-4">
                                            <hr>

                                            <div class="col-12 mt-2">

                                                <input type="text" v-model="formContato.nome" class="form-control" id="contato_nome" placeholder="Seu nome">

                                            </div>
                                            <div class="col-12 mt-2">

                                                <input type="tel" class="form-control phone_mask" v-model="formContato.telefone" id="contato_telefone" placeholder="Seu telefone">

                                            </div>

                                            <div class="col-12 mt-2">

                                                <input type="email" class="form-control" v-model="formContato.email" id="contato_email" placeholder="Seu email">

                                            </div>

                                            <div class="col-12 mt-2">
                                                <textarea class="form-control" id="contato_mensagem" v-model="formContato.mensagem" placeholder="escreva uma mensagem" rows="3">Olá, Gostaria de ter mais informações sobre o imóvel {{imovel.imovel_titulo}} Código {{imovel.imovel_ref}} que encontrei no seu site. Aguardo seu contato, obrigado(a)!</textarea>
                                            </div>

                                            <div class="col-12 mt-3">
                                                <div class="d-grid gap-2">
                                                    <button class="btn btn-primary btn-send-contact" @click="sendContact" type="button">Enviar</button>
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- descrição do imóvel -->
            <div class="description my-5" v-if="imovel.imovel_desc || imovel.caracteristicas_ids">
                <div class="container texto-cor-primaria correct-icons">
                    <h2 v-if="imovel.imovel_desc">Descrição</h2>
                    <div class="text pt-3" v-html="imovel.imovel_desc">
                    </div>
                    <div class="row py-3 w-100" v-if="imovel.caracteristicas_imóvel_pesquisa">
                        <div class="col-md-12">
                            <h5 v-text="imovel.caracteristicas_imóvel_pesquisa[0].caracteristica_categoria_nome"></h5>
                        </div>

                        <div class="col-sm-12 col-12 col-md-12 col-lg-6 col-xl-6 py-2 d-flex" v-if="imovel.caracteristicas_imóvel_pesquisa" v-for="caract in imovel.caracteristicas_imóvel_pesquisa">
                            <i class="fa fa-check pt-2"></i> &nbsp; <span class="align-self-end pt-1" v-text="caract.caracteristica_nome"></span>
                            <div class="ps-1 align-self-start" v-if="caract.caracteristica_diferencial == 1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container d-block d-xl-none ">
                <div class="row">
                    <div class="col-12">
                        <div class="card formulario-fixed-imovel mx-0 mt-5">
                            <div class="card-body">
                                <h4>Entre em contato</h4>
                                <hr>

                                <div v-if="contato"> <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                    </svg>
                                    &nbsp;
                                    <span v-text="contato.config_site_telefone"></span>

                                    <br>


                                    <svg class="text-success" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                    </svg>
                                    &nbsp;
                                    <span v-text="contato.config_site_telefone2"></span>

                                    <br>

                                    <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                                    </svg>

                                    &nbsp;
                                    <span v-text="contato.config_site_email"></span>

                                </div>


                                <div class="row pt-4">
                                    <hr>

                                    <div class="col-12 mt-2">

                                        <input type="text" v-model="formContato.nome" class="form-control" id="contato_nome" placeholder="Seu nome">

                                    </div>
                                    <div class="col-12 mt-2">

                                        <input type="tel" class="form-control phone_mask" v-model="formContato.telefone" id="contato_telefone" placeholder="Seu telefone">

                                    </div>

                                    <div class="col-12 mt-2">

                                        <input type="email" class="form-control" v-model="formContato.email" id="contato_email" placeholder="Seu email">

                                    </div>

                                    <div class="col-12 mt-2">
                                        <textarea class="form-control" id="contato_mensagem" v-model="formContato.mensagem" placeholder="escreva uma mensagem" rows="3">Olá, Gostaria de ter mais informações sobre o imóvel {{imovel.imovel_titulo}} Código {{imovel.imovel_ref}} que encontrei no seu site. Aguardo seu contato, obrigado(a)!</textarea>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-primary btn-send-contact" @click="sendContact" type="button">Enviar</button>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="row">
                    <!-- <div class="col-12 text-center" v-if="imovel.imovel_video">
                        <h1>Vídeo do Imóvel</h1>
                        <br>
                        <iframe width="100%" height="400" :src="'https://www.youtube.com/embed/'+ imovel.imovel_video.substr(32)" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div> -->

                    <div class="col-12 text-center mt-5 pt-4" v-if="imovel.imovel_link_tour">

                        <h1>Tour Virtual</h1>
                        <br>
                        <iframe width="100%" height="400" :src="'https://www.youtube.com/embed/'+ imovel.imovel_link_tour.substr(32)" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>

            </div>
            <!-- end descrição do imóvel -->
            <!-- descrição do condomínio -->
            <div class="my-5" v-if="imovel.condominio_descricao && imovel.condominio_caracteristicas_ids">
                <div class="container">
                    <h2 v-if="imovel.condominio_descricao">Conheça o condomínio {{ imovel.condominio_nome }}</h2>
                    <div class="text pt-3" v-html="imovel.condominio_descricao">
                    </div>
                    <div class="row py-3 w-100" v-if="imovel.condominio_caracteristicas_ids" v-for="(caracteristica_categoria,index) in imovel.condominio_caracteristicas_ids">
                        <div class="col-md-12 mt-3">
                            <h5 v-text="index"></h5>
                        </div>

                        <div class="col-sm-6 col-lg-3 col-md-3 py-2 d-flex" v-if="caracteristica_categoria" v-for="caract in caracteristica_categoria">
                            <i class="fa fa-check pt-2"></i> &nbsp; <span class="align-self-end pt-1" v-text="caract.caracteristica_nome"></span>
                            <div class="ps-1 align-self-start" v-if="caract.caracteristica_diferencial == 1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end descrição do condomínio -->

            <div class="row mt-5 pt-5 " v-if="imovel.imovel_latitude && imovel.imovel_longitude">
                <div v-if="imovel">
                    <div class="col-12 map">
                        <div class="container mb-5">
                            <h2>Conheça a vizinhança</h2>
                        </div>
                        <iframe :src="'https://maps.google.com/maps?q='+ imovel.imovel_latitude+','+imovel.imovel_longitude+'&hl=es;z=14&amp;output=embed'" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>


        <div class="toast text-bg-primary border-0 justify-content-center align-items-center  mx-auto " role="alert" aria-live="assertive" aria-atomic="true" id="toastSuccess">
            <div class="d-flex">
                <div class="toast-body">
                    Mensagem enviada com sucesso! Em breve entraremos em contato!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>


        <div class="toast text-bg-danger border-0 justify-content-center align-items-center  mx-auto " role="alert" aria-live="assertive" aria-atomic="true" id="toastError">
            <div class="d-flex">
                <div class="toast-body">
                    {{error}}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <?php if (!empty($data['config']->whatsNum)) : ?>
            <div class="whatsapp-button">
                <a target="_blank" :href="'https://api.whatsapp.com/send?phone=+55'+contato.config_site_telefone2+'&text=Olá, Gostaria de ter mais informações sobre o imóvel ' + imovel.imovel_titulo + ' Código ' + imovel.imovel_ref+' que encontrei no seu site'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                    </svg>
                </a>
            </div>
        <?php endif; ?>
        @(tema.components.novos.novos)

        @(tema.components.listBairros.listBairros)

        <modal-contato v-if="config" :contato="config"></modal-contato>


    </div>


    @(tema.components.footer.footer)


    <!-- <script src="${baseUri}/view/tema/assets/js/maskr/src/jquery.mask.js"></script> -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


    <script>
        const imovel_id = parseInt("<?= $data['imovel_id'] ?>");
        const {
            createApp
        } = Vue

        createApp({
            mixins: [mixinNews, mixinListBairros],
            data() {
                return {
                    imovel: null,
                    contato: null,
                    error: '',
                    config: JSON.parse('<?= json_encode($data['config_json']) ?>'),
                    formContato: {
                        nome: '',
                        telefone: '',
                        email: '',
                        mensagem: '',
                    }
                }
            },
            components: {
                CardImovel,
                CardImovelHorizontal,
                ModalContato
            },
            methods: {
                getIdImovel() {
                    return imovel_id;
                },

                toCurrency(value) {

                    value = Number(value).toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    });

                    return value.replace(',00', '')
                },


                async getDadosContato() {
                    try {
                        const response = await axios.get('${baseUri}/imovel/getDadosContato');
                        this.contato = response.data;
                    } catch (error) {
                        console.error(error);
                    }
                },

                async sendContact() {
                    $(".btn-send-contact").html("<i class='fa fa-refresh spin'></i> Enviando")
                    var toastSuccess = new bootstrap.Toast(document.getElementById('toastSuccess'));
                    var toastError = new bootstrap.Toast(document.getElementById('toastError'));
                    if (!this.formContato.nome || !this.formContato.telefone || !this.formContato.email || !this.formContato.mensagem) {
                        this.error = 'Todos os campos são obrigatórios!';
                        return toastError.show();
                    }
                    try {

                        var form = new FormData();

                        form.append('nome', this.formContato.nome);
                        form.append('telefone', this.formContato.telefone);
                        form.append('email', this.formContato.email);
                        form.append('mensagem', this.formContato.mensagem);
                        form.append('imovel_id', this.imovel.imovel_id);

                        const response = await axios.post('${baseUri}/imovel/sendContact', form);


                        if (response.status == 200) {
                            toastSuccess.show();
                            $(".btn-send-contact").html("Enviar")
                        }

                    } catch (error) {
                        console.error(error);
                        $(".btn-send-contact").html("Enviar")
                    }
                },


                async getImovel() {
                    let id = this.getIdImovel();
                    try {
                        const response = await axios.get('${baseUri}/imovel/getImovelById?id=' + id);
                        console.log(response)
                        this.imovel = response.data;

                        setTimeout(() => {
                            $('.imovel-slide').slick({
                                infinite: true,
                                slidesToShow: 4,
                                slidesToScroll: 3,
                                responsive: [{
                                        breakpoint: 1200,
                                        settings: {
                                            slidesToShow: 3,
                                            slidesToScroll: 3,
                                            centerMode: true,
                                        }
                                    },
                                    {
                                        breakpoint: 998,
                                        settings: {
                                            slidesToShow: 2,
                                            slidesToScroll: 1,
                                            centerMode: true,
                                        }
                                    },
                                    {
                                        breakpoint: 768,
                                        settings: {
                                            slidesToShow: 1,
                                            slidesToScroll: 1,
                                            centerMode: true,
                                        }
                                    },
                                    {
                                        breakpoint: 480,
                                        settings: {
                                            slidesToShow: 1,
                                            slidesToScroll: 1,
                                            variableWidth: true,
                                            centerMode: true,
                                        }
                                    },
                                ],


                                prevArrow: '<button class="slick-prev btn btn-primary" ><i class="fa fa-chevron-left" aria-hidden="true"></i></button>',
                                nextArrow: '<button class="slick-next btn btn-primary" ><i class="fa fa-chevron-right" aria-hidden="true"></i></button>'
                            });
                            /* glightbox
                             */


                            setTimeout(() => {
                                var glightbox = GLightbox({
                                    loop: true,
                                    selector: ".glightbox",
                                    openEffect: "zoom",
                                    closeEffect: "fade",
                                    closeOnOutsideClick: false,
                                    zoomable: true,
                                    height: "auto",
                                    width: "100vw",
                                    height: "100vh"
                                });
                            }, 500);



                        }, 500);



                    } catch (error) {
                        console.log("vish")
                        console.error(error);
                    }
                },
                copyText(text) {
                    var toastCopy = new bootstrap.Toast(document.getElementById('toastCopy'));
                    // Copy the text inside the text field
                    navigator.clipboard.writeText(text);
                    // return toastCopy.show();

                },
                getAddress() {
                    let address = '';

                    if (this.imovel.imovel_rua_view == 1 && this.imovel.imovel_rua) {
                        address += this.imovel.imovel_rua;
                    }


                    if (this.imovel.imovel_num_view == 1 && this.imovel.imovel_num) {
                        if (address != "") {
                            address += ", "
                        }
                        address += this.imovel.imovel_num;
                    }


                    if (this.imovel.imovel_bairro_view == 1 && this.imovel.imovel_bairro) {
                        if (address != "") {
                            address += ", "
                        }
                        address += this.imovel.imovel_bairro;
                    }


                    if (this.imovel.imovel_cidade_view == 1 && this.imovel.imovel_cidade) {
                        if (address != "") {
                            address += " - "
                        }
                        address += this.imovel.imovel_cidade;
                    }
                    if (this.imovel.imovel_uf_view == 1 && this.imovel.imovel_uf) {
                        if (address != "") {
                            address += " / "
                        }

                        address += this.imovel.imovel_uf;

                    }
                    return address;
                }
            },
            mounted() {
                this.getImovel();


                this.getDadosContato();



                setTimeout(() => {
                    const footer = document.querySelector('.label-price');
                    const meuSticky = document.querySelector('.meu-sticky');
                    meuSticky.style.height = `${$("#main").height() - 400}px`;

                    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
                    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))


                    this.formContato.mensagem = 'Olá, Gostaria de ter mais informações sobre o imóvel ' + this.imovel.imovel_titulo + ' Código ' + this.imovel.imovel_ref + ' que encontrei no seu site. Aguardo seu contato, obrigado(a)!';
                }, 1500);







            },
        }).mount('#main')

        window.onload = function() {
            $('.loading').hide()
        }
        $(document).ready(function($) {
            $('.phone_mask').mask('(00) 00000-0000');
        })
    </script>


</body>

</html>