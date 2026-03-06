<?php
//Edita o usuário selecionado
if (!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'edita-materia' && !empty($_REQUEST['id'])) : $materia = read_materia($_REQUEST['id']);
    $materia = $materia->fetch_assoc();
    ?>

    <div class="container">
        <div class="bg-white border-top p-3 mb-5">
            <h2 class="h3">Editar matéria</h2>
            <div class="bg-white shadow-md">
                <div class="bg-white h-100 mt-3 mb-3">
                    <div class="row m-0">
                        <div class="col-12 col-sm-6 m-auto p-0">
                            <div class="bg-white p-3">
                                <img src="/uploads/fotos/<?php echo $materia['foto']; ?>" class="img-fluid mb-3">
                                <h3 class="h5 d-inline-block">
                                    <?php echo $materia['titulo']; ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" id="form_edita_materia">
                <div class="form-row">
                    <input type="hidden" name="id_materia" id="id_materia" value="<?php echo $materia['id']; ?>">
                    <input type="hidden" name="foto_atual" id="foto_atual" value="<?php echo $materia['foto']; ?>">
                    <div class="col-12 col-lg-6 form-group p-1">
                        <label>Título</label>
                        <input type="text" class="form-control w-100 rounded-0" name="titulo" id="titulo" placeholder="Nome completo" value="<?php echo $materia['titulo']; ?>">
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="titulo">Data da matéria</label>
                            <?php
                            $data = new DateTime($materia['data']);
                            $data = $data->format('d-m-Y H:i');
                            ?>
                            <input type="text" class="form-control" data-mask-data name="data" id="data" 
                                   placeholder="" value="<?php echo $data;?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 form-group p-1">
                        <label>Categoria</label>
                        <input type="hidden" name="tipo" id="hidden-tipo" value="<?php echo $materia['tipo']; ?>">
                        <select class="form-control w-100 rounded-0" id="tipo">
                            <option>--</option>
                            <option value="evento">Eventos</option>
                            <option value="materia">Matérias</option>
                            <option value="seminario">Seminários do LEEM</option>
                            <option value="noticia">Notícias</option>
                            <option value="visita">Visitas</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 form-group p-1">
                        <label>É destaque?</label>
                        <input type="hidden" name="destaque" id="hidden-destaque" value="<?php echo $materia['destaque']; ?>">
                        <select class="form-control w-100 rounded-0" id="destaque">
                            <option>--</option>
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                    <div class="col-12 form-group p-1">
                        <label>Descrição</label>
                        <textarea type="text" class="form-control w-100 rounded-0" name="descricao" id="descricao" placeholder="Descrição breve da matéria" rows="4"><?php echo $materia['descricao']; ?></textarea>
                    </div>
                    <div class="col-12 form-group">
                        <label for="texto">Demais parágrafos da matéria</label>
                        <div id="texto" maxlength="400">
                            <?php echo $materia['texto']; ?>
                        </div>
                    </div>
                    <div class="col-12 input-group mb-3">
                        <div class="custom-file">
                            <input type="file" accept="image/jpeg" class="custom-file-input rounded-0" name="foto" id="foto" aria-describedby="inputAnexo">
                            <label class="custom-file-label" for="foto">Selecione uma imagem</label>
                        </div>
                    </div>
                </div>
                <a href="/admin/materias/" class="btn btn-sm bg-danger text-white">Cancelar</a>
                <button type="submit" class="btn btn-sm bg-blue text-white">Salvar</button>
            </form>
        </div>
    </div>
