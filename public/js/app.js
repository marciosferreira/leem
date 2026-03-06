var rotas = '/rotas/';
var carregando = $("#carregando").hide();

$(document).ready(function() {
    $(document)
        .ajaxStart(function() {
            carregando.show();
        })
        .ajaxStop(function() {
            carregando.hide();
        });
    inicia();

    $('#texto').trumbowyg({
        lang: 'pt_br',
        autogrow: true,
        urlProtocol: true,
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ]
    });
});

function inicia() {
    entrada();
    recupera();
    senha();
    menu();
    busca();
    atualiza_perfil();
    atualiza_avatar();
    envia_pesquisa();
    edita_pesquisa();
    apaga_pesquisa();
    reporta_bug();
    cria_usuario();
    $('[data-mask-data]').mask('00/00/0000 00:00');
}

function menu() {
    $(document).on('click', '.botao-menu, .fecha-menu, .menu-back', function() {
        $('.menu').toggleClass('ativo');
        $('.menu-back').toggleClass('ativo');
    });
    $(document).on('click', '#abre_admin', function() {
        $('.menu-admin').toggleClass('ativo');
    });
}

function busca() {
    $(document).on('click', '#abre_busca', function() {
        $('.busca').toggleClass('active');
    });
    $(document).on('click', '#fecha_busca', function() {
        $('.busca').toggleClass('active');
        $('#busca').focus();
    });
}

function entrada() {
    $(document).on('submit', '#form_entrada', function(evt) {
        evt.preventDefault();

        var dados = $(this).serialize();
        progresso();

        var ajax = $.ajax({
            url: rotas + 'entrada/',
            type: 'POST',
            dataType: 'json',
            data: dados
        });

        ajax.done(function(data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                progresso();
                window.location.href = "/";
            }
        });

        ajax.fail(function() {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
        });

    });
}

function recupera() {
    $(document).on('submit', '#form_recupera', function(evt) {
        evt.preventDefault();

        var dados = $(this).serialize();
        progresso();

        var ajax = $.ajax({
            url: rotas + 'recupera/',
            type: 'POST',
            dataType: 'json',
            data: dados
        });

        ajax.done(function(data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                progresso();
                window.location.href = "/entrada/";
            }
        });

        ajax.fail(function(data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data);
        });

    });
}

function senha() {

    $(document).on('submit', '#form_senha', function(evt) {
        evt.preventDefault();

        var dados = $(this).serialize();
        progresso();

        var ajax = $.ajax({
            url: rotas + 'senha/',
            type: 'POST',
            dataType: 'json',
            data: dados
        });

        ajax.done(function(data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                progresso();
                window.location.href = "/entrada/";
            }
        });

        ajax.fail(function() {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
        });

    });

}

