<link href="${baseUri}/view/tema/components/listBairros/listBairros.css" rel="stylesheet">

<div class="container px-3 list-bairros texto-cor-primaria">
    <div class="text-center pb-5">
        <h3>Explore e Descubra</h3>
        <div class="divisor-title"></div>
    </div>


    <div class="row">
        <!-- <div class="col-12 text-center py-5">
            <h5>Bairros</h5>
            <div class="divisor-title"></div>
        </div> -->
        <div class="row">
            <div class="col-md-12 col-12 my-3" v-for="(cidade,key) in bairros">
                <h5>{{key}}</h5>
                <div class="row">
                    <div class="col-md-3 col-12 list-group-item link-cor-primaria" v-for="bairro in cidade">
                        <a :href="'${baseUri}/imovel/lista?location=' + bairro+'&negociation=venda'">{{bairro}}</a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-md-12 col-12 my-3">
                <h5>Condomínios</h5>
                <div class="row">
                    <div class="col-12 col-md-3 list-group-item link-cor-primaria" v-for="cond in condominios">
                        <a :href="'${baseUri}/imovel/lista?condominio=' + cond.condominio_id">{{cond.condominio_nome}}</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- 
<div class="container px-3 list-bairros">
    <div class="row">
        <div class="col-12 text-center py-5">
            <h4>Condomínios</h4>
            <div class="divisor-title"></div>
        </div>
        <div class="slide-condominios my-3">

            <div class="condominio-circle" v-for="cond in condominios">
                <a :href="'${baseUri}/imovel/lista?condominio=' + cond.condominio_id">
                    <img v-if="cond.foto_condominio_img" :src="'${baseUri}/media/condominio/thumb_'+cond.foto_condominio_img" />
                    <img v-else src="https://archive.org/download/no-photo-available/no-photo-available.png" />
                    <h6>{{cond.condominio_nome}}</h6>
                </a>
            </div>
        </div>
    </div>
</div> -->



<script>
    const mixinListBairros = {
        data() {
            return {
                bairros: []
            }
        },
        methods: {
            async getCities() {
                try {
                    const response = await axios.get('${baseUri}/imovel/getCitiesNeighbor');
                    this.bairros = response.data;


                } catch (error) {
                    console.error(error);
                }
            },
            async getCondominios() {
                try {
                    const response = await axios.get('${baseUri}/imovel/getCondominios');
                    this.condominios = response.data;

                    // setTimeout(() => {
                    //     $('.slide-condominios').slick({
                    //         infinite: false,
                    //         slidesToShow: 5,
                    //         dots: true,
                    //         slidesToScroll: 3,
                    //         prevArrow: '<button class="slick-prev btn btn-primary" ><i class="fa fa-chevron-left" aria-hidden="true"></i></button>',
                    //         nextArrow: '<button class="slick-next btn btn-primary" ><i class="fa fa-chevron-right" aria-hidden="true"></i></button>',

                    //         responsive: [{
                    //                 breakpoint: 1024,
                    //                 settings: {
                    //                     slidesToShow: 5,
                    //                     slidesToScroll: 5,

                    //                 }
                    //             },
                    //             {
                    //                 breakpoint: 600,
                    //                 settings: {
                    //                     slidesToShow: 3,
                    //                     slidesToScroll: 3,
                    //                     dots: true,
                    //                     centerMode: true,
                    //                 }
                    //             },
                    //             {
                    //                 breakpoint: 480,
                    //                 settings: {
                    //                     slidesToShow: 1,
                    //                     slidesToScroll: 1,
                    //                     dots: true,
                    //                     centerMode: true,

                    //                 }
                    //             }

                    //         ],
                    //     });
                    // }, 500);

                } catch (error) {
                    console.error(error);
                }
            }
        },

        mounted() {
            this.getCities();
            this.getCondominios();
        },
    }
</script>