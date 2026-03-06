<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header.php');
?>

<div class="container pt-5">
    <h2>Reportar um erro</h2>
    <p>Encontrou um problema? Envie-nos os detalhes.</p>
    <div class="bg-white shadow-md border-top p-3 mb-5">
        <form method="post" id="form_bug">
            <div class="form-group">
                <label>Descreva o problema</label>
                <textarea class="form-control" rows="7" name="bug" id="bug" placeholder="Descreva o problema"></textarea>
            </div>
            <button type="reset" class="btn btn-sm bg-danger text-white" id="limparForm">Limpar tudo</button>
            <button type="submit" class="btn btn-sm bg-blue text-white">Enviar</button>
        </form>
    </div>
</div>

<?php
include_once("include/inc_rodape.php");
?>
