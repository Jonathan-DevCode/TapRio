<style>
    .whatsapp-button {
        position: fixed;
        bottom: 0;
        right: 0;
        width: 70px;
        height: 70px;
        border-radius: 50px;
        background-color: green;
        color: white !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 999;
        margin-bottom: 30px;
        margin-right: 15px;
        -webkit-box-shadow: 5px 5px 35px -13px #000000;
        box-shadow: 5px 5px 35px -13px #000000;
    }

    .whatsapp-button a {
        color: white;
    }

    /* LGPD - COOKIES */

    .divModalCookie {
        justify-content: center;
    }

    @media screen and (max-width: 799px) {
        .modalCookie {
            position: fixed !important;
            bottom: 0px !important;
            font-size: 16px !important;
            background-color: #242424de !important;
            border-radius: 10px 10px 0px 0px !important;
            z-index: 1999 !important;
            width: 100% !important;
            height: 150px !important;
            vertical-align: middle !important;
            color: white !important;
            padding: 10px;
            text-align: center;
        }

        .btn-frete {
            width: 100% !important;
        }

        .hide-on-mobile {
            display: none !important;
        }

        .slide-topo-foto {
            height: 10rem !important;
        }

        #menu-superior-fixed {
            position: fixed !important;
            top: 0px !important;
            width: 100% !important;
            z-index: 999999;
        }

        .divs-menu {
            z-index: 9999999;
        }
    }

    @media screen and (min-width: 800px) {
        .modalCookie {
            position: fixed !important;
            bottom: 0px !important;
            font-size: 16px !important;
            background-color: #242424de !important;
            border-radius: 10px 10px 0px 0px !important;
            z-index: 1999 !important;
            width: 100% !important;
            height: 100px !important;
            vertical-align: middle !important;
            color: white !important;
            padding: 10px;
            text-align: center;
        }

        .hide-on-desk {
            display: none !important;
        }

        .slide-topo-foto {
            height: 22.86rem !important;
        }
    }
