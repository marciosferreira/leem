<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
if (sessao_ativa()) {
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
        <title>LEEM | INPA - Laboratório de Ecofisiologia e Evolução Molecular – Instituto Nacional de Pesquisas da Amazônia.</title>
        <?php
        include_once('include/inc_styles.php');
        ?>
    </head>

    <body class="bg-blue">
        <div id="carregando"></div>
        <!-- Cabeçalho -->
        <header class="navbar navbar-expand-lg navbar-dark bg-blue">
            <h1 class="lead font-weight-bold m-0"><a class="navbar-brand" href="/"><i class="material-icons align-middle">arrow_back</i> LEEM</a></h1> <br>
        </header>

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
                    <p class="text-dark lead font-weight-bold text-center">Bem-vindo(a) ao novo portal do LEEM!</p>
                    <form method="post" name="form_login" id="form_entrada">
                        <div class="form-group bg-white p-0 shadow-sm rounded">
                            <div class="form-group m-0">
                                <div class="input-group p-2 border-bottom">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white text-dark border-0" id="login-addon">
                                            <i class="material-icons">account_circle</i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control border-0 rounded-0" name="email" id="email" placeholder="E-mail">
                                </div>
                                <div class="input-group p-2 border-bottom">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white text-dark border-0" id="senha-addon">
                                            <i class="material-icons">lock</i>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control border-0 rounded-0" name="senha" id="senha" placeholder="Senha">
                                </div>
                                <div class="input-group p-2">
                                    <button type="submit" class="btn btn-block btn-lg bg-green text-dark shadow-lg border-0">Acesse agora</button>
                                </div>
                            </div>
                        </div>
                        <a href="/cadastro/" class="btn btn-block btn-lg bg-white text-dark shadow-lg border-0">Crie sua conta</a>
                        <a href="/recuperar/" class="btn btn-block btn-link text-dark p-3 text-center">Esqueceu a senha?</a>
                    </form>
                </div>
            </div>
        </div>

        <?php include_once("include/inc_rodape.php"); ?>

    </body>

</html>