<?php
//Deleta o projeto selecionado
elseif (!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'apaga-materia' && !empty($_REQUEST['id'])) :
    $materias = read_materia(array('id' => $_REQUEST['id']));
    $materia = $materias->fetch_assoc();
    $foto = '<div class="h-100 col-12 p-0">';
    $foto .= '    <a href="/materia/' . $materia['slug'] . '" target="_blank">';
    $foto .= '        <img src="/uploads/fotos/' . $materia['foto'] . '" class="img-fluid">';
    $foto .= '    </a>';
    $foto .= '</div>';
    ?>

    <div class="bg-white border-top p-3 mb-5">
        <h2 class="h3">Apagar matéria?</h2>
        <p>Você está preste a apagar a matéria abaixo. <br> <span class="text-danger">A matéria será apagada permanentemente.</span></p>
        <div class="bg-white shadow-md">
            <div class="bg-white h-100">
                <div class="bg-white h-100 mt-3">
                    <div class="row m-0 align-items-center text-center">
                        <div class="col-12 col-md-6 p-0">
                            <div class="bg-white p-3">
                                <?php echo ($materia['foto'] == "") ? '<div class="p-3">Sem foto</div>' : $foto; ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 p-0">
                            <div class="bg-white p-3">
                                <h3 class="d-inline-block text-uppercase">
                                    <?php echo $materia['titulo']; ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" id="form_apaga_materia">
            <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                <input type="hidden" name="id_materia" id="id_materia" value="<?php echo $_REQUEST['id']; ?>">
            </div>
            <a class="btn btn-sm bg-danger text-white" href="/admin/materias/">Cancelar</a>
            <button type="submit" class="btn btn-sm bg-blue text-white">Confirmar</button>
        </form>
    </div>

