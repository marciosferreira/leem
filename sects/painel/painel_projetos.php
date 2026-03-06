<button type="button" class="btn btn-sm bg-green text-white mb-3" data-toggle="collapse" role="button" aria-expanded="false" data-target="#form_add_usuario"><i class="material-icons align-middle"> person_add </i> Adicionar usuário ao projeto</button>
<form method="post" id="form_add_usuario" class="bg-white p-3 shadow-md collapse mb-3">
    <div class="form-group mb-3">
        <label for="titulo">Projeto</label>
        <select name="id_projeto" id="id_projeto" class="form-control">
            <option>Nenhum</option>
            <?php
            $projetos = read_projeto();
            foreach ($projetos as $projeto) {
                echo '<option value="' . $projeto['id'] . '">' . $projeto['titulo'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group mb-3">
        <label for="titulo">Usuário</label>
        <select name="id_usuario" id="id_usuario" class="form-control">
            <option>Selecionar</option>
            <?php
            $usuarios = read_usuario();
            foreach ($usuarios as $usuario) {
                echo '<option value="' . $usuario['id'] . '">' . $usuario['nome'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="input-group-append">
        <button type="submit" class="btn btn-sm bg-dark text-white" type="button" id="busca-addon">Adicionar</button>
    </div>
</form>

<h2>Projetos</h2>
<?php
//Edita o projeto selecionado
if (!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'edita-projeto' && !empty($_REQUEST['id'])) :

    $projeto = read_projeto(array('id' => $_REQUEST['id']));
    $projeto = $projeto->fetch_assoc();
    ?>

<div class="bg-white border-top p-3 mb-5">
    <h2 class="h3">Editar projeto</h2>
    <div class="bg-white shadow-md">
        <div class="bg-white h-100 mt-3 mb-3">
            <div class="row m-0 align-items-center text-center">
                <div class="col-12 col-md-6 p-0">
                    <div class="bg-white p-3">
                        <img src="/public/uploads/fotos/<?php echo $projeto['foto']; ?>" class="img-fluid">
                    </div>
                </div>
                <div class="col-12 col-md-6 p-0">
                    <div class="bg-white p-3">
                        <h3 class="d-inline-block text-uppercase">
                            <?php echo $projeto['titulo']; ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" id="form_edita_projeto">
        <input type="hidden" name="id_projeto" id="id_projeto" value="<?php echo $projeto['id']; ?>">
        <div class="form-group">
            <label>Nome do projeto</label>
            <input type="text" class="form-control w-100 rounded-0" name="titulo" id="titulo" placeholder="Nome do projeto" value="<?php echo $projeto['titulo']; ?>">
        </div>
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input rounded-0" name="foto" id="foto" aria-describedby="inputFoto">
                <label class="custom-file-label" for="inputFoto">Selecione uma foto(Opicional)</label>
            </div>
        </div>
        <div class="form-group border-bottom">
            <label for="paises">Países que participaram</label>
            <input type="hidden" name="paises" id="paises" value="<?php echo $projeto['paises']; ?>">
        </div>
        
        <!-- Países selecionados -->
        <div class="row paises-selecionados p-3 border rounded p-3">
            <span class="text-muted small vazio">Selecione os países</span>
            <?php echo get_paises($projeto['paises']);?>
        </div>

        <!-- Todos os Países -->
        <div class="row paises p-3">

            <?php 
            echo get_paises($projeto['paises'], true);
            ?>

        </div>

        <div class="alert alert-info">
            <small>Clique em um país para adicionar ou remover</small>
        </div>

        <div class="form-group border-bottom">
            <label>Programas que colaboraram</label>
            <textarea class="form-control" rows="5" name="programas" id="programas" placeholder="Ex.: Programa 1, Programa 2..."><?php echo $projeto['programas']; ?></textarea>
            <small class="text-info">Separados por vírgula</small>
        </div>
        <div class="form-group">
            <label>Descrição o projeto</label>
            <textarea class="form-control" rows="8" name="descricao" id="descricao" placeholder="Descreva o projeto"><?php echo $projeto['descricao']; ?></textarea>
        </div>
        <button type="reset" class="btn btn-sm bg-danger text-white" id="limparForm">Limpar tudo</button>
        <a href="/admin/projetos/" class="btn btn-sm bg-danger text-white">Cancelar</a>
        <button type="submit" class="btn btn-sm bg-blue text-white">Salvar alterações</button>
    </form>
</div>

<?php
//Deleta o projeto selecionado
elseif (!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'apaga-projeto' && !empty($_REQUEST['id'])) :

    $projeto = read_projeto(array('id' => $_REQUEST['id']));
    $projeto = $projeto->fetch_assoc();
    ?>

<div class="bg-white border-top p-3 mb-5">
    <h2 class="h3">Apagar projeto?</h2>
    <p>Você está preste a apagar o projeto abaixo. <br> <span class="text-danger">O projeto será apagado permanentemente.</span></p>
    <div class="bg-white shadow-md">
        <div class="bg-white h-100">
            <div class="bg-white h-100 mt-3">
                <div class="row m-0 align-items-center text-center">
                    <div class="col-12 col-md-6 p-0">
                        <div class="bg-white p-3">
                            <img src="/public/uploads/<?php echo $projeto['foto']; ?>" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 p-0">
                        <div class="bg-white p-3">
                            <h3 class="d-inline-block text-uppercase">
                                <?php echo $projeto['titulo']; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" id="form_apaga_projeto">
        <div class="col-12 col-md-6 col-xl-4 form-group p-1">
            <input type="hidden" name="id_projeto" id="id_projeto" value="<?php echo $projeto['id']; ?>">
        </div>
        <a class="btn btn-sm bg-danger text-white" href="/admin/projetos/">Cancelar</a>
        <button type="submit" class="btn btn-sm bg-blue text-white">Confirmar</button>
    </form>
</div>

<?php
else :
    ?>

<!--Busca projetos-->
<p>Para encontrar um projeto, digite o id ou nome.</p>
<form method="post" id="form_busca_projeto" class="bg-white p-3 shadow-md">
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="busca" id="busca" placeholder="Encontre um projeto" aria-label="Encontre um usuário" aria-describedby="busca-addon" value="<?php if (isset($_REQUEST['busca'])) {
                                                                                                                                                                                            echo $_REQUEST['busca'];
                                                                                                                                                                                        } ?>">
        <div class="input-group-append">
            <button type="submit" class="btn btn-sm bg-dark text-white" type="button" id="busca-addon"><i class="material-icons align-middle"> search </i></button>
        </div>
    </div>
    <div class="navbar p-0">
        <button type="button" class="w-50 btn btn-sm bg-green text-white" data-toggle="collapse" role="button" aria-expanded="false" data-target="#novo"><i class="material-icons align-middle"> person_add </i> Novo projeto</button>
        <a href="" class="w-50 btn btn-sm bg-dark text-white"><i class="material-icons align-middle"> refresh </i>Atualizar</a>
    </div>
</form>
<!--Cria um novo projeto-->
<div class="bg-white shadow-md border-top p-3 collapse" id="novo">
    <h3 class="h5">Novo projeto</h3>
    <form method="post" id="form_projeto">
        <div class="form-group p-1">
            <label>Nome do projeto</label>
            <input type="text" class="form-control w-100 rounded-0" name="titulo" id="titulo" placeholder="Nome do projeto">
        </div>
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input rounded-0" name="foto" id="foto" aria-describedby="inputFoto">
                <label class="custom-file-label" for="inputFoto">Selecione uma foto</label>
            </div>
        </div>
        <div class="form-group">
            <label for="paises">Países que participaram</label>
            <input type="hidden" name="paises" id="paises">
        </div>

        <!-- Países selecionados -->
        <div class="paises-selecionados p-3 border rounded p-3">
            <span class="text-muted small vazio">Selecione os países</span>
        </div>

        <!-- Todos os Países -->
        <div class="row paises p-3">

            <?php echo get_paises();?>
            
        </div>

        <div class="alert alert-info">
            <small>Clique em um país para adicionar ou remover</small>
        </div>

        <div class="form-group">
            <label>Programas que colaboraram</label>
            <textarea class="form-control" rows="5" name="programas" id="programas" placeholder="Programas que colaboraram"></textarea>
        </div>
        <div class="form-group">
            <label>Descreva o projeto</label>
            <textarea class="form-control" rows="5" name="descricao" id="descricao" placeholder="Descreva o projeto"></textarea>
        </div>
        <button type="reset" class="btn btn-sm bg-danger text-white" id="limparForm">Limpar tudo</button>
        <button type="button" class="btn btn-sm bg-danger text-white" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="novoUsuario" data-target="#novo">Cancelar</button>
        <button type="submit" class="btn btn-sm bg-blue text-white">Salvar</button>
    </form>
</div>

<?php
    if (isset($_REQUEST['busca'])) :
        ?>
<div class="row">

    <?php
            //Lista os projetos da busca
            $busca = $_REQUEST['busca'];
            $projetos = read_projeto($busca);

            if ($projetos->num_rows > 0) :

                foreach ($projetos as $projeto) :
                    ?>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3 p-3">
        <div class="bg-white h-100 shadow-md">
            <div class="row m-0 align-items-center">
                <div class="col-12 text-center p-0">
                    <div class="bg-white">
                        <img src="/public/uploads/fotos/<?php echo $projeto['foto']; ?>" class="img-fluid mr-3">
                        <h3 class="lead mt-2">
                            <a href="/projetos/<?php echo $projeto['slug']; ?>/" target="_blank" class="text-dark">
                                <?php echo $projeto['titulo']; ?>
                            </a>
                        </h3>
                    </div>
                </div>
                <div class="col-12 navbar p-0 border-top">
                    <div class="w-50 p-3">
                        <a href="/admin/projetos/edita-projeto/<?php echo $projeto['id']; ?>/" class="btn btn-block btn-sm text-dark"><i class="material-icons align-middle"> edit </i> Alterar</a>
                    </div>
                    <div class="w-50 p-3">
                        <a href="/admin/projetos/apaga-projeto/<?php echo $projeto['id']; ?>/" class="btn btn-block btn-sm text-danger"><i class="material-icons align-middle"> delete </i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
                endforeach;
            else :
                ?>

    <div class="col-12 p-3 text-center">
        <p class="text-muted">Nenhum resultado.</p>
    </div>

    <?php
            endif;
            ?>

</div>
<?php
    else :
        ?>

<div class="row">

    <?php
            //Lista todos os projetos
            $projetos = read_projeto();

            foreach ($projetos as $projeto) :
                ?>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3 p-3">
        <div class="bg-white h-100 shadow-md">
            <div class="row m-0 align-items-center">
                <div class="col-12 text-center p-0">
                    <div class="bg-white">
                        <img src="/public/uploads/fotos/<?php echo $projeto['foto']; ?>" class="img-fluid mr-3">
                        <h3 class="lead mt-2">
                            <a href="/projetos/<?php echo $projeto['slug']; ?>/" target="_blank" class="text-dark">
                                <?php echo $projeto['titulo']; ?>
                            </a>
                        </h3>
                    </div>
                </div>
                <div class="col-12 navbar p-0 border-top">
                    <div class="w-50 p-3">
                        <a href="/admin/projetos/edita-projeto/<?php echo $projeto['id']; ?>/" class="btn btn-block btn-sm text-dark"><i class="material-icons align-middle"> edit </i> Alterar</a>
                    </div>
                    <div class="w-50 p-3">
                        <a href="/admin/projetos/apaga-projeto/<?php echo $projeto['id']; ?>/" class="btn btn-block btn-sm text-danger"><i class="material-icons align-middle"> delete </i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
            endforeach;
        endif;
        ?>

</div>

<?php
endif;
?>
