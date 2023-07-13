<link href="${baseUri}/view/tema/components/formBannerPesquisa/form.css" rel="stylesheet">


<div class="row mt-5">
    <div class="col-12 hero">
        <h1 class="pb-2">
            ${config_site_title}
        </h1>
        <label class="pb-4 ">
            ${config_site_slogan}
        </label>
    </div>
    <div class="col-12">
        <div class="container">
            <div class="selector">
                <div class="selecotr-item">
                    <input type="radio" value="venda" id="radio1" name="negociation" class="selector-item_radio" checked>
                    <label for="radio1" class="selector-item_label">Comprar</label>
                </div>
                <div class="selecotr-item">
                    <input type="radio" value="aluguel" id="radio2" name="negociation" class="selector-item_radio">
                    <label for="radio2" class="selector-item_label">Alugar</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 py-2">
        <label for="exampleFormControlInput1" class="form-label">Pesquisar</label>
        <input class="form-control me-2" v-on:keyup.enter="searchImovel()" v-model="filtros.search" type="search" placeholder="Pesquise por Rua, Bairro, Condominio" aria-label="Search">
    </div>
    <div class="col-md-4 col-12 py-2">
        <label for="exampleFormControlInput1" class="form-label">Tipo de imóvel</label>
        <select class="form-select" v-model="filtros.type" v-on:keyup.enter="searchImovel()"  aria-label="Default select example">
            <option value="0">Selecione</option>
            <option v-for="typeImovel in types" :value="typeImovel.categoria_imovel_nome">{{typeImovel.categoria_imovel_nome}}</option>
        </select>
    </div>

    <div class="col-12 col-xl-2 col-md-2 col-lg-2 align-self-end mb-1 my-3 d-grid gap-2">
        <button type="button" @click="searchImovel()" class="btn btn-primary btn-lg mt-0">Buscar</button>
    </div>
</div>


<script>
    const mixinFormSearch = {
        data() {
            return {
                types: [],
                filtros: {
                    search: null,
                    negociation: null,
                    type: 0
                }
            }
        },
        methods: {

            searchImovel() {
                this.filtros.negociation = $('input[name="negociation"]:checked').val();
                let url = "${baseUri}/imovel/lista/?negociation=" + this.filtros.negociation;
                if(this.filtros.search) {
                    url += '&search=' + this.filtros.search;
                }
                if(this.filtros.type) {
                    url += '&type=' + this.filtros.type;
                }
                window.location.href = url;

            },

            async getTypesImoveis() {
                try {
                    const response = await axios.get('${baseUri}/imovel/getTypes');
                    this.types = response.data;
                } catch (error) {
                    console.error(error);
                }
            }
        },

        mounted() {
            this.getTypesImoveis()
        },
    }
</script>