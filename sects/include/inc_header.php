<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Laboratório de Ecofisiologia e Evolução Molecular.">
    <meta name="author" content="Danilson Veloso de Sousa">
    <link rel="icon" href="/img/favicon.ico">

    <?php if (!isset($head)) : ?>
    <meta property="og:image" content="/img/logo-leem.png">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">
    <meta property="og:type" content="website">
    <meta property="article:section" content="Home">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:url" content="https://leem.net.br">
    <meta property="og:title" content="Laboratório de Ecofisiologia e Evolução Molecular">
    <meta property="og:site_name" content="leem.net.br">
    <meta property="article:og:description" content="Laboratório de Ecofisiologia e Evolução Molecular – Instituto Nacional de Pesquisas da Amazônia.">
    <meta property="article:published_time" content="">
    <title>LEEM | INPA - Laboratório de Ecofisiologia e Evolução Molecular – Instituto Nacional de Pesquisas da Amazônia.</title>
    <?php else : echo $head;
endif;
?>

    <?php include_once("inc_styles.php"); ?>

</head>

<body class="bg-white">
    <div id="carregando"></div>
    <!-- Cabeçalho -->
    <header class="bg-blue">
        <nav class="navbar bg-blue navbar-expand-md navbar-light w-100 p-0 header-menu">
            <button class="navbar-toggler border-0 p-3 ml-auto" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="material-icons align-middle">menu</i> <span class="small">MENU</span>
            </button>
            <div class="collapse navbar-collapse text-center" id="menu">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item inicio p-2">
                        <a class="nav-link text-black font-weight-bold" href="/">Início</a>
                    </li>
                    <li class="nav-item projetos p-2">
                        <a class="nav-link text-black font-weight-bold" href="/projetos/">Projetos</a>
                    </li>
                    <li class="nav-item midia p-2">
                        <a class="nav-link text-black font-weight-bold" href="/midia/">Midias</a>
                    </li>
                    <li class="nav-item leem p-2">
                        <a class="nav-link text-black font-weight-bold" href="/equipe/">Quem somos</a>
                    </li>
                    <li class="nav-item nossa-historia p-2">
                        <a class="nav-link text-black font-weight-bold" href="/nossa-historia/">Nossa história</a>
                    </li>

                    <?php
                    if (sessao_ativa()) : 
                        $usuario_logado = $_SESSION['usuario'];
                        if ($usuario_logado['perfil'] == 'admin') :
                            ?>

                        <li class="nav-item p-2">
                            <a class="nav-link bg-dark rounded text-white" href="/admin/"><i class="material-icons align-middle"> settings </i> Administração</a>
                        </li>

                    <?php
                        endif;
                    endif;
                    ?>

                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item p-2 bg-primary-dark" id="abre_busca">
                        <a class="nav-link" href="javascript:void(0)">
                            <i class="material-icons align-middle">search</i></a>
                    </li>

                    <?php
                    if (sessao_ativa()) {
                        //Área logada
                        include_once('inc_avatar.php');
                    } else {
                        ?>

                    <li class="nav-item p-2">
                        <a class="nav-link text-dark bg-white rounded" href="/cadastro/"><i class="material-icons align-middle">person_add</i> Cadastro</a>
                    </li>

                    <li class="nav-item p-2">
                        <a class="nav-link" href="/entrada/"><i class="material-icons align-middle">account_circle</i> Entre</a>
                    </li>

                    <?php

                }

                if (sessao_ativa()) {
                    
                ?>

                </ul>
                <!-- Menu do usuário -->
                <div class="menu-back"></div>
                <div class="menu bg-blue pb-3 shadow-md text-left">
                    <div class="navbar mb-2 p-3">
                        <button class="btn bg-danger text-white ml-auto fecha-menu"><i class="material-icons align-middle">close</i></button>
                    </div>
                    <div class="text-uppercase">
                        <a class="dropdown-item p-3 small text-dark" href="/equipe/<?php echo $usuario_logado['slug'];?>">
                            <i class="material-icons align-middle mr-3">account_circle</i> Meu Perfil
                        </a>
                        <a class="dropdown-item p-3 small text-dark" href="/publicar/">
                            <i class="material-icons align-middle mr-3">create_new_folder</i> Adicionar uma pesquisa
                        </a>
                        <a class="dropdown-item p-3 small text-dark" href="/pesquisas/">
                            <i class="material-icons align-middle mr-3">folder</i> Minhas pesquisas
                        </a>
                        <a class="dropdown-item p-3 small text-dark" href="/reportar-bug/">
                            <i class="material-icons align-middle mr-3">bug_report</i> Reportar um erro
                        </a>
                    </div>
                    <div class="p-3">
                        <a class="dropdown-item p-1 small text-center bg-danger text-white" href="/rotas/saida/">
                            <i class="material-icons align-middle">close</i> Encerrar sessão
                        </a>
                    </div>
                </div>

                <?php
                }
                ?>

            </div>
        </nav>
        <div class="container">
            <form method="post" action="/busca/" id="form_busca" class="form-inline p-3">
                <div class="input-group p-2 bg-white busca shadow">
                    <input type="text" class="form-control border-0 border-bottom align-middle" name="busca" id="busca" placeholder="Encontre um matéria..." autofocus>
                    <div class="input-group-prepend" id="fecha_busca" style="cursor:pointer">
                        <span class="input-group-text bg-white text-dark border-0" id="busca-addon">
                            <i class="material-icons">close</i>
                        </span>
                    </div>
                    <button type="submit" class="btn btn-sn bg-blue text-dark text-uppercase font-weight-bold">
                        <i class="material-icons align-middle">search</i></button>
                </div>
            </form>
        </div>
    </header> 
