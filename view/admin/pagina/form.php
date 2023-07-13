<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Páginas</title>
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
                            <h1><?= isset($data["pagina"]->pagina_id) && !empty($data["pagina"]->pagina_id) ? "Editar" : "Cadastrar" ?> Página <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/pagina-lista/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Meu Site</a></li>
                                <li class="breadcrumb-item active"><?= isset($data["pagina"]->pagina_id) && !empty($data["pagina"]->pagina_id) ? "Editar" : "Cadastrar" ?> Página</li>
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
                                    <form autocomplete="off" id="novo-página" method="post" action="<?= Http::base() ?>/PaginaAdmin/gravar/" enctype="multipart/form-data">
                                        <div class="card card-outline-primary">
                                            <div class="card-body" id="vm">
                                                <div class="content">
                                                    <input type="hidden" name="pagina_id" id="pagina_id" value="${pagina_id}">
                                                    <section id="pagina">
                                                        <div class="row">
                                                            <div class="col-md-6  col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="pagina_titulo">Título da página
                                                                        <span id="idf-info" class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="text" name="pagina_titulo" id="pagina_titulo" class="form-control" value="${pagina_titulo}" required placeholder="Informe um título para o página" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="pagina_categoria">Categoria <span id="idf-info" class="text-danger">*</span></label>
                                                                    <select name="pagina_categoria" id="pagina_categoria" class="form-control" required>
                                                                        <option disabled="disabled" value="" selected>Selecione uma categoria</option>
                                                                        <option v-for="cat in categorias" :value="cat.categoria_pagina_id">{{cat.categoria_pagina_nome}}</option>
                                                                        <option value="x">Criar nova categoria</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <h4 class="separator-line">Imagem
                                                                    <span id="idf-info" class="text-danger">*</span>
                                                                </h4>
                                                            </div>
                                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                                <input type="file" id="input-file-now-custom-1" name="pagina_capa" data-allowed-file-extensions="jpg jpeg png" class="dropify" <?php if (empty($data['pagina']->pagina_capa)) : ?> required <?php endif; ?> data-default-file="${pagina_capa}" />
                                                            </div>
                                                        </div>
                                                        <div class="row py-5">
                                                            <div class="col-md-12">
                                                                <h4 class="separator-line">Conteúdo
                                                                    <span id="idf-info" class="text-danger">*</span>
                                                                </h4>
                                                            </div>
                                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <textarea name="pagina_texto" id="pagina_texto" rows="40" required class="form-control">${pagina_texto}</textarea>
                                                                </div>
                                                            </div>
                                                    </section>
                                                    <section id="obs">
                                                        <div class="col-xs-12 text-center menu-access" data-id="PaginaAdmin:G">
                                                            <div class="form-group text-center">
                                                                <br><br>
                                                                <button id="btn-send" class="btn btn-primary"><i class="fas fa-check-circle"></i> Gravar Dados
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
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

        <div id="modal-categoria" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form action="<?= Http::base() ?>/PaginaAdmin/gravar_categoria/" id="form-nova-categoria" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel"><span class="categoria-acao">Incluir</span> categoria</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="categoria_pagina_id" id="categoria_pagina_id">
                            <div class="row">
                                <div class="col-md-4 col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="categoria_pagina_nome">Nome da categoria <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="categoria_pagina_nome" name="categoria_pagina_nome" maxlength="200" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-4">
                                    <label for="categoria_pagina_topo">Visível no topo ? <span class="text-danger">*</span></label>
                                    <select name="categoria_pagina_topo" id="categoria_pagina_topo" class="form-control" required>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-4">
                                    <label for="categoria_pagina_rodape">Visível no rodapé ? <span class="text-danger">*</span></label>
                                    <select name="categoria_pagina_rodape" id="categoria_pagina_rodape" class="form-control" required>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @(admin.layout.footer)
        @(admin.pagina.modal-help)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/pagina/form.js"></script>


    <script type="text/javascript">
        $(".supermenu-site").addClass("menu-open");
        $(".menu-site").addClass("active");

        $(".menu-pagina-gerenciar").addClass("active");
        setTimeout(function() {
            $('#pagina_categoria').val('${pagina_categoria}');
        }, 350);
        $('#pagina_texto').summernote({
            placeholder: '',
            lang: 'pt-BR',
            minHeight: 550,
            maxHeight: 950,
            disableDragAndDrop: true,
            toolbar: [
                ['media', ['link']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol']],
                ['size', ['paragraph', 'height', 'fontsize']],
                ['misc', ['undo', 'redo']],
            ]
        });
    </script>

    <script>
        var app = new Vue({
            el: '#seo',
            data: {
                titulo: '${pagina_titulo}',
                desc: '${pagina_desc}',
                categorias: null,
                cat_url: '${categoria_pagina_url}',
                pagina_url: '${pagina_url}',
                pagina_updated: '${pagina_updated}',
                pagina_nome: null,
                img: '',
                link: null,
                categoria_nome: null
            },
            created: function() {
                this.link = baseUri + '/pagina/' + this.cat_url + '/' + this.pagina_url;
            }
        });

        $(document).ready(function() {
            $("#keywords_seo").attr('name', 'pagina_keywords');
            $("#pagina_desc").attr('name', 'pagina_desc');
            $("#keywords_seo").val('${pagina_keywords}');
            $('#keywords_seo').tagsinput({
                confirmKeys: [32],
                delimiter: ',',
            });
        });
    </script>
</body>

</html>