<!doctype html>
<html lang="pr-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title}</title>
    <!-- SEO -->
    @(tema.components.partials_seo.meta_tags)
    @(tema.components.partials_seo.og_tags)
    <!-- SEO -->

    @(tema.components.header.assets)
    <link href="${baseUri}/view/admin/assets/plugins/fontawesome-free/css/all.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <link href="${baseUri}/view/tema/screens/home/index.css" rel="stylesheet">

    <style>
        body {
            font-family: fontAwesome !important;
        }
    </style>

    <style>
    .espaco-superior {
        margin-top: 50px;
    }
    .espaco-meio {
        margin-top: 30px;
    }
    .espaco-baixo {
        margin-top: 30px;
    }
    </style>

</head>

<body>

    <!-- SEO -->
    @(tema.components.partials_seo.google_analytics)
    @(tema.components.partials_seo.google_tag_manager)
    <!-- SEO -->

    @(tema.components.header.header)


    <div class="loading">
        <img src="${baseUri}/media/site/${config_site_logo}" class="img-loading">
    </div>
    <div id="main">
        <div id="carouselExampleIndicators" class="carousel slide mt-5" v-if="bannersMiddle">
            <div class="carousel-indicators">
                <button type="button" v-for="(banner,index) in bannersMiddle" data-bs-target="#carouselExampleIndicators" :data-bs-slide-to="index" class="active" aria-current="true" aria-label="Slide 1"></button>

            </div>
            <div class="carousel-inner">
                <div class="carousel-item middle " v-for="(banner,index) in bannersMiddle" :class="index == 0 ? 'active' : '' ">
                    <img :src="'${baseUri}/media/slides/'+banner.slide_img" class="d-block w-100" alt="..." style="object-fit:contain;">
                </div>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="container texto-cor-primaria" :class="bannersMiddle ? 'mt-5' : 'mt-5 pt-5'" style="margin-top: 50px;">
            <form action="${baseUri}/imovel/salvar_anuncio" method="POST">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h3>Oferecemos serviços completos de aluguel e administração de imóveis. Você já nos encontrou e agora pode contar conosco para cuidar de tudo. Nossa equipe especializada está pronta para tornar o processo simples e eficiente. </h3>
                    </div>
                    <div class="espaco-meio text-center">
                        <p>Agradecemos seu interesse em nossos serviços. Por favor, preencha o pré-cadastro abaixo e deixe seu imóvel em nossas mãos. Na Tap Rio, garantimos que você desfrutará da tranquilidade e do profissionalismo que só nós podemos oferecer.</p>
                    </div>

                    <div class="col-sm-12 mt-3">
                        <hr>
                        <h4>Dados para contato</h4>
                    </div>

                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-3">
                        <div class="form-group">
                            <label for="">Nome</label>
                            <input type="text" class="form-control" name="imovel_proprietario_nome" required>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-3">
                        <div class="form-group">
                            <label for="">Telefone</label>
                            <input type="text"  class="form-control cel" inputmode="numeric" name="imovel_proprietario_telefone" required>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-3">
                        <div class="form-group">
                            <label for="">E-mail</label>
                            <input type="email" class="form-control"  name="imovel_proprietario_email">
                        </div>
                    </div>


                    <div class="col-sm-12 mt-3 mb-3">

                        <h4>Dados do imóvel</h4>
                    </div>

                    <div class="col-12 col-sm-12 col-md-3 col-lg-4 mt-3">
                        <div class="form-group">
                            <label for="">Tipo de imóvel</label>
                            <input type="submit" disabled style="display: none" aria-hidden="true" />
                            <select id="" class="form-control" name="imovel_categoria">
                                <?php if (isset($data['categorias'][0])) : ?>
                                    <?php foreach ($data['categorias'] as $cat) : ?>
                                        <option value="<?= $cat->categoria_imovel_id ?>"><?= $cat->categoria_imovel_nome ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>


                    <input type="hidden" name="imovel_tipo_negociacao" value="aluguel">
                    <input type="hidden" name="imovel_site_type" value="administracao">
                    <input type="hidden" name="imovel_proprietario_obs" value="Deseja que seja feita a administração de seu imóvel através da ${config_site_title}">

                    <div class="col-12 col-sm-12 col-md-1 col-lg-2 mt-3">
                        <div class="form-group">
                            <label for="">Quartos</label>
                            <input type="number" class="form-control" name="imovel_quartos">
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-1 col-lg-2 mt-3">
                        <div class="form-group">
                            <label for="">Suítes</label>
                            <input type="number" class="form-control" name="imovel_suites">
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-1 col-lg-2 mt-3">
                        <div class="form-group">
                            <label for="">Banheiros</label>
                            <input type="number" class="form-control" name="imovel_banheiros">
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-1 col-lg-2 mt-3">
                        <div class="form-group">
                            <label for="">Vagas</label>
                            <input type="number" class="form-control" name="imovel_vagas">
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-2 mt-3">
                        <div class="form-group">
                            <label for="">CEP</label>
                            <input type="text" class="form-control cep" maxlength="8" oninput="handleZipCode(event)" inputmode="numeric"  name="imovel_cep">

                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-3">
                        <div class="form-group">
                            <label for="">Rua</label>
                            <input type="text" class="form-control rua" onkeyup="handleZipCode(event)" name="imovel_rua">
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-2 mt-3">
                        <div class="form-group">
                            <label for="">Nº</label>
                            <input type="number" class="form-control num" name="imovel_num">
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-3">
                        <div class="form-group">
                            <label for="">Complemento</label>
                            <input type="text" class="form-control" name="imovel_complemento">
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-3">
                        <div class="form-group">
                            <label for="">Bairro</label>
                            <input type="text" class="form-control bairro" name="imovel_bairro">
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-3">
                        <div class="form-group">
                            <label for="">Cidade</label>
                            <input type="text" class="form-control cidade" name="imovel_cidade">
                        </div>
                    </div>


                    <div class="col-12 col-sm-12 mt-3">
                        <button class="espaco-baixo btn btn-primary w-100"><i class="fa fa-check"></i> Enviar imóvel para análise</button>
                    </div>
                    <div class="espaco-superior text-center">

                        <h3>
