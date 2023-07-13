<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Informações da Imobiliária</title>
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
                            <h1>Informações da Imobiliária</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Configurações</a></li>
                                <li class="breadcrumb-item active">Informações da Imobiliária</li>
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
                                        Insira as principais informações da sua Imobiliária, informações de SEO, LGPD e de contato.
                                    </h5>
                                    <form method="post" action="<?= Http::base() ?>/configuracao/gravar/return/site/" enctype="multipart/form-data">
                                        <input type="hidden" name="config_id" value="1">
                                        <section class="container-fluid">
                                            <div>
                                                <br>
                                                <h4 class="separator-line"><b>Informações da Imobiliária</b></h4>
                                                <hr>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-4 col-xs-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_site_title">Título do Site <span class="text-danger">*</span> </label>
                                                        <input type="text" name="config_site_title" id="config_site_title" class="form-control" placeholder="informe um título para o site" required value="${config_site_title}" />
                                                    </div>
                                                </div>
                                                <input type="hidden" name="config_site_description" id="config_site_description" class="form-control" placeholder="ex: prestamos serviços de .... " value="${config_site_description}">
                                                <input type="hidden" name="config_site_keywords" id="config_site_keywords" class="form-control" placeholder="serviços prestatos ou produtos oferecidos" value="${config_site_keywords}" />


                                                <div class="col-md-4 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_site_slogan">Slogan</label>
                                                        <input type="text" name="config_site_slogan" onchange="changeSeo('#config_site_slogan', 'titulo')" id="config_site_slogan" class="form-control" placeholder="um slogan" value="${config_site_slogan}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_site_keywords">Keywords</label>
                                                        <input type="text" name="config_site_keywords" id="config_site_keywords" class="form-control" placeholder="informe as keywords" value="${config_site_keywords}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_site_ga_code">Código Google Analytics</label>
                                                        <input type="text" name="config_site_ga_code" id="config_site_ga_code" class="form-control" placeholder="informe o código do Google Analytics" value="${config_site_ga_code}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_site_tm_code">Código Google Tag Manager</label>
                                                        <input type="text" name="config_site_tm_code" id="config_site_tm_code" class="form-control" placeholder="Informe o código do Google Tag Manager" value="${config_site_tm_code}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_site_about">Descrição da Imobiliária</label>
                                                        <textarea name="config_site_about" id="config_site_about" rows="4" class="form-control" placeholder="Sobre">${config_site_about}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Logo e favicon -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <hr>
                                                        <h4 class="separator-line"><b>Informações da Imobiliária</b></h4>
                                                    </div>
                                                    <div class="col-sm-4">

                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <br>
                                                                <h4 class="separator-line"><b>Envie sua logo</b></h4>
                                                                <p>
                                                                    Essa logo será a imagem principal de sua imobiliária. Insira uma imagem com as dimensões o mais próxima possível da especificada no formato da sua logo para deixar o site personalizado <b>(Até 1MB)</b>.
                                                                </p>
                                                                <hr>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                                <input type="file" id="input-file-now-custom-1" data-max-file-size="1M" name="logo" data-allowed-file-extensions="png jpeg jpg" class="dropify " data-default-file="${baseUri}/media/site/${config_site_logo}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
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
                                                        </div>

                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <br>
                                                                <h4 class="separator-line"><b>Envie sua marca d'água</b></h4>
                                                                <p>
                                                                    Esta será a imagem que irá aparecer em todas as fotos dos seus imóveis. Insira uma imagem com as dimensões exatas ao formato do seu favicon para deixar o site personalizado <b>(Até 1MB, APENAS PNG SEM FUNDO)</b>.

                                                                </p>

                                                                <hr>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center ">
                                                                <input type="file" id="input-file-now-custom-1" data-max-file-size="1M" name="marcadagua" data-allowed-file-extensions="png" class="dropify" data-default-file="${baseUri}/media/site/${config_site_marcadagua}" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- fim Logo e favicon -->

                                                <!-- cores -->
                                                <div class="col-sm-12">
                                                    <br>
                                                    <h4 class="separator-line"><b>Cores do site</b></h4>                                                    
                                                    <hr>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_color_topo">Cor do topo</label>
                                                        <input type="color" name="config_color_topo" id="config_color_topo" class="form-control" placeholder="Informe a mensagem para o modal de privacidade" value="${config_color_topo}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_color_topo_text">Cor de texto do topo</label>
                                                        <input type="color" name="config_color_topo_text" id="config_color_topo_text" class="form-control" placeholder="Informe a mensagem para o modal de privacidade" value="${config_color_topo_text}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_color_button">Cor principal dos textos</label>
                                                        <input type="color" name="config_color_text_principal" id="config_color_text_principal" class="form-control" placeholder="Informe a mensagem para o modal de privacidade" value="${config_color_text_principal}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_color_button">Cor secundaria dos textos</label>
                                                        <input type="color" name="config_color_text_secundario" id="config_color_text_secundario" class="form-control" placeholder="Informe a mensagem para o modal de privacidade" value="${config_color_text_secundario}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_color_button">Cor principal e dos botões</label>
                                                        <input type="color" name="config_color_button" id="config_color_button" class="form-control" placeholder="Informe a mensagem para o modal de privacidade" value="${config_color_button}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_color_button_text">Cor de textos dos botões</label>
                                                        <input type="color" name="config_color_button_text" id="config_color_button_text" class="form-control" placeholder="Informe a mensagem para o modal de privacidade" value="${config_color_button_text}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_color_buttons_hover">Cor de foco nos botões</label>
                                                        <input type="color" name="config_color_buttons_hover" id="config_color_buttons_hover" class="form-control" placeholder="Informe a mensagem para o modal de privacidade" value="${config_color_buttons_hover}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_color_link">Cor dos links </label>
                                                        <input type="color" name="config_color_link" id="config_color_link" class="form-control" placeholder="Informe a mensagem para o modal de privacidade" value="${config_color_link}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_color_icons">Cor dos icones </label>
                                                        <input type="color" name="config_color_icons" id="config_color_icons" class="form-control" placeholder="Informe a mensagem para o modal de privacidade" value="${config_color_icons}" />
                                                    </div>
                                                </div>
                                                <!-- end cores -->

                                                <!-- INFORMAÇÕES DE PRIVACIDADE -->

                                                <div class="col-sm-12">
                                                    <br>
                                                    <h4 class="separator-line"><b>Informações de LGPD</b></h4>
                                                    <hr>
                                                </div>

                                                <div class="col-md-6 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_lgpd_texto">Mensagem para Modal de Privacidade</label>
                                                        <input type="text" name="config_lgpd_texto" id="config_lgpd_texto" class="form-control" placeholder="Informe a mensagem para o modal de privacidade" value="${config_lgpd_texto}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_lgpd_link">Link para políticas de segurança da Imobiliária</label>
                                                        <input type="text" name="config_lgpd_link" id="config_lgpd_link" class="form-control" placeholder="Ex: https://linkdepoliticadeseguranca.com" value="${config_lgpd_link}" />
                                                    </div>
                                                </div>
                                                <!-- INFORMAÇÕES DE PRIVACIDADE -->

                                                <div class="col-sm-12">
                                                    <br>
                                                    <h4 class="separator-line"><b>Informações de Contato</b></h4>
                                                    <b><i class="fa fa-info-circle"></i> Preencha todos os campos de endereço para que o local de sua imobiliária apareça no rodapé do site!</b>
                                                    <hr>
                                                </div>


                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_cep">CEP </label>
                                                    <input type="text" class="form-control cep" name="config_site_cep" value="${config_site_cep}" placeholder="Ex: 99999-999"><br><br>
                                                </div>
                                                
                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_num">Número </label>
                                                    <input type="text" class="form-control numero" name="config_site_num" value="${config_site_num}" placeholder="Ex: 123"><br><br>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_rua">Endereço </label>
                                                    <input type="text" class="form-control rua" name="config_site_rua" value="${config_site_rua}" placeholder="Ex: Rua João da Silva"><br><br>
                                                </div>

                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_bairro">Bairro </label>
                                                    <input type="text" class="form-control bairro" name="config_site_bairro" value="${config_site_bairro}" placeholder="Ex: Morumbi"><br><br>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_cidade">Cidade </label>
                                                    <input type="text" class="form-control cidade" name="config_site_cidade" value="${config_site_cidade}" placeholder="Ex: São Paulo"><br><br>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_uf">UF </label>
                                                    <input type="text" class="form-control uf" name="config_site_uf" value="${config_site_uf}" placeholder="Ex: SP"><br><br>
                                                </div>



                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_telefone">Telefone Comercial </label>
                                                    <input type="text" class="form-control fone" name="config_site_telefone" value="${config_site_telefone}" placeholder="Ex: (11) 91919-1919"><br><br>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_telefone">Whatsapp Comercial </label>
                                                    <input type="text" class="form-control fone" name="config_site_telefone2" value="${config_site_telefone2}" placeholder="Ex: (11) 91919-1919"><br><br>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_email">Email Comercial </label>
                                                    <input type="text" class="form-control" name="config_site_email" value="${config_site_email}" placeholder="Ex: contato@suaImobiliária.com.br"><br><br>
                                                </div>

                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_tel_admin">Telefone Administrativo </label>
                                                    <input type="text" class="form-control fone" name="config_site_tel_admin" value="${config_site_tel_admin}" placeholder="Ex: (11) 91919-1919"><br><br>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_whats_admin">Whatsapp Administrativo </label>
                                                    <input type="text" class="form-control fone" name="config_site_whats_admin" value="${config_site_whats_admin}" placeholder="Ex: (11) 91919-1919"><br><br>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label for="config_site_email_admin">Email Administrativo </label>
                                                    <input type="text" class="form-control" name="config_site_email_admin" value="${config_site_email_admin}" placeholder="Ex: contato@suaImobiliária.com.br"><br><br>
                                                </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <label for="config_site_funcionamento">Horário </label>
                                                    <input type="text" class="form-control" name="config_site_funcionamento" value="${config_site_funcionamento}" placeholder="Ex: das 09:00 às 17:00"><br><br>
                                                </div>


                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="config_site_chat_code">Código de chat externo</label>
                                                        <span class="float-right pt-1"><i class="fa fa-info-circle"></i> Copiar aqui o script de chat externo, como o <a href="https://www.jivochat.com/" target="_blank">Jivochat</a> ou <a target="_blank" href="https://www.zendesk.com/chat/?from=zp">zopim</a></span>
                                                        <textarea type="text" name="config_site_chat_code" id="config_site_chat_code" class="form-control" rows="5">
                                                        ${config_site_chat_code}
                                                    </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 text-center">
                                                    <div class="form-group ">

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

        let updated = '${config_updated}'.split(' ');
        let hora = updated[1];
        updated = updated[0].split('-');

        updated = updated[2] + '/' + updated[1] + '/' + updated[0] + ' ' + hora;
        var app = new Vue({
            el: '#seo',
            data: {
                titulo: '${config_site_slogan}',
                desc: '${config_site_description}',
                categorias: null,
                cat_url: '${categoria_pagina_url}',
                pagina_url: '${pagina_url}',
                pagina_updated: updated,
                pagina_nome: null,
                img: '',
                link: null,
                categoria_nome: null
            },
            created: function() {

            }
        });

        setTimeout(() => {

            image = `
            <img src="${baseUri}/media/site/${config_site_logo}">
            `;
            $("#img_facebook").html(image);
            $("#img_facebook").find('img').addClass('card-img-top');
            $("#img_facebook").find('img').css({
                "width": "100%",
                "height": "200px",
                "object-fit": "cover"
            });

        }, 500);

        $(document).ready(function() {
            $("#keywords_seo").attr('name', 'produto_keywords');
            $("#pagina_desc").attr('name', 'produto_desc');

            $('#keywords_seo').tagsinput({
                confirmKeys: [32],
                delimiter: ',',
            });

            $("#labelDesc").html('Descrição da Imobiliária');

        });


        $("#descSeo").html('- ${config_site_author}');

        $("#keywords_seo").val("${config_site_keywords}");
        $("#pagina_desc").val("${config_site_description}");

        function changeSeo(id, campo) {
            if (campo == 'titulo') {
                app.titulo = $(id).val();
            }
        }
        $("#pagina_desc").change(() => {
            $("#config_site_description").val($("#pagina_desc").val());
        });
        $("#keywords_seo").change(() => {
            $("#config_site_keywords").val($("#keywords_seo").val());
        });
    </script>
    <script>
        $(".supermenu-informacoes").addClass("menu-open");
        $(".menu-informacoes").addClass("active");
    </script>
</body>

</html>