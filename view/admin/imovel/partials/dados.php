<div class="row">
    <div class="col-12 col-sm-12">
        <h4>Informações principais do imóvel</h4>
        <hr>
    </div>
    <div class="col-12 mb-3">
        <i class="fa fa-info-circle"></i><small> &nbsp; (Caso o título não seja informado, será apresentado como "<b>Categoria</b> em <b>Cidade/UF</b>")</small>
    </div>
    <!-- <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Título</label>
            <input type="text" class="form-control" name="imovel_titulo" value="${imovel_titulo}" placeholder="Ex: Sobrado no litoral de Maresias/SP">
        </div>
    </div> -->
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Código do anúncio</label>
            <input type="text" class="form-control" name="imovel_ref" value="${imovel_ref}" placeholder="Ex: IMO-001" disabled>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Link Vídeo</label>
            <input type="text" class="form-control" name="imovel_video" value="${imovel_video}" placeholder="Ex: https://youtube.com/link">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Link Tour Virtual</label>
            <input type="text" class="form-control" name="imovel_link_tour" value="${imovel_link_tour}" placeholder="Ex: https://youtube.com/link">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Quais fotos exibe primeiro?</label>
            <select name="imovel_tipo_fotos_first" id="imovel_tipo_fotos_first" class="form-control">
                <option value="imovel">Imóvel > Condomínio</option>
                <option value="condominio">Condomínio > Imóvel</option>
            </select>
        </div>
    </div>

    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Quartos</label>
            <input type="number" class="form-control" name="imovel_quartos" value="${imovel_quartos}" placeholder="Ex: 2">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Suítes</label>
            <input type="number" class="form-control" name="imovel_suites" value="${imovel_suites}" placeholder="Ex: 2">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Banheiros</label>
            <input type="number" class="form-control" name="imovel_banheiros" value="${imovel_banheiros}" placeholder="Ex: 2">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Vagas</label>
            <input type="number" class="form-control" name="imovel_vagas" value="${imovel_vagas}" placeholder="Ex: 2">
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Andar</label>
            <input type="number" class="form-control" name="imovel_andar" value="${imovel_andar}" placeholder="Ex: 2">
        </div>
    </div>

    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Área Útil (m²)</label>
            <input type="number" class="form-control" name="imovel_area_util" value="${imovel_area_util}" placeholder="Ex: 58">
        </div>
    </div>
    <!-- <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="">Medida da Área Útil <span class="text-danger">*</span></label>
                    <select name="imovel_medida_area_util" id="imovel_medida_area_util" class="form-control">
                        <option value="m²">m² (Metros Quadrados)</option>
                        <option value="H">Hectáres</option>

                    </select>
                </div>
            </div>
        </div>
    </div> -->
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Área Total (m²)</label>
            <input type="number" class="form-control" name="imovel_area_total" value="${imovel_area_total}" placeholder="Ex: 172">
        </div>
    </div>
    <!-- <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="">Medida da Área Total <span class="text-danger">*</span></label>
                    <select name="imovel_medida_area_total" id="imovel_medida_area_total" class="form-control">
                        <option value="m²">m² (Metros Quadrados)</option>
                        <option value="H">Hectáres</option>

                    </select>
                </div>
            </div>
        </div>
    </div> -->
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Área construída (m²)</label>
            <input type="number" class="form-control" name="imovel_area_construida" value="${imovel_area_construida}" placeholder="Ex: 170">
        </div>
    </div>

    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Ano de construção</label>
            <input type="number" class="form-control" name="imovel_ano_construcao" value="${imovel_ano_construcao}" placeholder="Ex: 2010">
        </div>
    </div>


    <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="">Exibir fotos do imóvel <span class="text-danger">*</span></label>
                    <select name="imovel_mostra_fotos" id="imovel_mostra_fotos" class="form-control">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>

                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="">Tipo do imóvel <span class="text-danger">*</span></label>
                    <select name="imovel_tipo" id="imovel_tipo" class="form-control">
                        <option value="residencial">Residencial</option>
                        <option value="comercial">Comercial</option>

                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="">Condomínio </label>
                    <select name="imovel_condominio_id" id="imovel_condominio_id" class="form-control">
                        <option value="0">Sem condomínio</option>
                        <?php if (isset($data['condominios'][0])) : ?>
                            <?php foreach ($data['condominios'] as $condominio) : ?>
                                <option value="<?= $condominio->condominio_id ?>"><?= $condominio->condominio_nome ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <?php if (Usuario::verifyIsAdmin()) : ?>
        <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
            <div class="form-group">
                <label for="">Destaque <span class="text-danger">*</span></label>
                <select name="imovel_destaque" id="imovel_destaque" class="form-control">
                    <option value="2">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="">Categoria </label>
                    <select name="imovel_categoria" id="imovel_categoria" class="form-control">
                        <option value="0">Selecione uma opção</option>
                        <option v-if="categorias != null" v-for="cat in categorias" :value="cat.categoria_imovel_id">{{ cat.categoria_imovel_nome }}</option>
                    </select>
                </div>
            </div>
            <!-- <div class="col-2 align-self-center" style="margin-top: 17px;">
                <a onclick="$('#modalAddCategoria').modal('show')" class="btn btn-primary btn-block"> <i class="fa fa-plus"></i> </a>
            </div> -->
        </div>
    </div>
    <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="">Modelo do imóvel </label>
                    <select name="imovel_modelo_id" id="imovel_modelo_id" class="form-control">
                        <option v-if="modelos != null" v-for="modelo in modelos" :value="modelo.modelo_imovel_id">{{ modelo.modelo_imovel_nome }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>



    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="">Status <span class="text-danger">*</span></label>
            <select name="imovel_status" id="imovel_status" class="form-control">
                <option value="1">Ativo</option>
                <option value="2">Inativo</option>
            </select>
        </div>
    </div>

    <?php if (Usuario::verifyIsAdmin()) : ?>
        <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Corretor responsável <span class="text-danger">*</span></label>
                        <select name="imovel_user_id" id="imovel_user_id" class="form-control">
                            <?php if (isset($data['users'][0])) : ?>
                                <?php foreach ($data['users'] as $user) : ?>
                                    <option value="<?= $user->usuario_id ?>"><?= $user->usuario_nome ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php if (Usuario::verifyIsAdmin() || Usuario::verifyPermissaoAcesso("imoveis", "all") || ($data['imovel']->imovel_user_id == Session::node('uid'))) : ?>
        <div class="col-12">
            <h4>Dados do proprietário</h4>
            <hr>
        </div>

        <div class="col-12 col-sm-12 col-xs-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label for="">Nome Completo</label>
                <input type="text" name="imovel_proprietario_nome" class="form-control" value="${imovel_proprietario_nome}" placeholder="Ex: Manoel das Couves">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-xs-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label for="">Telefone/Whatsapp</label>
                <input type="text" inputmode="numeric" name="imovel_proprietario_telefone" class="form-control fone" value="${imovel_proprietario_telefone}" placeholder="Ex: (11) 11111-1111">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-xs-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label for="">E-mail</label>
                <input type="email" name="imovel_proprietario_email" class="form-control" value="${imovel_proprietario_email}" placeholder="Ex: manoel@email.com">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-xs-12 col-md-12 col-lg-12">
            <div class="form-group">
                <label for="">Anotações</label>
                <textarea type="email" name="imovel_proprietario_obs" class="form-control" value="${imovel_proprietario_obs}">${imovel_proprietario_obs}</textarea>
            </div>
        </div>


        <?php if (Usuario::verifyPermission('chaves')) : ?>
            <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label for="">Número da chave</label>
                    <input <?php if (!Usuario::verifyPermission('chaves', 'gerenciar')): ?> disabled <?php endif; ?> type="text" name="imovel_chave_num" class="form-control" value="${imovel_chave_num}" placeholder="Ex: 101">
                </div>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label for="">Situação das chaves <span class="text-danger">*</span></label>
                    <?php if (Usuario::verifyPermission('chaves', 'gerenciar')): ?>
                        <select name="imovel_chave_status" id="imovel_chave_status" class="form-control">
                            <option value="imobiliaria">Na imobiliária</option>
                            <option value="emprestada">Emprestada</option>
                        </select>
                    <?php else: ?>
                        <input disabled type="text" name="imovel_chave_num" class="form-control" value="<?= $data['imovel']->imovel_chave_status == "imobiliaria" ? 'Na imobiliária' : 'Emprestada'; ?>" placeholder="Ex: 101">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3 col-chave-emprestada <?= $data['imovel']->imovel_chave_status == "imobiliaria" ? 'd-none' : '' ?>">
                <div class="form-group">
                    <label for="">Portador da chave</label>
                    <input <?php if (!Usuario::verifyPermission('chaves', 'gerenciar')): ?> disabled <?php endif; ?> type="text" name="imovel_chave_portador" class="form-control" value="${imovel_chave_portador}" placeholder="Corretor X">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-xs-12 col-md-3 col-lg-3 col-chave-emprestada <?= $data['imovel']->imovel_chave_status == "imobiliaria" ? 'd-none' : '' ?>">
                <div class="form-group">
                    <label for="">Previsão de entrega</label>
                    <input <?php if (!Usuario::verifyPermission('chaves', 'gerenciar')): ?> disabled <?php endif; ?> type="date" name="imovel_chave_retorno" class="form-control" value="${imovel_chave_retorno}">
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>