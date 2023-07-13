$(".supermenu-imoveis").addClass("menu-open");
$(".menu-imoveis-condominios").addClass("active");


$('#btn-remove-').on('click', function() {
    $('#modal-remove').modal('hide');
    vm.remover();
});

$('#btn-remove-all').on('click', function() {
    $('#modal-remove-all').modal('hide');
    vm.remove_all();
});



var vm = new Vue({
    el: '#vm',
    data: {

        galerias: null,
        selected: false,
        remove_a: false,
        selected: false,
        data_remove: new Array(),
    },
    methods: {

        listar_fotos: function() {
            let url = baseUri + '/Condominio/lista_img_condominio/id/' + $("#condominio_id").val();
            $.post(url, {})
                .then(res => {
                    res = JSON.parse(res);
                    vm.galerias = res;

                    setTimeout(() => {

                        var el = document.getElementById('sort');
                        if(el) {
                        var sortable = Sortable.create(el, {
                            animation: 750,
                            delay: delay_order,
                            easing: "cubic-bezier(1, 0, 0, 1)",
                            onChange: function(evt) {
                                var id = $(evt.item).data('id');
                                var data = new Array();
                                var div = $(evt.to).children();
                                div.each(function(index, element) {
                                    var obj = {
                                        'pos': index + 1,
                                        'foto_id': $(element).data('id')
                                    };
                                    data.push(obj);
                                });
                                var url = baseUri + '/Condominio/ordena_img/';
                                $.post(url, {
                                    condominio_id: $("#condominio_id").val(),
                                    data: data
                                }).then(function(rs) {
                                    if (parseInt(rs) == 0) {
                                        alert_success('Posição Atualizada');
                                    } else {
                                        alert_error('Não foi possível atualizar posição');
                                    }
                                });
                            }
                        });
                    }
                    }, 100)

                    if (res == null) {
                        vm.remove_a = false;
                    } else {
                        vm.remove_a = true;
                    }
                })
        },
        add_class_remove: function(item) {
            // var ele = $('#img-galeria-card-' + item.foto_condominio_id);
            // ele.toggleClass('custom-checkbox-active');

            // if (ele.hasClass('custom-checkbox-active')) {
            //     alert_warning('Foto foi marcada');
            // } else {
            //     alert_warning('Foto foi desmarcada');
            // }


            // var remove = $('.custom-checkbox-active');


            var ele = $('#foto-check-' + item.foto_condominio_id);
            ele.toggleClass('custom-checkbox-active');

            if (ele.hasClass('custom-checkbox-active')) {
                alert_warning('Foto foi marcada');
            } else {
                alert_warning('Foto foi desmarcada');
            }
            var remove = $('.custom-checkbox-active');

            var _this = this;
            _this.$data.data_remove = new Array();
            if (remove.length > 0) {
                remove.each(function(index, element) {
                    var obj = {
                        'id': $(element).data('remove'),
                        'url': $(element).data('url')
                    };
                    _this.$data.data_remove.push(obj);
                });
                this.selected = true;
            } else {

                this.selected = false;
            }
        },
        remove_img: function() {
            $('#modal-remove').modal('show');

        },
        show_rotaciona_img: function () {
            $('#modal-rotaciona').modal('show');

        },
        rotaciona_imagens: function () {
            var _this = this;
            var url = baseUri + '/Condominio/rotaciona_imagens/';
            $("#btn-rotacionar").addClass("d-none");
            $("#btn-rotacionar-loading").removeClass("d-none");
            $.post(url, { condominio_id: $("#condominio_id").val(), data: _this.$data.data_remove }).then(function (rs) {
                if (parseInt(rs) == 0) {

                    var remove = $('.custom-checkbox-active');

                    remove.each(function (index, element) {
                        $(element).removeClass('custom-checkbox-active');
                    });



                    // window.location.reload(false);
                    _this.listar_fotos();
                    _this.selected = false;

                    alert_success('Fotos rotacionadas com sucesso!');
                    $("#btn-rotacionar").removeClass("d-none");
                    $("#btn-rotacionar-loading").addClass("d-none");

                } else {
                    alert_error('Fotos não puderam ser rotacionadas');
                }
            });
        },

        createButtonRotaciona(gale){

            return `<button class="btn btn-primary" onclick="rotaciona('${gale.foto_condominio_img}', ${gale.foto_condominio_id})">
                <i class="fa fa-repeat" aria-hidden="true"></i>
            </button>
            <button class="btn btn-danger" onclick="remove_image_by_galery(${gale.foto_condominio_id}, '${gale.foto_condominio_url}')">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>

            `

        },
        remove_all: function() {
            var _this = this;
            var url = baseUri + '/Condominio/remove_all_img_condominio/';
            $.post(url, {
                condominio_id: $("#condominio_id").val()
            }).then(function(rs) {
                if (parseInt(rs) == 0) {
                    alert_success('Fotos apagadas com sucesso!');
                    this.selected = false;
                    setTimeout(() => _this.listar_fotos(), 300);

                } else {
                    alert_success('Fotos não puderam ser apagadas');
                }
            });
        },


        remover: function() {
            var _this = this;
            var url = baseUri + '/Condominio/remove_img/';
            $.post(url, {
                condominio_id: $("#condominio_id").val(),
                data: _this.$data.data_remove
            }).then(function(rs) {
                if (parseInt(rs) == 0) {

                    alert_success('Fotos apagadas com sucesso!');
                    var remove = $('.custom-checkbox-active');

                    remove.each(function(index, element) {
                        $(element).removeClass('custom-checkbox-active');
                    });

                    // window.location.reload(false);
                    _this.listar_fotos();
                    _this.selected = false;

                } else {
                    alert_error('Fotos não puderam ser apagadas');
                }
            });
        },

    },
    created: function() {

        this.listar_fotos();

    }
});


