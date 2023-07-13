<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
    <title>${config_site_title} | Integrações</title>
    @(admin.layout.maincss)
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="vm">
        @(admin.layout.topo)
        @(admin.layout.menu-lateral)
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Gerenciar Integração <a class="btn btn-primary btn-sm ml-3" href="<?= Http::base() ?>/integracoes/"><i class="fa fa-arrow-left"></i>Voltar</a></h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a>Integrações</a></li>
                                <li class="breadcrumb-item active">Gerenciar Integração</li>
                            </ol>
                        </div>
                    </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="<?= Http::base() ?>/integracoes/gravar/" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 mb-3">
                                                <input type="hidden" name="integracao_id" id="integracao_id" value="${integracao_id}">
                                                <input type="hidden" name="imoveis_changed" id="imoveis_changed" value="0">
                                                <label for="">Título da integração</label>
                                                <input type="text" class="form-control" name="integracao_nome" value="${integracao_nome}">
                                            </div>
                                            <div class="col-12 col-sm-12 text-center">
                                                <button type="submit" id="btn-send" class="btn btn-primary"><i class="fas fa-check-circle"></i> Salvar integração</button>
                                            </div>
                                            <div class="col-12 col-sm-12">
                                                <hr>
                                                <label for="">Lista de imóveis da integração</label>
                                                <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <?php if (Usuario::verifyPermission('integracoes', 'gerenciar')) : ?>
                                                                <th><input type="checkbox" name="integracao_imovel_all" id="integracao_imovel_all" value="1"></th>
                                                            <?php endif; ?>
                                                            <th>Referência</th>
                                                            <th>Categoria</th>
                                                            <th>Transação</th>
                                                            <th>Título</th>
                                                            <th>Valor</th>
                                                            <?php if (Usuario::verifyPermission('integracoes', 'gerenciar')) : ?>
                                                            <th>Destaque</th>
                                                            <?php endif; ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="imovel in imoveis" v-if="imovel.imovel_status == 1">
                                                            <?php if (Usuario::verifyPermission('integracoes', 'gerenciar')) : ?>
                                                                <td>
                                                                    <input v-if="imoveis_integrados[imovel.imovel_id] && imoveis_integrados[imovel.imovel_id].is_checked == 1" checked type="checkbox" class="checkbox-imoveis" name="integracao_imovel_imovel_id[]" :value="imovel.imovel_id">
                                                                    <input v-else type="checkbox" class="checkbox-imoveis" name="integracao_imovel_imovel_id[]" :value="imovel.imovel_id">
                                                                </td>
                                                            <?php endif; ?>
                                                            <td>{{imovel.imovel_ref}}</td>
                                                            <td>{{imovel.categoria_imovel_nome}}</td>
                                                            <td>{{imovel.imovel_tipo_negociacao_label}}</td>
                                                            <td>{{imovel.imovel_titulo}}</td>
                                                            <td>
                                                                <span v-if="imovel.imovel_tipo_negociacao == 'aluguel'">{{ formatMoney(imovel.imovel_valor_locacao) }}</span>
                                                                <span v-else>{{ formatMoney(imovel.imovel_valor_venda) }}</span>
                                                            </td>
                                                            <?php if (Usuario::verifyPermission('integracoes', 'gerenciar')) : ?>
                                                                <td>
                                                                    <select :name="'integracao_imovel_destaque_' + imovel.imovel_id" :id="'integracao_imovel_destaque_' + imovel.imovel_id" class="form-control select-imoveis">
                                                                        <option value="padrao">Padrão</option>
                                                                        <option value="destaque">Destaque</option>
                                                                        <option value="super_destaque">Super Destaque</option>
                                                                        <option value="destaque_especial">Destaque Especial</option>
                                                                    </select>
                                                                </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    </tbody>
                                                </table>
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

        @(admin.layout.footer)
        @(admin.layout.modal-remove)
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @(admin.layout.mainjs)
    <script src="${baseUri}/view/admin/integracao/form.js"></script>
    <script>
        $(".supermenu-integracoes").addClass("menu-open");
        $(".menu-integracoes").addClass("active");
    </script>
</body>

</html>