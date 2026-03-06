<?php 
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header.php');?>

<!-- Conteúdo -->
<div class="bg-white">
    <div class="container pt-5 pb-5">

        <?php
        //Verifica se a sessão está ativa
        if(sessao_ativa()):
        ?>

        <h2 class="text-center text-dark mb-5 border-bottom pb-3">Publicar uma pesquisa</h2>
        <?php
        $projetos = read_projeto();
        if($projetos->num_rows > 0):
        ?>
        <form method="post" id="form_pesquisa">
            <div class="form-row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="titulo">Projeto relacionado</label>
                        <select name="projeto" id="projeto" class="form-control">

                            <?php
                            foreach($projetos as $projeto){
                                echo '<option value="' . $projeto['id'] . '">' . $projeto['titulo'] .'</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="titulo">DOI</label>
                        <input type="text" class="form-control" name="doi" id="doi" placeholder="Cole o link do DOI">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="titulo">Autor</label>
                <input type="text" class="form-control" name="autor" id="autor" placeholder="Ex.: João da Silva">
            </div>
            <div class="form-group">
                <label for="titulo">Co-autores</label>
                <input type="text" class="form-control" name="coautor" id="coautor" placeholder="Ex.: José, Maria...">
            </div>
            <div class="form-group">
                <label for="titulo">Título da pesquisa</label>
                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título da pesquisa">
            </div>
            <div class="form-group">
                <label for="texto">Descrição</label>
                <div id="texto" maxlength="400">
                    <p>Parágrafos da pesquisa...</p>
                </div>
            </div>
            <button type="submit" class="btn bg-blue">Enviar pesquisa</button>
            <button type="reset" class="btn bg-danger text-white">Limpar tudo</button>
        </form>
        <?php
        else:
        ?>

        <p class="text-center h4 text-muted">Nenhum projeto criado.</p>

        <?php
        endif;

        else:
        ?>

        <p class="text-center h4 text-danger">Área restrita a usuários.</p>

        <?php
        endif;
        ?>

    </div>
</div>

<?php include_once("include/inc_rodape.php");?>
