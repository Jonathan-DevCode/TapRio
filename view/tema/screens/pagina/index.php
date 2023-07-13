<!doctype html>
<html lang="pr-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} - <?= $data['pagina']->categoria_pagina_nome ?> - <?= $data['pagina']->pagina_titulo ?></title>
    @(tema.components.header.assets)
    <meta property="og:title" content="${config_site_title} - <?= $data['pagina']->categoria_pagina_nome ?> - <?= $data['pagina']->pagina_titulo ?>">
    <meta property="og:description" content="${pagina_desc}">
    <meta property="og:keywords" content="${pagina_keywords}">
    <meta property="og:url" content="${baseUri}/<?= $data['pagina']->categoria_pagina_nome ?>/<?= $data['pagina']->pagina_titulo ?>">
    <meta property="og:image" content="${baseUri}/media/pagina/${pagina_capa}">

    <link href="${baseUri}/view/tema/screens/imovel/imovel.css" rel="stylesheet">
    <link href="${baseUri}/view/admin/assets/plugins/fontawesome-free/css/all.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

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
    </style>

    @(tema.components.header.header)
    <div id="main">
        <div class="loading">
            
            <img src="${baseUri}/media/site/${config_site_logo}" class="img-loading">
        </div>
        <div>
            <?php if (isset($data['pagina']) && !empty($data['pagina'])) : ?>
                <section class="py-2 py-md-2">
                    <div style="margin-top: 100px;">
                        <div class="texto-cor-primaria">
                            <?php if (isset($data['pagina']->pagina_capa) && !empty($data['pagina']->pagina_capa)) : ?>
                                <div class="position-center text-center">
                                    <img class="card-img-top" src="${baseUri}/media/pagina/${pagina_capa}" alt="Card image" style="border-radius: 5px; width: 50vw !important;">
                                    <div class="card-img-overlay"></div>
                                </div>
                                <div class="card-body border-top-5 border-danger p-3 p-md-5">
                            <?php else : ?>
                                <div class="card-body p-3 p-md-5" style="margin-bottom: 50px;">
                            <?php endif; ?>
                            <br><br>
                            <div class="section-title justify-content-center mb-4 mb-md-8 wow fadeInUp text-center texto-cor-primaria">
                                <span class="shape shape-left bg-info"></span>
                                <h2 class="text-primary custom_loja_texto">${pagina_titulo}</h2>
                                <span class="shape shape-right bg-info"></span>
                            </div>
                        ${pagina_texto}
                        </div>
                    </div>
                </div>
                </section>
            <?php else : ?>
                <h2 class="text-primary text-center">Nenhuma página encontrada</h2>
            <?php endif; ?>


        </div>
    </div>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <script>
        setTimeout(function() {
            $(".loading").hide();
        }, 1000)
    </script>
</body>

</html>