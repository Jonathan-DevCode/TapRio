<link href="${baseUri}/view/admin/assets/plugins/fontawesome-free/css/all.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />


<div class="container my-5 texto-cor-primaria">
    <div class="row">
        <div class="col-12 text-center py-5">
            <h1>Novidades</h1>
            <div class="divisor-title"></div>
        </div>

        <div class="novidade-slide">
            <card-imovel :base="'${baseUri}'" :type="'novos'" :contato="contato" v-for="newImovel in news" :imovel="newImovel"></card-imovel>
        </div>

    </div>
</div>






<script>
    const mixinNews = {
        data() {
            return {
                news: [],
                contato: {
                    config_site_telefone2: '${config_site_telefone2}',
                    config_site_telefone: '${config_site_telefone}'
                }
            }
        },



        methods: {

            getConfig() {

            },

            async getnews() {
                try {
                    const response = await axios.get('${baseUri}/imovel/getNews');
                    this.news = response.data;


                    setTimeout(() => {
                        $(document).ready(function() {
                            $('.images-card-slick-2').slick({
                                nextArrow: `<button v-if="imovel.imgs.length > 1" class="carousel-control-next" type="button">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span></button>`,
                                prevArrow: `<button v-if="imovel.imgs.length > 1" class="carousel-control-prev" type="button">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span></button>`,
                            });
                        });
                        $('.novidade-slide').slick({
                            infinite: true,
                            slidesToShow: 4,
                            dots: false,
                            slidesToScroll: 3,
                            centerMode: true,
                            nextArrow: '<button class="slick-next btn btn-primary mt-5" ><i class="fa fa-chevron-right" aria-hidden="true"></i></button>',
                            prevArrow: '<button class="slick-prev btn btn-primary mt-5" ><i class="fa fa-chevron-left" aria-hidden="true"></i></button>',
                            responsive: [{
                                    breakpoint: 1200,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 3,
                                    }
                                },
                                {
                                    breakpoint: 998,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 1,
                                    }
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1,
                                    }
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1,
                                        variableWidth: true
                                    }
                                },
                            ],



                        });
                    }, 500);

                } catch (error) {
                    console.error(error);
                }
            },

        },

        mounted() {
            this.getnews()
        },
    }
</script>