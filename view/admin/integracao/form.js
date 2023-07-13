var vm = new Vue({
    el: '#vm',
    data: {
        imoveis_integrados: null,
        imoveis: null,
        ufs: null,
        rm: null,
    },
    methods: {
        listar: async function () {
            var url = baseUri + '/imovelAdmin/lista_full/';
            splash_dt();
            await $.post(url, {})
                .then(res => {
                    vm.imoveis = JSON.parse(res);
                    reload_dt_vue(false);
                })
        },
        formatMoney: function (value) {
            value = Number(value).toLocaleString('pt-br', {
                style: 'currency',
                currency: 'BRL'
            });

            return value.replace(',00', '')
        },
        listar_integrados: async function () {
            var url = baseUri + '/integracoes/listaImoveisIntegrados/';
            let integracao_id = $("#integracao_id").val();
            console.log(integracao_id)

            await $.post(url, {integracao_id: integracao_id})
                .then(res => {
                    vm.imoveis_integrados = JSON.parse(res);
                    console.log(vm.imoveis_integrados);
                })
        },
    },
    created: async function () {
        $('#tbl-div').hide().promise().done($('#tbl-splash').show());
        await this.listar_integrados();
        await this.listar();

        $(".checkbox-imoveis, .select-imoveis").on("change", function() {
            $("#imoveis_changed").val("1");

            // verifica se todos estão checados
            let all_checked = true;
            $(".checkbox-imoveis").each((index, el) => {
                if(!$(el).is(":checked")) {
                    all_checked = false;
                }
            })

            if(all_checked) {
                $('#integracao_imovel_all').prop('checked', true);
            } else {
                $('#integracao_imovel_all').prop('checked', false);
            }
        })

        // roda cada um dos selecionados, para dar o trigger change nos selects
        let keys_imoveis_integrados = Object.keys(this.imoveis_integrados);
        let values_imoveis_integrados = Object.values(this.imoveis_integrados);
        keys_imoveis_integrados.map((imovel_id, index) => {
            if(values_imoveis_integrados[index].is_checked == 1) {
                $(`#integracao_imovel_destaque_${imovel_id}`).val(values_imoveis_integrados[index].destaque).trigger("change");
                $(`#integracao_imovel_endereco_${imovel_id}`).val(values_imoveis_integrados[index].endereco).trigger("change");
            }
        })

    }
});

$("#btn-remove").click(function () {
    vm.remove();
})

$("#integracao_imovel_all").on("change", function() {
    if(document.getElementById("integracao_imovel_all").checked) {
        $('.checkbox-imoveis').prop('checked', true);
    }
})

