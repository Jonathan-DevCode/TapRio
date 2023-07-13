<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Contato</title>
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
                            <h1>Contato</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a >Configurações</a></li>
                                <li class="breadcrumb-item active">Contato</li>
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
                                    <form method="post" action="<?= Http::base() ?>/configuracao/gravarContato/return/contato/">
                                        <input type="hidden" name="contato_id" value="1">

                                        <section class="content">
                                            <div>
                                                <br>
                                                <h4 class="separator-line">Contato</h4>
                                                <hr>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 col-xs-5 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="contato_email">Email Principal</label>
                                                        <input type="email" name="contato_email" id="contato_email" class="form-control" placeholder="Informe um email" required value="${contato_email}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <br>
                                                <h4 class="separator-line">Endereço</h4>
                                                <hr>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="contato_cep">CEP</label>
                                                        <span id="cep-invalido" class="text-danger"></span>
                                                        <input type="text" name="contato_cep" id="contato_cep" class="form-control cep" maxlength="9" required placeholder="Informe o cep" value="${contato_cep}" onblur="completaEndereco(this.value)" />
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <div class="hide-elems">
                                                            <label for="contato_rua">Endereço</label>
                                                            <input type="text" name="contato_rua" id="contato_rua" class="form-control rua" placeholder="Informe o endereço" value="${contato_rua}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-xs-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cliente_num">Número</label>
                                                        <input type="text" name="contato_numero" id="contato_numero" class="form-control numero" placeholder="informe o número" required value="${contato_numero}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="contato_bairro">Bairro</label>
                                                        <input type="text" name="contato_bairro" id="contato_bairro" class="form-control bairro" placeholder="informe o nome do bairro" value="${contato_bairro}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="contato_cidade">Cidade</label>
                                                        <input type="text" name="contato_cidade" id="contato_cidade" class="form-control cidade" placeholder="informe o nome da cidade" value="${contato_cidade}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="contato_uf">UF/Estado</label>
                                                        <input type="text" name="contato_uf" id="contato_uf" class="form-control uf" placeholder="Informe o estado ex: SP" value="${contato_uf}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="contato_complemento">Complemento</label>
                                                        <input type="text" name="contato_complemento" id="contato_complemento" class="form-control" placeholder="ex: Sala 5 / Apto 15" value="${contato_complemento}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-7 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="contato_ref">Ponto de referência</label>
                                                        <input type="text" name="contato_ref" id="contato_ref" class="form-control" placeholder="ex: próximo ao Hospital Central" value="${contato_ref}" />
                                                    </div>
                                                </div>
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

    <script type="text/javascript">
        $('#emails').tagsinput({
            confirmKeys: [32],
            delimiter: ',',
        });
    </script>

    <script>
        $(".supermenu-contato").addClass("menu-open");
        $(".menu-contato").addClass("active");

        $(".menu-contato-endereco").addClass("active");
    </script>
</body>

</html>