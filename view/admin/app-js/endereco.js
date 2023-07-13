function completaEndereco(valor) {
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep != "") {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //Valida o formato do CEP.
        if (validacep.test(cep)) {
            $('.rua').val("...");
            $('.bairro').val("...");
            $('.cidade').val("...");
            $('.uf').val("...");
            var url = '//viacep.com.br/ws/' + cep + '/json/';
            $.getJSON(url).then(function(rs) {
                if (rs.erro) {
                    $('#cep-invalido').html(" CEP inválido.");
                    $('.cep').focus();
                    this.limpa_formulário_cep();
                } else {
                    $('.rua').val(rs.logradouro);
                    $('.bairro').val(rs.bairro);
                    $('.cidade').val(rs.localidade);
                    $('.uf').val(rs.uf);
                    $('.uf').trigger('change');
                    $('.numero').focus();
                    $('#cep-invalido').html("");
                }
            });
        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            $('#cep-invalido').html(" Formato de CEP inválido.");
            $('.cep').focus();
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
        $('#cep-invalido').html("");
    }
}

var limpa_formulário_cep = function() {
    $('.cep').val("");
    $('.rua').val("");
    $('.bairro').val("");
    $('.cidade').val("");
    $('.numero').val("");
    $('.uf').val("");
}