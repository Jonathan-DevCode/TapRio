var vm = new Vue({
    el: '#vm',
    data: {
        imoveis: null,
    },
    methods: {
        listar: function () {
            var url = baseUri + '/imovelAdmin/listaChaves/';
            splash_dt();
            $.post(url, {})
                .then(res => {
                    vm.imoveis = JSON.parse(res);
                    console.log(vm.imoveis);
                    reload_dt_vue();
                })
        },

    },
    created: function () {
        $('#tbl-div').hide().promise().done($('#tbl-splash').show());
        this.listar();
    }
});