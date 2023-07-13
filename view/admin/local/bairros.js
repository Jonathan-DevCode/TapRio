var vm = new Vue({
    el: '#vm',
    data: {
        cidades: null,
        bairros: null,
        ufs: null,
        rm: null,
    },
    methods: {
        listar_cidades: function () {
            var url = baseUri + '/local/lista_cidades/';
            $.post(url, {})
                .then(res => {
                    vm.cidades = JSON.parse(res);
                })
        },
        listar: function () {
            var url = baseUri + '/local/lista_bairros/';
            splash_dt();
            $.post(url, {})
                .then(res => {
                    vm.bairros = JSON.parse(res);
                    reload_dt_vue();
                })
        },
        show_novo: function () {
            $("#bairro_id").val("");
            $("#bairro_titulo").val("");
            $("#bairro_cidade").val("0").trigger('change');
            $('#modalAdd').modal('show');
        },
        show_edit: function (bairro) {
            $("#bairro_id").val(bairro.bairro_id);
            $("#bairro_titulo").val(bairro.bairro_titulo);
            $("#bairro_cidade").val(bairro.bairro_cidade).trigger('change');
            $('#modalAdd').modal('show');
        },

        remover: function (dt) {
            vm.$data.rm = dt.bairro_id;
            $('#modal-remove').modal('show');
        },
        remove: function () {
            let id = vm.$data.rm;
            var url_remove = baseUri + '/local/bairro_remove/';
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
        this.listar_cidades();
    }
});

$("#btn-remove").click(function () {
    vm.remove();
})