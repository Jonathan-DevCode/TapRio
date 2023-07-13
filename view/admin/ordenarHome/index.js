var table;
var vm = new Vue({
    el: '#vm',
    data: {
        sessoes: null,
    },
    methods: {
        listar: function() {
            var url = baseUri + '/OrdenarHome/lista/';
            var self = this;
            $.getJSON(url, {}, function(dados) {}).then(function(dados) {
                splash_dt();

                self.sessoes = dados;
                setTimeout(function() {
                    $('#tbl-splash').hide().promise().done($('#tbl-div').show());
                    table = $('#datatable').DataTable({
                        language: datatable_ptbr,
                        aaSorting: [],
                        retrieve: true,
                        responsive: true,
                        rowReorder: true,
                        "displayLength": 100,
                        "pageLength": 100,
                    });
                }, 500);

            });

        },
        mudar_status: function(sessao) {
            $('[data-toggle="tooltip"]').tooltip('dispose');
            var url = baseUri + '/OrdenarHome/altera_status/';
            var self = this;
            $.post(url, { id: sessao.order_home_id, status: sessao.order_home_status }).then(function(res) {
                res = JSON.parse(res);
                if (res.status != undefined && res.status == 200) {
                    alert_success('Procedimento realizado com sucesso!');
                    // $('[data-toggle="tooltip"]').tooltip('dispose');
                    self.listar();
                } else {
                    alert_error('Ação não pode ser realizada ou você não tem permissão!');
                }
            });
        },
    },
    created: function() {
        this.listar();

    }
});

$(document).ready(function() {
    setTimeout(function() {
        table.on('row-reorder', function(e, diff, edit, ) {
            var url = baseUri + '/OrdenarHome/ordenar/';
            if (diff.length > 0) {
                $.post(url, { diff: JSON.stringify(diff) }).then(function(rs) {
                    vm.listar();

                });
            }
        });

    }, 1200);
});