<div class="row">
    <div class="col-12 col-sm-12">
        <p><b>Dica: </b> Insira os arquivos deste imóvel.</p>
    </div>

    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
        <label for="">Título do arquivo</label>
        <input type="text" class="form-control" id="arquivo_titulo" name="arquivo_titulo">
    </div>
    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
        <label for="">Arquivo</label>
        <br>
        <label for="arquivo_file" class="btn btn-outline-success w-100" id="arquivo_file_label"><i class="fa fa-file"></i> Selecione seu arquivo</label>
        <input type="file" class="form-control" id="arquivo_file" name="arquivo_file" style="display: none;">
    </div>
    <div class="col-12 col-sm-12 col-md-4 col-lg-4 align-self-end">
        <button class="btn btn-success w-100 mb-2"><i class="fa fa-save"></i> Salvar arquivo</button>
    </div>

    
</div>
<hr>
<!-- grid -->
<div class="row">
    <div class="col-sm-12 mt-3">
        <h4>Arquivos deste imóvel</h4>
    </div>
    <div class="col-sm-12 mt-2" v-if="arquivos != null">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Atributo</th>
                    <th scope="col">Valor</th>
                    <th width="50">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="arq in arquivos">
                    <td>{{ arq.imovel_arquivo_nome }}</td>
                    <td>
                        <a class="btn btn-outline-primary btn-sm" title="download" target="_blank" :href="'${baseUri}/media/arquivos/' + arq.imovel_arquivo_url" ><i class="fa fa-download"></i> Fazer Download</a>
                    </td>
                    <td width="50">
                        <a class="btn btn-danger btn-sm" title="Remover" v-on:click="show_remove_arquivo(arq)"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-12 mt-2" v-if="arquivos == null">
        <p>
            Nenhum arquivo cadastrado
        </p>
    </div>
</div>

<!-- modais -->
<div id="modalRemoveArquivo" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Remover Arquivo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <i class="text-warning fa fa-4x fa-exclamation-triangle"></i>
                        <br></br>
                        <h2 class="text-center">Atenção!</h2>
                        <p class="text-center" style="color: black" v-if="arquivo_remove">Você está prestes a remover o arquivo <b>{{ arquivo_remove.imovel_arquivo_nome }}</b> e essa ação é irreversível.<br>
                            Deseja realmente prosseguir?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                <button type="button" v-on:click="remove_arquivo()" class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash"></i> Remover</button>
            </div>
        </div>
    </div>
</div>