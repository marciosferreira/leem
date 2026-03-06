<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';

//Visão do projeto selecionado
if (isset($_REQUEST['slug'])): $slug = $_REQUEST['slug'];
    $materias = read_materia(array('slug' => $slug));

    if ($materias->num_rows > 0): $materia = $materias->fetch_assoc();
        if (!empty($materia['foto'])) {
            $foto_materia =  '/uploads/fotos/' . $materia['foto'];
        } else {
            $foto_materia = '/img/logo-leem.png';
        }

        $head = '<meta property="og:image" content="' . $foto_materia . '">
                <meta property="og:image:type" content="image/jpeg">
                <meta property="og:image:width" content="800">
                <meta property="og:image:height" content="600">
                <meta property="og:type" content="article">
                <meta property="article:section" content="Matérias">
                <meta property="og:locale" content="pt_BR">
                <meta property="og:url" content="https://leem.net.br/'.$materia['slug'].'/">
                <meta property="og:title" content="'.$materia['titulo'].'">
                <meta property="og:site_name" content="leem.net.br">
                <meta property="article:og:description" content="'.substr($materia['descricao'], 0,100).'...">
                <meta property="article:published_time" content="'.$materia['data'].'">
                <title>'.$materia['titulo'].'</title>';

        include_once('include/inc_header.php');

        ?>

<div class="container">
    <div class="row mt-5 mb-5">

        <?php include_once('include/templates/inc_materia.php'); ?>

    </div>
</div>

<?php
else:
    ?>

<div class="container pt-5 pb-5 text-center">
    <p class="h4 text-muted">Página não encontrada.</p>
</div>

<?php
endif;
endif;
include_once("include/inc_rodape.php");
?> 