</style>
<div class="container footer texto-cor-primaria">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">

        <div class="col-12 col-sm-12 mb-4">
            <div class="row">
                <?php if (isset($data['paginasFooter']) && is_array($data['paginasFooter']) && sizeof($data['paginasFooter']) > 0) : ?>
                    <?php foreach ($data['paginasFooter'] as $pag) : ?>
                        <div class="col-12 col-sm-12 col-md-6 mb-2">
                            <!-- Paginas -->
                            <h5><?= $pag->categoria_pagina_nome ?></h5>
                            <?php if (isset($pag->paginas) && is_array($pag->paginas) && sizeof($pag->paginas) > 0) : ?>
                                <?php foreach ($pag->paginas as $pages) : ?>
                                    <div class="col-12 col-sm-12 mb-2">
                                        <a class="nav-link" href="<?= Http::base() ?>/pagina/<?= $pag->categoria_pagina_url ?>/<?= $pages->pagina_url ?>"><?= $pages->pagina_titulo ?></a>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <!-- FIm paginas -->
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-12 col-sm-12">
            <div class="row">
                <!-- Sobre a empresa -->
                <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 align-self-start">
                    <div class="widget pb-5">
                        <h4 class="widget-title custom_rodapeInformacoes_texto_no_hover pb-0">${config_site_title}</h4>
                        <p class="custom_rodapeInformacoes_texto_no_hover" style="text-align: justify;">
                            ${config_site_about}
                        </p>
                    </div>
                </div>
                <!-- Sobre a empresa -->


                <div class="col-12 col-md-6 align-self-start correct-icons" style="padding-left: 35px">

                    <div class="row link-cor-primaria">
                        <div class="col-12 col-sm-12 col-md-6">
                            <h5 class="widget-title pb-0">Setor Comercial</h5>

                            <?php if (isset($data['config']->config_site_email) && !empty($data['config']->config_site_email)) : ?>

                                <i class="fa fa-envelope"></i>
                                <span class="font-size-sm custom_rodapeInformacoes_texto">
                                    <a href="mailto:${config_site_email}">${config_site_email} </a>
                                </span>
                                <hr>
                            <?php endif; ?>

                            <?php if (isset($data['config']->config_site_telefone) && !empty($data['config']->config_site_telefone)) : ?>

                                <i class="fa fa-mobile"></i>
                                <span class="font-size-sm custom_rodapeInformacoes_texto">
                                    <a href="tel:+55<?= intval($data['config']->config_site_telefone_clean) ?>">${config_site_telefone} </a>
                                </span>
                                <hr>
                            <?php endif; ?>

                            <?php if (isset($data['config']->config_site_telefone2) && !empty($data['config']->config_site_telefone2)) : ?>

                                <i class="fab fa-whatsapp"></i>
                                <span class="font-size-sm custom_rodapeInformacoes_texto">
                                    <a target="_blank" href="https://api.whatsapp.com/send?phone=+55<?= $data['config']->whatsNum ?>&text=Olá,vim pelo site e gostaria de ter mais informações">
                                        ${config_site_telefone2}
                                    </a>
                                </span>
                                <hr>
                            <?php endif; ?>
                        </div>

                        <div class="col-12 col-sm-12 col-md-6">
                            <h5 class="widget-title pb-0">Setor Administrativo</h5>

                            <?php if (isset($data['config']->config_site_email_admin) && !empty($data['config']->config_site_email_admin)) : ?>

                                <i class="fa fa-envelope"></i>
                                <a href="mailto:${config_site_email_admin}">${config_site_email_admin} </a>
                                <hr>
                            <?php endif; ?>

                            <?php if (isset($data['config']->config_site_tel_admin) && !empty($data['config']->config_site_tel_admin)) : ?>

                                <i class="fa fa-mobile"></i>
                                <a href="tel:+55<?= intval($data['config']->config_site_tel_admin_clean) ?>">
                                    <span class="font-size-sm custom_rodapeInformacoes_texto">${config_site_tel_admin}</span>
                                </a>
                                <hr>
                            <?php endif; ?>

                            <?php if (isset($data['config']->config_site_whats_admin) && !empty($data['config']->config_site_whats_admin)) : ?>

                                <i class="fab fa-whatsapp"></i>
                                <a target="_blank" href="https://api.whatsapp.com/send?phone=+55<?= intval($data['config']->config_site_whats_admin_clean) ?>&text=Olá,vim pelo site e gostaria de ter mais informações">
                                    <span class="font-size-sm custom_rodapeInformacoes_texto">${config_site_whats_admin}</span>
                                </a>
                                <hr>
                            <?php endif; ?>
                        </div>
                    </div>


                    <?php if (isset($data['config']->config_site_funcionamento) && !empty($data['config']->config_site_funcionamento)) : ?>

                        <i class="fa fa-clock"></i>
                        <span class="font-size-sm custom_rodapeInformacoes_texto cor-link">${config_site_funcionamento}</span>
                        <hr>
                    <?php endif; ?>

                    <?php if (isset($data['config']->config_site_cep) && !empty($data['config']->config_site_cep)) : ?>
                        <b>
                            <i class="fa fa-map-marker"></i>
                            <span class="font-size-sm custom_rodapeInformacoes_texto cor-link">${config_site_rua}, nº ${config_site_num}, ${config_site_bairro} - ${config_site_cidade}, ${config_site_uf}. CEP ${config_site_cep}</span>
                        </b>
                        <hr>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <div class="col-12 mt-3 text-center texto-cor-secundaria">
            <?php if (!empty($data['config']->config_maps_embed_query)) : ?>
                <div class="widget pb-4">
                <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14688.809443261405!2d-43.478624!3d-23.016341!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9bdd4a48df1d87%3A0x923821bf3a049de!2sTap%20Rio!5e0!3m2!1spt-BR!2sbr!4v1680533252421!5m2!1spt-BR!2sbr" style="width: 100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
                    <iframe src="https://www.google.com/maps?q=+${config_maps_embed_query}&output=embed" style="width: 100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-12 col-sm-12 col-md-4 text-center cor-link">
            <a href="https://milesagencia.com.br" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1 cor-link">
                Feito com <i class="fa fa-heart"></i> pela <b>Miles Agência Criativa</b>
            </a>

        </div>

        <a class="col-6 col-sm-6 col-md-4 text-muted text-center text-decoration-none cor-link">© <?= date("Y") ?> ${config_site_title}</a>

        <ul class="nav col-6 col-sm-6 col-md-4 justify-content-end list-unstyled d-flex cor-link">
            <?php if (!empty($data['social']->rede_social_instagram)) : ?>
                <li class="ms-3">
                    <a target="_blank" href="<?= $data['social']->rede_social_instagram ?>">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                        </svg> -->
                        <i class="fab fa-instagram cor-link"></i>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!empty($data['social']->rede_social_facebook)) : ?>
                <li class="ms-3">
                    <a target="_blank" href="<?= $data['social']->rede_social_facebook ?>">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                        </svg> -->
                        <i class="fab fa-facebook cor-link"></i>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!empty($data['config']->whatsNum)) : ?>
                <li class="ms-3">
                    <a target="_blank" href="https://api.whatsapp.com/send?phone=+55<?= $data['config']->whatsNum ?>">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                        </svg> -->
                        <i class="fab fa-whatsapp cor-link"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </footer>
