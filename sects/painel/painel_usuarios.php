<h2>Usuários</h2>
<?php
//Edita o usuário selecionado
if (!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'edita-usuario' && !empty($_REQUEST['id'])) :

    $usuario = read_usuario(array('id_usuario' => $_REQUEST['id']));
    $usuario = $usuario->fetch_assoc();
    $avatar = read_avatar($_REQUEST['id']);
    ?>

    <div class="bg-white border-top p-3 mb-5">
        <h2 class="h3">Editar usuário</h2>
        <div class="bg-white shadow-md">
            <div class="bg-white h-100 mt-3 mb-3">
                <div class="row m-0">
                    <div class="col-12 p-0">
                        <div class="bg-white p-3">
                            <img src="/public/uploads/fotos/<?php echo $avatar; ?>" width="80px" height="80px" class="rounded-circle mr-3">
                            <h3 class="h5 d-inline-block">
                                <?php echo $usuario['nome']; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" id="form_edita_usuario">
            <div class="form-row">
                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $usuario['id']; ?>">
                <div class="col-12 col-md-6 form-group p-1">
                    <label>Nome completo</label>
                    <input type="text" class="form-control w-100 rounded-0" name="nome" id="nome" placeholder="Nome completo" value="<?php echo $usuario['nome']; ?>">
                </div>
                <div class="col-12 col-md-6 form-group p-1">
                    <label>E-mail</label>
                    <input type="email" class="form-control w-100 rounded-0" name="email" id="email" placeholder="E-mail" value="<?php echo $usuario['email']; ?>">
                </div>
                <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control rounded-0">
                        <option <?php if ($usuario['sexo'] == 'f') echo 'selected="f"'; ?> value="f">Feminino</option>';
                        <option <?php if ($usuario['sexo'] == 'm') echo 'selected="m"'; ?> value="m">Masculino</option>';
                    </select>
                </div>
                <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                    <label>Perfil</label>
                    <select name="perfil" class="form-control rounded-0">
                        <option <?php if ($usuario['perfil'] == 'pesquisador') echo 'selected="pesquisador"'; ?> value="pesquisador">Pesquisador</option>
                        <option <?php if ($usuario['perfil'] == 'admin') echo 'selected="admin"'; ?> value="admin">Administrador</option>
                        <option <?php if ($usuario['perfil'] == 'visita') echo 'selected="visita"'; ?> value="visita">Visitante</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                    <label>Usuário ativo?</label>
                    <select name="ativo" class="form-control rounded-0" <?php echo $usuario['ativo']; ?>>
                        <option <?php if ($usuario['ativo'] == '1') echo 'selected="1"'; ?> value="1">Sim</option>
                        <option <?php if ($usuario['ativo'] == '0') echo 'selected="0"'; ?> value="0">Não</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 form-group p-1">
                    <label>Nova senha(Opcional)</label>
                    <input type="password" class="form-control w-100 rounded-0" name="senha" id="senha" placeholder="Nova senha">
                    <input type="hidden" name="token" id="token" value="<?php echo $usuario['senha']; ?>">
                </div>
            </div>
            <button type="reset" class="btn btn-sm bg-danger text-white" id="limparForm">Limpar tudo</button>
            <a href="/admin/usuarios/" class="btn btn-sm bg-danger text-white">Cancelar</a>
            <button type="submit" class="btn btn-sm bg-blue text-white">Salvar</button>
        </form>
    </div>

