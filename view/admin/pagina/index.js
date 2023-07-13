var table;
var vm = new Vue({
    el: '#vm',
    data: {
        posts: null,
        rm: null,
        url: null,
    },
    methods: {
        listar: function() {
            var url = baseUri + '/PaginaAdmin/lista/';
            var self = this;
            $.getJSON(url, {}, function(dados) {
                splash_dt();
            }).then(function(dados) {
                if (dados) {
                    self.posts = dados;
                } else {
                    self.posts = null;
                }
                setTimeout(function() {
                    $('#tbl-splash').hide().promise().done($('#tbl-div').show());
                    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-primary mx-1 ';
                    table = $("#datatable").DataTable({
                        language: datatable_ptbr,
                        aaSorting: [],
                        retrieve: true,
                        rowReorder: true,
                        "pageLength": 100,
                    });
                }, 500);
            });
        },
        remover: function(dt) {
            vm.$data.rm = dt.pagina_id;
            vm.$data.url = dt.pagina_capa;
            $('#modal-remove').modal('show');
        },
        remove: function(id, url) {
            var url_remove = baseUri + '/PaginaAdmin/remover/';
            $.post(url_remove, { id: id, img: url }).then(function(rs) {
                if (rs == 1) {
                    alert_success('Ação realizada com sucesso!', 'Item removido');
                    vm.listar();
                } else {
                    alert_error('Ação não pode ser realizada!');
                }
            });
            $('#modal-remove').modal('hide');
        },

        mudar_status: function(obj) {
            var self = this;
            var id = obj.pagina_id;
            var status = obj.pagina_status;
            if (parseInt(id) > 0) {
                var url = baseUri + '/paginaAdmin/altera_status/';
                $.post(url, { id: id, pagina_status: status }).then(function(rs) {
                    if (rs == '') {
                        // alert_success('Ação realizada com sucesso!', 'Item removido');
                    } else {
                        alert_error('Ação não pode ser realizada!');
                    }
                    self.listar();
                });
            }
        }
    },
    created: function() {
        this.listar();
    }
});
// click do modal
$('#btn-remove').on('click', function() {
    if (vm.$data.rm !== null) {
        vm.remove(vm.$data.rm, vm.$data.url);
    }
});