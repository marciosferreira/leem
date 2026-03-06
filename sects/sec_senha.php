<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Laboratório de Ecofisiologia e Evolução Molecular – Instituto Nacional de Pesquisas da Amazônia.">
        <meta name="author" content="Danilson Veloso de Sousa">
        <title>LEEM | INPA - Laboratório de Ecofisiologia e Evolução Molecular – Instituto Nacional de Pesquisas da Amazônia.</title>
        <?php include_once('include/inc_styles.php');?>

    </head>
    <body class="bg-green">

        <div id="carregando"></div>
        <!-- Cabeçalho -->
        <header class="navbar navbar-expand-lg navbar-dark bg-green">
            <h1 class="lead font-weight-bold m-0"><a class="navbar-brand" href="/"><i class="material-icons align-middle">arrow_back</i> LEEM</a></h1> <br>
        </header>

        <?php
        $senha_atual = explode('/', $_SERVER['REDIRECT_URL']);
        ?>
        <!-- Conteúdo -->
        <div class="container mt-1">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-4 m-auto p-3">
                    <h1 class="w-100 pl-3 lead font-weight-bold text-center m-0 p-0 d-inline-block">
                        <a class="navbar-brand" href="/">
                            <img src="/public/img/logo-leem.png" width="180" alt="LEEM">
                        </a>
                        <span class="d-none">LEEM</span>
                    </h1>
                    <h2 class="text-dark font-weight-bold text-center h3">Alteração de senha</h2>
                    <p class="text-dark lead text-center">Agora você precisa criar uma nova senha:</p>
                    <form method="post" name="form_senha" id="form_senha">
                        <div class="form-group bg-white p-1 shadow-sm rounded">
                            <input type="hidden" name="token" id="token" value="<?php echo $senha_atual[2];?>">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-dark border-0" id="email-addon">
                                        <i class="material-icons">account_circle</i>
                                    </span>
                                </div>
                                <input type="email" class="form-control border-0" name="email" id="email" placeholder="Digite seu e-mail">
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-dark border-0" id="senha-addon">
                                        <i class="material-icons">lock</i>
                                    </span>
                                </div>
                                <input type="password" class="form-control border-0" name="senha" id="senha" placeholder="Nova senha">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-lg btn-dark shadow-lg border-0">Recuperar senha</button>
                    </form>
                </div>
            </div>
        </div>

        <?php 
        include_once("../configs.php");
        include_once("include/inc_rodape.php");
        ?>

    </body>
</html>