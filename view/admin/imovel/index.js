var vm = new Vue({
    el: '#vm',
    data: {
        filtros: {
            user_id: null,
            negociation: null,
            localization: null,
            type_imovel: null,
            quartos: null,
            banheiros: null,
            vagas: null,
            code_imovel: null,
            min_area: null,
            max_area: null,
            min_price: null,
            max_price: null,
            order: null,
            geral: null,
            condominio: null,
            status: 'ativo',
        },
        imoveis: null,
        rm: null,
        types: [],
        condominios: [],
        usuarios: [],
        countFilter: 0,
        pesquisar_imovel: null,
        imoveisFiltrados: null,
        foto_imovel_padrao: "https://archive.org/download/no-photo-available/no-photo-available.png",
    },
    methods: {
        async getUsers() {
            try {
                const response = await axios.get(baseUri + '/imovelAdmin/listaCorretores');
                this.usuarios = response.data;


            } catch (error) {
                console.error(error);
            }
        },
        async getCondominios() {
            try {
                const response = await axios.get(baseUri + '/imovel/getCondominios');
                this.condominios = response.data;


            } catch (error) {
                console.error(error);
            }
        },
        countFilters() {

            this.countFilter = 0;

            for (var [key, value] of Object.entries(this.filtros)) {
                if (value) {
                    this.countFilter++;
                }

            }

        },

        clearFiltros() {
            this.filtros = {
                negociation: 'venda',
                localization: null,
                type_imovel: null,
                quartos: null,
                banheiros: null,
                vagas: null,
                code_imovel: null,
                min_area: null,
                max_area: null,
                min_price: null,
                max_price: null,
                order: null,
                geral: null,
                condominio: null,
                status: 1,
            }

            $("#filtros_min_price").val('');
            $("#filtros_max_price").val('');

            this.countFilters();
            this.filtrar();
        },
        async getTypesImoveis() {
            try {
                const response = await axios.get(baseUri + '/imovel/getTypes');
                this.types = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        // pesquisa_geral(){

        //     this.imoveisFiltrados = this.imoveis;

        //     this.imoveisFiltrados = this.imoveisFiltrados.filter(imovel => this.filter(imovel));

        // },

        // filter(imovel){
        //     let stringImovel = imovel.imovel_cidade + ' ' +imovel.imovel_bairro + ' ' +imovel.imovel_titulo + ' ' +imovel.imovel_uf + ' ' +imovel.imovel_rua + ' ' + imovel.imovel_ref
        //     return stringImovel.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase().includes(this.pesquisar_imovel.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase())
        // },



        filterByTypeImovel(imovel) {
            if (imovel.categoria_imovel_nome == this.filtros.type_imovel)
                return true

            return false;
        },
        filterByNegociation(imovel) {
            if (imovel.imovel_tipo_negociacao == this.filtros.negociation)
                return true

            return false;
        },
        filterByLocalization(imovel) {

            if (this.filtros.localization) {
                let endereco = imovel.imovel_bairro + ' ' + imovel.imovel_cidade + ' ' + imovel.imovel_rua + ' ' + imovel.imovel_uf;

                endereco = endereco.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase();
                this.filtros.localization = this.filtros.localization.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase();

                if (endereco.includes(this.filtros.localization))
                    return true

                return false;

            }
        },
        filterByMinPrice(imovel) {
            if (this.filtros.negociation == 'aluguel') {
                if (imovel.imovel_valor_locacao >= this.filtros.min_price)
                    return true


            }else{

                if (imovel.imovel_valor_venda >= this.filtros.min_price)
                return true;

            }


            return false;

        },
        filterByMaxPrice(imovel) {

            if (this.filtros.negociation == 'aluguel') {
                if (imovel.imovel_valor_locacao <= this.filtros.max_price)
                    return true


            }else{

                if (imovel.imovel_valor_venda <= this.filtros.max_price)
                return true;

            }


            return false;

        },
        filterByQuartos(imovel) {
            if (this.filtros.quartos == 4) {
                if (Number(imovel.imovel_quartos) >= Number(this.filtros.quartos))
                    return true;

                return false;

            } else {

                if (Number(imovel.imovel_quartos) == Number(this.filtros.quartos))
                    return true;

                return false;
            }



        },
        filterByVagas(imovel) {

            if (this.filtros.vagas == 4) {

                if (Number(imovel.imovel_vagas) >= Number(this.filtros.vagas))
                    return true;

                return false;

            } else {
                if (Number(imovel.imovel_vagas) === Number(this.filtros.vagas))
                    return true;

                return false;
            }

        },
        filterByUser(imovel) {

            if (Number(imovel.imovel_user_id) === Number(this.filtros.user_id))
                return true;

            return false;
        },
        filterByStatus(imovel) {
            if(this.filtros.status == 'ativo') {
                return imovel.imovel_status == 1;
            }
            if(this.filtros.status == 'inativo') {
                return imovel.imovel_status == 2;
            }
            return true;

        },
        filterByCondominio(imovel) {

            if (Number(imovel.imovel_condominio_id) === Number(this.filtros.condominio))
                return true;

            return false;
        },
        filterByBanheiros(imovel) {

            if (this.filtros.banheiros == 4) {
                if (Number(imovel.imovel_banheiros) >= Number(this.filtros.banheiros))
                    return true;

                return false;

            } else {
                if (Number(imovel.imovel_banheiros) === Number(this.filtros.banheiros))
                    return true;

                return false;
            }


        },
        filterByMinArea(imovel) {
            if (Number(imovel.imovel_area_util) > Number(this.filtros.min_area))
                return true;

            return false;
        },
        filterByMaxArea(imovel) {
            if (Number(imovel.imovel_area_util) < Number(this.filtros.max_area))
                return true;

            return false;
        },
        filterByCode(imovel) {

            var codigo = this.filtros.code_imovel.toString().toLowerCase().trim();
            var pesquisa = imovel.imovel_ref.toString().toLowerCase().trim();

            if (pesquisa.includes(codigo)) {
                return true;
            }


            return false
        },

        setFiltro(filtro, value) {
            if (this.filtros[filtro] == value) {
                this.filtros[filtro] = null
            } else {
                this.filtros[filtro] = value;
            }
            this.filtrar();
        },
        resetFiltro(filtro) {
            this.filtros[filtro] = null;
            this.filtrar();
        },
        filtrar() {

            this.filtros.min_price = Number($("#filtros_min_price").val().trim().split(".").join("").replace(",", "."));
            this.filtros.max_price = Number($("#filtros_max_price").val().trim().split(".").join("").replace(",", "."));



            this.imoveisFiltrados = this.imoveis;

            if (this.filtros.geral)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterGeral);

            if (this.filtros.code_imovel)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByCode);

            if (this.filtros.negociation)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByNegociation);

            if (this.filtros.localization)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByLocalization);

            if (this.filtros.type_imovel)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByTypeImovel);

            if (this.filtros.min_price)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByMinPrice);

            if (this.filtros.max_price)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByMaxPrice);

            if (this.filtros.quartos)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByQuartos);

            if (this.filtros.vagas)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByVagas);

            if (this.filtros.banheiros)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByBanheiros);

            if (this.filtros.min_area)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByMinArea);

            if (this.filtros.max_area)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByMaxArea);

            if (this.filtros.condominio)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByCondominio);

            if(this.filtros.user_id)
                this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByUser);


            this.imoveisFiltrados = this.imoveisFiltrados.filter(this.filterByStatus);



            if (this.filtros.order == 'price_desc') {
                if (this.filtros.negociation == 'aluguel') {
                    this.imoveisFiltrados.sort((firstItem, secondItem) => secondItem.imovel_valor_locacao - firstItem.imovel_valor_locacao);
                }

                if (this.filtros.negociation == 'venda') {
                    this.imoveisFiltrados.sort((firstItem, secondItem) => secondItem.imovel_valor_venda - firstItem.imovel_valor_venda);
                }
            }

            if (this.filtros.order == 'price_asc') {
                if (this.filtros.negociation == 'aluguel') {
                    this.imoveisFiltrados.sort((firstItem, secondItem) => firstItem.imovel_valor_locacao - secondItem.imovel_valor_locacao);
                }

                if (this.filtros.negociation == 'venda') {
                    this.imoveisFiltrados.sort((firstItem, secondItem) => firstItem.imovel_valor_venda - secondItem.imovel_valor_venda);
                }
            }

            if (this.filtros.order == 'date_asc')
                this.imoveisFiltrados.sort((firstItem, secondItem) => firstItem.imovel_created - secondItem.imovel_date_create);

            if (this.filtros.order == 'destaque_asc')
                this.imoveisFiltrados.sort((firstItem, secondItem) => firstItem.imovel_destaque - secondItem.imovel_destaque);

            let inners = $('.carousel-inner');

            inners.each((index, inner) => {
                let itens = $(inner).find('.carousel-item');
                $(itens[0]).addClass('active');
            });

            this.countFilters();

        },





        formatMoney: function (value) {
            value = Number(value).toLocaleString('pt-br', {
                style: 'currency',
                currency: 'BRL'
            });

            return value.replace(',00', '')
        },
        listar: function () {
            var url = baseUri + '/imovelAdmin/lista/';
            splash_dt();
            $.post(url, {})
                .then(res => {
                    vm.imoveis = JSON.parse(res);
                    reload_dt_vue(isAdmin);
                    vm.imoveisFiltrados = vm.imoveis;

                    vm.filtrar();
                })
        },
        remover: function (dt) {
            vm.$data.rm = dt.imovel_id;
            $('#modal-remove').modal('show');
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
        this.getTypesImoveis();
        this.getCondominios();
        this.getUsers();
        $('#tbl-div').hide().promise().done($('#tbl-splash').show());
        this.listar();
        this.countFilters()
    },

});

$("#btn-remove").click(function () {
    vm.remove();
})


