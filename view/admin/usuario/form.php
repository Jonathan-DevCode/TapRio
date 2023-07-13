<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Usuário</title>
    @(admin.layout.maincss)

    <style>
        .dropify-clear {
            display: none !important;
        }

        .label-checkbox {
            font-weight: normal !important;
            color: #777;
            font-size: 14px;
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
                            <h1>Gerenciar Usuário <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/usuario/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar Conteudo</a></li>
                                <li class="breadcrumb-item"><a>Home</a></li>
                                <li class="breadcrumb-item"><a>Usuário</a></li>
                                <li class="breadcrumb-item active">Gerenciar Usuário</li>
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
                                    <div class="row">
                                        <div class="col-lg-2 col-md-6 col-sm-12 mt-10">
                                            <form method="post" id="form" action="<?= Http::base() ?>/usuario/avatar_upload/" enctype="multipart/form-data">
                                                <input type="hidden" name="usuario_id" value="${usuario_id}" />
                                                <div class="row">
                                                    <div class="col-12 pl-4 ">
                                                        <input type="file" id="input-file-now-custom-1" name="avatar" data-allowed-file-extensions="png jpeg jpg" class="dropify" data-default-file="${baseUri}/media/avatar/${usuario_avatar}" data-height="142" />
                                                    </div>
                                                </div>
                                                <div class="row pt-4">
                                                    <div class="col-12">
                                                        <button type="submit" id="up_avatar" class="btn btn-primary btn-block"><i class="fas fa-check-circle"></i> Atualizar Avatar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-10 col-md-6 col-sm-12">
                                            <form autocomplete="off" method="post" action="<?= Http::base() ?>/usuario/gravar/" enctype="multipart/form-data">
                                                <input type="hidden" name="usuario_id" value="${usuario_id}" />

                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="usuario_nome">Nome</label>
                                                            <span class="text-danger"> *</span>
                                                            <input type="text" name="usuario_nome" id="usuario_nome" class="form-control" placeholder="informe o nome do usuário" value="${usuario_nome}" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="usuario_code">Código de identificação</label>
                                                            <span class="text-danger"> *</span>
                                                            <input type="text" name="usuario_code" id="usuario_code" class="form-control" placeholder="informe o nome do usuário" value="${usuario_code}" required />
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="usuario_code">Possui acesso ao app?</label>
                                                            <span class="text-danger"> *</span>
                                                            <select name="usuario_access_app" id="usuario_access_app" class="form-control">
                                                                <option value="1">Sim</option>
                                                                <option value="2">Não</option>
                                                            </select>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="usuario_email">E-mail</label>
                                                            <span class="text-danger"> *</span>
                                                            &nbsp;&nbsp;<span id="email_error" class="text-danger"></span>
                                                            <input type="email" name="usuario_email" id="usuario_email" class="form-control email" autocomplete="off" value="${usuario_email}" placeholder="informe um endereço de e-mail" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group" autocomplete="off">
                                                            <label for="usuario_password">Senha</label>
                                                            <?php if (!isset($data['usuario']->usuario_id) || empty($data['usuario']->usuario_id)) : ?>
                                                                <span class="text-danger" id="pass-required"> *</span>
                                                            <?php endif; ?>
                                                            <input type="text" name="usuario_pass" id="usuario_pass" class="form-control" autocomplete="off" value="" placeholder="Informe uma senha" <?php if (!isset($data['usuario']->usuario_id) || empty($data['usuario']->usuario_id)) : ?> required <?php endif; ?> />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <?php if (Session::node('uid') != $data['usuario']->usuario_id) : ?>
                                                        <div class="col-12 col-sm-12 mt-3">
                                                            <h4>Permissões do usuário</h4>
                                                            <hr>
                                                        </div>

                                                        <input type="hidden" id="permission_changed" name="permission_changed" value="0">
                                                        <div class="col-12 col-sm-12 mb-3">
                                                            <b>Permissão total</b>
                                                            <br>
                                                            <input type="checkbox" value="1" <?php if ($data['usuario']->usuario_is_admin == '1') : ?>checked<?php endif; ?> name="usuario_is_admin" id="usuario_is_admin">
                                                            <label class="label-checkbox" for="usuario_is_admin">Marque para dizer que este usuário é um administrador</label>
                                                        </div>

                                                        <?php foreach ($data['permissoes'] as $k => $permissoes) : ?>
                                                            <div class="col-12 col-sm-12 mb-3">
                                                                <hr>
                                                                <b><?= $permissoes['name'] ?></b>
                                                                <div class="row mt-2">
                                                                    <div class="col-12 col-sm-12 col-md-2">
                                                                        <input type="checkbox" class="checkbox-permission" value="1" <?php if ($permissoes['visualizar'] == '1') : ?>checked<?php endif; ?> name="permissao_visualizar_<?= $k ?>" id="permissao_visualizar_<?= $k ?>">
                                                                        <label class="label-checkbox" for="permissao_visualizar_<?= $k ?>">Visualizar</label>
                                                                    </div>
                                                                    <div class="col-12 col-sm-12 col-md-2">
                                                                        <input type="checkbox" class="checkbox-permission" value="1" <?php if ($permissoes['gerenciar'] == '1') : ?>checked<?php endif; ?> name="permissao_gerenciar_<?= $k ?>" id="permissao_gerenciar_<?= $k ?>">
                                                                        <label class="label-checkbox" for="permissao_gerenciar_<?= $k ?>">Gerenciar</label>
                                                                    </div>
                                                                    <?php if ($k != "chaves") : ?>
                                                                        <div class="col-12 col-sm-12 col-md-2">
                                                                            <input type="checkbox" class="checkbox-permission" value="1" <?php if ($permissoes['remover'] == '1') : ?>checked<?php endif; ?> name="permissao_remover_<?= $k ?>" id="permissao_remover_<?= $k ?>">
                                                                            <label class="label-checkbox" for="permissao_remover_<?= $k ?>">Remover</label>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                    <?php if ($k == "imoveis") : ?>
                                                                        <div class="col-12 col-sm-12 col-md-6">
                                                                            <select class="select-permission form-control" name="permissao_acesso_<?= $k ?>" id="permissao_acesso_<?= $k ?>">
                                                                                <option <?php if ($permissoes['acesso'] == 'all') : ?>selected<?php endif; ?> value="all">Interagir com todos os cadastros</option>
                                                                                    <option <?php if ($permissoes['acesso'] == 'all_permission') : ?>selected<?php endif; ?> value="all_permission">Interagir com todos os cadastros, sem ver dados de proprietário</option>
                                                                                <option <?php if ($permissoes['acesso'] == 'self') : ?>selected<?php endif; ?> value="self">Interagir apenas com os próprios cadastros</option>
                                                                            </select>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <input type="hidden" name="permissao_acesso_<?= $k ?>" value="<?= $permissoes['acesso'] ?>">
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>


                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <p class="text-center">
                                                            <br><br>
                                                            <button class="btn btn-primary"><i class="fa fa-save"></i> Gravar
                                                                Dados
                                                            </button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>


                                    </div>

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

    <script>
        $(".supermenu-usuarios").addClass("menu-open");
        $(".menu-usuarios").addClass("active");

        $(document).ready(function() {
            $("#usuario_is_admin").on("change", function() {
                if (document.getElementById("usuario_is_admin").checked) {
                    $('.checkbox-permission').prop('checked', true);
                    $(".select-permission").val("all").trigger("change");
                }
            })

            $("#usuario_access_app").val("${usuario_access_app}").trigger("change");

            $(".select-permission").on("change", function() {
                $("#permission_changed").val("1");
            })

            $(".checkbox-permission").on("change", function() {
                $("#permission_changed").val("1");

                // verifica se todos estão checados
                let all_checked = true;
                $(".checkbox-permission").each((index, el) => {
                    if (!$(el).is(":checked")) {
                        all_checked = false;
                    }
                })

                console.log(all_checked);

                if (all_checked) {
                    $('#usuario_is_admin').prop('checked', true);
                } else {
                    $('#usuario_is_admin').prop('checked', false);
                }
            })

        })
    </script>
</body>

</html>