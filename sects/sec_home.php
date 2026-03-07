<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
header('Content-Type: text/html; charset=utf-8');
include_once('include/inc_header.php');
include_once("include/templates/inc_materia_min.php");
?>

<div class="bg-blue text-center">
    <?php
    //Banner de destaques
    $materias = read_materia(array('destaque' => 1));

    if ($materias->num_rows > 0) :
        ?>

        <div class="destaques">

            <?php
            $in = 1;
            foreach ($materias as $destaque) :
                ?>

                <div class="h-100 pt-5 pb-5 destaque" style=" background: linear-gradient(to top, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0)), url(/uploads/fotos/<?php echo $destaque['foto']; ?>) center no-repeat;">
                    <div class="container pt-5 pb-5">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6 text-center">
                                <h1 class="pl-3 lead font-weight-bold m-0">
                                    <img src="/img/LOGO.svg" class="img-fluid pl-4 pr-4" class="m-auto" alt="LEEM">
                                    <span class="d-none">LEEM</span>
                                </h1>
                            </div>
                            <div class="text-destaque col-12 col-md-6">
                                <h1 class="text-white">
                                    <a href="/index.php/materia/<?php echo $destaque['slug']; ?>" class="text-white">

                                        <?php
                                        $arrayWords = explode(' ', $destaque['titulo']);
                                        $count = 0;
                                        foreach($arrayWords as $word){

                                            echo $word . ' ';
                                            if($count == 12) {
                                                trim($word);
                                                break;
                                            }

                                            $count++;
                                        }
                                        //echo substr($destaque['titulo'], 0, 80); 
                                        ?>...
                                        
                                    </a>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $in++;
            endforeach;
            ?>

        </div>
    <?php
endif;
?>
</div>


<!-- Matérias -->
<div class="container pt-3">
    <div class="row d-flex justify-content-start flex-wrap">
        <div class="col-12">
            <?php
            $count = 4;
            if (isset($_REQUEST['count'])) {
                $count = $_REQUEST['count'];
                $count += 4;
            }

            $materias = read_materia(array('tipo' => 'materia'), $count);
            if ($materias->num_rows > 0) :

                ?>

                <div class="row m-0">
                    <div class="col-12 col-lg-8 p-0">
                        <h2 class="titulo-categoria text-left">Matérias</h2>
                    </div>
                </div>

                <?php
                materia($materias);

                if ($materias->num_rows > $count - 1) :
                    ?>

                    <div class="col-12 text-center p-3 bg-white">
                        <form method="post">
                            <input type="hidden" name="count" value="<?php echo $count; ?>">
                            <button type="submit" class="btn-lg btn-block bg-white h5 border-0 text-dark" style="cursor: pointer"> <i class="material-icons"> arrow_forward_ios </i> <br> Mais... </button>
                        </form>
                    </div>

                <?php
            endif;
        endif;
        ?>

        </div>
        <div class="col-12 col-lg-4 bg-white pt-3">
        </div>
    </div>
</div>



<!-- Seminários -->
<div class="container pt-3">
    <div class="row d-flex justify-content-start flex-wrap">
        <div class="col-12">
            <?php
            $count = 8;
            if (isset($_REQUEST['count'])) {
                $count = $_REQUEST['count'];
                $count += 8;
            }

            $materias = read_materia(array('tipo' => 'seminario'), $count);
            if ($materias->num_rows > 0) :

                ?>

                <div class="row m-0">
                    <div class="col-12 col-lg-8">
                        <h2 class="titulo-categoria">Seminários do LEEM</h2>
                    </div>
                </div>

                <?php

                ?>

                <?php
                materia($materias);
                ?>

                <?php

                if ($materias->num_rows > $count - 1) :
                    ?>

                    <div class="col-12 text-center p-3 bg-white">
                        <form method="post">
                            <input type="hidden" name="count" value="<?php echo $count; ?>">
                            <button type="submit" class="btn-lg btn-block bg-white h5 border-0 text-dark" style="cursor: pointer"> <i class="material-icons"> arrow_forward_ios </i> <br> Mais... </button>
                        </form>
                    </div>

                <?php
            endif;
        else :
            ?>

                <div class="col-12 p-3 text-center">
                    <p class="h4 text-muted m-0">Muitas matérias em breve.</p>
                </div>

            <?php
        endif;
        ?>

        </div>
        <div class="col-12 col-lg-4 bg-white pt-3">
        </div>
    </div>
