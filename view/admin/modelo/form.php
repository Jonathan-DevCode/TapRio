<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | modelo</title>
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
                            <h1>Gerenciar modelo <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/modelo/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>
                        </div>
                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar sua Imobiliária</a></li>
                                <li class="breadcrumb-item"><a>Imóveis</a></li>
                                <li class="breadcrumb-item active">Gerenciar modelo</li>
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
                                    <form action="<?= Http::base() ?>/modelo/gravar/" method="post" enctype="multipart/form-data">


                                        <input type="hidden" name="modelo_imovel_id" id="modelo_imovel_id" value="${modelo_imovel_id}">
                                        
                                        <div class="row">
                                            <div class="col-md-12  col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Nome do modelo</label>
                                                    <input type="text" id="modelo_imovel_nome" name="modelo_imovel_nome" value="${modelo_imovel_nome}" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-sm-12 mt-3 mb-3">
                                                <h4>Vincule este modelo em categorias</h4>
                                                <hr>
                                            </div>

                                            <input type="hidden" id="alterou_categoria" name="alterou_categoria" value="0">

                                            <?php foreach ($data['categoria_imovel'] as $categoria) : ?>
                                                <div class="col-12 col-sm-12 col-md-4">
                                                    <input type="checkbox" class="checkbox-categoria" <?php if (in_array($categoria->categoria_imovel_id, $data['categorias_vinculadas'])) : ?>checked<?php endif; ?> name="modelo_categorias[]" value="<?= $categoria->categoria_imovel_id ?>" id="categoria-checkbox-<?= $categoria->categoria_imovel_id ?>">
                                                    <label class="text-muted" for="categoria-checkbox-<?= $categoria->categoria_imovel_id ?>"><?= $categoria->categoria_imovel_nome ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>


                                        <div class="row">
                                            <div class="col-12 text-center mt-3">
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



        </div>
        @(admin.layout.footer)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)

    <script type="text/javascript">
        $(".supermenu-imoveis").addClass("menu-open");
        $(".menu-imoveis-modelos").addClass("active");

        $(".checkbox-categoria").on("change", function() {
            $("#alterou_categoria").val("1");
        })

    </script>


</body>

</html>