function atualiza_perfil() {

    $(document).on('submit', '#form_perfil', function(evt) {
        evt.preventDefault();

        var dados = $(this).serialize();

        progresso();

        var ajax = $.ajax({
            url: rotas + 'atualiza-perfil/',
            type: 'POST',
            dataType: 'json',
            data: dados,
        });

        ajax.done(function(data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                progresso();
                window.location.href = "/perfil/";
            }
        });

        ajax.fail(function(data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function atualiza_avatar() {

    $(document).on('click', '#fotoPerfil, #btnVatar', function() {
        $("#avatar").click();

        document.getElementById("avatar").onchange = function(evt) {
            var tgt = evt.target || window.event.srcElement,
                files = tgt.files;

            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function() {
                    $(".avatar").attr("src", fr.result);
                    $('#form_avatar').submit();
                }
                fr.readAsDataURL(files[0]);
            }
        }
    });

    $(document).on('submit', '#form_avatar', function(evt) {
        evt.preventDefault();

        var avatar = $('#avatar').prop('files')[0];
        var dados = new FormData();
        dados.append('avatar', avatar);

        var ajax = $.ajax({
            enctype: 'multipart/form-data',
            url: rotas + 'atualiza-avatar/',
            type: 'POST',
            dataType: 'json',
            data: dados,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000
        });

        ajax.done(function() {
            window.location.reload();
        });

        ajax.fail(function(data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data);
        });

    });
}

function envia_pesquisa() {
    $(document).on('submit', '#form_pesquisa', function(evt) {
        evt.preventDefault();

        var projeto = $("#projeto").val();
        var doi = $("#doi").val();
        var autor = $("#autor").val();
        var coautor = $("#coautor").val();
        var titulo = $("#titulo").val();
        var editor = $("#texto").html();

        var form = $('#form_pesquisa')[0];
        var data = new FormData(form);
        data.append('projeto', projeto);
        data.append('doi', doi);
        data.append('autor', autor);
        data.append('coautor', coautor);
        data.append('titulo', titulo);
        data.append('editor', editor);

        var ajax = $.ajax({
            enctype: 'multipart/form-data',
            url: rotas + 'cria-pesquisa/',
            type: 'POST',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000
        });

        ajax.done(function(data) {
            dialogo('Resposta', data.resposta);
        });

        ajax.fail(function(data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });
}

function edita_pesquisa() {
    $(document).on('submit', '#form_edita_pesquisa', function(evt) {
        evt.preventDefault();

        var slug = $("#slug").val();
        var doi = $("#doi").val();
        var autor = $("#autor").val();
        var coautor = $("#coautor").val();
        var editor = $("#texto").html();

        var form = $('#form_pesquisa')[0];
        var data = new FormData(form);

        data.append('slug', slug);
        data.append('doi', doi);
        data.append('autor', autor);
        data.append('coautor', coautor);
        data.append('editor', editor);

        var ajax = $.ajax({
            enctype: 'multipart/form-data',
            url: rotas + 'edita-pesquisa/',
            type: 'POST',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000
        });

        ajax.done(function(data) {
            dialogo('Resposta', data.resposta);
        });

        ajax.fail(function(data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });
}

function apaga_pesquisa() {
    $(document).on('submit', '#form_apaga_pesquisa', function(evt) {
        evt.preventDefault();

        var data = $(this).serialize();

        var ajax = $.ajax({
            url: rotas + 'apaga-pesquisa/',
            type: 'POST',
            dataType: 'json',
            data: data,
            timeout: 60000
        });

        ajax.done(function(data) {
            dialogo('Resposta', data.resposta);
            window.location.href = "../../";
        });

        ajax.fail(function(data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });
}

function dialogo(titulo, texto) {

    var dialogo_dom = $('#dialogo');
    var dialogo_titulo_dom = $('#dialogoTitulo');
    var dialogo_texto_dom = $('#dialogoTexto');
    var dialogo_acoes_dom = $('#dialogoAcoes');

    dialogo_titulo_dom.html(titulo);
    dialogo_texto_dom.html(texto);
    dialogo_acoes_dom.show();
    dialogo_dom.modal('show');
}

function progresso() {
    carregando.show();
}

function reporta_bug() {

    $(document).on('submit', '#form_bug', function(evt) {
        evt.preventDefault();

        var dados = $(this).serialize();

        progresso();

        var ajax = $.ajax({
            url: rotas + 'reporta-bug/',
            type: 'POST',
            dataType: 'json',
            data: dados,
        });

        ajax.done(function(data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                $('#limparForm').click();
            }
        });

        ajax.fail(function(data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function cria_usuario() {

    $(document).on('submit', '#form_usuario', function(evt) {
        evt.preventDefault();

        var dados = $(this).serialize();

        progresso();

        var ajax = $.ajax({
            url: rotas + 'cria-usuario/',
            type: 'POST',
            dataType: 'json',
            data: dados,
        });

        ajax.done(function(data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                $('#limparForm').click();
            }
        });

        ajax.fail(function(data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}
