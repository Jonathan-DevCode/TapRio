var vm = new Vue({
    el: '#vm',
    data: {
        imoveis: null,
        rm: null,
        foto_imovel_padrao: "https://archive.org/download/no-photo-available/no-photo-available.png",
    },
    methods: {
        formatMoney: function(value) {
            value =  Number(value).toLocaleString('pt-br', {
                style: 'currency',
                currency: 'BRL'
            });

            return value.replace(',00','')
        },
        listar: function () {
            var url = baseUri + '/imovelAdmin/listaSite/';
            splash_dt();
            $.post(url, {})
                .then(res => {
                    vm.imoveis = JSON.parse(res);
                    console.log(vm.imoveis);
                    reload_dt_vue(isAdmin);
                })
        },
        remover: function (dt) {
            vm.$data.rm = dt.imovel_id;
            $('#modal-remove').modal('show');
        },
        showSalvaImovel: function(imovel_id) {
            vm.imovel_salvar = imovel_id;
            $("#modal-salva").modal("show");
        },
        salvaImovel: function() {
            if(!vm.imovel_salvar) {
                return false;
            }

            var url_save = baseUri + '/imovelAdmin/salva_imovel_site/';
            $.post(url_save, { id: vm.imovel_salvar }).then(function (rs) {
                if (rs == 1) {
                    $("#modal-salva").modal("hide");
                    alert_success('Ação realizada com sucesso!', 'Item salvo');
                    vm.listar();
                } else {
                    alert_error('Ação não pode ser realizada!');
                }
            });

        },
        remove: function () {
            let id = vm.$data.rm;
            var url_remove = baseUri + '/imovelAdmin/remove/';
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
    }
});

$("#btn-remove").click(function () {
    vm.remove();
})