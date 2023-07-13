<div class="row">
    <div class="col-sm-12">
        <h4 class="mb-5">Adicione fotos ao imóvel <small style="float: right;">(Resolução ideal: 864x540)</small> </h4>

        <div class="fallback dropzone" id="form-galeria-img">

        </div>

    </div>
</div>
<br><br>
<div class="row align-items-center">
    <div class="col-lg-6 col-md-6 col-sm-12 pb-4">

        <h2>Fotos do imóvel</h2>
        <br>

        <label>
            <i class="fa fa-info-circle"></i> Arraste para ordenar
        </label>

    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 text-lg-right">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 mb-2" v-if="data_remove">
                <a id="btn-rotaciona-img" v-show="selected == true" v-on:click="show_rotaciona_img()" class="btn btn-block btn-info waves-effect waves-light text-white menu-access">
                    <i class="fa fa-repeat"></i> Rotacionar selecionadas <span v-if="data_remove.length > 0">({{ data_remove.length }})</span>
                </a>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 mb-2" v-if="data_remove">
                <a id="btn-remove-img" v-show="selected == true" v-on:click="remove_img()" class="btn btn-block btn-warning waves-effect waves-light text-white menu-access">
                    <i class="fa fa-trash"></i> Remover selecionadas <span v-if="data_remove.length > 0">({{ data_remove.length }})</span>
                </a>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 mb-2" v-if="galerias">
                <a id="remove-all" data-target="#modal-remove-all" v-show="remove_a" data-toggle="modal" class="btn btn-block btn-danger waves-effect waves-light text-white menu-access">
                    <i class="fa fa-trash"></i> Remover todas <span v-if="galerias.length > 0">({{ galerias.length }})</span>
                </a>
            </div>


        </div>
        <h6 class="float-right">
        </h6>
    </div>
</div>
<div id="">
    <div class="row el-element-overlay" id="sort" v-if="galerias != null">
        <div class="col-lg-2 col-md-4 col-sm-6 col-4" v-for="gale in galerias" :id="'foto-galeria-'+gale.foto_imovel_id" :data-id="gale.foto_imovel_id" :data-position="gale.foto_imovel_pos" style="    text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;">
            <button type="button" class="btn-custom-checkbox" v-on:click="add_class_remove(gale)" :id="'foto-check-'+gale.foto_imovel_id" :data-id="gale.foto_imovel_id" :data-url="gale.foto_imovel_url" :data-remove="gale.foto_imovel_id" :data-position="gale.foto_imovel_pos"><i class="fa fa-check"></i></button>
            <div class="cardX">
                <div class="el-card-item">
                    <div class="el-card-avatar el-overlay-1 border-default" :id="'img-galeria-id-'+gale.foto_imovel_id" :data-url="gale.foto_imovel_url" :data-remove="gale.foto_imovel_id">
                        <a class="image-popup-vertical-fit" :id="'btn-galeria-id-'+gale.foto_imovel_id" :data-title="createButtonRotaciona(gale)" data-lightbox="img" :href="'<?= Http::base() ?>/media/imovel/watermark_'+ gale.foto_imovel_img + '?cache='+Math.random()*2">
                            <img :src="'${baseUri}/media/imovel/watermark_'+ gale.foto_imovel_img + '?cache='+Math.random()*2" alt="user"  style="
                            width: 100px !important;
                            height: 100px !important;
                            display: block;
                            object-fit: cover;
                            margin-left: auto;
                            margin-right: auto" />

                        </a>
                        <!-- <div class="el-overlay">
                            <ul class="el-info">
                                <li>
                                    <a class="btn default btn-outline image-popup-vertical-fit" :id="'btn-galeria-id-'+gale.foto_imovel_id" :data-title="createButtonRotaciona(gale)" data-lightbox="img" :href="'<?= Http::base() ?>/media/imovel/watermark_'+ gale.foto_imovel_img + '?cache='+Math.random()*2">
                                        <i class="fa fa-search-plus" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-else>
        <div class="col-12 text-center">
            <i style="font-size:70px" class="fa fa-camera-retro"></i>
            <br> <br>
            <h5> Este imóvel ainda não possui imagem</h5>
        </div>
    </div>
</div>