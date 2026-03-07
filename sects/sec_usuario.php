<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once("include/templates/inc_materia_min.php");

if (!empty($_REQUEST['slug'])) :

    $equipe_usuario = read_usuario(array('slug' => $_REQUEST['slug']));

    //Verifica se o usuário existe
    if ($equipe_usuario->num_rows > 0) :
        $equipe_usuario = $equipe_usuario->fetch_assoc();
        $usuario_avatar = read_avatar($equipe_usuario['id']);

        if (!sessao_ativa()) {
            update_visitas($equipe_usuario['id']);
        }

        $head = '<meta property="og:image" content="https://leem.net.br/uploads/fotos/' . $usuario_avatar . '">
        <meta property="og:image:type" content="image/jpeg">
        <meta property="og:image:width" content="800">
        <meta property="og:image:height" content="600">
        <meta property="og:type" content="article">
        <meta property="article:section" content="Usuários">
        <meta property="og:locale" content="pt_BR">
        <meta property="og:url" content="https://leem.net.br/usuario/' . $equipe_usuario['slug'] . '/">
        <meta property="og:title" content="' . $equipe_usuario['nome'] . '">
        <meta property="og:site_name" content="leem.net.br">
        <meta property="article:og:description" content="' . substr($equipe_usuario['biografia'], 0, 100) . '...">
        <title>' . $equipe_usuario['nome'] . '</title>';

        include_once('include/inc_header.php');
        ?>

