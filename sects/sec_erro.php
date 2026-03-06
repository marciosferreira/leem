<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header.php');
$erro_code = (!empty($_REQUEST['erro_code'])) ? $_REQUEST['erro_code'] : '';
?>

<!-- Conteúdo -->
<div class="bg-blue">
    <div class="container pt-5 pb-5 text-dark text-center">
        <div class="row align-items-center text-uppercase">
            <div class="col-12 text-center">
                <h2 class="h1 font-weight-light">Erro <?php echo $erro_code; ?> </h2>
            </div>
        </div>
    </div>
</div>
<div class="bg-white">
    <div class="container pt-5 pb-5 text-dark text-center">
        <div class="row align-items-center text-uppercase">
            <div class="col-12 text-center">
                <?php
                switch ($erro_code) {
                    case '404':
                        echo 'A página não foi encontrada.';
                        break;
                    case '500':
                        echo 'Falha ao conectar no banco de dados.';
                        break;
                    default:
                        echo 'Ocorreu um erro desconhecido.';
                        break;
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once("include/inc_rodape.php");
?>
