<?php
if(sessao_ativa()){
    
    if($_SESSION['usuario']['perfil'] == 'normal'){
        header('Location: /');
    }

}else{
    header('Location: /');
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Laboratório de Ecofisiologia e Evolução Molecular – Instituto Nacional de Pesquisas da Amazônia.">
        <meta name="author" content="Danilson Veloso de Sousa">
        <link rel="icon" href="/img/favicon.ico">
        <title>LEEM | INPA - Laboratório de Ecofisiologia e Evolução Molecular – Instituto Nacional de Pesquisas da Amazônia.</title>

        <?php
        include_once("inc_styles.php");
        ?>

    </head>

    <body class="bg-white">
        <div id="carregando"></div>
        <!-- Cabeçalho -->
        <div class="container-fluid h-100 position-absolute">
            <div class="row">
                <div class="h-100 menu-admin col-12 col-md-4 col-lg-3 p-0 bg-dark" id="menuAdmin" contenteditable="false">
                    <nav class="navbar p-0" id="navbar">
                        <button class="btn bg-dark text-white d-inline-block d-md-none ml-auto" type="button" id="abre_admin">
                            <i class="material-icons"> close </i>
                        </button>
                        <ul class="w-100 flex-column list-unstyled p-0 m-0 text-left">
                            <li class="w-100 text-center nav-item bg-green p-2">
                                <a class="navbar-brand text-black" href="/"><i class="material-icons align-middle">arrow_back</i> LEEM</a>
                            </li>
                            <li class="pt-3">
                                <ul class="w-100 flex-column list-unstyled p-0 m-0 text-left">
                                    <li class="w-100 nav-item p-2">
                                        <a href="/admin/" class="nav-link text-white">
                                            <i class="material-icons align-middle mr-3"> how_to_reg </i> Solicitações
                                            <?php
                                            $usuarios = read_usuario(array('ativo'=>'0'));
                                            if($usuarios->num_rows > 0){
                                            ?>

                                            <span class="badge badge-warning"><?php echo $usuarios->num_rows;?></span>

                                            <?php
                                            }
                                            ?>
                                        </a>
                                    </li>
                                    <li class="w-100 nav-item p-2">
                                        <a href="/admin/usuarios/" class="nav-link text-white">
                                            <i class="material-icons align-middle mr-3"> supervised_user_circle </i> Usuários
                                        </a>
                                    </li>
                                    <li class="w-100 nav-item p-2">
                                        <a href="/admin/projetos/" class="nav-link text-white">
                                            <i class="material-icons align-middle mr-3"> dashboard </i> Projetos
                                        </a>
                                    </li>
                                    <li class="w-100 nav-item p-2">
                                        <a href="/admin/materias/" class="nav-link text-white">
                                            <i class="material-icons align-middle mr-3"> fiber_new </i> Matérias
                                        </a>
                                    </li>
                                    <li class="w-100 nav-item p-2">
                                        <a href="/admin/galeria/" class="nav-link text-white">
                                            <i class="material-icons align-middle mr-3"> insert_photo </i> Galeria de imagens
                                        </a>
                                    </li>
                                    <li class="w-100 nav-item p-2">
                                        <a href="/admin/pesquisas/" class="nav-link text-white">
                                            <i class="material-icons align-middle mr-3"> search </i> Pesquisas
                                        </a>
                                    </li>
                                    <li class="w-100 nav-item p-2">
                                        <a href="/admin/midias/" class="nav-link text-white">
                                            <i class="material-icons align-middle mr-3"> video_library </i> Mídias
                                        </a>
                                    </li>
                                    <li class="w-100 nav-item p-2">
                                        <a href="/admin/historia/" class="nav-link text-danger">
                                            <i class="material-icons align-middle mr-3"> copyright </i> Nossa história
                                        </a>
                                    </li>
                                    <li class="w-100 nav-item p-2">
                                        <a href="/admin/cronograma/" class="nav-link text-white">
                                            <i class="material-icons align-middle mr-3"> timeline </i> Cronograma
                                        </a>
                                    </li>
                                    <li class="w-100 nav-item p-2">
                                        <a href="/admin/apoiadores/" class="nav-link text-white">
                                            <i class="material-icons align-middle mr-3"> thumb_up_alt </i> Apoiadores
                                        </a>
                                    </li>
                                    <li class="w-100 nav-item p-2">
                                        <a href="/admin/bug/" class="nav-link text-white">
                                            <i class="material-icons align-middle mr-3"> bug_report </i> Reportar um erro
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
