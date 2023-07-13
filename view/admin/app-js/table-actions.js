var vm = new Vue({
    el: '#APP',
    data: {
        dados: null,
        rm: null,
        status: null,
        modUrl: null,
        postMudaStatus: null,
        postMudaStatusNome: null,
    },
    methods: {
        listar: function() {
            var url = baseUri + '/' + this.modUrl + '/lista/';
            var self = this;
            $.getJSON(url, {}, function(dados) {
                splash_dt();
            }).then(function(dados) {
                self.dados = dados;
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
        remover: function(dt) {
            vm.$data.rm = dt.id;
            $('#modal-remove').modal('show');
        },
        remove: function(id) {            
            var url_remove = baseUri + '/' + this.modUrl + '/remover/';
            var self = this;
            $.post(url_remove, { id: id })
                .then(function(rs) {
                    if (rs == 1) {
                        alert_success('Ação realizada com sucesso!', 'Item removido');
                        self.listar();
                    } else {
                        alert_error('Ação não pode ser realizada!');
                    }
                });
            $('#modal-remove').modal('hide');
        },
        prepare_muda_status: function(post) {
            vm.postMudaStatus = post;
            vm.postMudaStatusNome = post.cliente_nome;
            $("#modalMudaStatus").modal('show');
        },
        mudar_status: function() {
            $("#modalMudaStatus").modal('hide');
            $('[data-toggle="tooltip"]').tooltip('dispose');
            var url = baseUri + '/' + this.modUrl + '/altera_status/';
            var status = this.postMudaStatus;
            var self = this;
            $.post(url, { id: status.id, status: status.status }).then(function(rs) {
                if (rs == '') {
                    alert_success('Procedimento realizado com sucesso!');
                    $('[data-toggle="tooltip"]').tooltip('dispose');
                    self.listar();
                } else {
                    alert_error('Ação não pode ser realizada ou você não tem permissão!');
                }
            });
        },

        doc_exist: function(data) {
            var url = baseUri + '/valida/doc_exist/';
            $.post(url, { data: data }, function(rs) {
                // console.log(rs)
            })
        },
        email_exist: function(data) {
            var url = baseUri + '/valida/email_exist/';
            $.post(url, { data: data }, function(rs) {
                // console.log(rs)
            })
        },
        formatMoney: function (value) {
            value = Number(value).toLocaleString('pt-br', {
                style: 'currency',
                currency: 'BRL'
            });

            return value.replace(',00', '')
        }
    },
    created: function() {
        this.modUrl = $('#APP').data('url');        
        $('#tbl-div').hide().promise().done($('#tbl-splash').show());
        this.listar();
    }
});

$('#btn-remove').on('click', function() {
    if (vm.$data.rm !== null) {
        vm.remove(vm.$data.rm);
    }
});

