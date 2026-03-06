<?php
 //Edita o usuário selecionado
if (!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'edita-pesquisa' && !empty($_REQUEST['id'])): $pesquisa = read_pesquisa($_REQUEST['id']);
    $pesquisa = $pesquisa->fetch_assoc();
    ?>

    <h2 class="text-center mb-3">Editar pesquisa</h2>
    <form method="post" id="form_edita_pesquisa">
        <div class="form-row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="titulo">DOI</label>
                    <input type="hidden" name="slug" id="slug" value="<?php echo $pesquisa['slug'];?>">
                    <input type="text" class="form-control" name="doi" id="doi" placeholder="Cole o link do aqui DOI" 
                           value="<?php echo $pesquisa['doi'];?>">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="titulo">Autor</label>
                    <input type="text" class="form-control" name="autor" id="autor" placeholder="Ex.: João da Silva"
                           value="<?php echo $pesquisa['autor'];?>">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="titulo">Co-autores</label>
                    <input type="text" class="form-control" name="coautor" id="coautor" placeholder="Ex.: José, Maria..."
                           value="<?php echo $pesquisa['coautor'];?>">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="titulo">Título da pesquisa</label>
                    <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título da pesquisa"
                           value="<?php echo $pesquisa['titulo'];?>" disabled title="Não é possível alterar o título">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="texto">Descrição</label>
                    <div id="texto" maxlength="400">
                        <?php echo $pesquisa['texto'];?>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn bg-blue">Enviar pesquisa</button>
        <a href="../../" class="btn bg-danger text-white">Cancelar</a>
    </form>

<?php
 //Deleta o projeto selecionado
elseif (!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'apaga-pesquisa' && !empty($_REQUEST['id'])): 
    $pesquisas = read_pesquisa(array('id'=>$_REQUEST['id']));
    $pesquisa = $pesquisas->fetch_assoc();
    ?>

    <div class="bg-white border-top p-3 mb-5">
        <h2 class="h3">Apagar pesquisa?</h2>
        <p>Você está preste a apagar a pesquisa abaixo. <br> <span class="text-danger">A pesquisa será apagada permanentemente.</span></p>
        <div class="bg-white shadow-md">
            <div class="bg-white h-100">
                <div class="bg-white h-100 mt-3">
                    <div class="row m-0 align-items-center text-center">
                        <div class="col-12 p-0">
                            <div class="bg-white p-3">
                                <h3 class="d-inline-block text-uppercase">
                                    <?php echo $pesquisa['titulo']; ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" id="form_apaga_pesquisa">
            <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                <input type="hidden" name="slug" id="slug" value="<?php echo $pesquisa['slug']; ?>">
            </div>
            <a class="btn btn-sm bg-danger text-white" href="/admin/pesquisas/">Cancelar</a>
            <button type="submit" class="btn btn-sm bg-blue text-white">Confirmar</button>
        </form>
    </div>

<?php else:?>

<h2>Pesquisas</h2>
<!--Busca matérias-->
<p>Para encontrar uma pesquisa, digite palavras-chave.</p>
<form method="post" id="form_busca_materia" class="bg-white p-3 mb-3 shadow-md">
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="busca" id="busca" placeholder="Encontre uma pesquisa" aria-label="Encontre uma pesquisa" aria-describedby="busca-addon" value="<?php if (isset($_REQUEST['busca'])) echo $_REQUEST['busca']; ?>">
        <div class="input-group-append">
            <button type="submit" class="btn btn-sm bg-dark text-white" type="button" id="busca-addon"><i class="material-icons align-middle"> search </i></button>
        </div>
    </div>
    <div class="navbar p-0">
        <button type="button" class="w-50 btn btn-sm bg-green text-white p-2" data-toggle="collapse" role="button" aria-expanded="false" data-target="#novaPesquisa">Nova pesquisa</button>
        <a href="" class="w-50 btn btn-sm bg-dark text-white p-2"><i class="material-icons align-middle"> refresh </i>Atualizar</a>
    </div>
</form>

<div class="bg-white collapse" id="novaPesquisa">

    <?php
        //Verifica se a sessão está ativa
    if (sessao_ativa()):
        ?>

    <h2 class="text-center text-dark mb-5 border-bottom pb-3">Publicar uma pesquisa</h2>
    <?php
    $projetos = read_projeto();
    if ($projetos->num_rows > 0):
        ?>
    <form method="post" id="form_pesquisa">
        <div class="form-row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="titulo">Projeto relacionado</label>
                    <select name="projeto" id="projeto" class="form-control">

                        <?php
                        foreach ($projetos as $projeto) {
                            echo '<option value="' . $projeto['id'] . '">' . $projeto['titulo'] . '</option>';
                        }
                        ?>

                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="titulo">Usuário autor</label>
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

<?php
if (isset($_REQUEST['busca'])):
    ?>

<div class="row">

    <?php
    $pesquisas = read_pesquisa($_REQUEST['busca']);
    foreach ($pesquisas as $pesquisa):
        ?>

    <div class="col-12 col-md-6 col-xl-4 col-xl-3 p-3">
        <div class="bg-white h-100 shadow-md">
            <div class="row m-0">

                <?php
                if ($pesquisa['foto'] != null):
                    ?>

                <div class="h-100 col-12 p-0">
                    <a href="/materia/<?php echo $pesquisa['slug']; ?>/" target="_blank">
                        <img src="/uploads/fotos/<?php echo $pesquisa['foto']; ?>" class="img-fluid">
                    </a>
                </div>

                <?php
            endif;
            ?>

                <div class="col-12 navbar p-0 border-top">
                    <div class="w-100 p-3">
                        <h3 class="h5"><a href="/materia/<?php echo $pesquisa['slug']; ?>/" target="_blank">
                                <?php echo $pesquisa['titulo']; ?></a></h3>
                    </div>

                    <div class="w-50 p-3">
                        <a href="edita-materia/<?php echo $pesquisa['slug']; ?>/" class="btn btn-block btn-sm text-dark">Editar</a>
                    </div>

                    <div class="w-50 p-3">
                        <a href="apaga-materia/<?php echo $pesquisa['id']; ?>/" class="btn btn-block btn-sm text-danger">
                            <i class="material-icons align-middle"> delete </i> Apagar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
endforeach;
?>

</div>

<?php
else:
    ?>

<div class="row">

    <?php
    $pesquisas = read_pesquisa();
    foreach ($pesquisas as $pesquisa):
        ?>

    <div class="col-12 col-md-6 col-xl-4 col-xl-3 p-3">
        <div class="bg-white h-100 shadow-md">
            <div class="row m-0">
                <div class="col-12 navbar p-0 border-top">
                    <div class="w-100 p-3">
                        <h3 class="h5"><a class="text-dark" href="/pesquisas/<?php echo $pesquisa['slug']; ?>/" target="_blank">
                                <?php echo $pesquisa['titulo']; ?></a></h3>
                    </div>
                    <div class="w-50 p-3">
                        <a href="apaga-pesquisa/<?php echo $pesquisa['id']; ?>/" class="btn btn-block btn-sm text-danger">
                            <i class="material-icons align-middle"> delete </i> Apagar</a>
                    </div>
                    <div class="w-50 p-3">
                        <a href="edita-pesquisa/<?php echo $pesquisa['slug']; ?>/" class="btn btn-block btn-sm text-dark">
                            <i class="material-icons align-middle"> edit </i> Editar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
endforeach;
?>

</div>

<?php
endif;
endif;
?> 
