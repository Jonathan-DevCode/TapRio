var datatable_ptbr = {
    "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "<small>Mostrando de _START_ até _END_ de _TOTAL_ registros</small>",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "MENU resultados por página",
    "sLengthMenu": "",
    "sLoadingRecords": "Carregando...",
    "sProcessing": "Processando...",
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "Pesquisar",
    "oPaginate": {
        "sNext": "Próx.",
        "sPrevious": "Ant.",
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
    }
};

var datatable_buttons = [{
        extend: 'csv',
        className: 'btn-sm',
        text: '<i class="fas fa-file-code"></i> <span class="hidden-xs-down">CSV</span>'
    },
    {
        extend: 'excel',
        className: 'btn-sm',
        text: '<i class="fas fa-file-excel"></i> <span class="hidden-xs-down">Excel</span>'
    },
    {
        extend: 'pdf',
        className: 'btn-sm',
        text: '<i class="fas fa-file-pdf"></i> <span class="hidden-xs-down">PDF</span>',
        exportOptions: {
            //columns: ':visible',
            /*
            format: {
                body: function (data, row, column, node) {
                    if (node.className == 'd-print-none') {
                        return ''
                    }
                    return node.innerText;
                }
            }*/
        },
        customize: function(win) {
            //$('#datatable').DataTable().columns('.d-print-none').visible(false);
            //console.log($('#datatable').DataTable().columns('.d-print-none'))
        }
    },
    {
        extend: 'print',
        className: 'btn-sm',
        exportOptions: {
            //columns: ':visible',
            //stripHtml: false
        },
        text: '<i class="fas fa-print"></i> <span class="hidden-xs-down">Imprimir</span>',
        customize: function(win) {
            //$(win.document.body).find('.d-print-none').remove();
            /*
            $(win.document.body).addClass('white-bg');
            $(win.document.body).css('font-size', '10px');
            $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
            */
        }
    }
];

function draw_buttons() {
    $('.dataTables_filter LABEL').css('margin-right', '0px').css('font-weight', 'bold').css('color', '#333');
    $('.dataTables_filter INPUT').css('margin-left', '0px');
    $('.dataTables_filter INPUT').css('padding-left', '0px');
    $('[data-toggle="tooltip"]').tooltip();
}


/*RELOAD DATATABLE -> VUE LOAD*/
var dtable;
var column;
reload_dt_vue = function(show_buttons = true) {
    $('#tbl-splash').hide().promise().done($('#tbl-div').show());
    if ($('#datatable').length > 0) {
        setTimeout(function() {
            $('#tbl-splash').hide().promise().done($('#tbl-div').show());
            let array_buttons = ["csv", "excel", "pdf", "print", "colvis"];
            if(!show_buttons) {
                array_buttons = [];

            }
            $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-primary mx-1 ';
            $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-primary mx-1 ';
            dtable = $("#datatable").DataTable({
                pageLength: 100,
                language: datatable_ptbr,
                "buttons": array_buttons
            }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
        }, 500);
    }

}

/* load splash Datatable*/
splash_dt = function() {
    if ($.fn.DataTable.isDataTable('#datatable')) {
        $('#tbl-div').hide().promise().done($('#tbl-splash').show());
        $('#datatable').DataTable().destroy();
    }
}