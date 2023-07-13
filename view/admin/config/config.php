<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Configurações da Imobiliária</title>
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
                            <h1>Configurações da Imobiliária</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a >Configurações</a></li>
                                <li class="breadcrumb-item active">Configurações da Imobiliária</li>
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
                                    <form method="post" action="<?= Http::base() ?>/configuracao/gravar_modo/">
                                        <section class="container-fluid">
                                            <div class="row">
                                                <div class="col-sm-12">


                                                    <br>
                                                    <h4 class="separator-line">Selecione o tipo da sua Imobiliária</h4>
                                                    <hr>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="config_site_modo" id="config_site_modo1" value="1" checked>
                                                        <label class="form-check-label" for="config_site_modo1">
                                                            Imobiliária Padrão (Imobiliária virtual padrão com todas as funcionalidades de venda online)
                                                        </label>
                                                    </div>
                                                    <br>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="config_site_modo" id="config_site_modo2" value="2">
                                                        <label class="form-check-label" for="config_site_modo2">
                                                            Carrinho de Orçamento (Exibe os produtos para criar um orçamento de preços e taxas)
                                                        </label>
                                                    </div>
                                                    <br>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="config_site_modo" id="config_site_modo3" value="3">
                                                        <label class="form-check-label" for="config_site_modo3">
                                                            Vitrine (Exibe os produtos apenas para mostruário)
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <br>
                                                    <h4 class="separator-line">Sua Imobiliária desconta estoque em suas vendas?</h4>
                                                    <hr>
                                                </div>

                                                <div class="col-sm-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="config_desconta_estoque" id="config_desconta_estoque1" value="1" checked>
                                                            <label class="form-check-label" for="config_desconta_estoque1">
                                                                Sim, descontar estoque nas vendas
                                                            </label>
                                                        </div>
                                                        <br>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="config_desconta_estoque" id="config_desconta_estoque2" value="2">
                                                            <label class="form-check-label" for="config_desconta_estoque2">
                                                                Eu não trabalho com estoque
                                                            </label>
                                                        </div>
                                                    </div>

                                                <div class="row">
                                                   

                                                    <div class="col-12 text-center">
                                                        <div class="form-group">
                                                            <br>
                                                            <button type="submit" id="btn-send" class="btn btn-primary"><i class="fas fa-check-circle"></i> Atualizar Dados
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </section>

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

    <script>
        document.getElementById("config_site_modo${config_site_modo}").checked = true;
        document.getElementById("config_desconta_estoque${config_desconta_estoque}").checked = true;
    </script>

    <script>
        $(".supermenu-configuracoes").addClass("menu-open");
        $(".menu-configuracoes").addClass("active");
    </script>
</body>

</html>