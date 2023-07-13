var vm = new Vue({
    el: '#vm',
    data: {
        logs: null,
        log: null,
    },
    methods: {
        listar: function() {
            var url = baseUri + '/usuario/listLogs/';
            var self = this;
            $.post(url, {})
            .then(function(dados) {
                splash_dt();
                self.logs = JSON.parse(dados);
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
                }, 100);
            });
        },
        showDetail: function(log_id) {
            var url = baseUri + '/usuario/getLog/';
            var self = this;
            $.post(url, {log_id: log_id})
            .then(function(dados) {
                vm.log = JSON.parse(dados);
                console.log(vm.log);
                 

                $("#modal-log").modal("show");
            });
        },
        remover: function (dt) {
            vm.$data.rm = dt.log_id;
            $('#modal-remove').modal('show');
        },
        remove: function () {
            let id = vm.$data.rm;
            var url_remove = baseUri + '/log/remove/';
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
        }

    },
    created: function() {
        $('#tbl-div').hide().promise().done($('#tbl-splash').show());
        this.listar();
    }
});