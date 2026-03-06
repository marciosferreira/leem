<?php
//Deleta o projeto selecionado
if(!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'apaga-midia' && !empty($_REQUEST['id'])):

$midias = read_video($_REQUEST['id']);
$midia = $midias->fetch_assoc();
?>

<div class="bg-white border-top p-3 mb-5">
    <h2 class="h3">Apagar mídia?</h2>
    <p>Você está preste a apagar o video abaixo. <br> <span class="text-danger">O video será apagado permanentemente.</span></p>
    <div class="bg-white shadow-md mb-3">
        <div class="bg-white h-100">
            <div class="bg-white h-100 mt-3">
                <div class="row m-0 align-items-center text-center">
                    <div class="col-12 col-md-6 p-0">
                        <div class="bg-white p-3">
                            <img src="https://img.youtube.com/vi/<?php echo $midia['url_id'];?>/hqdefault.jpg" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 p-0">
                        <div class="bg-white p-3">
                            <h3 class="d-inline-block text-uppercase">
                                <?php echo $midia['titulo'];?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" id="form_apaga_video">
        <input type="hidden" name="id_video" id="id_video" value="<?php echo $_REQUEST['id'];?>">
        <a class="btn btn-sm bg-danger text-white" href="/admin/midias/">Cancelar</a>
        <button type="submit" class="btn btn-sm bg-blue text-white">Confirmar</button>
    </form>
</div>

<?php
else:
?>

<h2>Mídias</h2>

<div class="bg-white border-top border-bottom p-3">
    <h3 class="h5">Novo vídeo do YouTube</h3>
    <form method="post" id="form_video">
        <div class="form-group">
            <label>Título do vídeo</label>
            <input type="text" class="form-control w-100 rounded-0" name="titulo" id="titulo" 
                   placeholder="Título do vídeo">
        </div>
        <div class="form-group">
            <label>Informe a URL do vídeo</label>
            <input type="text" class="form-control w-100 rounded-0" name="url" id="url" 
                   placeholder="Exemplo: https://www.youtube.com/watch?v=DvjDPeYEg3g">
        </div>
        <button type="submit" class="btn btn-sm bg-dark text-white"><i class="material-icons align-middle"> save </i> Salvar vídeo</button>
    </form>
</div>

<div class="row">

    <?php
    $midias = read_video();
    foreach($midias as $midia):
    ?>

    <div class="col-12 col-sm-6 col-md-4 col-lg-3 p-3">
        <div class="bg-white shadow-md">
            <div class="row m-0">
                <div class="h-100 col-12 p-0">
                    <img src="https://img.youtube.com/vi/<?php echo $midia['url_id'];?>/hqdefault.jpg" class="img-fluid">
                </div>
                <div class="col-12 navbar p-0 border-top">
                    <div class="w-50 p-1">
                        <a href="/midia/video/<?php echo $midia['url_id'];?>" class="btn btn-block btn-sm text-dark" target="_blank">Visualizar</a>
                    </div>
                    <div class="w-50 p-1">
                        <a href="apaga-midia/<?php echo $midia['url_id'];?>/" class="btn btn-block btn-sm text-danger">
                            <i class="material-icons align-middle"> delete </i></a>
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