function rotaciona (image,id){

    var url = baseUri + '/Condominio/rotaciona_img/';
    $.post(url, {img:image}).then(function (rs) {
        vm.galerias = [];
        vm.listar_fotos();

        setTimeout(() => {
            $(`#btn-galeria-id-${id}`).click();
        }, 200);

    });
}


function remove_image_by_galery (foto_condominio_id,foto_condominio_url){
    var obj = {
        'id': foto_condominio_id,
        'url':foto_condominio_url
    };

    vm.$data.data_remove.push(obj);

    vm.remove_img();

    $('.lb-close').click();

}



Dropzone.autoDiscover = false;
Dropzone.prototype.defaultOptions.dictDefaultMessage = "Clique aqui ou arraste fotos";

dropzoneFotos = $("#form-galeria-img").dropzone({
    multiple: true,
    url: baseUri + "/Condominio/enviar_img/id/" + $("#condominio_id").val(),
    accept: function(file, done) {
        if (file.type == "image/jpeg" || file.type == "image/png" || file.type == "image/gif" || file.type == "image/jpg") {
            done();
        } else {
            alert_error('Erro ao enviar fotos do imóvel')
        }
    },
    complete: function(file) {
        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            setTimeout(function() {

                if (file.status == "success") {
                    var msg = 'Fotos enviadas com sucesso!';
                    alert_success(msg);
                    vm.listar_fotos();
                } else {
                    alert_error('Erro ao enviar fotos do imóvel')
                }
                Dropzone.forElement("#form-galeria-img").removeAllFiles(true);
            }, 300);
        }
    },
    sending: function(file, xhr, formData) {},
    error: function(file, response) {
        alert_error('Falha ao enviar arquivo (s)!', 'Verifique as imagens e tente novamente.');
        setTimeout(function() {}, 3000);
    },
    success: function(file, response) {},
    totaluploadprogress: function() {}
});

var delay_order = 0;
if(window.innerWidth <= 799) {
    delay_order = 200;
}


$(document).ready(function() {

    setTimeout(() => {

        var el = document.getElementById('sort');
        if(el) {
        var sortable = Sortable.create(el, {
            animation: 750,
            delay: delay_order,
            easing: "cubic-bezier(1, 0, 0, 1)",
            onChange: function(evt) {
                var id = $(evt.item).data('id');
                var data = new Array();
                var div = $(evt.to).children();
                div.each(function(index, element) {
                    var obj = {
                        'pos': index + 1,
                        'foto_id': $(element).data('id')
                    };
                    data.push(obj);
                });
                var url = baseUri + '/Condominio/ordena_img/';
                $.post(url, {
                    condominio_id: $("#condominio_id").val(),
                    data: data
                }).then(function(rs) {
                    if (parseInt(rs) == 0) {
                        alert_success('Posição Atualizada');
                    } else {
                        alert_error('Não foi possível atualizar posição');
                    }
                });
            }
        });
    }
    }, 100)


    $('.summernote').summernote({
        placeholder: '',
        lang: 'pt-BR',
        minHeight: 150,
        maxHeight: 550,
        disableDragAndDrop: true,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol']],
            ['size', ['paragraph', 'height', 'fontsize']],
            ['misc', ['undo', 'redo']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview']],
        ]
    });

    $(".checkbox-caracteristicas").on("change", function() {
        $("#alterou_caracteristica").val("1");
    })

})

