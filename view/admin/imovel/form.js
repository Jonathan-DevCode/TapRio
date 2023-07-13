var vm = new Vue({
    el: '#vm',
    data: {
        categorias: null,
        cidades: null,
        bairros: null,
        ufs: null,
        modelos: null,
    },
    methods: {
        //#region categorias
        listar_categorias: function () {
            var url = baseUri + '/categoria/lista/';
            $.post(url, {})
                .then(res => {
                    vm.categorias = JSON.parse(res);
                })
        },
        listar_modelos: function (categoria_id) {
            var url = baseUri + '/categoria/lista_modelos/';
            $.post(url, {categoria_id: categoria_id})
                .then(res => {
                    vm.modelos = JSON.parse(res);
                })
        },
        salvar_categoria: function() {
            let nome = $("#categoria_imovel_nome").val().trim();
            if(nome == '') {
                alert_error('Insira o nome da categoria para salvar!');
                return false;
            }

            let url = baseUri + "/categoria/gravar/1";
            $.post(url, {categoria_imovel_nome: nome})
                .then(res => {
                    if(parseInt(res) > 0) {
                        $("#categoria_imovel_nome").val("");
                        vm.listar_categorias();
                        alert_success('Categoria salva com sucesso!')
                        $("#modalAddCategoria").modal('hide');
                        setTimeout(() => {
                            $("#imovel_categoria").val(parseInt(res)).trigger('change');
                        }, 200);
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
        listar_cidades: function () {
            var url = baseUri + '/local/lista_cidades/';
            $.post(url, {})
                .then(res => {
                    vm.cidades = JSON.parse(res);
                })
        },
        listar_bairros: function (cidade_id) {
            var url = baseUri + '/local/lista_bairros_por_cidade/';
            $.post(url, {cidade_id: cidade_id})
                .then(res => {
                    vm.bairros = JSON.parse(res);
                })
        },
        
        salvar_cidade: function() {
            let nome = $("#cidade_titulo").val().trim();
            let uf = $("#cidade_uf").val();
            if(parseInt(uf) <= 0) {
                alert_error('Selecione o UF (Estado) da cidade');
                return false;
            }
            if(nome == '') {
                alert_error('Preencha o nome da cidade!');
                return false;
            }

            let url = baseUri + "/local/adicionar_cidade/1";
            $.post(url, {cidade_titulo: nome, cidade_uf: uf})
                .then(res => {
                    if(parseInt(res) > 0) {
                        $("#cidade_titulo").val("");
                        $("#cidade_uf").val(0).trigger('change');
                        vm.listar_cidades();
                        alert_success('Cidade salva com sucesso!')
                        $("#modalAddCidade").modal('hide');
                        setTimeout(() => {
                            $("#imovel_cidade_id").val(parseInt(res)).trigger('change');
                        }, 200);
                    } else {
                        alert_error('Não foi possível salvar essa cidade.')
                    }
                })

        },
        salvar_bairro: function() {
            let nome = $("#bairro_titulo").val().trim();
            let cidade = $("#bairro_cidade").val();
            if(parseInt(cidade) <= 0) {
                alert_error('Selecione a cidade do bairro');
                return false;
            }
            if(nome == '') {
                alert_error('Preencha o nome do bairro!');
                return false;
            }

            let url = baseUri + "/local/adicionar_bairro/1";
            $.post(url, {bairro_titulo: nome, bairro_cidade: cidade})
                .then(res => {
                    if(parseInt(res) > 0) {
                        $("#bairro_titulo").val("");
                        $("#imovel_cidade_id").val($('#bairro_cidade').val()).trigger('change')                        
                        alert_success('bairro salvo com sucesso!')
                        $("#modalAddBairro").modal('hide');
                        setTimeout(() => {
                            $("#imovel_bairro_id").val(parseInt(res)).trigger('change');
                        }, 400);
                    } else {
                        alert_error('Não foi possível salvar esse bairro.')
                    }
                })

        },
        //#endregion locais

        validaForm: function() {
            // if(
            //     $("#imovel_categoria").val() == 0 ||
            //     $("#imovel_cidade_id").val() == 0 ||
            //     $("#imovel_bairro_id").val() == 0
            // ) {
            //     alert_error("Campos obrigatórios pendentes de preenchimento!");
            //     return false;
            // }
        },
        
    },
    created: function () {        
        this.listar_categorias();
        this.listar_uf();
        this.listar_cidades();
    }
});

$("#imovel_cidade_id").change(function() {
    $("#bairro_cidade").val($("#imovel_cidade_id").val());
    vm.listar_bairros($("#imovel_cidade_id").val())
})

$("#imovel_categoria").on("change", function() {
    vm.listar_modelos($(this).val())
})

