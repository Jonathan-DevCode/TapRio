<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Parceiros</title>
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
                            <h1>Seus Parceiros <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/parceiros-lista/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a >Gerenciar Conteudo</a></li>
                                <li class="breadcrumb-item"><a >Home</a></li>
                                <li class="breadcrumb-item active">Seus Parceiros</li>
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
                                    <form autocomplete="off" id="parceiro" method="post" action="<?= Http::base() ?>/parceiros/gravar/" enctype="multipart/form-data">
                                        <input type="hidden" name="parceiro_id" id="parceiro_id" value="${parceiro_id}">
                                        <input type="text" hidden name="parceiro_logo" id="parceiro_logo" value="${parceiro_logo}">
                                        <section id="parceiro">
                                            <div class="row ">
                                                <div class="col-12">
                                                    <i class="fa fa-info-circle"></i> Dica: tente selecionar fotos com as mesmas dimensões de seus outros parceiros! <b>Resolução indicada: 200x200</b>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-12">
                                                    <div class="row ">
                                                        <div class="col-12 pt-3">
                                                            <input type="file" data-max-file-size="1M" id="input-file-now-custom-1" name="parceiro_logo" data-default-file="${baseUri}/media/parceria/${parceiro_logo}" data-allowed-file-extensions="jpg jpeg png" class="dropify" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-md-10 col-sm-12 align-self-end pt-2">

                                                    <div class="row">
                                                        <div class="col-md-12 col-xs-12 col-sm-12 align-self-center">
                                                            <div class="form-group">
                                                                <label for="autor_parceiro">Nome
                                                                    <span id="idf-info" class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" name="parceiro_nome" id="parceiro_nome" class="form-control" value="${parceiro_nome}" required placeholder="Informe o nome do parceiro" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 col-xs-12 col-sm-12 align-self-center">
                                                            <div class="form-group">
                                                                <label for="autor_parceiro">Link</label>
                                                                <input type="text" name="parceiro_link" id="parceiro_link" class="form-control" value="${parceiro_link}" placeholder="Informe um link para o seu parceiro" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row d-none">
                                                        <div class="col-md-3 col-xs-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="parceiro_status">Parceiro ativo?</label>
                                                                <select class="form-control" name="parceiro_status" id="parceiro_status">
                                                                    <option value="1" selected>Sim</option>
                                                                    <option value="0">Não</option>
                                                                </select>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 text-center menu-access" data-id="Parceiro:G">
                                                            <div class="form-group">
                                                                <button id="btn-send" class="btn btn-primary btn-block"><i class="fas fa-check-circle"></i> Gravar Dados
                                                                </button>
                                                            </div>
                                                        </div>
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
    <script src="${baseUri}/view/admin/parceiro/index.js"></script>


    <script type="text/javascript">
        $(".supermenu-home").addClass("menu-open");
        $(".menu-home").addClass("active");

        $(".menu-parceiros").addClass("active");
        
        $('#input-file-now-custom-1').dropify({
            messages: {
                default: '<div>Selecione a logo do seu parceiro (260 x 225)</div>',
                replace: '<div>Selecione a logo do seu parceiro (260 x 225)</div>',
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
    </script>
</body>

</html>