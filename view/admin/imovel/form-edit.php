<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Imóveis</title>
    @(admin.layout.maincss)
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
</head>
<style>
    select {
        font-family: fontAwesome
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="vm">
        @(admin.layout.topo)
        @(admin.layout.menu-lateral)
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <?php if ($data['imovel']->imovel_is_client == 1) : ?>
                                <h1>Informações de imóvel anunciado <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/imovel-lista-site/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>
                            <?php else : ?>
                                <h1>Editar Imóvel <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/imovel-lista/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Home</a></li>
                                <li class="breadcrumb-item"><a>Imóvel</a></li>
                                <li class="breadcrumb-item active">Editar Imóvel</li>
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
                                        <input type="hidden" id="imovel_id" name="imovel_id" value="${imovel_id}">
                                        <input type="hidden" name="redirect" id="redirect" value="dados">
                                        <div id="partials">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link nav-link-form active" style="cursor: pointer;" id="navDados" data-id="partialDados|navDados">Dados Principais</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link nav-link-form" style="cursor: pointer;" id="navValores" data-id="partialValores|navValores">Negociação e Valores</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link nav-link-form" style="cursor: pointer;" id="navEndereco" data-id="partialEndereco|navEndereco">Endereço</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link nav-link-form" style="cursor: pointer;" id="navDesc" data-id="partialDesc|navDesc">Descrição</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link nav-link-form" style="cursor: pointer;" id="navCaracteristicas" data-id="partialCaracteristicas|navCaracteristicas">Características</a>
                                                </li>
                                                <!-- <li class="nav-item">
                                                    <a class="nav-link nav-link-form" style="cursor: pointer;" id="navAtributos" data-id="partialAtributos|navAtributos">Atributos</a>
                                                </li> -->
                                                <li class="nav-item">
                                                    <a class="nav-link nav-link-form" style="cursor: pointer;" id="navFotos" data-id="partialFotos|navFotos">Fotos</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link nav-link-form" style="cursor: pointer;" id="navArquivos" data-id="partialArquivos|navArquivos">Arquivos</a>
                                                </li>
                                            </ul>
                                            <br>
                                            <div id="partialDados" class="partials">
                                                @(admin.imovel.partials.dados)
                                            </div>
                                            <div id="partialValores" class="partials">
                                                @(admin.imovel.partials.valores)
                                            </div>
                                            <div id="partialEndereco" class="partials">
                                                @(admin.imovel.partials.endereco)
                                            </div>
                                            <div id="partialDesc" class="partials">
                                                @(admin.imovel.partials.desc)
                                            </div>
                                            <div id="partialCaracteristicas" class="partials">
                                                @(admin.imovel.partials.caracteristicas)
                                            </div>
                                            <div id="partialAtributos" class="partials">
                                                @(admin.imovel.partials.atributos)
                                            </div>
                                            <div id="partialFotos" class="partials">
                                                @(admin.imovel.partials.fotos)
                                            </div>
                                            <div id="partialArquivos" class="partials">
                                                @(admin.imovel.partials.arquivos)
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <hr>
                                            </div>
                                            <div class="col-12 text-center">
                                                <?php if ($data['imovel']->imovel_is_client == 1) : ?>
                                                    <input type="hidden" name="imovel_is_client" value="0">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Aceitar e salvar imóvel</button>
                                                <?php else : ?>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Salvar</button>
                                                <?php endif; ?>
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
                                <p class="text-center" class="text-center" style="color: black">Você está prestes à remover todos registros desse imóvel e esta ação não pode ser desfeita.
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

            @(admin.layout.modal-remove)

        </div>
        @(admin.layout.footer)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)

    <script>
        var php_imovel_categoria = parseInt("${imovel_categoria}");
        var php_imovel_modelo_id = parseInt("${imovel_modelo_id}");
        var php_imovel_cidade_id = parseInt("${imovel_cidade_id}");
        var php_imovel_bairro_id = parseInt("${imovel_bairro_id}");
    </script>

    <script src="${baseUri}/view/admin/imovel/form-edit.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            loadPartials();
            redirect_tab();

            $(".checkbox-caracteristicas").on("change", function() {
                $("#alterou_caracteristica").val("1");
            })

            $("#imovel_isento_iptu").on("change", function() {
                if ($("#imovel_isento_iptu").val() == '1') {
                    $("#imovel_valor_iptu").attr("disabled", true)
                } else {
                    $("#imovel_valor_iptu").attr("disabled", false)
                }
            })
            $("#imovel_isento_condominio").on("change", function() {
                if ($("#imovel_isento_condominio").val() == '1') {
                    $("#imovel_valor_condominio").attr("disabled", true)
                } else {
                    $("#imovel_valor_condominio").attr("disabled", false)
                }
            })

            $(".supermenu-imoveis").addClass("menu-open");
            $(".menu-imoveis-cadastrar").addClass("active");

            setTimeout(() => {
                $("#imovel_destaque").val('${imovel_destaque}').trigger('change');
                $("#imovel_status").val('${imovel_status}').trigger('change');
                $("#imovel_temporada").val('${imovel_temporada}').trigger('change');
                $("#imovel_condominio_id").val('${imovel_condominio_id}').trigger('change');
                $("#imovel_mostra_fotos").val('${imovel_mostra_fotos}').trigger('change');
                // $("#imovel_modelo_id").val('${imovel_modelo_id}').trigger('change');
                $("#imovel_tipo_fotos_first").val("${imovel_tipo_fotos_first}").trigger("change");
                $("#imovel_tipo_negociacao").val('${imovel_tipo_negociacao}').trigger('change');
                $("#imovel_isento_condominio").val('${imovel_isento_condominio}').trigger('change');
                $("#imovel_isento_iptu").val('${imovel_isento_iptu}').trigger('change');
                $("#imovel_user_id").val("${imovel_user_id}").trigger("change");
                $("#imovel_medida_area_total").val("${imovel_medida_area_total}").trigger("change");
                $("#imovel_medida_area_util").val("${imovel_medida_area_util}").trigger("change");
                $("#imovel_chave_status").val("${imovel_chave_status}").trigger("change");
            }, 600);

            $("#imovel_tipo_negociacao").on("change", function() {
                if ($(this).val() == "venda_aluguel") {
                    $(".col-valor-venda").removeClass("d-none");
                    $(".col-valor-locacao").removeClass("d-none");
                } else if ($(this).val() == "venda") {
                    $(".col-valor-venda").removeClass("d-none");
                    $(".col-valor-locacao").addClass("d-none");
                } else if ($(this).val() == "aluguel") {
                    $(".col-valor-venda").addClass("d-none");
                    $(".col-valor-locacao").removeClass("d-none");
                }
            })

            $("#imovel_chave_status").on("change", function() {
                if ($(this).val() == "imobiliaria") {
                    $(".col-chave-emprestada").addClass("d-none");
                } else if ($(this).val() == "emprestada") {
                    $(".col-chave-emprestada").removeClass("d-none");
                }
            })

            $('.summernote').summernote({
                placeholder: '',
                lang: 'pt-BR',
                minHeight: 150,
                maxHeight: 550,
                disableDragAndDrop: true,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol']],
                    ['size', ['paragraph', 'height', 'fontsize']],
                    ['misc', ['undo', 'redo']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                ]
            });


        });




        function loadPartials() {
            $(".partials").hide();
            $("#partialDados").show();
        }

        $(".nav-link-form").click((e) => {
            if ($(e.target).attr('data-id')) {
                let target = $(e.target).attr('data-id').split('|');
                $(".nav-link-form").removeClass('active');
                $("#" + target[1]).addClass('active');

                $('.partials').hide();
                $("#" + target[0]).show();
                $("#redirect").val(target[1].replace('nav', '').toLowerCase());
            }


        })

        function redirect_tab() {
            let url = window.location.href;

            if (url.indexOf("dados") != -1) {
                $(".nav-link-form").removeClass('active');
                $("#navDados").addClass('active');
                $('.partials').hide();
                $("#partialDados").show();
                $("#redirect").val('dados');
            } else if (url.indexOf("desc") != -1) {
                $(".nav-link-form").removeClass('active');
                $("#navDesc").addClass('active');
                $('.partials').hide();
                $("#partialDesc").show();
                $("#redirect").val('desc');
            } else if (url.indexOf("atributos") != -1) {
                $(".nav-link-form").removeClass('active');
                $("#navAtributos").addClass('active');
                $('.partials').hide();
                $("#partialAtributos").show();
                $("#redirect").val('atributos');
            } else if (url.indexOf("fotos") != -1) {
                $(".nav-link-form").removeClass('active');
                $("#navFotos").addClass('active');
                $('.partials').hide();
                $("#partialFotos").show();
                $("#redirect").val('fotos');
            } else if (url.indexOf("rel") != -1) {
                $(".nav-link-form").removeClass('active');
                $("#navRel").addClass('active');
                $('.partials').hide();
                $("#partialRel").show();
                $("#redirect").val('rel');
            } else if (url.indexOf("valores") != -1) {
                $(".nav-link-form").removeClass('active');
                $("#navValores").addClass('active');
                $('.partials').hide();
                $("#partialValores").show();
                $("#redirect").val('valores');
            } else if (url.indexOf("endereco") != -1) {
                $(".nav-link-form").removeClass('active');
                $("#navEndereco").addClass('active');
                $('.partials').hide();
                $("#partialEndereco").show();
                $("#redirect").val('endereco');
            } else if (url.indexOf("caracteristicas") != -1) {
                $(".nav-link-form").removeClass('active');
                $("#navCaracteristicas").addClass('active');
                $('.partials').hide();
                $("#partialCaracteristicas").show();
                $("#redirect").val('caracteristicas');
            } else if (url.indexOf("arquivos") != -1) {
                $(".nav-link-form").removeClass('active');
                $("#navArquivos").addClass('active');
                $('.partials').hide();
                $("#partialArquivos").show();
                $("#redirect").val('arquivos');
            }
        }
    </script>



</body>

</html>


<?php if ($data['config']->isMobile) : ?>

    <script>
        window.oncontextmenu = function() {
            return false;
        }
    </script>
<?php endif; ?>