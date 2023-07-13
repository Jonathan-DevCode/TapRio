<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <title>${config_site_title} | Condomínio</title>
    @(admin.layout.maincss)

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @(admin.layout.topo)
        @(admin.layout.menu-lateral)
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Gerenciar Condomínio <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/condominio/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>
                        </div>
                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar sua Imobiliária</a></li>
                                <li class="breadcrumb-item"><a>Imóveis</a></li>
                                <li class="breadcrumb-item active">Gerenciar Condomínio</li>
                            </ol>
                        </div>
                    </div>
            </section>
            <section class="content" id="vm">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="<?= Http::base() ?>/condominio/gravar/" method="post" enctype="multipart/form-data">


                                        <input type="hidden" name="condominio_id" id="condominio_id" value="${condominio_id}">

                                        <div class="row">
                                            <div class="col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="">Nome da Condomínio</label>
                                                    <input type="text" id="condominio_nome" name="condominio_nome" value="${condominio_nome}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="">Descrição</label>
                                                    <textarea class="form-control summernote" name="condominio_descricao" id="condominio_descricao" cols="30" rows="10">${condominio_descricao}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Andares</label>
                                                    <input type="number" min="0" id="condominio_qtd_andar" name="condominio_qtd_andar" value="${condominio_qtd_andar}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Unidades p/ andar</label>
                                                    <input type="number" min="0" id="condominio_qtd_unidades_por_andar" name="condominio_qtd_unidades_por_andar" value="${condominio_qtd_unidades_por_andar}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Torres</label>
                                                    <input type="number" min="0" id="condominio_qtd_torres" name="condominio_qtd_torres" value="${condominio_qtd_torres}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Ano de construção</label>
                                                    <input type="number" min="0" id="condominio_ano_construcao" name="condominio_ano_construcao" value="${condominio_ano_construcao}" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-sm-12 mt-3 mb-3">
                                                <h4>Adicione Características do condomínio</h4>
                                                <hr>
                                            </div>

                                            <input type="hidden" id="alterou_caracteristica" name="alterou_caracteristica" value="0">

                                            <?php foreach ($data['caracteristica_categorias'] as $cat) : ?>
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <h5><b><?= $cat->caracteristica_categoria_nome ?></b></h5>

                                                    <div class="row">
                                                        <?php foreach ($cat->caracteristicas as $caracteristica) : ?>
                                                            <div class="col-12 col-sm-12 col-md-3">
                                                                <input type="checkbox" class="checkbox-caracteristicas" <?php if (in_array($caracteristica->caracteristica_id, $data['caracteristicas_vinculadas'])) : ?>checked<?php endif; ?> name="condominio_caracteristicas[]" value="<?= $caracteristica->caracteristica_id ?>" id="caracteristica-checkbox-<?= $caracteristica->caracteristica_id ?>">
                                                                <label class="text-muted" for="caracteristica-checkbox-<?= $caracteristica->caracteristica_id ?>"><?= stripslashes($caracteristica->caracteristica_nome) ?></label>
                                                                <?php if ($caracteristica->caracteristica_diferencial == '1') : ?>
                                                                    <i class="fa fa-star text-yellow"></i>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <div class="row" v-if="'${condominio_id}' > 0">
                                            <div class="col-12 col-sm-12 mt-3 mb-3">
                                                <h4 class="mb-5">Adicione fotos ao condomínio <small style="float: right;">(Resolução ideal: 864x540)</small> </h4>

                                                <div class="fallback dropzone" id="form-galeria-img">

                                                </div>

                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="row align-items-center" v-if="'${condominio_id}' > 0">
                                            <div class="col-lg-6 col-md-6 col-sm-12 pb-4">

                                                <h2>Fotos do condomínio</h2>
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
                                                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <a id="btn-remove-img" data-id="Galeria:G" v-show="selected == true" v-on:click="remove_img()" class="btn btn-block btn-warning waves-effect waves-light text-white menu-access">
                                                            <i class="fa fa-trash"></i> Remover selecionadas
                                                        </a>
                                                    </div>
                                                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <a id="remove-all" data-id="Galeria:G" data-target="#modal-remove-all" v-show="remove_a" data-toggle="modal" class="btn btn-block btn-danger waves-effect waves-light text-white menu-access">
                                                            <i class="fa fa-trash"></i> Remover todas
                                                        </a>
                                                    </div>


                                                </div>
                                                <h6 class="float-right">
                                                </h6>
                                            </div>
                                        </div>
                                        <div id="" v-if="'${condominio_id}' > 0">
                                            <div class="row el-element-overlay" id="sort" v-if="galerias != null">
                                                <div class="col-lg-2 col-md-4 col-sm-6 col-4" v-for="gale in galerias" :id="'foto-galeria-'+gale.foto_condominio_id" :data-id="gale.foto_condominio_id" :data-position="gale.foto_condominio_pos" style="    text-align: center;
                                                    display: flex;
                                                    flex-direction: column;
                                                    justify-content: center;
                                                    align-items: center;">
                                                    <button type="button" class="btn-custom-checkbox" v-on:click="add_class_remove(gale)" :id="'foto-check-'+gale.foto_condominio_id" :data-id="gale.foto_condominio_id" :data-url="gale.foto_condominio_url" :data-remove="gale.foto_condominio_id" :data-position="gale.foto_condominio_pos"><i class="fa fa-check"></i></button>
                                                    <div class="cardX">
                                                        <div class="el-card-item">
                                                            <div class="el-card-avatar el-overlay-1 border-default" :id="'img-galeria-id-'+gale.foto_condominio_id" :data-url="gale.foto_condominio_url" :data-remove="gale.foto_condominio_id">
                                                                <a class="image-popup-vertical-fit" :id="'btn-galeria-id-'+gale.foto_condominio_id" :data-title="createButtonRotaciona(gale)" data-lightbox="img" :href="'<?= Http::base() ?>/media/condominio/watermark_'+ gale.foto_condominio_img + '?cache='+Math.random()*2">
                                                                    <img :src="'${baseUri}/media/condominio/thumb_'+ gale.foto_condominio_img + '?cache='+Math.random()*2" alt="user"  style="
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
                                                                            <a class="btn default btn-outline image-popup-vertical-fit" :id="'btn-galeria-id-'+gale.foto_condominio_id" :data-title="createButtonRotaciona(gale)" data-lightbox="img" :href="'<?= Http::base() ?>/media/imovel/watermark_'+ gale.foto_condominio_img + '?cache='+Math.random()*2">
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
                                                    <h5> Este condomínio ainda não possui imagem</h5>
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

                <div id="modal-rotaciona" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Rotacionar imagens selecionadas</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 text-center">
                                    <i class="text-warning fa fa-4x fa-exclamation-triangle"></i>
                                    <br><br>
                                    <h2 class="text-center">Atenção!</h2>
                                    <p class="text-center" style="color: black">Você está prestes a rotacionar as imagens selecionadas. Deseja continuar?</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                                <button id="btn-rotacionar" v-on:click="rotaciona_imagens()" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-reload"></i> Rotacionar</button>
                                <button id="btn-rotacionar-loading" type="button" class="btn btn-primary waves-effect waves-light d-none">Rotacionando, aguarde...</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div id="modal-remove-all" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Remover todos os registros</h4>
                            <a type="button" class="close" data-dismiss="modal" aria-hidden="true">×</a>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 text-center">
                                <i class="text-warning fa fa-4x fa-exclamation-triangle"></i>
                                <br></br>
                                <h2 class="text-center">Atenção!</h2>
                                <p class="text-center" class="text-center" style="color: black">Você está prestes à remover todos registros desse condomínio e esta ação não pode ser desfeita.
                                    Deseja realmente prosseguir ?</p>
                            </div>
                        </div>
                        <div class="modal-footer text-white">
                            <a type="button" class="btn btn-primary waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</a>
                            <a id="btn-remove-all" type="button" class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash"></i> Remover</a>
                        </div>
                    </div>
                </div>
            </div>


            <div id="modal-remove" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Remover Registro</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 text-center">
                                <i class="text-warning fa fa-4x fa-exclamation-triangle"></i>
                                <br></br>
                                <h2 class="text-center">Atenção!</h2>
                                <p class="text-center" style="color: black">Você está prestes à remover um registro e esta ação não pode ser desfeita.<br>
                                    Deseja realmente prosseguir ?</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                            <button id="btn-remove-" type="button" class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash"></i> Remover</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--
            @(admin.layout.modal-remove) -->

        </div>
        @(admin.layout.footer)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/condominio/form.js"></script>


</body>

</html>

<?php if ($data['config']->isMobile) : ?>

    <script>
        window.oncontextmenu = function() {
            return false;
        }
    </script>
<?php endif; ?>