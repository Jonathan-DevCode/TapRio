$(function () {
    $('.date-calendar').bootstrapMaterialDatePicker({
        format: 'DD/MM/YYYY',
        lang: 'pt-br',
        weekStart: 0,
        clearButton: true,
        cancelText: '<i class="fa fa-times-circle"></i> Cancelar',
        clearText: '<i class="fa fa-eraser"></i> Limpar',
        okText: '<i class="fa fa-check-circle"></i> Salvar',

        time: false
    });
    $('.date-time-calendar').bootstrapMaterialDatePicker({
        format: 'DD/MM/YYYY HH:mm',
        lang: 'pt-br',
        weekStart: 0,
        cancelText: '<i class="fa fa-times-circle"></i> Cancelar',
        okText: '<i class="fa fa-check-circle"></i> Pronto ',
        time: false
    });
});