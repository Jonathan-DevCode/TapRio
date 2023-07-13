var vm = new Vue({
    el: '#vm',
    data: {
        cidades: null,
        ufs: null,
        rm: null,
    },
    methods: {
        listar_uf: function () {
            var url = baseUri + '/local/lista_ufs/';
            $.post(url, {})
                .then(res => {
                    vm.ufs = JSON.parse(res);
                })
        },
        listar: function () {
            var url = baseUri + '/local/lista_cidades/';
            splash_dt();
            $.post(url, {})
                .then(res => {
                    vm.cidades = JSON.parse(res);
                    reload_dt_vue();
                })
        },
        show_novo: function () {
            $("#cidade_id").val("");
            $("#cidade_titulo").val("");
            $("#cidade_uf").val("0").trigger('change');
            $('#modalAdd').modal('show');
        },
        show_edit: function (cidade) {
            $("#cidade_id").val(cidade.cidade_id);
            $("#cidade_titulo").val(cidade.cidade_titulo);
            $("#cidade_uf").val(cidade.cidade_uf).trigger('change');
            $('#modalAdd').modal('show');
        },

        remover: function (dt) {
            vm.$data.rm = dt.cidade_id;
            $('#modal-remove').modal('show');
        },
        remove: function () {
            let id = vm.$data.rm;
            var url_remove = baseUri + '/local/cidade_remove/';
            $.post(url_remove, { id: id }).then(function (rs) {
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
        this.listar_uf();
    }
});

$("#btn-remove").click(function () {
    vm.remove();
})