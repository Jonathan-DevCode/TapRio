<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Categoria</title>
    @(admin.layout.maincss)

    <style>
        .dropify-clear {
            display: none !important;
        }
    </style>
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
                            <h1>Gerenciar Categoria <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/categoria/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>
                        </div>
                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar sua Imobiliária</a></li>
                                <li class="breadcrumb-item"><a>Imóveis</a></li>
                                <li class="breadcrumb-item active">Gerenciar Categoria</li>
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
                                    <form action="<?= Http::base() ?>/categoria/gravar/" method="post" enctype="multipart/form-data">


                                        <input type="hidden" name="categoria_imovel_id" id="categoria_imovel_id" value="${categoria_imovel_id}">
                                        <input type="text" hidden name="categoria_imovel_img_capa" id="categoria_imovel_img_capa" value="${categoria_imovel_img_capa}">
                                        <div class="row">
                                            <div class="col-md-6  col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Nome da Categoria</label>
                                                    <input type="text" id="categoria_imovel_nome" name="categoria_imovel_nome" value="${categoria_imovel_nome}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6  col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Código da categoria</label>
                                                    <input type="text" id="categoria_imovel_code" name="categoria_imovel_code" value="${categoria_imovel_code}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="row pb-4">
                                            <div class="col-md-12 col-xs-12 col-sm-12" id="categoria_imovel_img_capa_div">                                                
                                                <label for="input-file-now-custom-1">Selecione uma Capa (Tamanho máximo: 1MB)</label>
                                                <input type="file" id="input-file-now-custom-1" data-max-file-size="1M" name="categoria_imovel_img_capa" value="${categoria_imovel_img_capa}" <?php if (isset($data['categoria']->categoria_imovel_img_capa) && !empty($data['categoria']->categoria_imovel_img_capa)) : ?> data-default-file="${baseUri}/media/categoria/${categoria_imovel_img_capa}" <?php endif; ?> data-allowed-file-extensions="jpg jpeg png gif" class="dropify" />
                                            </div>
                                        </div> -->

                                        <div class="row">
                                            <div class="col-12 col-sm-12 mt-3 mb-3">
                                                <h4>Vincule modelos nesta categoria</h4>
                                                <hr>
                                            </div>

                                            <input type="hidden" id="alterou_modelo" name="alterou_modelo" value="0">

                                            <?php foreach ($data['modelo_imovel'] as $modelo) : ?>
                                                <div class="col-12 col-sm-12 col-md-4">
                                                    <input type="checkbox" class="checkbox-modelo" <?php if (in_array($modelo->modelo_imovel_id, $data['modelos_vinculados'])) : ?>checked<?php endif; ?> name="vinculos_modelo[]" value="<?= $modelo->modelo_imovel_id ?>" id="modelo-checkbox-<?= $modelo->modelo_imovel_id ?>">
                                                    <label class="text-muted" for="modelo-checkbox-<?= $modelo->modelo_imovel_id ?>"><?= $modelo->modelo_imovel_nome ?></label>
                                                </div>
                                            <?php endforeach; ?>
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

    <script type="text/javascript">
        $(".supermenu-imoveis").addClass("menu-open");
        $(".menu-imoveis-categorias").addClass("active");

        $(".checkbox-modelo").on("change", function() {
            $("#alterou_modelo").val("1");
        })

        $(document).ready(function() {
            $('.dropify').dropify({
                messages: {
                    default: '<div>Clique aqui para selecionar um arquivo</div>',
                    replace: '<div>Clique em remover para selecionar um novo arquivo</div>',
                    remove: 'Remover',
                    error: 'Ocorreu um erro ao alterar o arquivo'
                },
                error: {
                    'fileSize': 'O tamanho máximo permitido é de: ({{ value }}).',
                    'minWidth': 'The image width is too small ({{ value }}}px min).',
                    'maxWidth': 'The image width is too big ({{ value }}}px max).',
                    'minHeight': 'The image height is too small ({{ value }}}px min).',
                    'maxHeight': 'The image height is too big ({{ value }}px max).',
                    'imageFormat': 'Os formatos de imagem permitidos são: ({{ value }}).',
                    'fileExtension': 'As extensões permitidas são: ({{ value }}).'
                }
            });
            var drEvent = $('.dropify').dropify();

            drEvent.on('dropify.afterClear', function(event, element) {
                $("#categoria_imovel_img_capa").val('');
            });
        });
    </script>


</body>

</html>