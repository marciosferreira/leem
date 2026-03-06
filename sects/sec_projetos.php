<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header.php');

if(!isset($_REQUEST['slug'])):
?>
<!-- Conteúdo -->
<div class="bg-blue">
    <div class="container pt-5 pb-5 text-dark text-center">
        <div class="row align-items-center text-uppercase font-weight-light">
            <div class="col-12 col-md-6">
                <h2 class="h1 font-weight-light">Projetos</h2>
            </div>
            <div class="col-12 col-md-6">
                <p class="h5 font-weight-light">Projetos sobre ciência e natureza.</p>
            </div>
        </div>
    </div>
</div>

<?php
endif;
?>

<?php
//Visão do projeto selecionado
if(isset($_REQUEST['slug'])):

$slug = $_REQUEST['slug'];
$projeto = read_projeto(array('slug'=>$slug));

if($projeto->num_rows > 0):
$projeto = $projeto->fetch_assoc();
?>

<section>
    <article class="w-100 bg-white h-100">
        <div class="bg-blue pt-5 pb-5">
            <div class="container">
                <div class="row align-items-center mb-3">
                    <div class="col-12 col-lg-4 text-center">
                        <img src="/public/uploads/fotos/<?php echo $projeto['foto'];?>" class="img-fluid" alt="<?php echo $projeto['titulo'];?>">
                    </div>
                    <header class="col-12 col-lg-8">
                        <h1 class="font-weight-bold text-uppercase mb-4 text-dark">
                            <?php echo $projeto['titulo'];?>
                        </h1>
                        <div class="pt-4 pb-4">
                            <p class="h5 font-weight-light m-0">
                                <?php echo $projeto['descricao'];?>
                            </p>
                        </div>
                    </header>
                </div>
            </div>
        </div>
        <div class="container pt-3">
            <section class="mb-3">
                <h2 class="h4 mb-5 pb-3 border-bottom">Pesquisadores do projeto</h2>
                <div class="row">
                    <?php
                    $count = 1;
                    if(isset($_REQUEST['count'])) {
                        $count = $_REQUEST['count'];
                        $count++;
                    }
                    
                    $slug_projeto = explode('-', $projeto['slug']);
                    
                    if($slug_projeto[0] == 'adapta'){
                        $equipe = read_usuario(array(
                            'perfil'=>'pesquisador',
                            'limit'=>$count * 10
                        ));
                    }else{
                        $equipe = read_usuario_projeto(array(
                            'id_projeto'=>$projeto['id'],
                            'limit'=>$count * 10
                        ));
                    }
                    

                    if($equipe->num_rows > 0):
                        include_once("include/templates/inc_usuario.php");
                        
                    if($equipe->num_rows > $count * 9):
                    ?>

                    <div class="col-12 text-center p-3 bg-white">
                        <form method="post">
                            <input type="hidden" name="count" value="<?php echo $count; ?>">
                            <button type="submit" class="btn-lg btn-block bg-white h5 border-0 text-dark" style="cursor: pointer"> <i class="material-icons"> arrow_forward_ios </i> <br> Mais... </button>
                        </form>
                    </div>

                    <?php
                    endif;
                    else:
                    ?>

                    <div class="col-12 pt-5 pb-5 text-center">
                        <p class="text-muted m-0 h3">Nenhum usuário econtrado.</p>
                    </div>

                    <?php
                    endif;
                    ?>

                </div>
            </section>

            <section class="mt-5 mb-5">
                <h2 class="h4 border-bottom mb-5 pb-3">Cronograma do projeto</h2>
                <div class="cronograma text-center">
                    <div class="row">

                        <?php
                        $cronogramas = read_cronograma(array('id_projeto'=>$projeto['id']));

                        $i = 0;
                        if($cronogramas->num_rows > 0):
                        foreach($cronogramas as $cronograma){
                            $avatar = read_avatar($usuario['id']);
                        ?>


                        <div class="col-12 col-md-8 m-auto">
                            <?php
                            if($i > 0){
                            ?>
                            <div style="width:3px;height:100px;" class="bg-danger m-auto"></div>

                            <?php
                            }
                            ?>

                            <h3 class="cronograma text-white pt-3 border border-danger bg-danger rounded-circle m-auto" style="width:100px;height:100px;border-width: 3px!important;">
                                <div class="p-3 h-100">
                                    <?php echo $cronograma['ano'];?>
                                </div>
                            </h3>
                            <div style="width:3px;height:100px;" class="bg-danger m-auto"></div>
                            <div class="cronograma-texto border border-danger p-3" style="border-width: 3px!important;">
                                <?php echo $cronograma['texto'];?>
                            </div>

                        </div>

                        <?php
                            $i++;
                        }
                        ?>

                    </div>

                    <?php
                    else:
                    ?>

                    <div class="col-12 pt-5 pb-5 text-center">
                        <p class="text-muted m-0 h3">Nenhum cronograma econtrado.</p>
                    </div>

                    <?php
                    endif;
                    ?>

                </div>
            </section>
            <section class="mt-5 mb-5">
                <h2 class="h4 border-bottom mb-5 pb-3">Países participantes</h2>

                <div class="row">
                    <?php echo get_paises($projeto['paises']);?>
                </div>

            </section>
            <section class="mt-5 mb-5">
                <h2 class="h4 border-bottom mb-5 pb-3">Programas colaboradores</h2>

                <?php
                $programas = explode(',', $projeto['programas']);

                if(!empty($projeto['paises'])){

                    if(count($programas) > 1){
                        $i = 0;
                        echo '<ul class="row list-unstyled">';
                        foreach($programas as $programa){
                            echo '<li class="col-12 col-sm-6 col-md-3 mb-4 d-inline-block">' 
                                . '<div class="p-3 font-weight-bold">'
                                .'<div class="bg-blue text-white d-inline-block p-3 rounded-circle mr-3">'
                                .'<i class="material-icons align-middle">extension</i>'
                                .'</div>'
                                .'<div class=" d-inline-block">'. $programa .'</div>'
                                . '</li>';
                        }
                        echo '</ul>';
                    }else{
                        echo '<ul class="row list-unstyled">'
                            .'<li class="col-12 col-sm-6 col-md-3 mb-4 d-inline-block">' 
                            . '<div class="p-3 font-weight-bold">'
                            .'<div class="bg-blue text-white d-inline-block p-3 rounded-circle mr-3">'
                            .'<i class="material-icons align-middle">extension</i>'
                            .'</div>'
                            .'<div class=" d-inline-block">'. $projeto['programas'] .'</div>'
                            . '</li>'
                            .'</ul>';
                    }
                }else{
                    echo '<div class="col-12 pt-5 pb-5 text-center">';
                    echo '<p class="text-muted m-0 h3">Nenhum programa.</p>';
                    echo '</div>';
                }
                ?>

            </section>
            <section>
                <h2 class="h4 border-bottom mb-5 pb-3">Papers submetidos ao
                    <?php echo $projeto['titulo'];?>
                </h2>
                <h3 class="h5 mb-3 border-bottom">Matérias</h3>

                <?php
                $materias = read_materia(array('id_projeto'=>$projeto['id']));
                if($materias->num_rows > 0):
                ?>

                <section class="mb-5">
                    <div class="row m-0">

                        <?php
                        foreach($materias as $materia):
                        $usuario = read_usuario($materia['id_usuario']);
                        $usuario = $usuario->fetch_assoc();
                        $avatar = read_avatar($usuario['id']);
                        ?>

                        <div class="col-12 col-sm-6 col-md-4 p-0 h-100 m-0">
                            <article class="h-100 bg-white border">
                                <div class="row m-0 align-items-center border-bottom">
                                    <div class="col-4 col-lg-2 p-1 text-center">
                                        <img src="/public/uploads/fotos/<?php echo $avatar;?>" alt="<?php echo $usuario['nome'];?>" class="m-auto" width="60">
                                    </div>
                                    <div class="col-8 col-md-8 p-1">
                                        <p class="small d-inline-block m-0"><strong>
                                                <?php echo $usuario['nome'];?></strong>
                                            <span class="text-muted">

                                                <?php 
                                                $dia = data_dia($materia['data']);
                                                $mes = data_mes($materia['data']);
                                                $ano = data_ano($materia['data']);
                                                $hor = data_hora($materia['data']);

                                                echo '<br>Publicado dia ' . $dia .' de '. $mes .' de '. $ano .' às '. $hor;
                                                ?>

                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row m-0">
                                    <div class="col-12 p-0">
                                        <header>
                                            <h1 class="h3 p-3 font-weight-bold">
                                                <a href="/materia/<?php echo $materia['slug'];?>/" class="text-dark">
                                                    <?php echo $materia['titulo'];?></a></h1>
                                        </header>
                                        <main class="p-3">
                                            <p class="text-dark small">
                                                <?php echo $materia['descricao'];?>
                                            </p>

                                            <?php if($materia['foto'] != NULL):?>

                                            <figure>
                                                <a href="/materia/<?php echo $materia['slug'];?>/">
                                                    <img src="/public/uploads/fotos/<?php echo $materia['foto'];?>" class="img-fluid" alt="<?php echo $materia['titulo'];?>">
                                                </a>
                                            </figure>

                                            <?php endif;?>

                                        </main>

                                    </div>
                                </div>
                            </article>
                        </div>

                        <?php
                        endforeach;
                        ?>

                    </div>
                </section>

                <?php
                else: 
                    echo '<p class="text-muted mb-3">Nada publicado ainda.</p>';
                endif;
                ?>

                <h3 class="h5 mb-3">Pesquisas</h3>

                <?php
                $pesquisas = read_pesquisa(array('id_projeto'=>$projeto['id']));
                if($pesquisas->num_rows > 0):
                ?>

                <section class="mb-5">
                    <div class="row">

                        <?php include_once("include/templates/inc_pesquisa.php");?>

                    </div>
                </section>

                <?php
                else: 
                    echo '<p class="text-muted mb-3">Nada publicado ainda.</p>';
                endif;
                ?>
            </section>
        </div>
    </article>