<?php
//Deleta o usuário selecionado
elseif (!empty($_REQUEST['acao']) && $_REQUEST['acao'] == 'apaga-usuario' && !empty($_REQUEST['id'])) :

    $usuario = read_usuario(array('id_usuario' => $_REQUEST['id']));
    $usuario = $usuario->fetch_assoc();
    $avatar = read_avatar($_REQUEST['id']);
    ?>

    <div class="bg-white border-top p-3 mb-5">
        <h2 class="h3">Apagar usuário?</h2>
        <p>Você está preste a apagar o usuário abaixo. <br> <span class="text-danger">O usuário será apagado permanentemente.</span></p>
        <div class="bg-white shadow-md">
            <div class="bg-white h-100">
                <div class="row m-0">
                    <div class="col-12 p-0">
                        <div class="bg-white p-3">
                            <img src="/public/uploads/fotos/<?php echo $avatar; ?>" width="80px" height="80px" class="rounded-circle mr-3">
                            <h3 class="h5 d-inline-block">
                                <?php echo $usuario['nome']; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" id="form_apaga_usuario" class="text-center">
            <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_REQUEST['id']; ?>">
            </div>
            <a class="btn btn-sm bg-danger text-white" href="/admin/usuarios/">Cancelar</a>
            <button type="submit" class="btn btn-sm bg-blue text-white">Confirmar</button>
        </form>
    </div>

