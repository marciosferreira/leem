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
        require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
        if(sessao_ativa()){
            header('Location: ./');
        }
        ?>
    </head>

    <body class="bg-blue">
        <div id="carregando"></div>
        <!-- Cabeçalho -->
        <header class="navbar navbar-expand-lg navbar-dark bg-blue">
            <h1 class="lead font-weight-bold m-0"><a class="navbar-brand" href="/"><i class="material-icons align-middle">arrow_back</i> LEEM</a></h1> <br>
        </header>

        <!-- Conteúdo -->
        <div class="container mt-1 pb-5">
            <div class="row">
                <div class="col-12 col-sm-6 m-auto p-3">
                    <h1 class="w-100 pl-3 lead font-weight-bold text-center m-0 p-0 d-inline-block">
                        <a class="navbar-brand" href="/">
                            <img src="/public/img/logo-leem.png" width="180" alt="LEEM">
                        </a>
                        <span class="d-none">LEEM</span>
                    </h1>
                    <p class="text-dark lead font-weight-bold text-center">Bem-vindo(a) ao novo portal do LEEM!</p>
                    <p class="text-dark lead font-weight-normal text-center">Preencha os dados abaixo para solicitar o seu cadastro.</p>
                    <form method="post" id="form_usuario" class="bg-white p-3">
                        <div class="form-row">
                            <div class="col-12 form-group">
                                <label>Nome completo</label>
                                <input type="text" class="form-control w-100 rounded-0" name="nome" id="nome" placeholder="Nome completo">
                            </div>
                            <div class="col-12 form-group">
                                <label>E-mail</label>
                                <input type="email" class="form-control w-100 rounded-0" name="email" id="email" placeholder="E-mail">
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label>Sexo</label>
                                <select name="sexo" class="form-control rounded-0">
                                    <option>Selecione</option>
                                    <option value="f">Feminino</option>
                                    <option value="m">Masculino</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label>Senha</label>
                                <input type="password" class="form-control w-100 rounded-0" name="senha" id="senha" placeholder="Senha">
                            </div>
                        </div>
                        <button type="reset" class="btn btn-sm bg-danger text-white" id="limparForm">Limpar tudo</button>
                        <a class="btn btn-sm bg-danger text-white" href="/">Cancelar</a>
                        <button type="submit" class="btn btn-sm bg-dark text-white">Concluído</button>
                    </form>
                </div>
            </div>
        </div>

        <?php include_once("include/inc_rodape.php");?>

    </body>

</html>
