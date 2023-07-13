var vm = new Vue({
    el: '#vm',
    data: {
        atributos: null,
        rm: null,
        lista_fixa: ['Quartos', 'Suítes', 'Banheiros', 'Vagas', 'Área Útil', 'Área Total'],
    },
    methods: {
        listar: function () {
            var url = baseUri + '/atributo/lista/';
            splash_dt();
            $.post(url, {})
                .then(res => {
                    vm.atributos = JSON.parse(res);
                    reload_dt_vue();
                })
        },
        show_novo: function () {
            $("#atributo_id").val("");
            $("#atributo_titulo").val("");
            $("#atributo_icone").val("0").trigger('change');
            $('#modalAdd').modal('show');
        },
        show_edit: function (atributo) {
            $("#atributo_id").val(atributo.atributo_id);
            $("#atributo_titulo").val(atributo.atributo_titulo);
            $("#atributo_icone").val(atributo.atributo_icone).trigger('change');
            $('#modalAdd').modal('show');
        },

        remover: function (dt) {
            vm.$data.rm = dt.atributo_id;
            $('#modal-remove').modal('show');
        },
        remove: function () {
            let id = vm.$data.rm;
            var url_remove = baseUri + '/atributo/remove/';
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