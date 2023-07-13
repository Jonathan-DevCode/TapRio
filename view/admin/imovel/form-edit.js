var delay_order = 0;
if(window.innerWidth <= 799) {
    delay_order = 200;
}


var vm = new Vue({
    el: '#vm',
    data: {
        categorias: null,
        modelos: null,
        cidades: null,
        bairros: null,
        atributos_disponiveis: null,
        atributos_indisponiveis: null,
        ufs: null,
        atributo_remove: null,

        galerias: null,
        selected: false,
        remove_a: false,
        selected: false,
        data_remove: new Array(),

        arquivos: null,
        arquivo_remove: null,
    },
    methods: {
        listar_arquivos: function () {
            var url = baseUri + '/imovelAdmin/lista_arquivos/';
            $.post(url, { imovel_id: $("#imovel_id").val() })
                .then(res => {
                    vm.arquivos = JSON.parse(res);
                })
        },


        findLatLon: function () {
            $("#btn-lat-lon").html(`Buscando...`)
            let query = "";
            if ($("#imovel_rua").val() != "") {
                query += "," + $("#imovel_rua").val();
            }
            if ($("#imovel_num").val() != "") {
                query += "," + $("#imovel_num").val();
            }
            // if($("#imovel_cep").val() != "") {
            //     query += "," + $("#imovel_cep").val();
            // }
            if ($("#imovel_cidade").val() != "") {
                query += "," + $("#imovel_cidade").val();
            }
            // if($("#imovel_bairro").val() != "") {
            //     query += "," + $("#imovel_bairro").val();
            // }
            // const url_search = "https://geocode.maps.co/search?q=" + query.split(" ").join("+");
            const url_search = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCwsIeeTEPswof8wpn1pP6zBum2TFqdvLY&address=" + query;
            $.get(url_search)
                .then(res => {
                    $("#btn-lat-lon").html(`<i class="fa fa-map-marker"></i> Buscar Lat/Lon`)
                    console.log(url_search);
                    console.log(res);
                    if (res.results.length > 0) {
                        $("#imovel_latitude").val(res.results[0].geometry.location.lat);
                        $("#imovel_longitude").val(res.results[0].geometry.location.lng);
                    }
                })
        },
        listar_modelos: function (categoria_id) {
            var url = baseUri + '/categoria/lista_modelos/';
            $.post(url, { categoria_id: categoria_id })
                .then(res => {
                    vm.modelos = JSON.parse(res);

                    setTimeout(() => {
                        console.log(php_imovel_modelo_id)
                        if (php_imovel_modelo_id) {
                            $("#imovel_modelo_id").val(php_imovel_modelo_id).trigger("change");
                        }
                    }, 800);
                })
        },
        //#region categorias
        listar_categorias: function (categoria_id_param) {
            var url = baseUri + '/categoria/lista/';
            $.post(url, {})
                .then(res => {
                    vm.categorias = JSON.parse(res);

                    setTimeout(() => {
                        $("#imovel_categoria").val(categoria_id_param).trigger('change');
                    }, 800);
                })
        },
        salvar_categoria: function () {
            let nome = $("#categoria_imovel_nome").val().trim();
            if (nome == '') {
                alert_error('Insira o nome da categoria para salvar!');
                return false;
            }

            let url = baseUri + "/categoria/gravar/1";
            $.post(url, { categoria_imovel_nome: nome })
                .then(res => {
                    if (parseInt(res) > 0) {
                        $("#categoria_imovel_nome").val("");
                        vm.listar_categorias();
                        alert_success('Categoria salva com sucesso!')
                        $("#modalAddCategoria").modal('hide');
                        setTimeout(() => {
                            $("#imovel_categoria").val(parseInt(res)).trigger('change');
                        }, 900);
                    } else {
                        alert_error('Não foi possível salvar essa categoria.')
                    }
                })
        },
        //#endregion categorias

        //#region locais
        listar_uf: function () {
            var url = baseUri + '/local/lista_ufs/';
            $.post(url, {})
                .then(res => {
                    vm.ufs = JSON.parse(res);
                })
        },
        listar_cidades: function (imovel_cidade_id_param = 0) {
            var url = baseUri + '/local/lista_cidades/';
            $.post(url, {})
                .then(res => {
                    vm.cidades = JSON.parse(res);
                    if (imovel_cidade_id_param != 0) {
                        setTimeout(() => {
                            $("#imovel_cidade_id").val(imovel_cidade_id_param).trigger('change');

                        }, 800);
                    }
                })
        },
        listar_bairros: function (imovel_bairro_id_param = 0, cidade_id = 0) {
            var url = baseUri + '/local/lista_bairros_por_cidade/';
            $.post(url, { cidade_id: cidade_id })
                .then(res => {
                    vm.bairros = JSON.parse(res);
                    if (imovel_bairro_id_param != 0) {
                        setTimeout(() => {
                            $("#imovel_bairro_id").val(imovel_bairro_id_param).trigger('change');
                        }, 800);
                    }
                })
        },
        salvar_cidade: function () {
            let nome = $("#cidade_titulo").val().trim();
            let uf = $("#cidade_uf").val();
            if (parseInt(uf) <= 0) {
                alert_error('Selecione o UF (Estado) da cidade');
                return false;
            }
            if (nome == '') {
                alert_error('Preencha o nome da cidade!');
                return false;
            }

            let url = baseUri + "/local/adicionar_cidade/1";
            $.post(url, { cidade_titulo: nome, cidade_uf: uf })
                .then(res => {
                    if (parseInt(res) > 0) {
                        $("#cidade_titulo").val("");
                        $("#cidade_uf").val(0).trigger('change');
                        alert_success('Cidade salva com sucesso!')
                        vm.listar_cidades(parseInt(res));
                        $("#modalAddCidade").modal('hide');
                    } else {
                        alert_error('Não foi possível salvar essa cidade.')
                    }
                })

        },
        salvar_bairro: function () {
            let nome = $("#bairro_titulo").val().trim();
            let cidade = $("#bairro_cidade").val();
            if (parseInt(cidade) <= 0) {
                alert_error('Selecione a cidade do bairro');
                return false;
            }
            if (nome == '') {
                alert_error('Preencha o nome do bairro!');
                return false;
            }

            let url = baseUri + "/local/adicionar_bairro/1";
            $.post(url, { bairro_titulo: nome, bairro_cidade: cidade })
                .then(res => {
                    if (parseInt(res) > 0) {
                        $("#bairro_titulo").val("");
                        $("#modalAddBairro").modal('hide');
                        alert_success('bairro salvo com sucesso!')
                        php_imovel_bairro_id = parseInt(res);
                        vm.listar_bairros(php_imovel_bairro_id, $("#imovel_cidade_id").val());

                    } else {
                        alert_error('Não foi possível salvar esse bairro.')
                    }
                })

        },
        //#endregion locais


        //#region atributos
        salvar_atributo: function () {
            let titulo = $("#atributo_titulo_novo").val().trim();
            let valor = $("#atributo_valor_novo").val().trim();
            let icone = $("#atributo_icone_novo").val().trim();

            if (titulo == '') {
                alert_error('Insira um título válido!');
                $("#atributo_titulo_novo").focus();
                return false;
            }
            if (parseInt(valor) < 0) {
                alert_error('Insira um valor válido!');
                $("#atributo_valor_novo").focus();
                return false;
            }

            let data = {
                titulo: titulo,
                icone: icone,
                valor: valor,
                imovel_id: $("#imovel_id").val()
            };
            var url = baseUri + '/atributo/gravar_api/';
            $.post(url, data)
                .then(res => {
                    res = JSON.parse(res);
                    if (res.status != undefined && res.status == 200) {
                        $("#atributo_titulo_novo").val("");
                        $("#atributo_valor_novo").val("");
                        vm.listar_atributos_disponiveis();
                        vm.listar_atributos_indisponiveis();
                        alert_success('Cadastro e Vinculo realizado com sucesso!');
                        $("#modalAddAtributo").modal('hide');
                    } else {
                        alert_error(res.msg);
                    }
                })
        },
        listar_atributos_disponiveis: function () {
            var url = baseUri + '/atributo/lista_disponivel/';
            $.post(url, { imovel_id: $("#imovel_id").val() })
                .then(res => {
                    res = JSON.parse(res);
                    if (res.status != undefined && res.status == 200) {
                        vm.atributos_disponiveis = res.atributos;
                    } else {
                        vm.atributos_disponiveis = null;
                    }
                })
        },
        listar_atributos_indisponiveis: function () {
            var url = baseUri + '/atributo/lista_indisponivel/';
            $.post(url, { imovel_id: $("#imovel_id").val() })
                .then(res => {
                    res = JSON.parse(res);
                    if (res.status != undefined && res.status == 200) {
                        vm.atributos_indisponiveis = res.atributos;
                    } else {
                        vm.atributos_indisponiveis = null;
                    }
                })
        },
        vincula_atributo: function () {
            let atributo = parseInt($("#imovel_atributos").val());
            let valor = parseInt($("#imovel_atributo_valor").val());
            if (atributo <= 0) {
                alert_error('Insira um atributo válido!');
                return false;
            }

            let url = baseUri + '/atributo/vincular';
            $.post(url, { imovel_id: $("#imovel_id").val(), atributo_id: atributo, valor: valor })
                .then(res => {
                    res = JSON.parse(res);
                    if (res.status != undefined && res.status == 200) {
                        $("#imovel_atributo_valor").val("");
                        alert_success('Vinculo realizado com sucesso!');
                        vm.listar_atributos_disponiveis();
                        vm.listar_atributos_indisponiveis();
                    } else {
                        alert_success('Não foi possível realizar o vinculo!');
                    }
                })
        },
        show_remove_arquivo: function (arq) {
            vm.arquivo_remove = arq;
            $("#modalRemoveArquivo").modal('show');
        },
        remove_arquivo: function () {
            if (vm.arquivo_remove != null) {
                let url = baseUri + "/imovelAdmin/remove_arquivo";
                $.post(url, { arquivo_id: vm.arquivo_remove.imovel_arquivo_id, imovel_id: $("#imovel_id").val() })
                    .then(res => {
                        res = JSON.parse(res);
                        if (res.status != undefined && res.status == 200) {
                            vm.listar_arquivos();
                            alert_success('Arquivo removido com sucesso!');
                            vm.arquivo_remove = null;
                            $("#modalRemoveArquivo").modal('hide');
                        } else {
                            alert_success('Não foi possível remover o arquivo!');
                        }
                    })
            }
        },

        show_remove_atributo: function (att) {
            vm.atributo_remove = att;
            $("#modalRemoveAtributo").modal('show');
        },
        remove_atributo: function () {
            if (vm.atributo_remove != null) {
                let url = baseUri + "/atributo/desvincular";
                $.post(url, { id: vm.atributo_remove.atributo_imovel_id })
                    .then(res => {
                        res = JSON.parse(res);
                        if (res.status != undefined && res.status == 200) {
                            vm.listar_atributos_disponiveis();
                            vm.listar_atributos_indisponiveis();
                            alert_success('Vínculo removido com sucesso!');
                            vm.atributo_remove = null;
                            $("#modalRemoveAtributo").modal('hide');
                        } else {
                            alert_success('Não foi possível remover o vinculo!');
                        }
                    })
            }
        },


        createButtonRotaciona(gale){

            return `<button class="btn btn-primary" onclick="rotaciona('${gale.foto_imovel_img}', ${gale.foto_imovel_id})">
                <i class="fa fa-repeat" aria-hidden="true"></i>
            </button>
            <button class="btn btn-danger" onclick="remove_image_by_galery(${gale.foto_imovel_id}, '${gale.foto_imovel_url}')">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>

            `

        },

        //#endregion

        validaForm: function () {
            // if (
            //     $("#imovel_categoria").val() == 0 ||
            //     $("#imovel_cidade_id").val() == 0 ||
            //     $("#imovel_bairro_id").val() == 0
            // ) {
            //     alert_error("Campos obrigatórios pendentes de preenchimento!");
            //     return false;
            // }
        },

        listar_fotos: function () {
            let url = baseUri + '/ImovelAdmin/lista_img_imovel/id/' + $("#imovel_id").val();
            $.post(url, {})
                .then(res => {
                    res = JSON.parse(res);
                    vm.galerias = res;

                    if (res == null) {
                        vm.remove_a = false;
                    } else {
                        vm.remove_a = true;
                    }

                    setTimeout(() => {
                        var el = document.getElementById('sort');
                        if(el) {
                            var sortable = Sortable.create(el, {
                                animation: 750,
                                delay: delay_order,
                                easing: "cubic-bezier(1, 0, 0, 1)",
                                onChange: function (evt) {
                                    var id = $(evt.item).data('id');
                                    var data = new Array();
                                    var div = $(evt.to).children();
                                    div.each(function (index, element) {
                                        var obj = {
                                            'pos': index + 1,
                                            'foto_id': $(element).data('id')
                                        };
                                        data.push(obj);
                                    });
                                    var url = baseUri + '/ImovelAdmin/ordena_img/';
                                    $.post(url, { imovel_id: $("#imovel_id").val(), data: data }).then(function (rs) {
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
                })
        },
        add_class_remove: function (item) {
            // var ele = $('#img-galeria-id-' + item.foto_imovel_id);
            // ele.toggleClass('custom-checkbox-active');

            // if (ele.hasClass('custom-checkbox-active')) {
            //     alert_warning('Foto foi marcada');
            // } else {
            //     alert_warning('Foto foi desmarcada');
            // }
            // var remove = $('.custom-checkbox-active');

            var ele = $('#foto-check-' + item.foto_imovel_id);
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
                remove.each(function (index, element) {
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
        remove_img: function () {
            $('#modal-remove').modal('show');

        },
        show_rotaciona_img: function () {
            $('#modal-rotaciona').modal('show');

        },
        rotaciona_imagens: function () {
            var _this = this;
            var url = baseUri + '/ImovelAdmin/rotaciona_imagens/';
            $("#btn-rotacionar").addClass("d-none");
            $("#btn-rotacionar-loading").removeClass("d-none");
            $.post(url, { imovel_id: $("#imovel_id").val(), data: _this.$data.data_remove }).then(function (rs) {
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
        remove_all: function () {
            var _this = this;
            var url = baseUri + '/ImovelAdmin/remove_all_img_imovel/';
            $.post(url, { imovel_id: $("#imovel_id").val() }).then(function (rs) {
                if (parseInt(rs) == 0) {
                    alert_success('Fotos apagadas com sucesso!');
                    this.selected = false;
                    setTimeout(() => _this.listar_fotos(), 300);

                } else {
                    alert_success('Fotos não puderam ser apagadas');
                }
            });
        },

        ForcesUpdateComponent:function() {
            // our code
            this.$forceUpdate();  // Notice we have to use a $ here
            // our code
          },

        remover: function () {
            var _this = this;
            var url = baseUri + '/ImovelAdmin/remove_img/';
            $.post(url, { imovel_id: $("#imovel_id").val(), data: _this.$data.data_remove }).then(function (rs) {
                if (parseInt(rs) == 0) {

                    alert_success('Fotos apagadas com sucesso!');
                    var remove = $('.custom-checkbox-active');

                    remove.each(function (index, element) {
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
    created: function () {
        this.listar_categorias(php_imovel_categoria);
        this.listar_uf();
        this.listar_cidades(php_imovel_cidade_id);
        this.listar_atributos_disponiveis();
        this.listar_atributos_indisponiveis();
        this.listar_fotos();
        this.listar_arquivos();
    }
});

$("#imovel_cidade_id").change(function () {
    // campo da cidade, no modal de add bairro
    setTimeout(() => {
        $("#bairro_cidade").val($("#imovel_cidade_id").val());
        vm.listar_bairros(php_imovel_bairro_id, $("#imovel_cidade_id").val())
    }, 100);
})

$("#imovel_categoria").on("change", function () {
    vm.listar_modelos($(this).val())
})


$(".lb-close").on("click", function () {
    console.log('hsuahs');
})
$("#imovel_modelo_id").on("change", function () {
    php_imovel_modelo_id = $(this).val();
})


Dropzone.autoDiscover = false;
Dropzone.prototype.defaultOptions.dictDefaultMessage = "Clique aqui ou arraste fotos";

dropzoneFotos = $("#form-galeria-img").dropzone({
    multiple: true,
    url: baseUri + "/ImovelAdmin/enviar_img/id/" + $("#imovel_id").val(),
    accept: function (file, done) {
        if (file.type == "image/jpeg" || file.type == "image/png" || file.type == "image/gif" || file.type == "image/jpg") {
            done();
        } else {
            alert_error('Erro ao enviar fotos do imóvel')
        }
    },
    complete: function (file) {
        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            setTimeout(function () {

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
    sending: function (file, xhr, formData) { },
    error: function (file, response) {
        alert_error('Falha ao enviar arquivo (s)!', 'Verifique as imagens e tente novamente.');
        setTimeout(function () { }, 3000);
    },
    success: function (file, response) { },
    totaluploadprogress: function () { }
});

$('#btn-remove').on('click', function () {
    $('#modal-remove').modal('hide');
    vm.remover();
});

$('#btn-remove-all').on('click', function () {
    $('#modal-remove-all').modal('hide');
    vm.remove_all();
});


function rotaciona (image,id){

    var url = baseUri + '/ImovelAdmin/rotaciona_img/';
    $.post(url, {img:image}).then(function (rs) {


        vm.galerias = [];
        vm.listar_fotos();

        setTimeout(() => {
            $(`#btn-galeria-id-${id}`).click();
        }, 200);



    });



}


function remove_image_by_galery (foto_imovel_id,foto_imovel_url){
    var obj = {
        'id': foto_imovel_id,
        'url':foto_imovel_url
    };

    vm.$data.data_remove.push(obj);

    vm.remove_img();

    $('.lb-close').click();

}




$(document).ready(function () {



    $("#arquivo_file").on("change", function () {
        console.log($(this).val())
        let nome = $(this).val().replace("/", "\\").split("\\");
        nome = nome[nome.length - 1];
        if (nome) {
            $("#arquivo_file_label").html(`<i class="fa fa-check"></i> ${nome}`)
        }
    })
})
