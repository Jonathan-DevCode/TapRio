
        <div id="modal-categoria" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form action="<?= Http::base() ?>/PaginaAdmin/gravar_categoria/" method="post" enctype="multipart/form-data">
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
