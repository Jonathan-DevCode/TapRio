<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Email e SMTP</title>
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
                            <h1>Email e SMTP</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a >Configurações</a></li>
                                <li class="breadcrumb-item active">Email e SMTP</li>
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
                                        Insira as informações de SMTP que você possui. Este cadastro é necessário apenas se você deseja que o sistema envie e-mails em alguns gatilhos.                                         
                                    </h5>
                                    <form method="post" action="<?= Http::base() ?>/configuracao/gravarSmtp/return/email/">
                                        <input type="hidden" name="smtp_id" value="1">

                                        <section class="content">
                                            <div>
                                                <br>
                                                <h4 class="separator-line">Configuração de Email e SMTP</h4>
                                                <hr>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="smtp_nome">Nome do Email</label>
                                                        <input type="text" name="smtp_nome" id="smtp_nome" class="form-control" placeholder="serviços prestatos ou produtos oferecidos" value="${smtp_nome}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="smtp_email">Email</label>
                                                        <input type="email" name="smtp_email" id="smtp_email" class="form-control" placeholder="Informe o email" required value="${smtp_email}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="smtp_host">Nome do host</label>
                                                        <input type="text" name="smtp_host" id="smtp_host" class="form-control" placeholder="Informe o host" <?php if (isset($data['smtp']->smtp_host) && !empty($data['smtp']->smtp_host)) : ?> value="${smtp_host}" <?php else : ?> value="mail.${baseUri}" <?php endif; ?> />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="smtp_pass">Senha</label>
                                                        <input type="password" name="smtp_pass" id="smtp_pass" class="form-control" placeholder="Informe a senha" value="" />
                                                    </div>
                                                </div>


                                                <div class="col-md-2 col-xs-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="smtp_port">Número da Porta</label>
                                                        <input type="number" name="smtp_port" id="smtp_port" class="form-control" placeholder="Informe a porta" required value="${smtp_port}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="smtp_secure">Segurança</label>

                                                        <select class="form-control" id="smtp_secure" name="smtp_secure" required>
                                                            <option value="1" <?= $data['smtp']->smtp_secure == '1' ? 'selected' : '' ?>>Nenhuma</option>
                                                            <option value="2" <?= $data['smtp']->smtp_secure == '2' ? 'selected' : '' ?>>SSL</option>
                                                            <option value="3" <?= $data['smtp']->smtp_secure == '3' ? 'selected' : '' ?>>TLS</option>
                                                        </select>
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
    <script>
        $(".supermenu-contato").addClass("menu-open");
        $(".menu-contato").addClass("active");

        $(".menu-contato-email").addClass("active");
    </script>
</body>

</html>