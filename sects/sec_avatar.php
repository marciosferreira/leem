<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header.php');

if (!empty($usuario)) :
    ?>

    <div class="container bg-white mt-3 p-0 pb-3">
        <div class="row text-center m-0">
            <section class="col-12 col-sm-10 col-md-8 m-auto pb-5 p-3">
                <h2>Selecione uma imagem</h2>
                <button style="button" onclick="$('#file-input').click()" 
                class="btn btn-block bg-blue">Selecione uma imagem</button>
                <p><input type="file" id="file-input" class="d-none" /></p>
                <div id="actions" style="display:none;" class="btn-group w-100">
                    <button class="btn" type="button" id="edit">Editar</button>
                    <button class="btn" type="button" id="crop">Cortar</button>
                    <button class="btn" type="button" id="cancel">Cancelar</button>
                </div>
                <div id="result" class="w-100">
                    <p>
                        This demo works only in browsers with support for the
                        <a href="https://developer.mozilla.org/en/DOM/window.URL">URL</a> or
                        <a href="https://developer.mozilla.org/en/DOM/FileReader">FileReader</a>
                        API.
                    </p>
                </div>
                <button id="enviar-foto" class="btn btn-block bg-success text-white d-none">Enviar foto</button>
                <div id="exif" style="display:none;">
                    <h3>Exif meta data</h3>
                    <p id="thumbnail" style="display:none;"></p>
                    <table></table>
                </div>
                <div id="iptc" style="display:none;">
                    <h3>IPTC meta data</h3>
                    <table></table>
                </div>
            </section>
        </div>
    </div>

<?php
else :
    ?>

    <div class="container bg-white pt-5 pb-5 text-center">
        <p class="text-muted m-0 txt-center h3">Este usuário não foi encontrado.</p>
    </div>

<?php
endif;
include_once("include/inc_rodape.php");
?>