</div>

<!-- Notícias -->
<div class="container pt-3">
    <div class="row d-flex justify-content-start flex-wrap">
        <div class="col-12">
            <?php
            $count = 4;
            if (isset($_REQUEST['count'])) {
                $count = $_REQUEST['count'];
                $count += 4;
            }

            $materias = read_materia(array('tipo' => 'noticia'), $count);
            if ($materias->num_rows > 0) :

                ?>

                <div class="row m-0">
                    <div class="col-12 col-lg-4 p-0"></div>
                    <div class="col-12 col-lg-8">
                        <h2 class="titulo-categoria text-right">Notícias</h2>
                    </div>
                </div>

                <?php

                ?>

                <?php
                materia($materias);
                ?>

                <?php

                if ($materias->num_rows > $count - 1) :
                    ?>

                    <div class="col-12 text-center p-3 bg-white">
                        <form method="post">
                            <input type="hidden" name="count" value="<?php echo $count; ?>">
                            <button type="submit" class="btn-lg btn-block bg-white h5 border-0 text-dark" style="cursor: pointer"> <i class="material-icons"> arrow_forward_ios </i> <br> Mais... </button>
                        </form>
                    </div>

                <?php
            endif;
        endif;
        ?>

        </div>
        <div class="col-12 col-lg-4 bg-white pt-3">
        </div>
    </div>
</div>









<!-- Eventos -->
<div class="container pt-3">
    <div class="row d-flex justify-content-start flex-wrap">
        <div class="col-12">
            <?php
            $count = 4;
            if (isset($_REQUEST['count'])) {
                $count = $_REQUEST['count'];
                $count += 4;
            }

            $materias = read_materia(array('tipo' => 'evento'), $count);
            if ($materias->num_rows > 0) :

                ?>

                <div class="row m-0">
                    <div class="col-12 col-lg-4 p-0"></div>
                    <div class="col-12 col-lg-8 p-0">
                        <h2 class="titulo-categoria text-left">Eventos</h2>
                    </div>
                </div>

                <?php
                materia($materias);

                if ($materias->num_rows > $count - 1) :
                    ?>

                    <div class="col-12 text-center p-3 bg-white">
                        <form method="post">
                            <input type="hidden" name="count" value="<?php echo $count; ?>">
                            <button type="submit" class="btn-lg btn-block bg-white h5 border-0 text-dark" style="cursor: pointer"> <i class="material-icons"> arrow_forward_ios </i> <br> Mais... </button>
                        </form>
                    </div>

                <?php
            endif;
        endif;
        ?>

        </div>
        <div class="col-12 col-lg-4 bg-white pt-3">
        </div>
    </div>
</div>

<!-- Visitas -->
<div class="container pt-3">
    <div class="row d-flex justify-content-start flex-wrap">
        <div class="col-12">
            <?php
            $count = 4;
            if (isset($_REQUEST['count'])) {
                $count = $_REQUEST['count'];
                $count += 4;
            }

            $materias = read_materia(array('tipo' => 'visita'), $count);
            if ($materias->num_rows > 0) :

                ?>

                <div class="row m-0">
                    <div class="col-12 col-lg-8 p-0">
                        <h2 class="titulo-categoria text-left">Visitas</h2>
                    </div>
                </div>

                <?php
                materia($materias);

                if ($materias->num_rows > $count - 1) :
                    ?>

                    <div class="col-12 text-center p-3 bg-white">
                        <form method="post">
                            <input type="hidden" name="count" value="<?php echo $count; ?>">
                            <button type="submit" class="btn-lg btn-block bg-white h5 border-0 text-dark" style="cursor: pointer"> <i class="material-icons"> arrow_forward_ios </i> <br> Mais... </button>
                        </form>
                    </div>

                <?php
            endif;
        endif;
        ?>

        </div>
        <div class="col-12 col-lg-4 bg-white pt-3">
        </div>
    </div>
</div>

<?php
$pag =
    '<script>
        var pag = $(".inicio");
        if(!pag.hasClass("active")){
            pag.addClass("active");
        }

        $(".usuarios,.visitantes").slick({
            slidesToShow: 1,
            slidesToScroll: 1
        });
        $(".destaques").slick();
    </script>';

include_once("include/inc_rodape.php"); ?>
