<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header.php');

//URL da live ou do vídeo selecionado
$url = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
?>
<!-- Conteúdo -->
<div class="bg-blue">
    <div class="container pt-5 pb-5 text-dark text-center">
        <div class="row align-items-center text-uppercase font-weight-light">
            <div class="col-12 col-md-6">
                <h2 class="h1 font-weight-light">MÍDIAS</h2>
            </div>
            <div class="col-12 col-md-6 text-uppercase h5 font-weight-light">
                <p class="h5 font-weight-light">Conteúdos audiovisuais <br> sobre ciências e projetos.</p>
            </div>
        </div>
    </div>
</div>
<div class="container pt-3 pb-3">
    <?php
    if (!empty($url)) :
        $video = read_video($url);
        $video = $video->fetch_assoc();
        ?>
    <h3 class="mb-3 text-center">
        <?php $titulo = (empty($_REQUEST['id'])) ? 'Acompanhe nossa live' : $video['titulo'];
        echo $titulo; ?></h3>
    <div class="row m-0">
        <div class="col-12 p-0 m-auto bg-transparent shadow-md">
            <div class="text-center">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $url; ?>" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    <?php
endif;
?>
    <div class="mt-5 mb-3">
        <h3 class="mb-3">Últimos videos</h3>
        <div class="row">
            <?php
            $videos = read_video();
            include('include/templates/inc_midia.php');
            ?>
        </div>
    </div>
</div>

<?php
$pag =
    '<script>
    var pag = $(".midia");
    if(!pag.hasClass("active")){
        pag.addClass("active");
    }
</script>';

include_once("include/inc_rodape.php");
?> 
