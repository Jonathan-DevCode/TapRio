<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Categoria de Característica</title>
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
                            <h1>Gerenciar Categoria de Característica <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/caracteristicaCategoria/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>
                        </div>
                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar sua Imobiliária</a></li>
                                <li class="breadcrumb-item"><a>Imóveis</a></li>
                                <li class="breadcrumb-item active">Gerenciar Categoria de Característica</li>
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
                                    <form action="<?= Http::base() ?>/caracteristicaCategoria/gravar/" method="post" enctype="multipart/form-data">


                                        <input type="hidden" name="caracteristica_categoria_id" id="caracteristica_categoria_id" value="${caracteristica_categoria_id}">
                                        
                                        <div class="row">
                                            <div class="col-md-12  col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Nome da categoria</label>
                                                    <input type="text" id="caracteristica_categoria_nome" name="caracteristica_categoria_nome" value="${caracteristica_categoria_nome}" class="form-control">
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



        </div>
        @(admin.layout.footer)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)

    <script type="text/javascript">
        $(".supermenu-imoveis").addClass("menu-open");
        $(".menu-imoveis-caracteristicaCategorias").addClass("active");

    </script>


</body>

</html>