var vm = new Vue({
    el: '#vm',
    data: {
        usuario: null,
        rm: null,
        status: null,
    },
    methods: {


        listar: function() {
            var url = baseUri + '/usuario/lista/';
            var self = this;
            $.getJSON(url, {}, function(dados) {
                splash_dt();
            }).then(function(dados) {
                self.usuario = dados;
                setTimeout(function() {
                    $('#tbl-splash').hide().promise().done($('#tbl-div').show());
                    table = $('#datatable').DataTable({
                        language: datatable_ptbr,
                        aaSorting: [],
                        retrieve: true,
                        rowReorder: true,
                        "pageLength": 100,
                    });
                }, 100);
            });
        },

        remover: function(dt) {
            vm.$data.rm = dt.usuario_id;
            $('#modal-remove').modal('show');
        },
        remove: function(id) {
            var url_remove = baseUri + '/usuario/remove/';
            $.post(url_remove, { id: id }).then(function(rs) {
                if (rs == 1) {
                    alert_success('Ação realizada com sucesso!', 'Item removido');
                    vm.listar();
                } else {
                    alert_error('Ação não pode ser realizada!');
                }
            });
            $('#modal-remove').modal('hide');
        },
        mudar_status: function(dt) {
            $('[data-toggle="tooltip"]').tooltip('dispose');
            var url = baseUri + '/usuario/altera_status/';
            var self = this;
            $.post(url, { id: dt.usuario_id, status: dt.usuario_status }).then(function(rs) {
                if (rs == '') {
                    alert_success('Procedimento realizado com sucesso!');
                    self.listar();
                } else {
                    alert_error('Ação não pode ser realizada!');
                }
            });
        }
    },
    created: function() {
        $('#tbl-div').hide().promise().done($('#tbl-splash').show());
        this.listar();
    }
});