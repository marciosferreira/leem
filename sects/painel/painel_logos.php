<h2>Logos dos apoiadores</h2>
<?php
 //Deleta o apoiador selecionado
if (!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'apaga-apoiador' && !empty($_REQUEST['id'])):
    ?>

<div class="bg-white border-top p-3 text-center">
    <h2 class="h3">Apagar <em>apoiador</em>?</h2>
    <p>Você está preste a apagar o destaque selecionado. <br> <span class="text-danger">O destaque será apagado permanentemente.</span></p>
    <form method="post" id="form_apaga_apoiador">
        <div class="col-12 col-md-6 col-xl-4 form-group p-1">
            <input type="hidden" name="id_apoiador" id="id_apoiador" value="<?php echo $_REQUEST['id']; ?>">
        </div>
        <a class="btn btn-sm bg-danger text-white" href="/admin/apoiadores/">Cancelar</a>
        <button type="submit" class="btn btn-sm bg-blue text-white">Confirmar</button>
    </form>
</div>

<?php
else:
    ?>

<!--Cria um novo apoiador-->
<div class="bg-white shadow-md border-top p-3 collapse" id="novoUsuario">
    <h3 class="h5">Novo <em>apoiador</em></h3>
    <form method="post" id="form_apoiador">
        <div class="form-group">
            <label>Descrição</label>
            <input type="text" class="form-control w-100 rounded-0" name="nome" id="nome" placeholder="Nome do apoiador">
        </div>
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input rounded-0" name="foto" id="foto" aria-describedby="foto">
                <label class="custom-file-label" for="foto">Selecione uma foto</label>
            </div>
        </div>
        <div class="alert alert-warning">
            <small>
                Atenção: As imagens devem ter a mesma resolução (Recomendado 512x512 px).
            </small>
        </div>
        <button type="reset" class="btn btn-sm bg-danger text-white" id="limparForm">Limpar tudo</button>
        <button type="button" class="btn btn-sm bg-danger text-white" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="novoUsuario" data-target="#novoUsuario">Cancelar</button>
        <button type="submit" class="btn btn-sm bg-blue text-white">Salvar</button>
    </form>
</div>

<!--Busca usuários-->
<div class="navbar bg-white p-3 shadow-md">
    <button type="button" class="w-50 btn btn-sm bg-green text-white" data-toggle="collapse" role="button" aria-expanded="false" data-target="#novoUsuario"><i class="material-icons align-middle"> person_add </i> Novo <em>apoiador</em></button>
    <a href="" class="w-50 btn btn-sm bg-dark text-white"><i class="material-icons align-middle"> refresh </i>Atualizar</a>
</div>

<div class="row">

    <?php
    //Lista todos os apoiadores
    $apoiadores = read_apoiador();
    foreach ($apoiadores as $apoiador):

        ?>

    <div class="col-12 col-sm-4 col-md-3 col-xl-2 p-3">
        <div class="bg-white h-100 shadow-md">
            <a href="/admin/apoiadores/apaga-apoiador/<?php echo $apoiador['id']; ?>/" class="btn btn-block btn-sm text-white bg-danger"><i class="material-icons align-middle"> delete </i> Apagar</a>
            <div class="bg-white">
                <img src="/public/uploads/fotos/<?php echo $apoiador['foto']; ?>" class="img-fluid">
            </div>
        </div>
    </div>

    <?php
endforeach;

?>

</div>

<?php
endif;
?> 