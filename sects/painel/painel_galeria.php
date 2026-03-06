<h2>Galeria de imagens</h2>
<?php
//Deleta o usuário selecionado
if (!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'apagar' && !empty($_REQUEST['id'])) :
    ?>

    <div class="bg-white border-top p-3 text-center">
        <h2 class="h3">Apagar <em>imagem</em>?</h2>
        <p>Você está preste a apagar a imagem selecionada. <br> <span class="text-danger">A imagem será apagada permanentemente.</span></p>
        <form method="post" id="form_apaga_imagem">
            <input type="hidden" name="id_imagem" id="id_imagem" value="<?php echo $_REQUEST['id']; ?>">
            <a class="btn btn-sm bg-danger text-white" href="/admin/galeria/">Cancelar</a>
            <button type="submit" class="btn btn-sm bg-blue text-white">Confirmar</button>
        </form>
    </div>

<?php
else :
    ?>

    <!--Cria um novo destaque-->
    <div class="bg-white shadow-md border-top p-3 collapse" id="novoUsuario">
        <h3 class="h5">Subir imagem</h3>
        <form method="post" id="form_imagem">
            <input type="file" name="imagem" id="imagem" aria-describedby="inputFoto">
            <button type="reset" class="btn btn-sm bg-danger text-white" id="limparForm">Limpar tudo</button>
            <button type="button" class="btn btn-sm bg-danger text-white" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="novoUsuario" data-target="#novoUsuario">Cancelar</button>
            <button type="submit" class="btn btn-sm bg-blue text-white">Salvar</button>
        </form>
    </div>

    <!--Busca usuários-->
    <div class="navbar bg-white p-3 shadow-md">
        <button type="button" class="w-50 btn btn-sm bg-green text-white" data-toggle="collapse" role="button" aria-expanded="false" data-target="#novoUsuario"><i class="material-icons align-middle"> add </i> Subir imagem</button>
        <a href="" class="w-50 btn btn-sm bg-dark text-white"><i class="material-icons align-middle"> refresh </i>Atualizar</a>
    </div>

    <div class="row">

        <?php
        //Lista todos os destaques
        $imagens = read_imagem();
        foreach ($imagens as $imagem) :

            ?>

            <div class="col-12 col-md-4 col-xl-4 p-3">
                <div class="bg-white h-100 shadow-md">
                    <div class="bg-white p-3">
                        <a href="/admin/galeria/apagar/<?php echo $imagem['id']; ?>/" class="btn btn-block btn-sm text-white bg-danger mb-3">
                            <i class="material-icons align-middle"> delete </i> Apagar
                        </a>
                        <img src="/public/uploads/fotos/<?php echo $imagem['nome']; ?>" class="w-100 h-100">
                        <input type="text" class="form-control" value="https://leem.net.br/public/uploads/fotos/<?php echo $imagem['nome']; ?>">
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