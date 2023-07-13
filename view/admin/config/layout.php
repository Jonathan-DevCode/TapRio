<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Personalizar Layout</title>
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
                            <h1>Personalizar Layout</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar Conteudo</a></li>
                                <li class="breadcrumb-item active">Personalizar Layout</li>
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
                                        Personalize o visual da sua Imobiliária! Deixe a Imobiliária com a suas cores, insira sua logo, seu Favicon (ícone na aba do navegador), configure os textos e organização na sua página inicial!
                                    </h5>
                                    <div class="container-fluid">
                                        <!-- tema do topo do site -->
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <hr>
                                                <h1><b>Topo do site</b></h1>
                                                <h4>
                                                    <i class="fa fa-info-circle"></i> Escolha as opções de topo do site de acordo com a sua preferência
                                                </h4>
                                            </div>
                                            <div class="col-sm-6 text-center">
                                                <h5 class="text-left"><b>Quarzar Top</b></h5>
                                                <p class="text-left">
                                                    Um topo com elementos mais divididos, com a opção de troca de cor do fundo do menu superior e imagem de fundo do formulário de busca.
                                                </p>
                                                <!-- <img src="https://www.thinkercode.com.br/view/tema/thinker_default/assets/images/start_shop.png" alt="" style="width: 300px"> -->
                                                <br>

                                                <form method="post" action="<?= Http::base() ?>/configuracao/set_tema_form">
                                                    <input type="hidden" name="tema" value="quarzar">
                                                    <button class="btn btn-<?= $data['config']->config_site_tema_search === 1 ? 'success' : 'primary' ?> btn-block"><i class="fa fa-check"></i> <?= $data['config']->config_site_tema_search === 1 ? 'Opção atual' : 'Escolher opção' ?></button>
                                                </form>
                                            </div>
                                            <div class="col-sm-6 text-center">
                                                <h5 class="text-left"><b>Landing Top</b></h5>
                                                <p class="text-left">
                                                    Um topo com elementos mais dispersos e soltos, com fundo sendo uma imagem e com um design mais livre.
                                                </p>
                                                <!-- <img src="https://www.thinkercode.com.br/view/tema/thinker_default/assets/images/start_shop.png" alt="" style="width: 300px"> -->
                                                <br>

                                                <form method="post" action="<?= Http::base() ?>/configuracao/set_tema_form">
                                                    <input type="hidden" name="tema" value="landing">
                                                    <button class="btn btn-<?= $data['config']->config_site_tema_search === 1 ? 'primary' : 'success' ?> btn-block"><i class="fa fa-check"></i> <?= $data['config']->config_site_tema_search === 1 ? 'Escolher opção' : 'Opção atual' ?></button>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- fim tema do topo do site -->
                                        <!-- Logo e favicon -->
                                        <div class="row">
                                            <div class="col-12">
                                                <hr>
                                                <h1><b>Logotipo e Favicon</b></h1>
                                            </div>
                                            <div class="col-sm-6">
                                                <form method="post" action="<?= Http::base() ?>/configuracao/logo_upload/" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <br>
                                                            <h4 class="separator-line"><b>Envie sua logo</b></h4>
                                                            <p>
                                                                Essa logo será a imagem principal de sua imobiliária. Insira uma imagem com as dimensões o mais próxima possível à especificada no formato da sua logo para deixar o site personalizado <b>(Até 1MB)</b>.
                                                            </p>
                                                            <hr>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                            <input type="file" id="input-file-now-custom-1" data-max-file-size="1M" name="logo" data-allowed-file-extensions="png jpeg jpg" class="dropify " data-default-file="${baseUri}/media/site/${config_site_logo}" />
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <label for="">Formato da sua logo</label>
                                                            <select name="config_site_logo_formato" id="config_site_logo_formato" class="form-control">
                                                                <option value="1">Quadrada/redonda (100x100 pixels)</option>
                                                                <option value="2">Retangular (300x100 pixels)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row py-3">
                                                        <div class="col-12">
                                                            <button type="submit" id="btn-send" class="btn btn-primary btn-block"><i class="fas fa-check-circle"></i> Atualizar Logo
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-sm-6">
                                                <form method="post" action="<?= Http::base() ?>/configuracao/favicon_upload/" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <br>
                                                            <h4 class="separator-line"><b>Envie seu Favicon</b></h4>
                                                            <p>
                                                                O favicon é o ícone que aparecerá na aba do navegador de quem acessar seu site. Insira uma imagem com as dimensões exatas ao formato do seu favicon para deixar o site personalizado <b>(Até 1MB)</b>.
                                                            </p>
                                                            <hr>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                            <input type="file" id="input-file-now-custom-1" data-max-file-size="1M" name="favicon" data-allowed-file-extensions="png jpeg jpg" class="dropify" data-default-file="${baseUri}/media/site/${config_site_favicon}" />
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <label for="">Formato do seu favicon</label>
                                                            <select class="form-control">
                                                                <option>Quadrado/redondo (50x50 pixels)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row py-3">
                                                        <div class="col-12">
                                                            <button type="submit" id="btn-send" class="btn btn-primary btn-block"><i class="fas fa-check-circle"></i> Atualizar Favicon
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- fim Logo e favicon -->
                                        <!-- Configurações do tema do topo -->
                                        <?php if ($data['config']->config_site_tema_search === 1) : ?>
                                            <div class="row justify-content-around">
                                                <div class="col-12">
                                                    <hr>
                                                    <h1><b>Formulário de busca</b></h1>
                                                </div>
                                                <div class="col-sm-12">
                                                    <form method="post" action="<?= Http::base() ?>/configuracao/search_foto_upload/" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <br>
                                                                <h4 class="separator-line"><b>Envie a imagem de fundo do formulário de busca</b></h4>
                                                                <p>
                                                                    Essa imagem irá aparecer atrás do formulário de busca. Largura obrigatória: 1300px ou mais <b>(Até 1MB)</b>.
                                                                </p>
                                                                <hr>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                                <input type="file" id="input-file-now-custom-1" data-max-file-size="1M" name="foto" data-allowed-file-extensions="png jpeg jpg" class="dropify" <?php if (isset($data['config']->config_site_fundo_search) && !empty($data['config']->config_site_fundo_search)) : ?> data-default-file="${baseUri}/media/site/${config_site_fundo_search}" <?php endif; ?> />
                                                            </div>
                                                            <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 align-self-end">
                                                                <div class="form-group">
                                                                    <label for="">Cor do texto do formulário (Escolha uma cor que combine com a foto de fundo)</label>
                                                                    <input type="color" name="config_site_color_search" value="${config_site_color_search}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 align-self-end">
                                                                <div class="form-group">
                                                                    <label for="">Altura da sessão de formulário de busca (a imagem de fundo deverá ter essa altura)</label>
                                                                    <select name="config_site_altura_search" id="config_site_altura_search" class="form-control">
                                                                        <option value="600">600 Pixels (Ideal)</option>
                                                                        <option value="700">700 Pixels</option>
                                                                        <option value="800">800 Pixels</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 align-self-end">
                                                                <div class="form-group">
                                                                    <label for="">Posição dos campos de preenchimento no formulário de busca</label>
                                                                    <select name="config_site_search_posicao" id="config_site_search_posicao" class="form-control">
                                                                        <option value="1">Centralizado</option>
                                                                        <option value="2">À esquerda</option>
                                                                        <option value="3">À direita</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row py-3">
                                                            <div class="col-12">
                                                                <button type="submit" id="btn-send" class="btn btn-primary btn-block"><i class="fas fa-check-circle"></i> Atualizar Formulário
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-sm-4">

                                                </div>
                                            </div>
                                        <?php elseif ($data['config']->config_site_tema_search === 2) : ?>
                                            <div class="row justify-content-around">
                                                <div class="col-12">
                                                    <hr>
                                                    <h1><b>Configurações do tema Landing top</b></h1>
                                                </div>
                                                <div class="col-sm-12">
                                                    <form method="post" action="<?= Http::base() ?>/configuracao/search_foto_upload_lading/" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <br>
                                                                <h4 class="separator-line"><b>Envie a imagem de fundo do topo do seu site</b></h4>
                                                                <p>
                                                                    Resolução indicada: 1600x900
                                                                </p>
                                                                <hr>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                                <input type="file" id="input-file-now-custom-1" data-max-file-size="1M" name="foto" data-allowed-file-extensions="png jpeg jpg" class="dropify" <?php if (isset($data['config']->config_site_fundo_search) && !empty($data['config']->config_site_fundo_search)) : ?> data-default-file="${baseUri}/media/site/${config_site_fundo_search}" <?php endif; ?> />
                                                            </div>
                                                            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 align-self-end">
                                                                <div class="form-group">
                                                                    <label for="">Cor do texto do topo (Escolha uma cor que combine com a foto de fundo)</label>
                                                                    <input type="color" name="config_site_color_search" value="${config_site_color_search}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 align-self-end">
                                                                <div class="form-group">
                                                                    <label for="">Posição dos campos de preenchimento no formulário de busca</label>
                                                                    <select name="config_site_search_posicao" id="config_site_search_posicao" class="form-control">
                                                                        <option value="2">À esquerda</option>
                                                                        <option value="3">À direita</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 align-self-end">
                                                                <div class="form-group">
                                                                    <label for="">Fade escuro no topo</label>
                                                                    <select name="config_site_top_gradient" id="config_site_top_gradient" class="form-control">
                                                                        <option value="1">Ativo</option>
                                                                        <option value="2">Desativado</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 align-self-end">
                                                                <div class="form-group">
                                                                    <label for="">Título do topo do seu site</label>
                                                                    <input type="text" class="form-control" name="config_site_titulo_lading" value="${config_site_titulo_lading}">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 align-self-end">
                                                                <div class="form-group">
                                                                    <label for="">Texto do topo do seu site</label>
                                                                    <textarea name="config_site_text_lading" cols="30" rows="10" class="form-control">${config_site_text_lading}</textarea>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row py-3">
                                                            <div class="col-12">
                                                                <button type="submit" id="btn-send" class="btn btn-primary btn-block"><i class="fas fa-check-circle"></i> Atualizar Formulário
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-sm-4">

                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <!-- fim Configurações do tema do topo -->
                                        <!-- tema das categorias na home -->
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <hr>
                                                <h1><b>Categorias </b></h1>
                                                <h4>
                                                    <i class="fa fa-info-circle"></i> Escolha as opções de layout das categorias do site de acordo com a sua preferência
                                                </h4>
                                            </div>
                                            <div class="col-sm-6 text-center">
                                                <h5 class="text-left"><b>Simple</b></h5>
                                                <p class="text-left">
                                                    Suas categorias terão as cores principais da sua plataforma, sendo possível alterar elas no final desta página.
                                                </p>
                                                <!-- <img src="https://www.thinkercode.com.br/view/tema/thinker_default/assets/images/start_shop.png" alt="" style="width: 300px"> -->
                                                <br>

                                                <form method="post" action="<?= Http::base() ?>/configuracao/set_tema_categorias">
                                                    <input type="hidden" name="tema" value="simple">
                                                    <button class="btn btn-<?= $data['config']->config_site_tema_categoria === 1 ? 'success' : 'primary' ?> btn-block"><i class="fa fa-check"></i> <?= $data['config']->config_site_tema_categoria === 1 ? 'Layout atual' : 'Escolher layout' ?></button>
                                                </form>
                                            </div>
                                            <div class="col-sm-6 text-center">
                                                <h5 class="text-left"><b>Background</b></h5>
                                                <p class="text-left">
                                                    Suas categorias terão o fundo de acordo com a imagem escolhida na mesma.
                                                </p>
                                                <!-- <img src="https://www.thinkercode.com.br/view/tema/thinker_default/assets/images/start_shop.png" alt="" style="width: 300px"> -->
                                                <br>

                                                <form method="post" action="<?= Http::base() ?>/configuracao/set_tema_categorias">
                                                    <input type="hidden" name="tema" value="background">
                                                    <button class="btn btn-<?= $data['config']->config_site_tema_categoria === 1 ? 'primary' : 'success' ?> btn-block"><i class="fa fa-check"></i> <?= $data['config']->config_site_tema_categoria === 1 ? 'Escolher layout' : 'Layout atual' ?></button>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- fim tema das categorias na home -->
                                          <!-- tema dos imóveis na home -->
                                          <div class="row">
                                            <div class="col-12 mb-3">
                                                <hr>
                                                <h1><b>Imóveis </b></h1>
                                                <h4>
                                                    <i class="fa fa-info-circle"></i> Escolha as opções de layout dos imóveis do site de acordo com a sua preferência
                                                </h4>
                                            </div>
                                            <div class="col-sm-6 text-center">
                                                <h5 class="text-left"><b>Grid</b></h5>
                                                <p class="text-left">
                                                    Seus imóveis aparecerão de forma mais sofisticada, mostrando 4 p/ linha e com um layout mais moderno.
                                                </p>
                                                <!-- <img src="https://www.thinkercode.com.br/view/tema/thinker_default/assets/images/start_shop.png" alt="" style="width: 300px"> -->
                                                <br>
                                                <form method="post" action="<?= Http::base() ?>/configuracao/set_tema_imoveis">
                                                    <input type="hidden" name="tema" value="grid">
                                                    <button class="btn btn-<?= $data['config']->config_site_tema_imovel === 1 ? 'success' : 'primary' ?> btn-block"><i class="fa fa-check"></i> <?= $data['config']->config_site_tema_imovel === 1 ? 'Layout atual' : 'Escolher layout' ?></button>
                                                </form>
                                            </div>
                                            <div class="col-sm-6 text-center">
                                                <h5 class="text-left"><b>List</b></h5>
                                                <p class="text-left">
                                                    Seus imóveis aparecerão de um jeito mais convencional, mostrando 1 p/ linha com um layout mais popular.
                                                </p>
                                                <!-- <img src="https://www.thinkercode.com.br/view/tema/thinker_default/assets/images/start_shop.png" alt="" style="width: 300px"> -->
                                                <br>

                                                <form method="post" action="<?= Http::base() ?>/configuracao/set_tema_imoveis">
                                                    <input type="hidden" name="tema" value="list">
                                                    <button class="btn btn-<?= $data['config']->config_site_tema_imovel === 1 ? 'primary' : 'success' ?> btn-block"><i class="fa fa-check"></i> <?= $data['config']->config_site_tema_imovel === 1 ? 'Escolher layout' : 'Layout atual' ?></button>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- fim tema dos imóveis na home -->
                                    </div>

                                    <!-- Cores -->
                                    <form method="post" action="<?= Http::base() ?>/configuracao/gravar_cores/">
                                        <input type="hidden" name="config_cores_id" value="1">
                                        <div class="container-fluid mt-3">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <hr>
                                                    <h1><b>Personalizar Cores</b></h1>
                                                    <h4>
                                                        <i class="fa fa-info-circle"></i> Escolha as cores das fontes, textos e principais conteúdos da sua imobiliária!
                                                    </h4>
                                                    <br>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12 col-md-3">
                                                    <input type="hidden" name="config_cores_id[]" value="<?= $data['cores'][0]->config_cores_id ?>">
                                                    <input type="hidden" name="config_cores_local[]" value="Topo">
                                                    <h5>Topo</h5>
                                                    <input type="color" name="config_cores_fundo[]" value="<?= $data['cores'][0]->config_cores_fundo ?>">
                                                    <label for="">Fundo</label>
                                                    <br>
                                                    <input type="color" name="config_cores_texto[]" value="<?= $data['cores'][0]->config_cores_texto ?>">
                                                    <label for="">Textos</label>
                                                    <br>
                                                    <input type="hidden" name="config_cores_hover_fundo[]" value="#000">
                                                    <input type="color" name="config_cores_hover_texto[]" value="<?= $data['cores'][0]->config_cores_hover_texto ?>">
                                                    <label for="">Hover Textos</label>
                                                </div>

                                                <div class="col-sm-12 col-md-3">
                                                    <input type="hidden" name="config_cores_id[]" value="<?= $data['cores'][1]->config_cores_id ?>">
                                                    <input type="hidden" name="config_cores_local[]" value="Menu">
                                                    <h5>Menu</h5>
                                                    <input type="color" name="config_cores_fundo[]" value="<?= $data['cores'][1]->config_cores_fundo ?>">
                                                    <label for="">Fundo</label>
                                                    <br>
                                                    <input type="color" name="config_cores_texto[]" value="<?= $data['cores'][1]->config_cores_texto ?>">
                                                    <label for="">Textos</label>
                                                    <br>
                                                    <input type="hidden" name="config_cores_hover_fundo[]" value="#000">

                                                    <input type="color" name="config_cores_hover_texto[]" value="<?= $data['cores'][1]->config_cores_hover_texto ?>">
                                                    <label for="">Hover Textos</label>
                                                </div>

                                                <div class="col-sm-12 col-md-3">
                                                    <h5>Imobiliária</h5>
                                                    <input type="hidden" name="config_cores_id[]" value="<?= $data['cores'][2]->config_cores_id ?>">
                                                    <input type="hidden" name="config_cores_local[]" value="Imobiliária">
                                                    <input type="color" name="config_cores_fundo[]" value="<?= $data['cores'][2]->config_cores_fundo ?>">
                                                    <label for="">Fundo</label>
                                                    <br>
                                                    <input type="color" name="config_cores_texto[]" value="<?= $data['cores'][2]->config_cores_texto ?>">
                                                    <label for="">Textos</label>

                                                    <input type="hidden" name="config_cores_hover_fundo[]" value="#000">

                                                    <input type="hidden" name="config_cores_hover_texto[]" value="#000">

                                                </div>

                                                <div class="col-sm-12 col-md-3">
                                                    <h5>Newsletter</h5>
                                                    <input type="hidden" name="config_cores_id[]" value="<?= $data['cores'][3]->config_cores_id ?>">
                                                    <input type="hidden" name="config_cores_local[]" value="Redes Sociais">
                                                    <input type="color" name="config_cores_fundo[]" value="<?= $data['cores'][3]->config_cores_fundo ?>">
                                                    <label for="">Fundo</label>
                                                    <br>
                                                    <input type="color" name="config_cores_texto[]" value="<?= $data['cores'][3]->config_cores_texto ?>">
                                                    <label for="">Textos</label>

                                                    <input type="hidden" name="config_cores_hover_fundo[]" value="#000">

                                                    <input type="hidden" name="config_cores_hover_texto[]" value="#000">

                                                </div>

                                                <div class="col-sm-12">
                                                    <br>
                                                </div>

                                                <div class="col-sm-12 col-md-3">
                                                    <h5>Rodapé de Informações</h5>
                                                    <input type="hidden" name="config_cores_id[]" value="<?= $data['cores'][4]->config_cores_id ?>">
                                                    <input type="hidden" name="config_cores_local[]" value="Rodapé Informações">
                                                    <input type="color" name="config_cores_fundo[]" value="<?= $data['cores'][4]->config_cores_fundo ?>">
                                                    <label for="">Fundo</label>
                                                    <br>
                                                    <input type="color" name="config_cores_texto[]" value="<?= $data['cores'][4]->config_cores_texto ?>">
                                                    <label for="">Textos</label>
                                                    <br>
                                                    <input type="hidden" name="config_cores_hover_fundo[]" value="#000">
                                                    <input type="color" name="config_cores_hover_texto[]" value="<?= $data['cores'][4]->config_cores_hover_texto ?>">
                                                    <label for="">Hover Textos</label>
                                                </div>

                                                <div class="col-sm-12 col-md-3">
                                                    <h5>Rodapé</h5>
                                                    <input type="hidden" name="config_cores_id[]" value="<?= $data['cores'][5]->config_cores_id ?>">
                                                    <input type="hidden" name="config_cores_local[]" value="Rodapé">
                                                    <input type="color" name="config_cores_fundo[]" value="<?= $data['cores'][5]->config_cores_fundo ?>">
                                                    <label for="">Fundo</label>
                                                    <br>
                                                    <input type="color" name="config_cores_texto[]" value="<?= $data['cores'][5]->config_cores_texto ?>">
                                                    <label for="">Textos</label>

                                                    <input type="hidden" name="config_cores_hover_fundo[]" value="#000">

                                                    <input type="hidden" name="config_cores_hover_texto[]" value="#000">

                                                </div>

                                                <div class="col-sm-12 col-md-3">
                                                    <h5>Botões Principais</h5>
                                                    <input type="hidden" name="config_cores_id[]" value="<?= $data['cores'][6]->config_cores_id ?>">
                                                    <input type="hidden" name="config_cores_local[]" value="Botões Principais">
                                                    <input type="color" name="config_cores_fundo[]" value="<?= $data['cores'][6]->config_cores_fundo ?>">
                                                    <label for="">Fundo</label>
                                                    <br>
                                                    <input type="color" name="config_cores_texto[]" value="<?= $data['cores'][6]->config_cores_texto ?>">
                                                    <label for="">Textos</label>
                                                    <br>
                                                    <input type="color" name="config_cores_hover_fundo[]" value="<?= $data['cores'][6]->config_cores_hover_fundo ?>">
                                                    <label for="">Hover Fundo</label>
                                                    <br>
                                                    <input type="color" name="config_cores_hover_texto[]" value="<?= $data['cores'][6]->config_cores_hover_texto ?>">
                                                    <label for="">Hover Textos</label>
                                                </div>

                                                <div class="col-sm-12 col-md-3">
                                                    <h5>Botões Secundários</h5>
                                                    <input type="hidden" name="config_cores_id[]" value="<?= $data['cores'][7]->config_cores_id ?>">
                                                    <input type="hidden" name="config_cores_local[]" value="Botões de Sucesso">
                                                    <input type="color" name="config_cores_fundo[]" value="<?= $data['cores'][7]->config_cores_fundo ?>">
                                                    <label for="">Fundo</label>
                                                    <br>
                                                    <input type="color" name="config_cores_texto[]" value="<?= $data['cores'][7]->config_cores_texto ?>">
                                                    <label for="">Textos</label>
                                                    <br>
                                                    <input type="color" name="config_cores_hover_fundo[]" value="<?= $data['cores'][7]->config_cores_hover_fundo ?>">
                                                    <label for="">Hover Fundo</label>
                                                    <br>
                                                    <input type="color" name="config_cores_hover_texto[]" value="<?= $data['cores'][7]->config_cores_hover_texto ?>">
                                                    <label for="">Hover Textos</label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <div class="form-group">
                                                        <br>
                                                        <button type="submit" id="btn-send" class="btn btn-primary"><i class="fas fa-check-circle"></i> Atualizar Cores
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </form>
                                    <!-- Fim Cores -->
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
        $('.menu-aparencia').addClass('active');
        $('.menu-layout').addClass('active');

        $("#config_site_logo_formato").val("${config_site_logo_formato}").trigger('change');
        $("#config_site_altura_search").val("${config_site_altura_search}").trigger('change');
        $("#config_site_search_posicao").val("${config_site_search_posicao}").trigger('change');
        $("#config_site_top_gradient").val("${config_site_top_gradient}").trigger('change');

        $('.dropify').dropify({
            messages: {
                default: 'Clique aqui para selecionar uma imagem',
                replace: 'Clique em remover para selecionar uma nova imagem',
                remove: 'Remover',
                error: 'Ocorreu um erro ao alterar a imagem'
            },
            error: {
                'fileSize': 'O tamanho máximo permitido é de: ({{ value }}).',
                'minWidth': 'The image width is too small ({{ value }}}px min).',
                'maxWidth': 'The image width is too big ({{ value }}}px max).',
                'minHeight': 'The image height is too small ({{ value }}}px min).',
                'maxHeight': 'The image height is too big ({{ value }}px max).',
                'imageFormat': 'Os formatos de imagem permitidos são: ({{ value }}).',
                'fileExtension': 'As extensões permitidas são: ({{ value }}).'
            },

        });
    </script>
</body>

</html>