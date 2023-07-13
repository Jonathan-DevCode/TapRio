const CardImovelHorizontal = {
  props: ['imovel', 'base', 'contato'],

  data() {
    return {
      hashImovel: Math.random() * 3,
      error: '',
      showForm: true,
      formContato: {
        nome: '',
        telefone: '',
        email: '',
        mensagem: '',
      }
    }
  },


  mounted(){
    $(".carousel").swipe({
      swipe: function (event, direction, distance, duration, fingerCount, fingerData) {
          console.log(direction)
          if (direction == 'left') $(this).carousel('next');
          if (direction == 'right') $(this).carousel('prev');
      },
      allowPageScroll: "vertical"
  });
  },

  methods: {
    toCurrency(value) {

      value = Number(value).toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
      });

      return value.replace(',00', '')
    },


    getPrice() {
      if (this.imovel.imovel_temporada == 1)
        return this.toCurrency(this.imovel.imovel_valor_locacao) + '<small class="label-price">/dia</small>'

      if (this.imovel.imovel_tipo_negociacao == 'aluguel')
        return this.toCurrency(this.imovel.imovel_valor_locacao) + '<small class="label-price">/mês</small>'

      if (this.imovel.imovel_tipo_negociacao == 'venda')
        return this.toCurrency(this.imovel.imovel_valor_venda)

      // venda e aluguel
      let valor_venda_return = [];

      if(this.imovel.imovel_valor_venda) {
        valor_venda_return.push(this.toCurrency(this.imovel.imovel_valor_venda));
      }

      if(this.imovel.imovel_valor_locacao) {
        valor_venda_return.push(this.toCurrency(this.imovel.imovel_valor_locacao));
      }

      return valor_venda_return.join(" / ");
    },
    getDescription() {

      if (this.imovel.imovel_desc)
        return '<p>' + this.imovel.imovel_desc.replace(/<.*?>/g, '').slice(0, 100) + '</p>';

      else
        return '<p>&nbsp;</p>'
    },

    getTitle() {
      if (this.imovel.imovel_titulo)
        return this.imovel.imovel_titulo;

      else
        return '<p>&nbsp;</p>'
    },

    getImpostos() {

      let impostos = '';

      if (this.imovel.imovel_isento_condominio == 0 && this.imovel.imovel_valor_condominio != null) {
        impostos += 'Cond. ' + '' + this.toCurrency(this.imovel.imovel_valor_condominio)
      }


      if (this.imovel.imovel_isento_iptu == 0 && this.imovel.imovel_valor_iptu != null && this.imovel.imovel_isento_condominio == 0 && this.imovel.imovel_valor_condominio != null) {
        impostos += ' &#8226; '
      }


      if (this.imovel.imovel_isento_iptu == 0 && this.imovel.imovel_valor_iptu != null) {
        impostos += 'IPTU ' + '' + this.toCurrency(this.imovel.imovel_valor_iptu)
      }


      return impostos;

    },

    getAddress() {
      let address = '';

      if (this.imovel.imovel_rua_view == 1 && this.imovel.imovel_rua) {
        address += this.imovel.imovel_rua;
      }


      if (this.imovel.imovel_num_view == 1 && this.imovel.imovel_num) {
        if(address != "") {
          address += ", "
        }
        address += this.imovel.imovel_num;
      }


      if (this.imovel.imovel_bairro_view == 1 && this.imovel.imovel_bairro) {
        if(address != "") {
          address += ", "
        }
        address += this.imovel.imovel_bairro;
      }


      if (this.imovel.imovel_cidade_view == 1 && this.imovel.imovel_cidade) {
        if(address != "") {
          address += " - "
        }
        address += this.imovel.imovel_cidade;
      }
      if (this.imovel.imovel_uf_view == 1 && this.imovel.imovel_uf) {
        if(address != "") {
          address += " / "
        }

        address += this.imovel.imovel_uf;

      }


      if (address.length > 60) {
        address = address.substring(0, 60) + "...";
      }
      return address;
    }
  },

  template: `
  <div>
  <div class="card">
      <div class="row align-items-center py-0 my-0">
          <div class="col-md-4 py-0 my-0">
              <div :id="'carouselExampleSlidesOnly'+imovel.imovel_id" v-if="imovel.imgs" class="carousel slide">
                  <div class="carousel-inner">
                      <div v-for="(img, indexImg) in imovel.imgs" class="carousel-item" :ttr-slide="indexImg"
                          :class="indexImg == 0 ? 'active' : '' ">
                          <a :href="base+'/imovel/ver/'+imovel.imovel_id" target="_blank">
                              <img :src="base+'/media/imovel/thumb_'+ img.foto_imovel_img"
                                  style="width: 365px; height:245px;object-fit: cover;" alt="...">
                          </a>
                      </div>

                      <div class="carousel-item">
                        <a :href="base+'/imovel/ver/'+imovel.imovel_id" target="_blank" >
                          <img :src="base+'/media/imovel/thumb_'+ imovel.imgs[0].foto_imovel_img" alt="..."  style="width: 365px; height:245px;object-fit: cover;" >
                          <div class="see-more text-center w-100">
                            <small>
                              Ver mais
                            </small>
                          </div>
                        </a>
                      </div>
                  </div>
                  <button v-if="imovel.imgs.length > 1" class="carousel-control-prev" typimovele="button"
                      :data-bs-target="'#carouselExampleSlidesOnly'+ imovel.imovel_id" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                  </button>
                  <button v-if="imovel.imgs.length > 1" class="carousel-control-next" type="button"
                      :data-bs-target="'#carouselExampleSlidesOnly'+imovel.imovel_id" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                  </button>
              </div>
              <a v-else :href="base+'/imovel/ver/'+imovel.imovel_id" target="_blank">
                  <img src="https://archive.org/download/no-photo-available/no-photo-available.png"
                      class="card-img-top" alt="...">
              </a>
          </div>
          <div class="col-md-8 py-0 my-0">
              <div class="card-body">

                  <div class="row texto-cor-primaria correct-icons">
                    <a :href="base+'/imovel/ver/'+imovel.imovel_id" target="_blank">
                      <div class="col-12 texto-cor-primaria ">
                          <p class="text-muted fw-bold">
                            {{imovel.imovel_titulo}}

                          </p>
                          <h4 v-html="getPrice()" class="m-0"></h4>
                          <small class="label-price m-0 pt-0" style="font-size:15px;" v-html="getImpostos()"></small>

                      </div>

                      <div class="my-2" v-html="getAddress()">

                      </div>
                      <small v-if="imovel.condominio_nome"><i class="fa fa-building"></i> Condomínio <b>{{ imovel.condominio_nome }}</b></small>
                    </a>
                      <div class="col-6 pt-2">
                          <a :href="base+'/imovel/ver/'+imovel.imovel_id" target="_blank">
                              <div>
                                  <div class="d-flex gap-3 icons-card">
                                    <div v-if="imovel.imovel_area_util">
                                        <i class="fa fa-clone" aria-hidden="true"></i> &nbsp;
                                        <small v-html="imovel.imovel_area_util"> m² </small>
                                    </div>
                                    <div v-if="imovel.imovel_quartos">
                                        <i class="fa fa-bed" aria-hidden="true"></i> &nbsp;
                                        <small v-html="imovel.imovel_quartos"> </small>
                                    </div>
                                    <div v-if="imovel.imovel_banheiros">
                                        <i class="fa fa-bath" aria-hidden="true"></i> &nbsp;
                                        <small v-html="imovel.imovel_banheiros"> </small>
                                    </div>
                                    <div v-if="imovel.imovel_vagas">
                                        <i class="fa fa-car" aria-hidden="true"></i> &nbsp;
                                        <small v-html="imovel.imovel_vagas"> </small>
                                    </div>

                                  </div>
                              </div>
                          </a>
                      </div>

                      <div class="col-6 align-self-end text-end justify-content-end float-right">
                          <div class=" col-price  text-end float-end me-2">
                          <a class="btn btn-primary text-white" v-if="contato" target="_blank"
                          :href="'https://api.whatsapp.com/send?phone=+55'+contato.config_site_telefone2+'&text=Olá, Gostaria de ter mais informações sobre o imóvel ' + imovel.imovel_titulo + ' Código ' + imovel.imovel_ref+' que encontrei no seu site'">WhatsApp</a>
                          </div>


                          <div class=" col-price  text-end float-end me-2">
                              <a :href="'tel:'+contato.config_site_telefone" class="btn btn-primary-outline" >Telefone</a>
                          </div>

                      </div>
                  </div>

              </div>
          </div>
      </div>

  </div>

</div>
`
}