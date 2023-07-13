var table;
var vm = new Vue({
    el: '#vm',
    data: {
        emails: null,
        rm: null,
        url: null,
        postMudaStatus: null,
    },
    methods: {
        listar: function() {
            var url = baseUri + '/Newsletter/getAll/';
            var self = this;
            $.getJSON(url, {}, function(dados) {
                splash_dt();
            }).then(function(dados) {
                if (dados != null) {
                    vm.emails = dados;
                } else {
                    vm.emails = null;
                }
                setTimeout(function() {
                    $('#tbl-splash').hide().promise().done($('#tbl-div').show());
                    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-primary mx-1 ';
                    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-primary mx-1 ';
                    table = $('#datatable').DataTable({
                        language: datatable_ptbr,
                        aaSorting: [],
                        retrieve: true,
                        responsive: true,
                        rowReorder: true,
                        "displayLength": 100,
                        "pageLength": 100,
                        "buttons": ["csv", "excel", "pdf", "print", "colvis"]
                    }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
                }, 100);
            });
        },
        mudar_status: function(id, status) {
            $("#modalMudaStatus").modal('hide');
            $('[data-toggle="tooltip"]').tooltip('dispose');
            var url = baseUri + '/Newsletter/alteraStatus';
            $.post(url, { id: id, status: status }).then(function(rs) {
                if (rs.trim() == '1') {
                    alert_success('Procedimento realizado com sucesso!');
                    $('[data-toggle="tooltip"]').tooltip('dispose');
                    vm.listar();
                } else {
                    alert_error('Ação não pode ser realizada ou você não tem permissão!');
                }
            });
        },
        remover: function(dt) {
            vm.$data.rm = dt.newsletter_id;
            $('#modal-remove').modal('show');
        },
        remove: function(id) {
            var url_remove = baseUri + '/Newsletter/remover/';
            $.post(url_remove, { id: id }).then(function(rs) {
                if (rs == 1) {
                    alert_success('Ação realizada com sucesso!', 'Item removido');
                    vm.listar();
                } else {
                    alert_error('Ação não pode ser realizada!');

                }
            });
            $('#modal-remove').modal('hide');
        }
    },
    created: function() {
        $('#tbl-div').hide().promise().done($('#tbl-splash').show());
        this.listar();
    }
});
// click do modal
$('#btn-remove').on('click', function() {
    if (vm.$data.rm !== null) {
        vm.remove(vm.$data.rm);
    }
});