<?php 
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header_admin.php'); ?>

<!-- Conteúdo -->
<div class="h-100 admin-conteudo bg-white col-12 col-md-8 col-lg-9 p-0" contenteditable="false">
    <div class="w-100 p-2 bg-blue text-white">
        <button class="btn bg-blue text-white d-inline-block d-md-none" type="button" id="abre_admin">
            <i class="material-icons"> menu </i>
        </button>
        <h2 class="d-inline-block h5 p-2 m-0">Administração</h2>
    </div>

    <div class="p-3">
        <?php
        if (isset($_REQUEST['painel'])) {
            $painel = $_REQUEST['painel'];

            switch ($painel) {
                case 'usuarios':
                    include_once('painel/painel_usuarios.php');
                    break;
                case 'projetos':
                    include_once('painel/painel_projetos.php');
                    break;
                case 'materias':
                    include_once('painel/painel_materias.php');
                    break;
                case 'galeria':
                    include_once('painel/painel_galeria.php');
                    break;
                case 'pesquisas':
                    include_once('painel/painel_pesquisas.php');
                    break;
                case 'midias':
                    include_once('painel/painel_midias.php');
                    break;
                case 'historia':
                    include_once('painel/painel_historia.php');
                    break;
                case 'cronograma':
                    include_once('painel/painel_cronograma.php');
                    break;
                case 'apoiadores':
                    include_once('painel/painel_logos.php');
                    break;
                case 'bug':
                    include_once('painel/painel_bug.php');
                    break;
                default:
                    echo '<p>Sem resultados para <strong class="font-weight-bold">' . $painel . '</strong>.</p>';
                    break;
            }
        } else {
            include_once("painel/painel_pendente.php");
        }

        ?>
    </div>
</div>
</div>
</div>

<?php include_once("include/inc_rodape_admin.php"); ?> 
