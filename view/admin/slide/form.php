<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Slides</title>
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
                            <h1>Gerenciar Slides e Banners <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/slide-lista/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>
                        </div>
                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar Conteudo</a></li>
                                <li class="breadcrumb-item"><a>Home</a></li>
                                <li class="breadcrumb-item"><a>Slides e Banners</a></li>
                                <li class="breadcrumb-item active">Gerenciar Slides e Banners</li>
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
                                    <form action="<?= Http::base() ?>/slide/gravar/" method="post" enctype="multipart/form-data">


                                        <input type="hidden" name="slide_id" id="slide_id" value="${slide_id}">
                                        <input type="text" hidden name="slide_img" id="slide_img" value="${slide_img}">
                                        <div class="row pb-4">
                                            <div class="col-md-12 col-xs-12 col-sm-12" id="slide_img_div">
                                                <span class="float-right pt-1" style="cursor: pointer;" onclick="$('#modalAjuda').modal('show')"><i class="fa fa-info-circle"></i> Precisa de ajuda? </span>
                                                <label for="input-file-now-custom-1">Selecione uma Imagem (Tamanho máximo: 1MB)</label>
                                                <input type="file" data-max-file-size="1M" id="input-file-now-custom-1" name="slide_img" value="${slide_img}" <?php if (isset($data['slide']->slide_img) && !empty($data['slide']->slide_img)) : ?> data-default-file="${baseUri}/media/slides/${slide_img}" <?php endif; ?> data-allowed-file-extensions="jpg jpeg png gif" class="dropify" />

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12  col-sm-12">
                                                <div class="form-group">
                                                    <label for="slide_url">Posição do slide</label>
                                                    <select class="form-control" id="slide_tipo" name="slide_tipo">
                                                        <option value="1">Slide 1</option>
                                                        <option value="2">Slide 2</option>
                                                        <option value="3">Slide Venda ou alugue</option>
                                                        <option value="4">Slide Administração</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Salvar</button>
                                            </div>
                                        </div>

                                        <div id="modalAjuda" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="mySmallModalLabel">Slides e Banners</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-4">
                                                                <h5>Slide Superior</h5>
                                                            </div>
                                                            <div class="col-sm-12 col-md-8 text-right">
                                                                <span class="badge badge-primary">Resolução Indicada: (1351 X 366)</span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                                <br>
                                                                Nesta posição irá conter os slides que se localizam no topo do seu site. É indicado o uso de imagens horizontais e com a resolução igual ou maior que a indicada para um melhor aproveitamento da imagem, mantendo assim sua qualidade.
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-4">
                                                                <h5>Slide Meio</h5>
                                                            </div>
                                                            <div class="col-sm-12 col-md-8 text-right">
                                                                <span class="badge badge-primary">Resolução Indicada: (1351 X 366)</span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                                <br>
                                                                Nesta posição irá conter os slides que se localizam no meio do seu site. É indicado o uso de imagens horizontais e com a resolução igual ou maior que a indicada para um melhor aproveitamento da imagem, mantendo assim sua qualidade.
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>



        </div>
        @(admin.layout.footer)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/slide/index.js"></script>

    <script type="text/javascript">
        $(".supermenu-home").addClass("menu-open");
        $(".menu-home").addClass("active");

        $(".menu-slide").addClass("active");

        $("#slide_tipo").val("${slide_tipo}").trigger('change');
    </script>


</body>

</html>