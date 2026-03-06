<?php
//Edita o usuário selecionado
if(!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'edita-cronograma' && !empty($_REQUEST['id'])):

$cronograma = read_cronograma(array('id'=>$_REQUEST['id']));
$cronograma = $cronograma->fetch_assoc();
?>

<div class="bg-white p-3 mb-5">
    <h2 class="h3">Editar cronograma</h2>
    <form method="post" id="form_edita_cronograma">
        <div class="form-row">
            <input type="hidden" name="id" id="id" value="<?php echo $cronograma['id'];?>">
            <div class="col-12 form-group p-1">
                <label>Ano</label>
                <input type="number" class="form-control w-100 rounded-0" name="ano" id="ano" placeholder="Ano" value="<?php echo $cronograma['ano'];?>">
            </div>
            <div class="col-12 form-group">
                <label for="texto">Descrição</label>
                <div id="texto">
                    <?php echo $cronograma['texto'];?>
                </div>
            </div>
        </div>
        <a href="/admin/cronograma/" class="btn btn-sm bg-danger text-white">Cancelar</a>
        <button type="submit" class="btn btn-sm bg-blue text-white">Salvar</button>
    </form>
</div>
<?php
//Deleta o projeto selecionado
elseif(!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'apaga-cronograma' && !empty($_REQUEST['id'])):

$cronograma = read_cronograma(array('id'=>$_REQUEST['id']));
$cronograma = $cronograma->fetch_assoc();
?>

<div class="bg-white border-top p-3 mb-5">
    <h2 class="h3">Apagar cronograma?</h2>
    <p>Você está preste a apagar o cronograma abaixo. <br> <span class="text-danger">O cronograma será apagado permanentemente.</span></p>
    <div class="bg-white">
        <div class="bg-white h-100">
            <div class="bg-white h-100 mt-3">
                <div class="row m-0 align-items-center text-center">
                    <div class="col-12 col-md-6 p-0">
                        <div class="bg-white p-3">
                            <?php
                            $projeto = read_projeto(array('id'=>$cronograma['id_projeto']));
                            $projeto = $projeto->fetch_assoc();
                            ?>

                            <div class="w-100 p-3">
                                <h1><?php echo $cronograma['ano'];?></h1>
                                <p><?php echo $projeto['titulo'];?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" id="form_apaga_cronograma">
        <div class="col-12 col-md-6 col-xl-4 form-group p-1">
            <input type="hidden" name="id" id="id" value="<?php echo $cronograma['id'];?>">
        </div>
        <a class="btn btn-sm bg-danger text-white" href="/admin/cronograma/">Cancelar</a>
        <button type="submit" class="btn btn-sm bg-blue text-white">Confirmar</button>
    </form>
</div>

<?php
else:
?>

<h2>Cronogramas</h2>
<div class="navbar p-0">
    <button type="button" class="w-50 btn btn-sm bg-green text-white p-2" data-toggle="collapse" role="button" aria-expanded="false" data-target="#novaMateria">Adicionar</button>
    <a href="" class="w-50 btn btn-sm bg-dark text-white p-2"><i class="material-icons align-middle"> refresh </i>Atualizar</a>
</div>

<div class="collapse bg-white border-top border-bottom p-3" id="novaMateria">
    <h3 class="h5">Criar um cronograma</h3>
    <form method="post" id="form_cronograma">
        <div class="form-row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="titulo">Projeto relacionado</label>
                    <select name="projeto" id="projeto" class="form-control">
                        <option>Nenhum</option>
                        <?php
                        $projetos = read_projeto();
                        foreach($projetos as $projeto){
                            echo '<option value="' . $projeto['id'] . '">' . $projeto['titulo'] .'</option>';
                        }
                        ?>

                    </select>
                </div>
            </div>
            <div class="col-12 form-group p-1">
                <label>Ano</label>
                <input type="number" class="form-control w-100 rounded-0" name="ano" id="ano" placeholder="Ano">
            </div>
            <div class="col-12 form-group">
                <label for="texto">Descrição</label>
                <div id="texto"></div>
            </div>
        </div>
        <button type="submit" class="btn bg-blue">Salvar</button>
        <button type="reset" class="btn bg-danger text-white">Limpar tudo</button>
    </form>

</div>

<div class="row">

    <?php
    $cronogramas = read_cronograma();
    foreach($cronogramas as $cronograma):
    ?>

    <div class="col-12 col-md-6 col-xl-4 col-xl-3 p-3">
        <div class="bg-white shadow-md">
            <div class="row m-0">
                <div class="col-12 navbar p-0 border-top">

                    <?php
                    $projeto = read_projeto(array('id'=>$cronograma['id_projeto']));
                    $projeto = $projeto->fetch_assoc();
                    ?>

                    <div class="w-100 p-3 border-bottom">
                        <h1><?php echo $cronograma['ano'];?></h1>
                        <p><?php echo $projeto['titulo'];?></p>
                    </div>
                    <div class="w-50 p-3">
                        <a href="edita-cronograma/<?php echo $cronograma['id'];?>/" class="btn btn-block btn-sm text-dark">Editar</a>
                    </div>
                    <div class="w-50 p-3">
                        <a href="apaga-cronograma/<?php echo $cronograma['id'];?>/" class="btn btn-block btn-sm text-danger">
                            <i class="material-icons align-middle"> delete </i> Apagar</a>
                    </div>
                </div>
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