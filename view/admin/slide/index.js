var table;
var vm = new Vue({
    el: '#vm',
    data: {
        imgUrl: "",
        slides: null,
        rm: null,
        url: null,
    },
    methods: {
        listar: function() {

            var url = baseUri + '/slide/lista/';
            var self = this;
            $.post(url, {}, function(dados) {}).then(function(dados) {
                // splash_dt();
                self.slides = JSON.parse(dados);
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
        limpar: function() {
            $('.anexo-acao').html('Incluir');
            $('#slide_id').val('');
            $('#slide_status').val(1);
            $('#slide_url').val('');
            $('#slide_texto').val('');
            $('#slide_titulo').val('');
            $('#slide_img').val('');
        },

        mudar_status: function(dt) {
            $('[data-toggle="tooltip"]').tooltip('dispose');
            var url = baseUri + '/slide/altera_status/';
            var self = this;
            var _status = dt;
            $.post(url, { id: _status.slide_id, slide_status: _status.slide_status }).then(function(rs) {
                if (rs == '') {
                    self.limpar();
                    // alert_success('Procedimento realizado com sucesso!');
                    // $('[data-toggle="tooltip"]').tooltip('dispose');
                    self.listar();
                } else {
                    alert_error('Ação não pode ser realizada ou você não tem permissão!');
                }
            });
        },
        remover: function(dt) {
            vm.$data.rm = dt.slide_id;
            vm.$data.url = dt.slide_img;
            $('#modal-remove').modal('show');
        },
        remove: function(id, url) {
            var url_remove = baseUri + '/slide/remover/';
            $.post(url_remove, { id: id, img: url }).then(function(rs) {
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
        this.listar();

    }
});

// modal excluir slide
$('#btn-remove').on('click', function() {
    if (vm.$data.rm !== null) {
        vm.remove(vm.$data.rm, vm.$data.url);
    }
});

$(document).ready(function() {
    setTimeout(function() {
        table.on('row-reorder', function(e, diff, edit, ) {
            var url = baseUri + '/slide/ordenar/';
            if (diff.length > 0) {
                $.post(url, { diff: JSON.stringify(diff) }).then(function(rs) {
                    vm.listar();
                });
            }
        });
    }, 1200);
    $('.dropify').dropify({
        messages: {
            default: '<div>Clique aqui para selecionar um arquivo</div>',
            replace: '<div>Clique em remover para selecionar um novo arquivo</div>',
            remove: 'Remover',
            error: 'Ocorreu um erro ao alterar o arquivo'
        },
        error: {
            'fileSize': 'O tamanho máximo permitido é de: ({{ value }}).',
            'minWidth': 'The image width is too small ({{ value }}}px min).',
            'maxWidth': 'The image width is too big ({{ value }}}px max).',
            'minHeight': 'The image height is too small ({{ value }}}px min).',
            'maxHeight': 'The image height is too big ({{ value }}px max).',
            'imageFormat': 'Os formatos de imagem permitidos são: ({{ value }}).',
            'fileExtension': 'As extensões permitidas são: ({{ value }}).'
        }
    });
    var drEvent = $('.dropify').dropify();

    drEvent.on('dropify.afterClear', function(event, element) {
        $("#slide_img").val('');
    });
});