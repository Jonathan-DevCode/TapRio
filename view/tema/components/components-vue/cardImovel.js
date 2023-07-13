const CardImovel = {
  props: ['imovel', 'base', 'contato','type'],

  data() {
    return {
      hashImovel: Math.random() * 3,
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

      else
        return this.toCurrency(this.imovel.imovel_valor_venda) + " / " + this.toCurrency(this.imovel.imovel_valor_locacao)

    },
    getDescription() {

      if (this.imovel.imovel_desc)
        return '<p>' + this.imovel.imovel_desc.replace(/<.*?>/g, '').slice(0, 100) + ' ...</p>';

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

      if (this.imovel.imovel_isento_condominio == 0 && this.imovel.imovel_valor_condominio) {
        impostos += 'Cond. ' + '' + this.toCurrency(this.imovel.imovel_valor_condominio)
      }

      if (this.imovel.imovel_isento_condominio == 0 && this.imovel.imovel_valor_condominio && this.imovel.imovel_isento_iptu == 0 && this.imovel.imovel_valor_iptu) {

        impostos += ' &#8226; ';
      }

      if (this.imovel.imovel_isento_iptu == 0 && this.imovel.imovel_valor_iptu) {
        impostos += 'IPTU ' + '' + this.toCurrency(this.imovel.imovel_valor_iptu)
      }



      return impostos;

    },

    getCondominio() {
      return "Condominio <br>" +
      this.imovel.condominio_nome.length > 20 ? (this.imovel.condominio_nome.substring(0, 20) + "...") : this.imovel.condominio_nome +
      "</br>";
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


      return address;
    }
  },

  template: `<div>
  <div class="card main-card-imovel mx-2">


    <div class="images-card-slick" v-if="imovel.imgs  && type == 'destaques'">
      <div v-for="(img, indexImg) in imovel.imgs">
        <a :href="base+'/imovel/ver/'+imovel.imovel_id" target="_blank">
          <img :src="base+'/media/imovel/thumb_'+ img.foto_imovel_img" alt="..."
            style="border-radius:0px;height:250px;width: 100%;object-fit: cover;">
        </a>
      </div>

      <div class="carousel-item">
        <a :href="base+'/imovel/ver/'+imovel.imovel_id" target="_blank">
          <img :src="base+'/media/imovel/thumb_'+ imovel.imgs[0].foto_imovel_img" alt="..."
            style="border-radius:0px;height:250px;width: 100%;object-fit: cover;">
          <div class="see-more text-center">
            <small>
              Ver mais
            </small>
          </div>
        </a>
      </div>
    </div>

    <div class="images-card-slick-2" v-if="imovel.imgs && type == 'novos'">
      <div v-for="(img, indexImg) in imovel.imgs">
        <a :href="base+'/imovel/ver/'+imovel.imovel_id" target="_blank">
          <img :src="base+'/media/imovel/thumb_'+ img.foto_imovel_img" alt="..."
            style="border-radius:0px;height:250px;width: 100%;object-fit: cover;">
        </a>
      </div>

      <div class="carousel-item">
        <a :href="base+'/imovel/ver/'+imovel.imovel_id" target="_blank">
          <img :src="base+'/media/imovel/thumb_'+ imovel.imgs[0].foto_imovel_img" alt="..."
            style="border-radius:0px;height:250px;width: 100%;object-fit: cover;">
          <div class="see-more text-center">
            <small>
              Ver mais
            </small>
          </div>
        </a>
      </div>
    </div>

    <a v-if="!imovel.imgs" :href="base+'/imovel/ver/'+imovel.imovel_id" target="_blank">
      <img src="https://archive.org/download/no-photo-available/no-photo-available.png" class="card-img-top" alt="...">
    </a>

    <div class="card-body texto-cor-primaria correct-icons" style="position: relative;">
      <a :href="base+'/imovel/ver/'+imovel.imovel_id" target="_blank">

        <div class="text-break title-card-imovel">
          <h6 class="card-title" v-html="getTitle()"></h6>
        </div>

        <h4 class="card-title" v-html="getPrice()"></h4>
        <div>
          <div class="label-price mt-0 text-break" style="font-size:15px; height:20px;" v-html="getImpostos()"></div>

          <div class="address-imovel-card">
            <div class="address"><label v-html="getAddress()"></label></div>

          </div>
          <div style="height:30px">
            <i v-if="imovel.condominio_nome" class="fa fa-building" aria-hidden="true"></i> &nbsp;
            <small v-if="imovel.condominio_nome" v-html="getCondominio()"></small>
          </div>


        </div>
        <div>
          <div class="d-flex gap-3 icons-card justify-content-center" style="height:40px;">
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
      <div class="d-flex gap-3 links-card">

        <a :href="'tel:'+contato.config_site_telefone" class="btn" v-if="contato">Telefone</a>
        <a v-if="contato" target="_blank" class="btn btn-primary"
          :href="'https://api.whatsapp.com/send?phone=+55'+contato.config_site_telefone2+'&text=Olá, Gostaria de ter mais informações sobre o imóvel ' + imovel.imovel_titulo + ' Código ' + imovel.imovel_ref+' que encontrei no seu site'">WhatsApp</a>

      </div>

    </div>

  </div>

</div>`
}