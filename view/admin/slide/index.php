<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Slides</title>
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
                            <h1>Slides e Banners
                                <?php if (Usuario::verifyPermission('slides', 'gerenciar')) : ?>
                                    <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/slide-novo/"><i class="fa fa-plus"></i>Novo</a>
                                    <a data-id="Slide:G" class="btn btn-primary btn-sm waves-effect waves-light text-white menu-access d-none" onclick="$('#modalConfig').modal('show')">
                                        <i class="fa fa-cog"></i> Configurações
                                        <span class="d-none d-xl-inline-block">Avançadas</span>
                                    </a>
                                <?php endif; ?>
                            </h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar Conteudo</a></li>
                                <li class="breadcrumb-item"><a>Home</a></li>
                                <li class="breadcrumb-item active">Slides e Banners</li>
                            </ol>
                        </div>
                    </div>
            </section>
            <section class="content" id="vm">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card pr-2">
                                <div class="card-body table-responsive">
                                    <h5>
                                        <i class="fa fa-info-circle"></i>
                                        Cadastre Slides e/ou banners para impulsionar o marketing de sua imobiliária e deixar a mesma mais atraente
                                    </h5>
                                    <table id="datatable" class="table table-bordered table-striped align-middle overflow-auto">
                                        <thead>
                                            <tr class="text-center">
                                                <?php if (Usuario::verifyPermission('slides', 'gerenciar')) : ?>
                                                    <td title="Arraste o slide para ordenar" data-toggle="tooltip"><small>
                                                            <i class="fa fa-info-circle" style="font-size:15px!important;"></i></small>
                                                        Ordem </td>
                                                <?php endif; ?>
                                                <th class="col-md-4">Imagem</th>
                                                <th class="col-md-3">Posição</th>
                                                <?php if (Usuario::verifyPermission('slides', 'gerenciar')) : ?>
                                                    <th>Status</th>
                                                <?php endif; ?>
                                                <?php if (Usuario::verifyPermission('slides', 'gerenciar') || Usuario::verifyPermission('slides', 'remover')) : ?>
                                                    <th style="min-width: 100px">Ações</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center" v-for="sld in slides" :class="'slide-editar-' + sld.slide_id" :id="'slide-id-' + sld.slide_id">
                                                <?php if (Usuario::verifyPermission('slides', 'gerenciar')) : ?>
                                                    <td class="text-center" width="110" style="cursor: crosshair "><i class="fa fa-list pt-2"></i></td>
                                                <?php endif; ?>
                                                <td width="100"><img :src="'${baseUri}/media/slides/' + sld.slide_img" :alt="sld.slide_titulo" style="object-fit: cover; width: 100%;height: 100px;"></td>

                                                <td class="pt-4">{{ sld.slide_tipo }}</td>
                                                <?php if (Usuario::verifyPermission('slides', 'gerenciar')) : ?>
                                                    <td width="80">
                                                        <a v-on:click="mudar_status(sld)" style="cursor: pointer;" data-toggle="tooltip">
                                                            <span v-if="sld.slide_status == 1"><i class="fa fa-2x fa-toggle-on text-primary"></i></span>
                                                            <span v-else><i class="fa fa-toggle-off fa-2x text-primary"></i></span>
                                                        </a>
                                                    </td>
                                                <?php endif; ?>
                                                <?php if (Usuario::verifyPermission('slides', 'gerenciar') || Usuario::verifyPermission('slides', 'remover')) : ?>
                                                    <td width="90">
                                                        <?php if (Usuario::verifyPermission('slides', 'gerenciar')) : ?>
                                                            <a class="btn btn-sm text-white btn-primary waves-effect waves-light menu-acces" title="editar" data-toggle="tooltip" :href="'<?= Http::base() ?>/slide-editar/id/' + sld.slide_id">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (Usuario::verifyPermission('slides', 'remover')) : ?>
                                                            <button class="btn btn-sm btn-danger menu-access" data-toggle="tooltip" title="remover" v-on:click="remover(sld)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- <div id="modalConfig" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="mySmallModalLabel">
                                Configurações dos Slides
                                <br><small><i class="fa fa-info-circle"></i> Preencha de acordo com o slide desejado</small>
                            </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form action="<?= Http::base() ?>/configuracao/slide_config" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4>Slides e Banners</h4>
                                        <hr>
                                    </div>
                                    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
                                        <label for="slide_altura_imagens">Altura das imagens</label>
                                        <select name="slide_altura_imagens" id="slide_altura_imagens" class="form-control">
                                            <option value="height: auto !important;">Altura automática (de acordo com a imagem)</option>
                                            <option value="height: 250px !important;">250 Pixels</option>
                                            <option value="height: 300px !important;">300 Pixels</option>
                                            <option value="height: 350px !important;">350 Pixels</option>
                                            <option value="height: 400px !important;">400 Pixels</option>
                                            <option value="height: 450px !important;">450 Pixels</option>
                                            <option value="height: 500px !important;">500 Pixels</option>
                                            <option value="height: 550px !important;">550 Pixels</option>
                                            <option value="height: 600px !important;">600 Pixels</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
                                        <label for="slide_preenchimento_imagens">Preenchimento das imagens</label>
                                        <select name="slide_preenchimento_imagens" id="slide_preenchimento_imagens" class="form-control">
                                            <option value=";">Padrão (Automático, risco de imagem achatada)</option>
                                            <option value="object-fit: fill !important;">Preenchimento 1 (risco de imagem achatada)</option>
                                            <option value="object-fit: cover !important;">Preenchimento 2 (risco de imagem cortada)</option>

                                        </select>
                                    </div>
                                    <div class="col-sm-12 mt-4">
                                        <h4>Banners múltiplos 1 e 2 (Estáticos)</h4>
                                        <hr>
                                    </div>
                                    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
                                        <label for="multiplo_altura_imagens">Altura das imagens</label>
                                        <select name="multiplo_altura_imagens" id="multiplo_altura_imagens" class="form-control">
                                            <option value="height: auto !important;">Altura automática (de acordo com a imagem)</option>
                                            <option value="height: 250px !important;">250 Pixels</option>
                                            <option value="height: 300px !important;">300 Pixels</option>
                                            <option value="height: 350px !important;">350 Pixels</option>
                                            <option value="height: 400px !important;">400 Pixels</option>
                                            <option value="height: 450px !important;">450 Pixels</option>
                                            <option value="height: 500px !important;">500 Pixels</option>
                                            <option value="height: 550px !important;">550 Pixels</option>
                                            <option value="height: 600px !important;">600 Pixels</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
                                        <label for="multiplo_preenchimento_imagens">Preenchimento das imagens</label>
                                        <select name="multiplo_preenchimento_imagens" id="multiplo_preenchimento_imagens" class="form-control">
                                            <option value=";">Padrão (Automático, risco de imagem achatada)</option>
                                            <option value="object-fit: fill !important;">Preenchimento 1 (risco de imagem achatada)</option>
                                            <option value="object-fit: cover !important;">Preenchimento 2 (risco de imagem cortada)</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 mt-4" style="font-weight: 900;">
                                        <span class="text-danger">Atenção</span><br> Os demais banners são configurados de acordo com o tamanho da imagem cadastrada.
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary waves-effect"><i class="fa fa-save"></i> Salvar configurações</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
        </div>
        @(admin.layout.footer)
        @(admin.layout.modal-remove)
        @(admin.layout.modal-status)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/slide/index.js"></script>

    <script>
        $(".supermenu-home").addClass("menu-open");
        $(".menu-home").addClass("active");

        $(".menu-slide").addClass("active");
    </script>

</body>

</html>