</section>

<?php
endif;

else:

$projetos = read_projeto();
if($projetos->num_rows > 0):
?>

<div class="container">

    <?php
    foreach($projetos as $projeto):
    ?>

    <article class="w-100 bg-white h-100 mt-3 mb-3 border-bottom">
        <div class="row align-items-center">
            <div class="col-12 col-lg-4 text-center">
                <img src="/public/uploads/fotos/<?php echo $projeto['foto'];?>" class="img-fluid" alt="<?php echo $projeto['titulo'];?>">
            </div>
            <div class="col-12 col-lg-8 text-uppercase">
                <h1 class="font-weight-bold mb-4 mt-3">
                    <a href="/projetos/<?php echo $projeto['slug'];?>/" class="w-100 font-weight-bold bg-white text-dark">
                        <?php echo $projeto['titulo'];?>
                    </a>
                </h1>
                <p class="h5 font-weight-light m-0">
                    <?php echo substr($projeto['descricao'], 0,120);?>...</p>
            </div>
        </div>
    </article>

    <?php
    endforeach;
    ?>

</div>

<?php
else:
?>

<div class="col-12 p-3 text-center">
    <p class="h4 text-muted">Muitos projetos em breve.</p>
</div>

<?php
endif;
endif;
?>

</div>

<?php
$pag = 
    '<script>
    var pag = $(".projetos");
    if(!pag.hasClass("active")){
        pag.addClass("active");
    }
</script>';

include_once("include/inc_rodape.php");
?>
