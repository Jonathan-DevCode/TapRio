$(function () {
    setTimeout(function () {
        setModoLoja();
        $('.cep').mask('99999-999');
        $(".moeda").mask('000.000.000.000.000,00', { reverse: true });
        $(".moeda-imovel").mask('000.000.000.000.000', { reverse: true });
        $(".moeda2").mask('000.000.000.000.000');
        $(".cnpj").mask("00.000.000/0000-00");
        $(".cpf").mask("000.000.000-00");
        $(".rg").mask("000000000999");
        $(".datar").mask("00/00/0000");
        $('.cep').keyup(function () {
            if ($(this).val().length >= 9) {
                completaEndereco($(this).val());
                if ($(".numero").length) {
                    $(".num").focus();
                } else {
                    $('.cep').blur();
                }
            }
        })

        $('.fone').mask("(99) 99999-9999").focusout(function (event) {
            var target, phone, element;
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
            phone = target.value.replace(/\D/g, '');
            element = $(target);
            element.unmask();
            if (phone.length > 10) {
                element.mask("(99) 99999-9999");
            } else {
                element.mask("(99) 9999-9999");
            }
        });

        var cpfCnpj = function (val) {
            return val.replace(/\D/g, '').length > 11 ? '00.000.000/0000-00' : '000.000.000-009';
        },
            cpfOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(cpfCnpj.apply({}, arguments), options);
                }
            };
        $('.cpfCnpj').mask(cpfCnpj, cpfOptions);

        $('[data-toggle="tooltip"]').tooltip();
    }, 400);



});


function scroll_to(target) {
    $('html, body').animate({
        scrollTop: $(target).offset().top
    }, 1000);
}

function alert_success(title, msg) {
    $.toast({
        heading: title,
        text: msg,
        position: 'top-right',
        //loaderBg: '#ff6849',
        icon: 'success',
        hideAfter: 3500,
        stack: 1
    });
}

function alert_error(title, msg) {
    $.toast({
        heading: title,
        text: msg,
        position: 'top-right',
        //loaderBg: '#ff6849',
        icon: 'error',
        hideAfter: 3500,
        stack: 1
    });
}

function alert_warning(title, msg) {
    $.toast({
        heading: title,
        text: msg,
        position: 'top-right',
        //loaderBg: '#ff6849',
        icon: 'warning',
        hideAfter: 3500,
        stack: 1
    });
}

function alert_error_center(title, msg) {
    $.toast({
        heading: title,
        text: msg,
        position: 'top-center',
        //loaderBg: '#1e88e5',
        showHideTransition: 'slide',
        icon: 'error',
        hideAfter: 7000,
        stack: 1
    });
}

/*ALERTAS SUCESS ERROR*/
if (window.location.href.indexOf("success") != -1) {
    alert_success('Ação realizada com sucesso!');
}
if (window.location.href.indexOf("error") != -1) {
    alert_error('Ação não pode ser realizada!');
}

/*MODAL REMOVE*/
$('#btn-remove').on('click', function () {
    if (typeof vm != 'undefined') {
        if (vm.$data.rm !== null) {
            vm.remove(vm.$data.rm);
        }
    }
});
$('#btn-altera-status').on('click', function () {
    if (typeof vm != 'undefined') {
        if (vm.$data.status !== null) {
            vm.altera_status();
        }
    }
});
/*MODAL REMOVE*/

function bindFoto(val) {
    if (val == 1) {
        $(".user-profile").hide();
        $("#menuButton").attr('onclick', 'bindFoto(2)');
    } else {
        $(".user-profile").show();
        $("#menuButton").attr('onclick', 'bindFoto(1)');
    }
}
// SHOW OU HIDE CONFORME O MODO DE LOJA (VITRINE, ORÇAMENTO OU PADRÃO)
function setModoLoja() {
    switch (site_modo) {
        case '1':
            // Loja padrão
            $(".hide-on-loja").attr('style', 'display: none !important');
            break;
        case '2':
            // Loja Orçamento
            $(".hide-on-orcamento").attr('style', 'display: none !important');
            break;
        case '3':
            // Loja Vitrine
            $(".hide-on-vitrine").attr('style', 'display: none !important');
            break;
        default:
            // Loja padrão
            $(".hide-on-loja").attr('style', 'display: none !important');
            break;
    }
}