<?php
else :
    ?>

    <h2>Matérias</h2>
    <!--Busca matérias-->

    <div class="container">
        <p>Para encontrar uma matéria, digite palavras-chave.</p>
        <form method="post" id="form_busca_materia" class="bg-white p-3">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="busca" id="busca" placeholder="Encontre uma matéria" aria-label="Encontre uma matéria" aria-describedby="busca-addon" value="<?php if (isset($_REQUEST['busca'])) echo $_REQUEST['busca']; ?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-sm bg-dark text-white" type="button" id="busca-addon"><i class="material-icons align-middle"> search </i></button>
                </div>
            </div>
            <div class="navbar p-0">
                <button type="button" class="w-50 btn btn-sm bg-green text-white p-2" data-toggle="collapse" role="button" aria-expanded="false" data-target="#novaMateria">Nova matéria</button>
                <a href="" class="w-50 btn btn-sm bg-dark text-white p-2"><i class="material-icons align-middle"> refresh </i>Atualizar</a>
            </div>
        </form>


        <div class="collapse bg-white border-top border-bottom p-3" id="novaMateria">
            <h3 class="h5">Publicar uma matéria</h3>
            <form method="post" id="form_materia">
                <div class="form-row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="titulo">Título da matéria</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título da pesquisa">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="titulo">Data da matéria</label>
                            <input type="datetime-local" class="form-control" name="data" id="data" placeholder="Data da pesquisa">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="titulo">Projeto relacionado</label>
                            <select name="projeto" id="projeto" class="form-control">
                                <option>Nenhum</option>
                                <?php
                                $projetos = read_projeto();
                                foreach ($projetos as $projeto) {
                                    echo '<option value="' . $projeto['id'] . '">' . $projeto['titulo'] . '</option>';
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 form-group p-1">
                        <label>É destaque?</label>
                        <select class="form-control w-100 rounded-0" id="destaque" name="destaque">
                            <option>--</option>
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 form-group p-1">
                        <label>Categoria</label>
                        <select class="form-control w-100 rounded-0" id="tipo" name="tipo">
                            <option>--</option>
                            <option value="evento">Eventos</option>
                            <option value="materia">Matérias</option>
                            <option value="seminario">Seminários do LEEM</option>
                            <option value="noticia">Notícias</option>
                            <option value="visita">Visitas</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="titulo">Autor do texto</label>
                            <select name="autor" id="autor" class="form-control">
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
                    <div class="col-12 form-group p-1">
                        <label>Descrição</label>
                        <textarea type="text" class="form-control w-100 rounded-0" name="descricao" id="descricao" placeholder="Descrição breve da matéria" rows="4"></textarea>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" accept="image/jpeg" class="custom-file-input rounded-0" name="foto" id="foto" aria-describedby="inputAnexo">
                        <label class="custom-file-label" for="foto">Selecione uma imagem</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="texto">Texto longo</label>
                    <div id="texto" maxlength="400">
                        <p>Parágrafos da matéria...</p>
                    </div>
                </div>
                <button type="submit" class="btn bg-blue">Enviar matéria</button>
                <button type="reset" class="btn bg-danger text-white">Limpar tudo</button>
            </form>

        </div>
    </div>

    <?php
    if (isset($_REQUEST['busca'])) :
        ?>

        <div class="container mt-5">
            <div class="row m-0">

                <?php
                $pag = 1;
                if (isset($_REQUEST['pag'])) {
                    $pag = $_REQUEST['pag'];
                    $pag++;
                }
                $materias = read_materia($_REQUEST['busca'], $pag * 10);
                foreach ($materias as $materia) :
                    ?>

<div class="col-12 col-sm-6 col-lg-4 mb-3 align-items-start flex-column border-bottom">
                        <article class="bg-white">
                            <div class="row m-0 align-items-center">
                                <div class="col-12 p-0">
                                    <div class="navbar bg-dark rounded mb-3 p-0">
                                        <div class="w-50 p-1">
                                            <a href="edita-materia/<?php echo $materia['slug']; ?>/" class="btn btn-block btn-sm text-white">Editar</a>
                                        </div>

                                        <div class="w-50 p-1">
                                            <a href="apaga-materia/<?php echo $materia['id']; ?>/" class="btn btn-block btn-sm text-danger">
                                                <i class="material-icons align-middle"> delete </i> Apagar</a>
                                        </div>
                                    </div>
                                    <?php
                                    $foto = (isset($materia['foto'])) ? '/uploads/fotos/' . $materia['foto'] : '/img/LOGO.svg'; ?>

                                    <a href="/materia/<?php echo $materia['slug']; ?>/">
                                        <figure class="materia-imagem rounded border-dark bg-dark" style="height: 200px;background: url(<?php echo $foto; ?>) center center;background-size: cover">
                                        </figure>
                                    </a>

                                </div>
                                <div class="col-12 p-0">
                                    <main class="p-3 pt-3 pb-3">
                                        <div class="w-100 p-3">
                                            <h3 class="h5"><a href="/materia/<?php echo $materia['slug']; ?>/" class="text-dark" target="_blank">
                                                    <?php echo $materia['titulo']; ?></a></h3>
                                        </div>
                                    </main>
                                </div>
                            </div>
                        </article>
                    </div>

                <?php
            endforeach;
            ?>

            </div>
        </div>

    <?php
else :
    ?>

        <div class="container mt-5">
            <div class="row m-0">

                <?php
                $count = 9;
                if (isset($_REQUEST['count'])) {
                    $count = $_REQUEST['count'];
                    $count += 9;
                }
                $materias = read_materia("", $count);
                foreach ($materias as $materia) :
                    ?>

                    <div class="col-12 col-sm-6 col-lg-4 mb-3 align-items-start flex-column border-bottom">
                        <article class="bg-white">
                            <div class="row m-0 align-items-center">
                                <div class="col-12 p-0">
                                    <div class="navbar bg-dark rounded mb-3 p-0">
                                        <div class="w-50 p-1">
                                            <a href="edita-materia/<?php echo $materia['slug']; ?>/" class="btn btn-block btn-sm text-white">Editar</a>
                                        </div>

                                        <div class="w-50 p-1">
                                            <a href="apaga-materia/<?php echo $materia['id']; ?>/" class="btn btn-block btn-sm text-danger">
                                                <i class="material-icons align-middle"> delete </i> Apagar</a>
                                        </div>
                                    </div>
                                    <?php
                                    $foto = (isset($materia['foto'])) ? '/uploads/fotos/' . $materia['foto'] : '/img/LOGO.svg'; ?>

                                    <a href="/materia/<?php echo $materia['slug']; ?>/">
                                        <figure class="materia-imagem rounded border-dark bg-dark" style="height: 200px;background: url(<?php echo $foto; ?>) center center;background-size: cover">
                                        </figure>
                                    </a>

                                </div>
                                <div class="col-12 p-0">
                                    <main class="p-3 pt-3 pb-3">
                                        <div class="w-100 p-3">
                                            <h3 class="h5"><a href="/materia/<?php echo $materia['slug']; ?>/" class="text-dark" target="_blank">
                                                    <?php echo $materia['titulo']; ?></a></h3>
                                        </div>
                                    </main>
                                </div>
                            </div>
                        </article>
                    </div>

                <?php
            endforeach;
            ?>

            </div>
        </div>

        <?php
        $pag = 1;

    endif;
    if ($materias->num_rows > $count - 1) :
        ?>

        <div class="col-12 text-center p-3 bg-white">
            <form method="post">
                <input type="hidden" name="count" value="<?php echo $count; ?>">
                <button type="submit" class="btn-block btn-sm bg-blue rounded border-0 text-dark">Mais matérias...</button>
            </form>
        </div>

    <?php
endif;

endif;