<p>Alugamos seu imóvel, nós cuidaremos de todos os aspectos, desde a divulgação, seleção de potenciais inquilinos, elaboração de contratos e até mesmo a gestão da locação. Nossa equipe se encarregará de realizar visitas, analisar documentos e oferecer suporte completo ao longo de todo o processo.</p>

<p>Na Tap Rio, nosso objetivo é proporcionar uma experiência tranquila e profissional, independentemente de você optar pela venda ou aluguel do seu imóvel. Entre em contato conosco para obter mais informações e dar o próximo passo rumo ao sucesso na negociação do seu imóvel.</p>
                        </h3>

</div>


                </div>
            </form>
        </div>
    </div>

    <div id="modal-sucesso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <i class="text-success fa-4x fa fa-check-circle"></i>
                        <br><br>
                        <h4>Sucesso!</h4>
                        <p>Seu imóvel foi enviado para a nossa equipe e em breve entraremos em contato. Muito obrigado pela confiança!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($data['config']->whatsNum)) : ?>
    <div class="whatsapp-button">
        <a target="_blank" href="https://api.whatsapp.com/send?phone=+55<?= $data['config']->whatsNum ?>&text=Olá, vim pelo site, gostaria de ter mais informações sobre alugar e administrar meu imóvel">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
            </svg>
        </a>
    </div>
<?php endif; ?>

    @(tema.components.footer.footer)
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script></script>

    <script>
        const handleZipCode = (event) => {
        let input = event.target
        input.value = zipCodeMask(input.value)
}

        const zipCodeMask = (value) => {
        if (!value) return ""
        value = value.replace(/\D/g,'')
        value = value.replace(/(\d{5})(\d)/,'$1-$2')
        return value
}

        window.onload = function() {
            $('.loading').hide()
        }
        $(document).ready(function() {
            $(".money").mask('000.000.000.000.000,00', {
                reverse: true
            });
            $(".year").mask("9999");
            $(".cep").mask("99999-999");
            $(".cel").mask("(99) 99999-9999");

            $(".cep").on("change", function() {
                const cep = $(this).val();
                $('.rua').val("...");
                $('.bairro').val("...");
                $('.cidade').val("...");
                $('.uf').val("...");
                var url = '//viacep.com.br/ws/' + cep + '/json/';
                $.getJSON(url).then(function(rs) {
                    if (rs.erro) {
                        //
                    } else {
                        $('.rua').val(rs.logradouro);
                        $('.bairro').val(rs.bairro);
                        $('.cidade').val(rs.localidade);
                        $('.uf').val(rs.uf);
                        $('.uf').trigger('change');
                        $('.num').focus();
                    }
                });
            })

            if (window.location.href.indexOf("success=1") != -1) {
                $("#modal-sucesso").modal("show");
            }
        })

        const {
            createApp
        } = Vue

        createApp({
                data() {
                    return {
                        pageready: false,
                        bannersMiddle: [],
                        config: JSON.parse('<?= json_encode($data['config_json']) ?>')
                    }
                },

                mounted() {
                    setTimeout(() => {
                        this.getBannerMiddle();
                        this.pageready = true;

                    }, 1500);
                },

                methods: {

                    async getBannerMiddle() {
                        try {
                            const response = await axios.get('${baseUri}/imovel/getSlideAdministracao');
                            this.bannersMiddle = response.data;
                        } catch (error) {
                            console.error(error);
                        }
                    }

                },
            })

            .mount('#main')
        // createApp
    </script>

</body>

</html>