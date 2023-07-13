<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Redes Sociais</title>
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
                            <h1>Redes Sociais</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a >Configurações</a></li>
                                <li class="breadcrumb-item active">Redes Sociais</li>
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
                                    <h5>
                                        <i class="fa fa-info-circle"></i>
                                        Insira as Redes Sociais de sua imobiliária
                                    </h5>
                                    <form method="post" action="<?= Http::base() ?>/configuracao/gravarRede/return/rede/">
                                        <input type="hidden" name="rede_social_id" value="1">

                                        <section class="content">
                                            <div>
                                                <br>
                                                <h4 class="separator-line">Configuração de Redes Sociais</h4>
                                                <hr>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-6 col-xs-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="rede_social_facebook">Facebook</label>
                                                        <input type="text" name="rede_social_facebook" id="rede_social_facebook" class="form-control" placeholder="informe o link do perfil ou fanpage no Facebook" value="${rede_social_facebook}" />
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="rede_social_twitter">Twitter</label>
                                                        <input type="text" name="rede_social_twitter" id="rede_social_twitter" class="form-control" placeholder="informe o link do perfil do Twitter" value="${rede_social_twitter}" />
                                                    </div>
                                                </div> -->
                                                <div class="col-md-6 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="rede_social_instagram">Instagram</label>
                                                        <input type="text" name="rede_social_instagram" id="rede_social_instagram" class="form-control" placeholder="informe o link do perfil do Instagram" value="${rede_social_instagram}" />
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="rede_social_youtube">Youtube</label>
                                                        <input type="text" name="rede_social_youtube" id="rede_social_youtube" class="form-control" placeholder="informe o link do YouTube" value="${rede_social_youtube}" />
                                                    </div>
                                                </div> -->

                                            </div>

                                            <div class="col-xs-12 text-center">
                                                <div class="form-group text-center">
                                                    <br />
                                                    <button type="submit" id="btn-send" class="btn btn-primary"><i class="fas fa-check-circle"></i> Atualizar Dados
                                                    </button>
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
        $(".supermenu-contato").addClass("menu-open");
        $(".menu-contato").addClass("active");

        $(".menu-contato-redes").addClass("active");
    </script>
</body>

</html>