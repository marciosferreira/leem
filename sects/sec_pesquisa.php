<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';

$head = '<meta property="og:image" content="/img/logo-leem.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">
    <meta property="og:type" content="article">
    <meta property="article:section" content="Pesquisas">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:url" content="https://leem.net.br/pesquisas/">
    <meta property="og:title" content="Pesquisas do leem">
    <meta property="og:site_name" content="leem.net.br">
    <meta property="article:og:description" content="Pesquisas do instituto INPA no LEEM">
    <title>Pesquisas</title>';
include_once('include/inc_header.php');

//Verifica se a sessão está ativa
if (isset($_REQUEST['slug']) && !isset($_REQUEST['acao'])) :

    //Visão do projeto selecionado
    $slug = $_REQUEST['slug'];
    $pesquisas = read_pesquisa(array('slug' => $slug));

    if ($pesquisas->num_rows > 0) :
        $pesquisa = $pesquisas->fetch_assoc();

        $head = '<meta property="og:image" content="/img/logo-leem.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">
    <meta property="og:type" content="article">
    <meta property="article:section" content="Pesquisas">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:url" content="https://leem.net.br/usuario/u/' . $pesquisa['slug'] . '/">
    <meta property="og:title" content="' . $pesquisa['titulo'] . '">
    <meta property="og:site_name" content="leem.net.br">
    <meta property="article:og:description" content="' . substr($pesquisa['texto'], 0, 100) . '...">
    <title>' . $pesquisa['titulo'] . '</title>';
        include_once('include/inc_header.php');
        ?>

        <div class="container">
            <div class="row mt-5 mb-5">

                <?php
                        $usuario = read_usuario(array('id_usuario' => $pesquisa['id_usuario']));
                        $usuario = $usuario->fetch_assoc();
                        $avatar = read_avatar($usuario['id']);
                        ?>

                <div class="col-12 p-0 h-100 m-0">
                    <article class="h-100 bg-white">
                        <div class="row m-0 align-items-center border-bottom">
                            <div class="col-3 col-lg-2 p-1 text-center pb-3">
                                <img src="/uploads/fotos/<?php echo $avatar; ?>" alt="<?php echo $usuario['nome']; ?>" class="m-auto" width="60">
                            </div>
                            <div class="col-9 col-lg-10 p-1 pb-3">
                                <p class="small d-inline-block m-0"><strong>
                                        <?php echo $usuario['nome']; ?></strong>
                                    <span class="text-muted">

                                        <?php
                                                $dia = data_dia($pesquisa['data']);
                                                $mes = data_mes($pesquisa['data']);
                                                $ano = data_ano($pesquisa['data']);
                                                $hor = data_hora($pesquisa['data']);

                                                echo '<br>Publicado dia ' . $dia . ' de ' . $mes . ' de ' . $ano . ' às ' . $hor;
                                                ?>

                                    </span>
                                </p>
                            </div>
                        </div>

                        <header>
                            <h1 class="h3 p-3 font-weight-bold border-bottom">
                                <?php echo $pesquisa['titulo']; ?>
                            </h1>

                            <p class="small text-muted m-0 p-3">
                                Autor: <strong>
                                    <?php echo $pesquisa['autor']; ?></strong> <br>
                                <?php
                                if (!empty($pesquisa['coautor'])) {
                                    echo 'Coautor: <strong>';
                                    echo $pesquisa['coautor'];
                                    echo '</strong>';
                                }

                                if (!empty($pesquisa['local'])) {
                                    echo 'Local de publicação: <strong>';
                                    echo $pesquisa['local'];
                                    echo '</strong>';
                                }
                                ?>
                            </p>

                            <?php if (!empty($pesquisa['doi'])) : ?>

                                <p class="p-3"><i class="material-icons align-middle"> picture_as_pdf </i>
                                    <?php
                                                if (strstr($pesquisa['doi'], 'doi.org')) {
                                                    $link_doi = $pesquisa['doi'];
                                                } else {
                                                    $link_doi = 'https://doi.org/' . $pesquisa['doi'];
                                                }
                                                ?>
                                    Veja também o DOI desta pesquisa clicando <a href="<?php echo $link_doi; ?>" target="_blank">aqui</a>.
                                </p>

                            <?php endif; ?>

                        </header>
                        <main class="p-3">

                            <div class="small">
                                <?php echo $pesquisa['texto']; ?>
                            </div>

                        </main>
                    </article>
                </div>
            </div>
        </div>

    <?php
        else :
            ?>

        <div class="container pt-5 pb-5 text-center">
            <p class="h4 text-muted">Página não encontrada.</p>
        </div>

    <?php
        endif;

    elseif (isset($_REQUEST['acao']) && isset($_REQUEST['slug'])) :
        if ($_REQUEST['acao'] == 'edita') :
            $pesquisa = read_pesquisa(array('slug' => $_REQUEST['slug']));
            $pesquisa = $pesquisa->fetch_assoc();
            ?>

        <div class="container pt-5 pb-5 bg-white">
            <h2 class="text-center mb-3">Editar pesquisa</h2>
            <form method="post" id="form_edita_pesquisa">
                <div class="form-row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="titulo">DOI</label>
                            <input type="hidden" name="slug" id="slug" value="<?php echo $pesquisa['slug']; ?>">
                            <input type="text" class="form-control" name="doi" id="doi" placeholder="Cole o link do aqui DOI" value="<?php echo $pesquisa['doi']; ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="titulo">Autor</label>
                            <input type="text" class="form-control" name="autor" id="autor" placeholder="Ex.: João da Silva" value="<?php echo $pesquisa['autor']; ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="titulo">Co-autores</label>
                            <input type="text" class="form-control" name="coautor" id="coautor" placeholder="Ex.: José, Maria..." value="<?php echo $pesquisa['coautor']; ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="titulo">Título da pesquisa</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título da pesquisa" value="<?php echo $pesquisa['titulo']; ?>" disabled title="Não é possível alterar o título">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="texto">Descrição</label>
                            <div id="texto" maxlength="400">
                                <?php echo $pesquisa['texto']; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn bg-blue">Enviar pesquisa</button>
                <a href="../../" class="btn bg-danger text-white">Cancelar</a>
            </form>
        </div>

    <?php
        endif;

        if ($_REQUEST['acao'] == 'apaga') :
            $pesquisa = read_pesquisa(array('slug' => $_REQUEST['slug']));
            $pesquisa = $pesquisa->fetch_assoc();
            ?>

        <div class="container pt-5 pb-5 bg-white">
            <h2 class="text-center mb-3">Apagar pesquisa</h2>
            <p class="text-center">Você deseja apagar a pesquisa <span class="font-weight-bold">
                    <?php echo $pesquisa['titulo']; ?></span>?</p>
            <form method="post" id="form_apaga_pesquisa" class="m-auto text-center">
                <div class="form-row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <input type="hidden" name="slug" id="slug" value="<?php echo $pesquisa['slug']; ?>">
                        </div>
                    </div>
                </div>
                <a href="../../" class="btn bg-blue text-white">Cancelar</a>
                <button type="submit" class="btn bg-danger text-white">Sim</button>
            </form>
        </div>

    <?php
        endif;

    else :
        if (sessao_ativa()) :
            ?>
        <!-- Conteúdo -->
        <div class="container pt-3 pb-3">

            <div class="mt-5 mb-3">
                <div class="row">
                    <?php
                            $pesquisas = read_pesquisa(array('id_usuario' => $_SESSION['usuario']['id']));
                            if ($pesquisas->num_rows > 0) :

                                foreach ($pesquisas as $pesquisa) :
                                    $usuario = read_usuario(array('id' => $pesquisa['id_usuario']));
                                    $usuario = $usuario->fetch_assoc();

                                    include_once("include/templates/inc_pesquisa.php");
                                endforeach;

                            else :
                                ?>

                        <div class="col-12 p-3 text-center">
                            <p class="h4 text-muted">Você ainda não adicionou uma pesquisa.</p>
                        </div>

                    <?php
                            endif;
                            ?>
                </div>
            </div>
        </div>

<?php
    endif;
endif;

include_once("include/inc_rodape.php");
?>