<div class="container bg-white mt-4 pb-3">
    <div class="text-center pb-3">
        <section class="text-left pb-5">

            <!-- Conteúdo -->
            <div class="row align-items-top text-center">
                <div class="col-12 col-md-6 col-xl-5 h-100 mb-3">
                    <div class="p-3 perfil-left-imagem mb-3 text-center">
                        <figure class="avatar p-2 bg-white m-auto" style="background-image: url(/uploads/fotos/<?php echo $usuario_avatar; ?>);background-size: 100%;background-position: center;">
                            <img src="/uploads/fotos/<?php echo $usuario_avatar; ?>" class="img-fluid avatar p-2 d-none">
                        </figure>

                        <?php
                                if (sessao_ativa() && $_REQUEST['slug'] == $usuario_logado['slug']) {
                                    ?>

                        <a href="/perfil/" class="btn btn-sm mt-3 bg-blue small p-3">Alterar perfil</a>

                        <?php
                                }
                                ?>

                        <h1 class="h3 font-weight-normal mt-5">
                            <img src="/img/cracha-usuario.svg" width="45" class="align-middle mr-2">
                            <?php echo $equipe_usuario['nome']; ?>
                        </h1>

                        <?php
                                if ($equipe_usuario['perfil'] == 'admin') :
                                    ?>

                        <img src="/img/admin-usuario.svg" width="30" class="align-middle">

                        <?php
                                endif;
                                if ($equipe_usuario['perfil'] == 'pesquisador') :
                                    ?>

                        <img src="/img/pesquisador-usuario.svg" width="30" class="align-middle">

                        <?php
                                endif;

                                echo '<b>' . $equipe_usuario['perfil'] . '</b>';
                                ?>

                        <div class="mt-3 p-3">
                            <a href="<?php echo $equipe_usuario['lattes']; ?>" class="d-inline-block p-1 text-center border-lg border-dark h4 text-dark rounded-lg mr-3 mb-3" target="_blank">Lattes</a>
                            <a href="<?php echo $equipe_usuario['orcid']; ?>" class="d-inline-block p-1 text-center border-lg border-dark h4 text-dark rounded-lg mb-3" target="_blank">Orcid</a>
                            <a href="<?php echo $equipe_usuario['research']; ?>" class="d-inline-block p-1 text-center border-lg border-dark h4 text-dark rounded-lg mb-3" target="_blank">ResearchGate</a>
                            <br />
                            <a href="<?php echo $equipe_usuario['curriculo']; ?>" class="d-inline-block p-1 text-center border-lg border-dark h4 text-dark rounded-lg" target="_blank">Outros</a>
                        </div>

                        <section>

                            <h1 class="h4">
                                <img src="/img/apresentacao-usuario.svg" width="45" class="align-middle mr-2"> Apresentação
                            </h1>
                            <div class="border-lg border-dark p-3 rounded-lg">
                                <?php
                                        if (!empty($equipe_usuario['biografia'])) :
                                            ?>

                                <p class="text-dark m-0 text-left">
                                    <?php echo str_replace('http://', 'https://', $equipe_usuario['biografia']); ?>
                                </p>

                                <?php
                                        else :
                                            ?>

                                <p class="text-dark m-0 txt-center">
                                    O usuário ainda não adicionou sua biografia.
                                </p>

                                <?php
                                        endif;
                                        ?>
                            </div>

                        </section>

                        <section class="mt-5">

                            <h1 class="h4">
                                <img src="/img/social-usuario.svg" width="45" class="align-middle mr-2"> Redes Sociais
                            </h1>
                            <div class="">
                                <a href="<?php echo $equipe_usuario['instagram']; ?>" class="icon-social p-2 m-2 h5 d-inline-block text-center text-white bg-dark" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>

                                <a href="<?php echo $equipe_usuario['twitter']; ?>" class="icon-social p-2 m-2 h5 d-inline-block text-center text-white bg-info" target="_blank">
                                    <i class="fab fa-twitter-square"></i>
                                </a>

                                <a href="<?php echo $equipe_usuario['facebook']; ?>" class="icon-social p-2 m-2 h5 d-inline-block text-center text-white bg-primary" target="_blank">
                                    <i class="fab fa-facebook-square"></i>
                                </a>
                            </div>

                        </section>

                    </div>

                </div>
                <div class="col-12 col-md-6 col-xl-7 mb-3">
                    <div class="pt-3 text-left">

                        <section>

                            <h1 class="h2">
                                <img src="/img/pesquisas-icon.svg" width="45" class="align-middle mr-2"> Pesquisas
                            </h1>

                            <div class="bg-white border p-1 rounded-lg">
                                <div class="bg-section p-3 rounded" style="height: 300px;overflow-y: auto">
                                    <?php
                                            $pesquisas = read_pesquisa(array('id_usuario' => $equipe_usuario['id']));
                                            if ($pesquisas->num_rows > 0) :
                                                ?>

                                    <div class="row miniatura">

                                        <?php include_once("include/templates/inc_pesquisa.php"); ?>

                                    </div>

                                    <?php
                                            else :
                                                echo '<p class="text-muted mb-3">Nada publicado ainda.</p>';
                                            endif;
                                            ?>
                                </div>
                            </div>

                        </section>

                        <section class="mt-5">

                            <h1 class="h2">
                                <img src="/img/news-icon.svg" width="45" class="align-middle mr-2"> Matérias
                            </h1>

                            <div class="bg-white border p-1 rounded-lg">
                                <div class="bg-section p-3 rounded container-materias" style="height: 300px;overflow-y: auto">

                                    <?php

                                            $materias = read_materia(array('id_usuario' => $equipe_usuario['id']));
                                            if ($materias->num_rows > 0) {
                                                materia($materias);
                                            }
                                            ?>

                                </div>
                            </div>

                        </section>

                        <section class="mt-5">

                            <h1 class="h2">
                                <img src="/img/projetos-icon.svg" width="45" class="align-middle mr-2"> Projetos
                            </h1>

                            <div class="bg-white border p-1 rounded-lg">
                                <div class="bg-section p-3 rounded" style="height: 300px;overflow-y: auto">

                                    <div class="row m-0">

                                        <?php
                                                $projetos = read_projeto_usuario(array('id_usuario' => $equipe_usuario['id']));
                                                if ($projetos->num_rows > 0) :
                                                    foreach ($projetos as $projeto) {
                                                        ?>
                                        <a href="/projetos/<?php echo $projeto['slug']; ?>/" class="bg-white mb-3">
                                            <img src="/uploads/fotos/<?php echo $projeto['foto']; ?>" width="120" height="80" alt="<?php echo $projeto['titulo']; ?>">
                                        </a>

                                        <?php
                                                    } else :
                                                    ?>

                                        <div class="col-12">
                                            <p class="text-muted m-0 txt-center">Este usuário ainda não perticipa de um projeto.</p>
                                        </div>

                                        <?php
                                                endif;
                                                ?>

                                    </div>
                                </div>
                            </div>

                        </section>

                    </div>
                </div>
            </div>

        </section>
    </div>
</div>

<?php
    else :
        include_once('include/inc_header.php');
        ?>

<div class="container bg-white pt-5 pb-5 text-center">
    <p class="text-muted m-0 txt-center h3">Este usuário não foi encontrado.</p>
</div>

<?php
    endif;
endif;
include_once("include/inc_rodape.php");
?>
