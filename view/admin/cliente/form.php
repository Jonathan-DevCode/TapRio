<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Clientes</title>
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
                            <h1>Gerenciar Cliente <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/cliente/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Gerenciar sua imobiliária</a></li>
                                <li class="breadcrumb-item"><a>Cliente</a></li>
                                <li class="breadcrumb-item active">Gerenciar Cliente</li>
                            </ol>
                        </div>
                    </div>
            </section>
            <section class="content" id="vm">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 card">
                            <div class="card-body">

                                <div class="content">

                                    <form autocomplete="off" method="post" action="<?= Http::base() ?>/cliente/gravar/">
                                        <input type="hidden" name="cliente_id" value="${cliente_id}" />
                                        <div class="form-group pt-3 ">
                                            <h4 class="separator-line" id="tit_form">Dados Pessoais</h4>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label id="label_nome" for="cliente_nome">Nome Completo</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" name="cliente_nome" id="cliente_nome" required class="form-control" placeholder="Nome do cliente" value="${cliente_nome}" />
                                                </div>
                                            </div>

                                            <!-- <div class="col-lg-3 col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label for="cliente_nascimento">Data de Nascimento</label>
                                                    <input type="date" name="cliente_nascimento" id="cliente_nascimento" class="form-control" placeholder="Data de Nascimento" value="${cliente_nascimento}" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label for="cliente_rg">RG</label>
                                                    <input type="text" name="cliente_rg" id="cliente_rg" class="form-control rg" placeholder="RG do cliente" value="${cliente_rg}" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label for="cliente_cpf">CPF</label>
                                                    <input type="text" name="cliente_cpf" id="cliente_cpf" class="form-control cpf" placeholder="CPF do cliente" value="${cliente_cpf}" />
                                                </div> -->
                                            </div>
                                        </div>

                                        <div class="form-group pt-3 ">
                                            <h4 class="separator-line" id="tit_form">Link de pesquisa</h4>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
                                                <div class="form-group">
                                                    <label for="">Quartos</label>
                                                    <input type="number" class="form-control" name="cliente_busca_quartos" value="${cliente_busca_quartos}" placeholder="Ex: 2">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
                                                <div class="form-group">
                                                    <label for="">Suítes</label>
                                                    <input type="number" class="form-control" name="cliente_busca_suites" value="${cliente_busca_suites}" placeholder="Ex: 2">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
                                                <div class="form-group">
                                                    <label for="">Banheiros</label>
                                                    <input type="number" class="form-control" name="cliente_busca_banheiros" value="${cliente_busca_banheiros}" placeholder="Ex: 2">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
                                                <div class="form-group">
                                                    <label for="">Vagas</label>
                                                    <input type="number" class="form-control" name="cliente_busca_vagas" value="${cliente_busca_vagas}" placeholder="Ex: 2">
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
                                                <div class="form-group">
                                                    <label for="">Área (de)</label>
                                                    <input type="number" class="form-control" name="cliente_busca_area_de" value="${cliente_busca_area_de}" placeholder="Ex: 170">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2 align-self-end">
                                                <div class="form-group">
                                                    <label for="">Área (até)</label>
                                                    <input type="number" class="form-control" name="cliente_busca_area_ate" value="${cliente_busca_area_ate}" placeholder="Ex: 170">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label for="">Preço (de)</label>
                                                    <input type="text" class="form-control moeda-imovel" name="cliente_busca_preco_de" value="${cliente_busca_preco_de}" placeholder="Ex: 170">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3 align-self-end">
                                                <div class="form-group">
                                                    <label for="">Preço (até)</label>
                                                    <input type="text" class="form-control moeda-imovel" name="cliente_busca_preco_ate" value="${cliente_busca_preco_ate}" placeholder="Ex: 170">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label for="">Bairro</label>
                                                    <input type="text" class="form-control" name="cliente_busca_bairro" value="${cliente_busca_bairro}" placeholder="Ex: Centro">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label for="">Cidade</label>
                                                    <input type="text" class="form-control" name="cliente_busca_cidade" value="${cliente_busca_cidade}" placeholder="Ex: São Paulo">
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Tipo de imóvel</label>
                                                    <select name="cliente_busca_tipo_imovel" id="cliente_busca_tipo_imovel" class="form-control">
                                                        <?php if(isset($data['categoria_imovel'][0])): ?>
                                                            <?php foreach($data['categoria_imovel'] as $cat): ?>
                                                                <option value="<?= $cat->categoria_imovel_nome ?>"><?= $cat->categoria_imovel_nome ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Condomínio</label>
                                                    <select name="cliente_busca_condominio_id" id="cliente_busca_condominio_id" class="form-control">
                                                        <option value="0">Sem condomínio</option>
                                                        <?php if(isset($data['condominio'][0])): ?>
                                                            <?php foreach($data['condominio'] as $cond): ?>
                                                                <option value="<?= $cond->condominio_id ?>"><?= $cond->condominio_nome ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Negociação</label>
                                                    <select name="cliente_busca_negociacao" id="cliente_busca_negociacao" class="form-control">
                                                        <option value="venda">Venda</option>                                                        
                                                        <option value="aluguel">Aluguel</option>                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label for="">Link para busca do cliente <a href="${baseUri}/imovel/lista/${cliente_busca_link}" target="_blank"><i class="fa fa-share"></i></a></label>
                                                    <input type="text" class="form-control" disabled value="${baseUri}/imovel/lista/${cliente_busca_link}" placeholder="">
                                                </div>
                                            </div>


                                        </div>


                                        <section>
                                            <div>
                                                <br>
                                                <h4 class="separator-line">Dados de Contato</h4>
                                                <hr>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cliente_telefone">Telefone 1</label>
                                                        <input type="text" name="cliente_telefone" id="cliente_telefone" class="form-control fone" placeholder="informe um telefone de contato" value="${cliente_telefone}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cliente_telefone2">Telefone 2</label>
                                                        <input type="text" name="cliente_telefone2" id="cliente_telefone2" class="form-control fone" placeholder="informe um telefone de contato" value="${cliente_telefone2}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cliente_celular">Celular 1</label>
                                                        <input type="text" name="cliente_celular" id="cliente_celular" class="form-control fone" placeholder="informe um telefone de contato" value="${cliente_celular}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cliente_celular2">Celular 2</label>
                                                        <input type="text" name="cliente_celular2" id="cliente_celular2" class="form-control fone" placeholder="informe um telefone de contato" value="${cliente_celular2}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="cliente_email">E-mail Principal</label>
                                                        <span class="text-danger"> *</span>
                                                        &nbsp;&nbsp;<span id="email_error" class="text-danger"></span>
                                                        <input type="email" name="cliente_email" id="cliente_email" class="form-control" autocomplete="off" value="${cliente_email}" placeholder="informe um endereço de e-mail" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">Corretor responsável <span class="text-danger">*</span></label>
                                                        <select name="cliente_user_id" id="cliente_user_id" class="form-control">
                                                            <?php if (isset($data['users'][0])) : ?>
                                                                <?php foreach ($data['users'] as $user) : ?>
                                                                    <option value="<?= $user->usuario_id ?>"><?= $user->usuario_nome ?></option>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </section>
                                        <section>
                                            <!-- <div>
                                                <br>
                                                <h4 class="separator-line">Endereço</h4>
                                                <hr>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cliente_cep">CEP</label>
                                                        <span id="cep-invalido" class="text-danger"></span>
                                                        <input type="text" name="cliente_cep" id="cliente_cep" class="form-control cep" maxlength="9" placeholder="informe o cep" value="${cliente_cep}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <div class="hide-elems">
                                                            <label for="cliente_rua">Endereço</label>
                                                            <input type="text" name="cliente_rua" id="cliente_rua" class="form-control rua" placeholder="Informe o endereço" value="${cliente_rua}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cliente_num">Número</label>
                                                        <input type="text" name="cliente_num" id="cliente_num" class="form-control numero" placeholder="informe o número" value="${cliente_num}" />
                                                    </div>
                                                </div>


                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cliente_bairro">Bairro</label>
                                                        <input type="text" name="cliente_bairro" id="cliente_bairro" class="form-control bairro" placeholder="informe o nome do bairro" value="${cliente_bairro}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cliente_complemento">Complemento</label>
                                                        <input type="text" name="cliente_complemento" id="cliente_complemento" class="form-control" placeholder="ex: Sala 5 / Apto 15" value="${cliente_complemento}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cliente_cidade">Cidade</label>
                                                        <input type="text" name="cliente_cidade" id="cliente_cidade" class="form-control cidade" placeholder="informe o nome da cidade" value="${cliente_cidade}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cliente_uf">UF/Estado</label>
                                                        <input type="text" name="cliente_uf" id="cliente_uf" class="form-control uf" placeholder="Informe o estado ex: SP" value="${cliente_uf}" />
                                                    </div>
                                                </div>
                                            </div> -->

                                            <div>
                                                <br>
                                                <h4 class="separator-line">Observações</h4>
                                                <hr>
                                            </div>

                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="cliente_obs">Caso exista uma observação neste cliente, insira no campo abaixo</label>
                                                    <textarea name="cliente_obs" id="cliente_obs" class="form-control" cols="300" rows="10">${cliente_obs}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 text-center menu-access">
                                                <div class="form-group text-center">
                                                    <br />
                                                    <button type="submit" id="btn-send" class="btn btn-primary"><i class="fas fa-check-circle"></i> Gravar Dados
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
    <script src="${baseUri}/view/admin/cliente/form.js"></script>


    <script>
        $(".supermenu-clientes").addClass("menu-open");
        $(".menu-clientes").addClass("active");
        $("#cliente_user_id").val("${cliente_user_id}").trigger("change");
        $("#cliente_busca_condominio_id").val("${cliente_busca_condominio_id}").trigger("change");
        $("#cliente_busca_tipo_imovel").val("${cliente_busca_tipo_imovel}").trigger("change");
        $("#cliente_busca_negociacao").val("${cliente_busca_negociacao}").trigger("change");



    </script>
</body>

</html>