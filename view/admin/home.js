/*
Template Name: Material Pro Admin
Author: Themedesigner
Email: niravjoshi87@gmail.com
File: js
*/
$(function() {
    populaSelect();
    "use strict";
    // ============================================================== 
    // Sales overview
    // ============================================================== 
    let url = baseUri + "/relatorios/vendasByYear";
    let vendas = [];
    $.post(url, { ano: new Date().getUTCFullYear() })
        .then(res => {
            res = JSON.parse(res);
            vendas = res;
            let series = [];
            vendas.map(venda => {
                series[venda.pedido_mes - 1] = venda.pedido_qtd;
            })

            for (let i = 0; i < 12; i++) {
                if (series[i] == undefined)
                    series[i] = 0;
            }

            populaGrafico(series);
        })
});

function getVendasByYear() {
    let url = baseUri + "/relatorios/vendasByYear";
    let vendas = [];
    $.post(url, { ano: $("#vendasAno").val() })
        .then(res => {
            res = JSON.parse(res);
            vendas = res;
            let series = [];
            if (vendas) {
                vendas.map(venda => {
                    series[venda.pedido_mes - 1] = venda.pedido_qtd;
                })

                for (let i = 0; i < 12; i++) {
                    if (series[i] == undefined)
                        series[i] = 0;
                }
                populaGrafico(series);
            } else {
                populaGrafico([0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);
            }

        })
}

function populaSelect() {
    let url = baseUri + "/relatorios/getYears";
    $.post(url)
        .then(res => {
            res = JSON.parse(res);
            let anos = res;

            anos.map(ano => {
                $("#vendasAno").append(`
                    <option value="${ano.pedido_ano}">${ano.pedido_ano}</option>
                `);
            })
        })
}

$("#vendasAno").change(() => getVendasByYear());

function populaGrafico(arr) {
    var chart2 = new Chartist.Bar('.amp-pxl', {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        series: [
            arr
        ]
    }, {
        axisX: {
            // On the x-axis start means top and end means bottom
            // position: 'end',
            showGrid: false
        },
        axisY: {
            // On the y-axis start means left and end means right
            position: 'start',
            onlyInteger: true,
        },
        // high: '12',
        low: '0',
        plugins: [
            Chartist.plugins.tooltip()
        ]
    });
}