<?php
else :
    ?>

    <!--Busca usuários-->
    <p>Para encontrar um usuário, digite o id, e-mail ou nome no campo abaixo.</p>
    <form method="post" id="form_busca_usuario" class="bg-white p-3 border mb-1">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="busca" id="busca" placeholder="Encontre um usuário" aria-label="Encontre um usuário" aria-describedby="busca-addon" value="<?php if (isset($_REQUEST['busca'])) echo $_REQUEST['busca']; ?>">
            <div class="input-group-append">
                <button type="submit" class="btn btn-sm bg-dark text-white" type="button" id="busca-addon"><i class="material-icons align-middle"> search </i></button>
            </div>
        </div>
        <div class="navbar p-0">
            <button type="button" class="w-50 btn btn-sm bg-green text-white" data-toggle="collapse" role="button" aria-expanded="false" data-target="#novoUsuario"><i class="material-icons align-middle"> person_add </i> Novo usuário</button>
            <a href="" class="w-50 btn btn-sm bg-dark text-white"><i class="material-icons align-middle"> refresh </i>Atualizar</a>
        </div>
    </form>

    <!--Cria um novo usuário-->
    <div class="bg-white shadow-md border-top p-3 collapse" id="novoUsuario">
        <h3 class="h5">Novo usuário</h3>
        <form method="post" id="form_usuario">
            <div class="form-row">
                <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                    <label>Nome completo</label>
                    <input type="text" class="form-control w-100 rounded-0" name="nome" id="nome" placeholder="Nome completo">
                </div>
                <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control rounded-0">
                        <option>Selecione</option>
                        <option value="f">Feminino</option>
                        <option value="m">Masculino</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                    <label>E-mail</label>
                    <input type="email" class="form-control w-100 rounded-0" name="email" id="email" placeholder="E-mail">
                </div>
                <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                    <label>Senha</label>
                    <input type="password" class="form-control w-100 rounded-0" name="senha" id="senha" placeholder="Senha">
                </div>
                <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                    <label>Perfil</label>
                    <select name="perfil" class="form-control rounded-0">
                        <option value="pesquisador">Pesquisador</option>
                        <option value="admin">Administrador</option>
                        <option value="visitante">Visitante</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-xl-4 form-group p-1">
                    <label>Ativo?</label>
                    <select name="ativo" class="form-control rounded-0">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                </div>
            </div>
            <button type="reset" class="btn btn-sm bg-danger text-white" id="limparForm">Limpar tudo</button>
            <button type="button" class="btn btn-sm bg-danger text-white" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="novoUsuario" data-target="#novoUsuario">Cancelar</button>
            <button type="submit" class="btn btn-sm bg-blue text-white">Salvar</button>
        </form>
    </div>

    <?php
    if (isset($_REQUEST['busca'])) :
        ?>
        <div class="row">

            <?php
            //Lista os usuários da busca
            $busca = $_REQUEST['busca'];
            $usuarios = read_usuario(array('busca' => $busca));

            if ($usuarios->num_rows > 0) :

                foreach ($usuarios as $usuario) :
                    $avatar = read_avatar($usuario['id']);
                    ?>

                    <div class="col-12">
                        <div class="bg-white h-100 border-bottom">
                            <div class="row m-0 align-items-center">
                                <div class="col-12 p-0">
                                    <div class="bg-white p-1">
                                        <div class="row w-100">
                                            <div class="col-2 text-center">
                                                <img src="/public/uploads/fotos/<?php echo $avatar; ?>" width="40" height="40" class="rounded-circle mr-3">
                                            </div>
                                            <div class="col-8">
                                                <h3 class="lead"><a href="/equipe/<?php echo $usuario['slug']; ?>/" target="_blank" class="text-dark">
                                                        <?php echo $usuario['nome']; ?></a>
                                                </h3>
                                                <div class="small text-capitalize <?php $cor = ($usuario['perfil'] == 'visitante') ? 'text-warning' : 'text-dark';
                                                                                    echo $cor; ?>">
                                                    <i class="material-icons align-middle lead"> stars </i>
                                                    <?php echo $usuario['perfil']; ?>
                                                </div>
                                            </div>
                                            <div class="col-2 navbar p-0">
                                                <a href="/admin/usuarios/edita-usuario/<?php echo $usuario['id']; ?>/" class="btn btn-sm text-dark"><i class="material-icons align-middle" title="Alterar"> edit </i></a>
                                                <a href="/admin/usuarios/apaga-usuario/<?php echo $usuario['id']; ?>/" class="btn btn-sm text-danger"><i class="material-icons align-middle" title="Apagar"> delete </i></a>
                                            </div>
                                        </div>
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
                    <p class="h4 pt-3 text-muted text-center">Nenhum resultado.</p>
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
            $count = 9;
            if (isset($_REQUEST['count'])) {
                $count = $_REQUEST['count'];
                $count += 9;
            }
            //Lista todos os usuários
            $usuarios = read_usuario(array('limit' => $count));

            foreach ($usuarios as $usuario) :
                $avatar = read_avatar($usuario['id']);

                ?>

                <div class="col-12">
                    <div class="bg-white h-100 border-bottom">
                        <div class="row m-0 align-items-center">
                            <div class="col-12 p-0">
                                <div class="bg-white p-1">
                                    <div class="row w-100">
                                        <div class="col-2 text-center">
                                            <img src="/public/uploads/fotos/<?php echo $avatar; ?>" width="40" height="40" class="rounded-circle mr-3">
                                        </div>
                                        <div class="col-8">
                                            <h3 class="lead"><a href="/equipe/<?php echo $usuario['slug']; ?>/" target="_blank" class="text-dark">
                                                    <?php echo $usuario['nome']; ?></a>
                                            </h3>
                                            <div class="small text-capitalize <?php $cor = ($usuario['perfil'] == 'visitante') ? 'text-warning' : 'text-dark';
                                                                                echo $cor; ?>">
                                                <i class="material-icons align-middle lead"> stars </i>
                                                <?php echo $usuario['perfil']; ?>
                                            </div>
                                        </div>
                                        <div class="col-2 navbar p-0">
                                            <a href="/admin/usuarios/edita-usuario/<?php echo $usuario['id']; ?>/" class="btn btn-sm text-dark"><i class="material-icons align-middle" title="Alterar"> edit </i></a>
                                            <a href="/admin/usuarios/apaga-usuario/<?php echo $usuario['id']; ?>/" class="btn btn-sm text-danger"><i class="material-icons align-middle" title="Apagar"> delete </i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
        endforeach;
    endif;

    if ($usuarios->num_rows > $count - 1) :
        ?>

            <div class="col-12 text-center p-3 bg-white">
                <form method="post">
                    <input type="hidden" name="count" value="<?php echo $count; ?>">
                    <button type="submit" class="btn-lg btn-block bg-white h5 border-0 text-dark" style="cursor: pointer"> <i class="material-icons"> arrow_forward_ios </i> <br> Mais... </button>
                </form>
            </div>

        <?php
    endif;
    ?>

    </div>

<?php
endif;
?>