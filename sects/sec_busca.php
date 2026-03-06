<?php 
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header.php');

if(isset($_REQUEST['busca'])):
?>

<!-- Conteúdo -->
<div class="bg-blue">
    <div class="container pt-5 pb-5 text-dark text-center">
        <h2 class="text-uppercase font-weight-light">Resultados da busca:
            <br>
            <span class="font-weight-bold"><?php if(isset($_REQUEST['busca'])){echo $_REQUEST['busca'];} ?></span>
        </h2>
    </div>
</div>
<div class="bg-white pt-3 pb-5">
    <div class="container mt-5">

        <?php
        $materias = read_materia($_REQUEST['busca']);
        if($materias->num_rows > 0):
        ?>

        <section class="mb-5">
            <h3 class="mb-3 border-bottom pb-3 mb-3">Resultados em matérias</h3>
            <div class="row m-0">

                <?php 
                include_once("include/templates/inc_materia_min.php");
                materia($materias);
                ?>

            </div>
        </section>

        <?php
        endif;
        ?>

        <?php
        $projetos = read_projeto($_REQUEST['busca']);
        if($projetos->num_rows > 0):
        ?>

        <section class="mb-5">
            <h3 class="mb-3 border-bottom pb-3 mb-3">Resultados em projetos</h3>
            <div class="row align-items-center">

                <?php include_once("include/templates/inc_projeto.php");?>

            </div>
        </section>

        <?php
        endif;
        ?>

        <?php
        $videos = read_video($_REQUEST['busca']);
        if($videos->num_rows > 0):
        ?>

        <section class="mb-5">
            <h3 class="mb-3 border-bottom pb-3 mb-3">Resultados em mídias</h3>
            <div class="row">

                <?php include_once("include/templates/inc_midia.php");?>

            </div>
        </section>

        <?php
        endif;
        ?>

        <?php
        $pesquisas = read_pesquisa($_REQUEST['busca']);
        if($pesquisas->num_rows > 0):
        ?>

        <section class="mb-5">
            <h3 class="mb-3 border-bottom pb-3 mb-3">Resultados em pesquisas</h3>
            <div class="row">

                <?php include_once("include/templates/inc_pesquisa.php");?>

            </div>
        </section>

        <?php
        endif;
        ?>

        <?php
        $equipe = read_usuario(array('busca'=>$_REQUEST['busca']));
        if($equipe->num_rows > 0):
        ?>

        <section class="mb-5">
            <h3 class="mb-3 border-bottom pb-3 mb-3">Resultados em usuários</h3>
            <div class="row align-items-center">

                <?php include_once("include/templates/inc_usuario.php");?>

            </div>
        </section>

        <?php
        endif;

        if($materias->num_rows == 0 &&
        $projetos->num_rows == 0 &&
        $videos->num_rows == 0 &&
        $pesquisas->num_rows == 0 &&
        $equipe->num_rows == 0){
            echo '<p class="h5 text-muted text-center">Nenhum resultado para a sua pesquisa.</p>';
        }
        ?>

    </div>
</div>

<?php 
endif;
include_once("include/inc_rodape.php");?>
