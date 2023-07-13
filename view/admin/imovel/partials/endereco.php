<div class="row">
    <div class="col-12 col-sm-12">
        <h4>Dados de localização do imóvel</h4>
        <hr>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="">CEP</label>
            <input type="text" class="form-control cep" id="imovel_cep" name="imovel_cep" value="${imovel_cep}" placeholder="Ex: 11111-111">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
        <div class="form-group">
            <label for="">Rua</label>
            <input type="text" class="form-control rua" id="imovel_rua" name="imovel_rua" value="${imovel_rua}" placeholder="Ex: Rua Maria da Silva">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="">Nº</label>
            <input type="number" inputmode="numeric" class="form-control numero" id="imovel_num" name="imovel_num" value="${imovel_num}" placeholder="Ex: 123">
        </div>
    </div>
    
    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="">Complemento</label>
            <input type="text" class="form-control" name="imovel_complemento" value="${imovel_complemento}" placeholder="Ex: Casa">
        </div>
    </div>

    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="">Bairro</label>
            <input type="text" inputmode="numeric" class="form-control bairro" id="imovel_bairro" name="imovel_bairro" value="${imovel_bairro}" placeholder="Ex: Interlagos">
        </div>
    </div>

    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="">Cidade</label>
            <input type="text" inputmode="numeric" class="form-control cidade" id="imovel_cidade" name="imovel_cidade" value="${imovel_cidade}" placeholder="Ex: São Paulo">
        </div>
    </div>

    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="">UF</label>
            <input type="text" class="form-control uf" id="imovel_uf" name="imovel_uf" value="${imovel_uf}" placeholder="Ex: SP">
        </div>
    </div>
    
    <!-- <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="row">
            <div class="col-10">
                <div class="form-group">
                    <label for="">Cidade <span class="text-danger">*</span></label>
                    <select id="imovel_cidade_id" name="imovel_cidade_id" class="form-control">
                        <option value="0">Selecione uma opção</option>
                        <option v-if="cidades != null" v-for="cid in cidades" :value="cid.cidade_id" :id="'option-cidade-' + cid.cidade_id">{{ cid.cidade_titulo }}</option>
                    </select>
                </div>
            </div>
            <div class="col-2 align-self-center" style="margin-top: 17px;">
                <a onclick="$('#modalAddCidade').modal('show')" class="btn btn-primary btn-block"> <i class="fa fa-plus"></i> </a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="row">
            <div class="col-10">
                <div class="form-group">
                    <label for="">Bairro <span class="text-danger">*</span></label>
                    <select name="imovel_bairro_id" id="imovel_bairro_id" class="form-control">
                        <option value="0">Selecione uma opção</option>
                        <option v-if="bairros != null" v-for="bai in bairros" :value="bai.bairro_id" :id="'option-bairro-' + bai.bairro_id">{{ bai.bairro_titulo }}</option>
                    </select>
                </div>
            </div>
            <div class="col-2 align-self-center" style="margin-top: 17px;">
                <a onclick="$('#modalAddBairro').modal('show')" class="btn btn-primary btn-block"> <i class="fa fa-plus"></i> </a>
            </div>
        </div>
    </div> -->
    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="">Latitude</label>
            <input type="text" class="form-control" id="imovel_latitude" name="imovel_latitude" value="${imovel_latitude}" placeholder="Ex: -156654848">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="">Longitude</label>
            <input type="text" class="form-control" id="imovel_longitude" name="imovel_longitude" value="${imovel_longitude}" placeholder="Ex: -129189548481">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2 align-self-end">
        <div class="form-group">
            <button class="btn btn-outline-primary w-100" type="button" v-on:click="findLatLon()" id="btn-lat-lon"><i class="fa fa-map-marker"></i> Buscar Lat/Lon</button>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-12 col-sm-12 mt-3">
        <h4>Visualização do endereço no imóvel</h4>
        <hr>
    </div>
    <input type="hidden" name="imovel_rua_view" value="1">
    <input type="hidden" name="imovel_bairro_view" value="1">
    <input type="hidden" name="imovel_cidade_view" value="1">
    <input type="hidden" name="imovel_uf_view" value="1">
    <!-- <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <input type="checkbox" name="imovel_rua_view" value="1" <?php if ($data['imovel']->imovel_rua_view == 1) : ?>checked<?php endif; ?>>
            <label for="">Mostrar Rua</label>
        </div>
    </div>
   
    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <input type="checkbox" name="imovel_bairro_view" value="1" <?php if ($data['imovel']->imovel_bairro_view == 1) : ?>checked<?php endif; ?>>
            <label for="">Mostrar Bairro</label>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <input type="checkbox" name="imovel_cidade_view" value="1" <?php if ($data['imovel']->imovel_cidade_view == 1) : ?>checked<?php endif; ?>>
            <label for="">Mostrar Cidade</label>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <input type="checkbox" name="imovel_uf_view" value="1" <?php if ($data['imovel']->imovel_uf_view == 1) : ?>checked<?php endif; ?>>
            <label for="">Mostrar UF</label>
        </div>
    </div> -->
    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <input type="checkbox" name="imovel_num_view" value="1" <?php if ($data['imovel']->imovel_num_view == 1) : ?>checked<?php endif; ?>>
            <label for="">Mostrar Nº</label>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
        <div class="form-group">
            <input type="checkbox" name="imovel_complemento_view" value="1" <?php if ($data['imovel']->imovel_complemento_view == 1) : ?>checked<?php endif; ?>>
            <label for="">Mostrar Complemento</label>
        </div>
    </div>
</div>