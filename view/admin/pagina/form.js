var table;
var vm = new Vue({
    el: '#vm',
    data: {
        categorias: null,
        subcategorias: null,
    },
    methods: {
        lista_categorias: function() {
            var url = baseUri + '/PaginaAdmin/lista_categoria/';
            var _this = this;
            $.getJSON(url).then(function(rs) {
                if (rs != null) {
                    _this.categorias = rs;
                }
            });
        },
        lista_subcategorias: function(cat) {
            var url = baseUri + '/PaginaAdmin/lista_subcategoria_from_cat/id/' + parseInt(cat);
            var _this = this;
            $.getJSON(url).then(function(rs) {
                _this.subcategorias = rs;
                if (_this.subcategorias == null) {
                    $('#sbcateg').hide();
                } else {
                    $('#sbcateg').show();
                }
            });
        }
    },
    created: function() {
        this.lista_categorias();
        this.lista_subcategorias();
    }
});

$(document).ready(function() {
    setTimeout(() => {
        let image = $(".dropify-render");
        image = image.html();
        $("#img_facebook").html(image);
        $("#img_facebook").find('img').addClass('card-img-top')
        $("#img_facebook").find('img').css({
            "width": "100%",
            "height": "200px",
            "object-fit": "cover"
        })
    }, 500);

    $('#pagina_categoria').on('change', function() {
        if ($(this).val() == 'x') {
            $('#modal-categoria').modal('show');
            let url = $('#modal-categoria form').attr('action');
            url += '/?return=nova-pagina';
            $('#modal-categoria').find('form').attr('action', url);
        } else {
            let url = baseUri + "/paginaAdmin/url";
            let value = $(this.selectedOptions).text();
            $.post(url, { value: value }, {})
                .then(res => {
                    app.cat_url = res;
                    app.link = baseUri + '/pagina/' + app.cat_url + '/' + app.pagina_url;
                })
        }
    })

    $('#input-file-now-custom-1').on('change', function() {
        setTimeout(() => {
            let image = $(".dropify-render");
            image = image.html();
            $("#img_facebook").html(image);
            $("#img_facebook").find('img').addClass('card-img-top')
            $("#img_facebook").find('img').css({
                "width": "100%",
                "height": "200px",
                "object-fit": "cover"
            })
        }, 500);

    });
    $('#pagina_titulo').on('blur', function() {
        let url = baseUri + "/paginaAdmin/url";
        let value = $(this).val();
        $.post(url, { value: value }, {})
            .then(res => {
                app.pagina_url = res;
                app.link = baseUri + '/pagina/' + app.cat_url + '/' + app.pagina_url;
                app.titulo = value;
            })
    })

    // if (categoria_edit > 0) {
    //     vm.lista_subcategorias(categoria_edit);
    //     $('#pagina_subcategoria').val(sub_cat_id);
    // }

    $('.dropify').dropify({
        messages: {
            default: '<div>Selecione uma capa (260 x 225)</div>',
            replace: '<div>Selecione uma capa (260 x 225)</div>',
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
});

$('#add_cat').on('click', function() {
    $('#modal-categoria').modal('show');
})

$("#form-nova-categoria").on("submit", function(e) {
    e.preventDefault();
    let nome = $("#categoria_pagina_nome").val().trim();
    let topo = $("#categoria_pagina_topo").val();
    let rodape = $("#categoria_pagina_rodape").val();
    let id = 0;
    if(nome == '') {
        alert_error("Preencha o nome da categoria!");
        return false;
    }
    let data = {
        categoria_pagina_nome: nome,
        categoria_pagina_topo: topo,
        categoria_pagina_rodape: rodape,
        categoria_pagina_id: id
    };
    let url = $('#form-nova-categoria').attr('action');
    $.post(url, data)
        .then(res => {
            $('#modal-categoria').modal('hide');
            alert_success("Categoria criada com sucesso!");
            vm.lista_categorias();            
        })

})