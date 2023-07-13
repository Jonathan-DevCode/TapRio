<link href="${baseUri}/view/admin/assets/plugins/fontawesome-free/css/all.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />


<div class="container my-5 texto-cor-primaria">
    <div class="row">
        <div class="col-12 text-center py-5">
            <div class="d-sm-block d-md-none"><br><br><br></div>
            <h1>Destaques</h1>
            <div class="divisor-title"></div>
        </div>

        <div class="destaque-slide ">
            <card-imovel v-if="highlights" :contato="contato" :type="'destaques'" :imovel="hightlight" :base="'${baseUri}'" v-for="hightlight in highlights"></card-imovel>
        </div>

    </div>
</div>



<script>
    const mixinHighlights = {
        data() {
            return {
                highlights: [],
                contato: {
                    config_site_telefone2: '${config_site_telefone2}',
                    config_site_telefone: '${config_site_telefone}'
                }
            }
        },

        methods: {

            async getHighlights() {
                try {
                    const response = await axios.get('${baseUri}/imovel/getHighlights');
                    this.highlights = response.data;



                    setTimeout(() => {
                        $(document).ready(function() {
                            $('.images-card-slick').slick({
                                nextArrow: `<button v-if="imovel.imgs.length > 1" class="carousel-control-next" type="button">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span></button>`,
                                prevArrow: `<button v-if="imovel.imgs.length > 1" class="carousel-control-prev" type="button">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span></button>`,
                            });
                        });
                        $('.destaque-slide').slick({
                            infinite: true,
                            slidesToShow: 4,
                            dots: false,
                            slidesToScroll: 3,
                            centerMode: true,
                            nextArrow: '<button class="slick-next btn btn-primary  mt-5" ><i class="fa fa-chevron-right" aria-hidden="true"></i></button>',
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
            }

        },

        mounted() {

            this.getHighlights()
        },
    }
</script>