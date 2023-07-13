<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Login Administrativo</title>
    @(admin.layout.maincss)
</head>

<body class="hold-transition login-page">
    <div class="wrapper mt-5">
        <div class="login-box">
            <div class="login-logo" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <img src="${baseUri}/media/site/${config_site_logo}" style="width: 200px" />
                <!-- <a><b>Admin</b> ${config_site_title}</a> -->
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Insira seus dados para se autenticar</p>

                    <form id="loginform" action="<?= Http::base() ?>/login/auth/" method="post">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="login" required="" placeholder="Email" value="${email}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="pass" placeholder="Senha" value="">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" name="lembrar" ${lembrar_ipt}>
                                    <label for="remember">
                                        Lembrar-me
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <div class="social-auth-links text-center mb-3 d-none">
                        <p>- OR -</p>
                        <a  class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                        </a>
                        <a  class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                        </a>
                    </div>
                    <!-- /.social-auth-links -->

                    <!-- <p class="mb-1">
                        <a href="javascript:void(0)" id="to-recover" class="text-muted" onclick="$('#recoverform').removeClass('d-none')">
                            <i class="fa fa-lock m-r-5"></i>
                            Recuperar senha
                        </a>
                    </p> -->

                    <form class="form-horizontal d-none" id="recoverform" action="<?= Http::base() ?>/login/gera_token/" method="post">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Recuperar Senha</h3>
                                <p class="text-muted">Informe seu email cadastrado! </p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" name="email" placeholder="Informe o e-mail">
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">
                                    <i class="fa fa-retweet m-r-5"></i>
                                    Recuperar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>


    @(admin.layout.mainjs)

    <script>
        function alert_error_center(title, msg) {
            $.toast({
                heading: title,
                text: msg,
                position: 'top-center',
                //loaderBg: '#1e88e5',
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 7000,
                stack: 2
            });
        }

        if (window.location.href.indexOf("incorreto") != -1) {
            alert_error_center('Login ou senha incorretos!', 'Entre em contato com o administrador!');
        }
        if (window.location.href.indexOf("desativado") != -1) {
            alert_error_center('Usuário desativado!', 'Entre em contato com o o administrador! ');
        }
    </script>
</body>

</html>