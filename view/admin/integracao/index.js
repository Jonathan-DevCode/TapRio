var vm = new Vue({
    el: '#vm',
    data: {
        integracoes: null,
        ufs: null,
        rm: null,
    },
    methods: {
        listar: function () {
            var url = baseUri + '/integracoes/lista/';
            splash_dt();
            $.post(url, {})
                .then(res => {
                    vm.integracoes = JSON.parse(res);
                    reload_dt_vue();
                })
        },
        

        remover: function (dt) {
            vm.$data.rm = dt.integracao_id;
            $('#modal-remove').modal('show');
        },
        remove: function () {
            let id = vm.$data.rm;
            var url_remove = baseUri + '/integracoes/remove/';
            $.post(url_remove, { id: id }).then(function (rs) {
                console.log(rs);
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
            var url = baseUri + '/integracoes/altera_status/';
            var self = this;
            var _status = dt;
            $.post(url, { id: _status.integracao_id, integracao_status: _status.integracao_status }).then(function(rs) {
                if (rs == '') {                    
                    self.listar();
                } else {
                    alert_error('Ação não pode ser realizada ou você não tem permissão!');
                }
            });
        },
    },
    created: function () {
        $('#tbl-div').hide().promise().done($('#tbl-splash').show());
        this.listar();
    }
});

$("#btn-remove").click(function () {
    vm.remove();
})