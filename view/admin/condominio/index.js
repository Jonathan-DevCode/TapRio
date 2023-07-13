var vm = new Vue({
    el: '#vm',
    data: {
        condominios: null,
        ufs: null,
        rm: null,
    },
    methods: {
        listar: function () {
            var url = baseUri + '/condominio/lista/';
            splash_dt();
            $.post(url, {})
                .then(res => {
                    vm.condominios = JSON.parse(res);
                    reload_dt_vue();
                })
        },

        remover: function (dt) {
            vm.$data.rm = dt.condominio_id;
            $('#modal-remove').modal('show');
        },
        remove: function () {
            let id = vm.$data.rm;
            var url_remove = baseUri + '/condominio/remove/';
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
    },
    created: function () {
        $('#tbl-div').hide().promise().done($('#tbl-splash').show());
        this.listar();
    }
});

$("#btn-remove").click(function () {
    vm.remove();
})