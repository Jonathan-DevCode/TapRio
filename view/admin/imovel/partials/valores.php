<div class="row">
    <div class="col-12 col-sm-12">
        <h4>Dados de negociação, valores e preços</h4>
        <hr>
    </div>

    <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="">Tipo de negociação <span class="text-danger">*</span></label>
                    <select name="imovel_tipo_negociacao" id="imovel_tipo_negociacao" class="form-control">
                        <option value="venda_aluguel">Venda e Aluguel</option>
                        <option value="venda">Somente Venda</option>
                        <option value="aluguel">Somente Aluguel</option>

                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3 d-none col-valor-venda">
        <div class="form-group">
            <label for="">Valor de Venda (R$)</label>
            <input type="text" inputmode="numeric" class="form-control moeda" name="imovel_valor_venda" value="${imovel_valor_venda}" placeholder="Ex: 750.000,00">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3 d-none col-valor-locacao">
        <div class="form-group">
            <label for="">Valor de Locação (R$)</label>
            <input type="text" inputmode="numeric" class="form-control moeda" name="imovel_valor_locacao" value="${imovel_valor_locacao}" placeholder="Ex: 980,00">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3 d-none col-valor-locacao">
        <div class="form-group">
            <label for="">Imóvel de temporada? <span class="text-danger">*</span></label>
            <select name="imovel_temporada" id="imovel_temporada" class="form-control">
                <option value="2">Não</option>
                <option value="1">Sim</option>
            </select>
        </div>
    </div>

    <div class="col-12 col-sm-12">
        <div class="row">
            <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Isento de condomínio <span class="text-danger">*</span></label>
                            <select name="imovel_isento_condominio" id="imovel_isento_condominio" class="form-control">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label for="">Valor do Condomínio (R$)</label>
                    <input type="text" inputmode="numeric" class="form-control moeda" id="imovel_valor_condominio" name="imovel_valor_condominio" value="${imovel_valor_condominio}" placeholder="Ex: 780,00">
                </div>
            </div>

            <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Isento de IPTU <span class="text-danger">*</span></label>
                            <select name="imovel_isento_iptu" id="imovel_isento_iptu" class="form-control">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label for="">Valor do IPTU (R$)</label>
                    <input type="text" inputmode="numeric" class="form-control moeda" id="imovel_valor_iptu" name="imovel_valor_iptu" value="${imovel_valor_iptu}" placeholder="Ex: 780,00">
                </div>
            </div>

        </div>
    </div>

    <div class="col-sm-12 col-xs-12">
        <b>OBS: </b> A opção de imóvel de temporada só é válida em imóveis para locação. Quando o imóvel é de temporada, o valor de locação deverá ser o da diária (valor p/ dia)
    </div>
</div>