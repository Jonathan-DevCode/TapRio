<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="${baseUri}/view/admin/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="${baseUri}/view/admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="${baseUri}/view/admin/assets/dist/js/adminlte.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="${baseUri}/view/admin/assets/dist/js/demo.js"></script>
<script src="${baseUri}/view/admin/assets/dist/js/vue.min.js"></script>
<!-- CONST VARS -->
<script>
    const baseUri = '<?= Http::base() ?>';
    const baseUriSystem = '<?= Http::base() ?>';
    const site_modo = '${config_site_modo}';
    var isAdmin = false;
    <?php if (Usuario::verifyIsAdmin()) : ?>
        var isAdmin = true;
    <?php endif; ?>
</script>
<!-- CONST VARS -->
<script src="${baseUri}/view/admin/assets/plugins/dropify/dist/js/dropify.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/dropzone-master/dist/dropzone.js"></script>
<!-- DataTables  & Plugins -->
<script src="${baseUri}/view/admin/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/datatables/dataTables.rowReorder.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/sortable/Sortable.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="${baseUri}/view/admin/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/summernote/summernote-lite.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/summernote/lang/summernote-pt-BR.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/toast-master/js/jquery.toast.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/jszip/jszip.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/lightbox/js/lightbox.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/select2/js/select2.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="${baseUri}/view/admin/assets/plugins/jquery.mask.min.js"></script>
<script src="${baseUri}/view/admin/app-js/datatable.js"></script>
<script src="${baseUri}/view/admin/app-js/main.js"></script>
<script src="${baseUri}/view/admin/app-js/endereco.js"></script>
<script src="${baseUri}/view/admin/app-js/validacoes.js"></script>