</div>
<!-- Modal cookie -->
<?php if (isset($data['config']->config_lgpd_texto) && !empty($data['config']->config_lgpd_texto)) : ?>
    <div class="divModalCookie" style="display: none;">
        <div class="modalCookie" id="#modalCookie">
            <?= $data['config']->config_lgpd_texto ?>
            <?php if (isset($data['config']->config_lgpd_link) && !empty($data['config']->config_lgpd_link)) : ?>
                <a target="_blank" href="<?= $data['config']->config_lgpd_link ?>" style="color: white; border-bottom: 1px solid white;">Mais informações.</a>
            <?php endif; ?>
            <br>
            <button class="btn btn-primary mar-top-10" id="btnCookie">Entendi</button>
        </div>
    </div>
<?php endif; ?>



${config_site_chat_code}

<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
<!-- <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script> -->
<!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.19/jquery.touchSwipe.min.js" ></script> -->
<script src="${baseUri}/view/tema/assets/js/jquery.js"></script>
<script src="${baseUri}/view/tema/assets/js/vue/vue.js"></script>
<script src="${baseUri}/view/tema/assets/js/axios.js"></script>
<script src="${baseUri}/view/tema/assets/js/touchSwipe.js"></script>
<script src="${baseUri}/view/tema/assets/js/glightbox.js"></script>
<script src="${baseUri}/view/tema/assets/js/bootstrap.js"></script>
<script src="${baseUri}/view/tema/assets/js/slick.js"></script>

<script src="${baseUri}/view/tema/assets/js/maskr/src/jquery.mask.js"></script>
<script>
    function showCookie() {
        if (!localStorage.getItem('cookiesAceitos')) {
            $(".divModalCookie").attr('style', 'display: block').fadeIn('slow');
        }
    }
    $("#btnCookie").click(() => {
        localStorage.setItem('cookiesAceitos', 'true');
        $(".divModalCookie").hide();
    })

    $(document).ready(function() {
        showCookie();
        $('.phone_mask').mask('(00) 00000-0000');
    })
</script>


<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> -->


<script type="text/javascript" src="${baseUri}/view/tema/components/components-vue/cardImovel.js"></script>

<script type="text/javascript" src="${baseUri}/view/tema/components/components-vue/cardImovelHorizontal.js"></script>
<script type="text/javascript" src="${baseUri}/view/tema/components/components-vue/modal-contato.js"></script>

