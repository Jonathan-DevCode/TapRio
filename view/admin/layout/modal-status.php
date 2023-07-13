<div id="modal-status" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Alterar Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="col-md-12 text-center">
                  <i class="text-warning fa fa-4x fa-exclamation-triangle"></i>
                  <br><br>
                  <h2 class="text-center">Atenção!</h2>
                  <p class="text-center" style="color: black">Você está prestes à alterar o status de um registro de <strong id="status_nome"></strong> para <strong id="status_reverso"></strong>. <br>
                  Deseja realmente prosseguir ?</p>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                <button id="btn-altera-status" type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check-circle"></i> Atualizar</button>
            </div>
        </div>
    </div>
</div>