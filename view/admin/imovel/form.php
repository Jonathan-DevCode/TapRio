<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Imóveis</title>
    @(admin.layout.maincss)
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="vm">
        @(admin.layout.topo)
        @(admin.layout.menu-lateral)
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Adicionar Imóvel <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/imovel-lista/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>
                        </div>
                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Home</a></li>
                                <li class="breadcrumb-item"><a>Imóvel</a></li>
                                <li class="breadcrumb-item active">Adicionar Imóvel</li>
                            </ol>
                        </div>
                    </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="<?= Http::base() ?>/imovelAdmin/gravar/" method="post" enctype="multipart/form-data" onsubmit="return vm.validaForm()">
                                        <div class="row">
                                            <div class="col-12 col-sm-12">
                                                <h4>Informações principais do imóvel</h4>
                                                <hr>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <i class="fa fa-info-circle"></i><small> &nbsp; (Caso o título não seja informado, será apresentado como "<b>Categoria</b> em <b>Cidade/UF</b>")</small>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Link Vídeo</label>
                                                    <input type="text" class="form-control" name="imovel_video" value="${imovel_video}" placeholder="Ex: https://youtube.com/link">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
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
                                                    <label for="">Área Útil</label>
                                                    <input type="number" class="form-control" name="imovel_area_util" value="${imovel_area_util}" placeholder="Ex: 92">
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
                                                    <label for="">Área Total</label>
                                                    <input type="number" class="form-control" name="imovel_area_total" value="${imovel_area_total}" placeholder="Ex: 185">
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
                                                    <label for="">Área construída</label>
                                                    <input type="number" class="form-control" name="imovel_area_construida" value="${imovel_area_construida}" placeholder="Ex: 172">
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
                                                                <option value="0">Sem Condomínio</option>
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
                                        </div>

                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Salvar</button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- modais de adição -->
            <div id="modalAddCategoria" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Adicionar Categoria</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="">Nome da categoria <span class="text-danger">*</span> </label>
                                    <input type="text" v-on:keyup.enter="salvar_categoria()" class="form-control" required id="categoria_imovel_nome" name="categoria_imovel_nome">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                            <button type="button" v-on:click="salvar_categoria()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Salvar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modalAddCidade" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Adicionar Cidade</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">UF</label>
                                        <select name="cidade_uf" id="cidade_uf" required class="form-control">
                                            <option value="0">Selecione um estado</option>
                                            <option v-if="ufs != null" v-for="uf in ufs" :value="uf.uf_id">({{uf.uf_sigla}}) {{uf.uf_estado}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Nome da Cidade <span class="text-danger">*</span> </label>
                                        <input type="text" v-on:keyup.enter="salvar_cidade()" class="form-control" required id="cidade_titulo" name="cidade_titulo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                            <button type="button" v-on:click="salvar_cidade()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Salvar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modalAddBairro" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Adicionar Bairro</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Cidade</label>
                                        <select name="bairro_cidade" id="bairro_cidade" required class="form-control">
                                            <option value="0">Selecione uma Cidade</option>
                                            <option v-if="cidades != null" v-for="cid in cidades" :value="cid.cidade_id">{{ cid.cidade_titulo }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Nome do bairro <span class="text-danger">*</span> </label>
                                        <input type="text" v-on:keyup.enter="salvar_bairro()" class="form-control" required id="bairro_titulo" name="bairro_titulo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                            <button type="button" v-on:click="salvar_bairro()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fim modais de adição -->

        </div>
        @(admin.layout.footer)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/imovel/form.js"></script>

    <script type="text/javascript">
        $(".supermenu-imoveis").addClass("menu-open");
        $(".menu-imoveis-cadastrar").addClass("active");

        $("#imovel_user_id").val("<?= Session::node('uid') ?>").trigger("change");
    </script>


</body>

</html>