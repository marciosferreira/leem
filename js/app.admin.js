$(document).ready(function () {
    $(document)
        .ajaxStart(function () {
            carregando.show();
        })
        .ajaxStop(function () {
            carregando.hide();
        });
    inicia_admin();
});

function inicia_admin() {
    add_usuario_projeto();
    edita_usuario();
    apaga_usuario();
    cria_imagem();
    apaga_imagem();
    cria_projeto();
    edita_projeto();
    apaga_projeto();
    cria_materia();
    edita_materia();
    apaga_materia();
    cria_video();
    apaga_video();
    cria_cronograma();
    apaga_cronograma();
    edita_cronograma();
    cria_apoiador();
    apaga_apoiador();
    ativa_usuario();
    paises();

    updatePaises();
}

function paises() {
    $(document).on('click', '.paises .pais', function () {
        $(this).appendTo($('.paises-selecionados'));
        updatePaises();
    });

    $(document).on('click', '.paises-selecionados .pais', function () {
        $(this).appendTo($('.paises'));
        updatePaises();
    });
}

function updatePaises() {
    if ($('.paises-selecionados .pais').length > 0) {
        $('.paises-selecionados .vazio').addClass('d-none');
    } else {
        $('.paises-selecionados .vazio').removeClass('d-none');
    }

    var strPaises = '';
    var paises = $('.paises-selecionados .pais');

    for(var i = 0; i < paises.length;i++){
        strPaises += $(paises[i]).attr('data-pais').trim() + ',';
    }

    strPaises = strPaises.substring(0, strPaises.length - 1);
    console.log(strPaises);

    $('input#paises').val(strPaises);
}

