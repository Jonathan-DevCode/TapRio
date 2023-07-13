<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Característica</title>
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
                            <h1>Gerenciar Característica <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/caracteristica/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>
                        </div>
                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar sua Imobiliária</a></li>
                                <li class="breadcrumb-item"><a>Imóveis</a></li>
                                <li class="breadcrumb-item active">Gerenciar Característica</li>
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
                                    <form action="<?= Http::base() ?>/caracteristica/gravar/" method="post" enctype="multipart/form-data">


                                        <input type="hidden" name="caracteristica_id" id="caracteristica_id" value="${caracteristica_id}">
                                        
                                        <div class="row">
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Nome da Característica</label>
                                                    <input type="text" id="caracteristica_nome" name="caracteristica_nome" value="${caracteristica_nome}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Tipo de Característica</label>
                                                    <select name="caracteristica_tipo" id="caracteristica_tipo" class="form-control">
                                                        <option value="ambos">Imóvel e Condomínio</option>
                                                        <option value="imovel">Imóvel</option>
                                                        <option value="Condomínio">Condomínio</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Diferencial</label>
                                                    <select name="caracteristica_diferencial" id="caracteristica_diferencial" class="form-control">
                                                        <option value="1">Sim</option>
                                                        <option value="0">Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Categoria</label>
                                                    <select name="caracteristica_categoria_id" id="caracteristica_categoria_id" class="form-control">
                                                        <option value="0">Escolha uma categoria</option>
                                                        
                                                        <?php if(isset($data['categorias'][0])): ?>
                                                            <?php foreach($data['categorias'] as $cat): ?>
                                                                <option value="<?= $cat->caracteristica_categoria_id ?>"><?= $cat->caracteristica_categoria_nome ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
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
        $(".menu-imoveis-caracteristicas").addClass("active");

        $("#caracteristica_tipo").val("${caracteristica_tipo}").trigger("change");
        $("#caracteristica_diferencial").val("${caracteristica_diferencial}").trigger("change");
        $("#caracteristica_categoria_id").val("${caracteristica_categoria_id}").trigger("change");

    </script>


</body>

</html>