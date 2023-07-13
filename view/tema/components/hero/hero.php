<link href="${baseUri}/view/tema/components/hero/hero.css" rel="stylesheet">

<div class="row ">
    <div class="col-4 d-none d-lg-block">
        <div class="imagens-top">
            <div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" v-for="banner in banners">
                        <img :src="'${baseUri}/media/slides/'+ banner.slide_img" class="d-block w-100" alt="...">
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8 col-xl-8 col-md-12 mt-5 pt-5 ">
        @(tema.components.formBannerPesquisa.form)
    </div>
</div>

<script>
    const mixinHero = {
        data() {
            return {
                banners: [],
            }
        },
        methods: {

            async getBanner() {
                try {
                    const response = await axios.get('${baseUri}/imovel/getSlide');
                    this.banners = response.data;
                } catch (error) {
                    console.error(error);
                }
            }

        },

        mounted() {
            this.getBanner()
        },
    }
</script>