function add_usuario_projeto() {
    $(document).on('submit', '#form_add_usuario', function (evt) {
        evt.preventDefault();

        var dados = $(this).serialize();

        progresso();

        var ajax = $.ajax({
            url: rotas + 'add-usuario-projeto/',
            type: 'POST',
            dataType: 'json',
            data: dados,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "../../";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });
}

function edita_usuario() {

    $(document).on('submit', '#form_edita_usuario', function (evt) {
        evt.preventDefault();

        var dados = $(this).serialize();

        progresso();

        var ajax = $.ajax({
            url: rotas + 'edita-usuario/',
            type: 'POST',
            dataType: 'json',
            data: dados,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "../../";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function ativa_usuario() {

    $(document).on('click', '.aceita', function (evt) {
        evt.preventDefault();

        var dados = {
            ativo: 1,
            id_usuario: $(this).attr('data-id-usuario'),
            email: $(this).attr('data-email')
        };

        progresso();

        var ajax = $.ajax({
            url: rotas + 'ativa-usuario/',
            type: 'POST',
            dataType: 'json',
            data: dados
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.reload();
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function apaga_usuario() {

    $(document).on('submit', '#form_apaga_usuario', function (evt) {
        evt.preventDefault();

        var dados = $(this).serialize();

        progresso();

        var ajax = $.ajax({
            url: rotas + 'apaga-usuario/',
            type: 'POST',
            dataType: 'json',
            data: dados,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "/admin/";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function cria_imagem() {

    $(document).on('submit', '#form_imagem', function (evt) {
        evt.preventDefault();

        var form = $('#form_imagem')[0];
        var data = new FormData(form);

        progresso();

        var ajax = $.ajax({
            url: rotas + 'cria-imagem/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.reload();
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function apaga_imagem() {

    $(document).on('submit', '#form_apaga_imagem', function (evt) {
        evt.preventDefault();

        var dados = $(this).serialize();

        progresso();

        var ajax = $.ajax({
            url: rotas + 'apaga-imagem/',
            type: 'POST',
            dataType: 'json',
            data: dados,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "/admin/galeria/";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function cria_projeto() {

    $(document).on('submit', '#form_projeto', function (evt) {
        evt.preventDefault();

        var form = $('#form_projeto')[0];
        var data = new FormData(form);

        progresso();

        var ajax = $.ajax({
            url: rotas + 'cria-projeto/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                $('#limparForm').click();
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function edita_projeto() {

    $(document).on('submit', '#form_edita_projeto', function (evt) {
        evt.preventDefault();

        var form = $('#form_edita_projeto')[0];
        var data = new FormData(form);

        progresso();

        var ajax = $.ajax({
            url: rotas + 'edita-projeto/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "../../";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function apaga_projeto() {

    $(document).on('submit', '#form_apaga_projeto', function (evt) {
        evt.preventDefault();

        var form = $('#form_apaga_projeto')[0];
        var data = new FormData(form);

        progresso();

        var ajax = $.ajax({
            url: rotas + 'apaga-projeto/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "../../";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data);
        });

    });

}

function cria_materia() {

    $(document).on('submit', '#form_materia', function (evt) {
        evt.preventDefault();

        var form = $('#form_materia')[0];
        var data = new FormData(form);
        data.append('texto', $("#texto").html());

        progresso();

        var ajax = $.ajax({
            url: rotas + 'cria-materia/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.reload();
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data);
        });

    });

}

function edita_materia() {

    $(document).on('change', 'select#destaque', function (evt) {
        $('#hidden-destaque').val($(this).val());
        console.log($('#hidden-destaque').val());
    });
    $(document).on('change', 'select#tipo', function (evt) {
        $('#hidden-tipo').val($(this).val());
        console.log($('#hidden-tipo').val());
    });

    $(document).on('submit', '#form_edita_materia', function (evt) {
        evt.preventDefault();

        var form = $('#form_edita_materia')[0];
        var data = new FormData(form);
        data.append('texto', $("#texto").html());

        progresso();

        var ajax = $.ajax({
            url: rotas + 'edita-materia/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "../../";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data);
        });

    });

}

function apaga_materia() {

    $(document).on('submit', '#form_apaga_materia', function (evt) {
        evt.preventDefault();

        var form = $('#form_apaga_materia')[0];
        var data = new FormData(form);

        progresso();

        var ajax = $.ajax({
            url: rotas + 'apaga-materia/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "../../";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function cria_video() {

    $(document).on('submit', '#form_video', function (evt) {
        evt.preventDefault();

        var form = $('#form_video')[0];
        var data = new FormData(form);

        progresso();

        var ajax = $.ajax({
            url: rotas + 'cria-video/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.reload();
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function apaga_video() {

    $(document).on('submit', '#form_apaga_video', function (evt) {
        evt.preventDefault();

        var data = $(this).serialize();

        progresso();

        var ajax = $.ajax({
            url: rotas + 'apaga-video/',
            type: "POST",
            dataType: 'json',
            data: data,
            timeout: 60000
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "../../";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function cria_cronograma() {

    $(document).on('submit', '#form_cronograma', function (evt) {
        evt.preventDefault();

        var form = $('#form_apaga_cronograma')[0];
        var data = new FormData(form);
        var texto = $("#texto").html();
        var projeto = $("#projeto").val();
        var ano = $("#ano").val();
        data.append('texto', texto);
        data.append('projeto', projeto);
        data.append('ano', ano);

        progresso();

        var ajax = $.ajax({
            url: rotas + 'cria-cronograma/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.reload();
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function edita_cronograma() {

    $(document).on('submit', '#form_edita_cronograma', function (evt) {
        evt.preventDefault();

        var form = $('#form_edita_cronograma')[0];
        var data = new FormData(form);
        var id = $("#id").val();
        var texto = $("#texto").html();
        var projeto = $("#projeto").val();
        var ano = $("#ano").val();
        data.append('id', id);
        data.append('texto', texto);
        data.append('ano', ano);

        progresso();

        var ajax = $.ajax({
            url: rotas + 'edita-cronograma/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "../../";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function apaga_cronograma() {

    $(document).on('submit', '#form_apaga_cronograma', function (evt) {
        evt.preventDefault();

        var form = $('#form_apaga_cronograma')[0];
        var data = new FormData(form);

        progresso();

        var ajax = $.ajax({
            url: rotas + 'apaga-cronograma/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "../../";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

function cria_apoiador() {

    $(document).on('submit', '#form_apoiador', function (evt) {
        evt.preventDefault();

        var form = $('#form_apoiador')[0];
        var data = new FormData(form);

        progresso();

        var ajax = $.ajax({
            url: rotas + 'cria-apoiador/',
            type: "POST",
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.reload();
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data);
        });

    });

}

function apaga_apoiador() {

    $(document).on('submit', '#form_apaga_apoiador', function (evt) {
        evt.preventDefault();

        var dados = $(this).serialize();

        progresso();

        var ajax = $.ajax({
            url: rotas + 'apaga-apoiador/',
            type: 'POST',
            dataType: 'json',
            data: dados,
        });

        ajax.done(function (data) {
            dialogo('Resposta', data.resposta);
            if (data.sucesso) {
                window.location.href = "/admin/apoiadores/";
            }
        });

        ajax.fail(function (data) {
            dialogo('Resposta', 'Ocorreu um erro inesperado.');
            console.log(data.responseText);
        });

    });

}

//Exibe dialogos ao UI
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
    //    dialogo('Aguarde', 'Carregando...');
    //    $('#dialogoAcoes').hide();
}