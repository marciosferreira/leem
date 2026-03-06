<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header.php');
?>

<!-- Conteúdo -->
<div class="bg-blue">
    <div class="container pt-5 pb-5 text-dark text-center">
        <div class="row align-items-center text-uppercase">
            <div class="col-12 col-md-6">
                <h2 class="h1 font-weight-light">Quem somos</h2>
            </div>
            <div class="col-12 col-md-6">
                <p class="h5 font-weight-light">Você poderá encontrar o registro de nossos colaboradores atuais e de quem já colaborou conosco.</p>
            </div>
        </div>
    </div>
</div>
<!-- Conteúdo -->
<div class="container pt-3">
    <?php
    $visitantes = read_usuario(array('perfil' => 'visitante'));
    if ($visitantes->num_rows > 0) :
        ?>

        <!-- Visitantes -->
        <h3 class="h4 mt-3 pb-3 border-bottom">Visitantes</h3>
        <div class="visitantes bg-white m-0 pt-3 mt-3 border-bottom mb-5">

            <?php
            foreach ($visitantes as $visitante) :
                $avatar = read_avatar($visitante['id']);
                ?>

                <div class="pl-3 pr-3 text-center pb-3">
                    <div class="p-3 bg-white h-100">
                        <img src="/uploads/fotos/<?php echo $avatar; ?>" width="120" class="m-auto mb-3" alt="<?php echo $visitante['nome']; ?>">
                        <h3 class="h5 pb-3">
                            <a href="/index.php/equipe/<?php echo $visitante['slug']; ?>/" class="btn btn-sm bg-white text-dark"><?php echo $visitante['nome']; ?></a>
                        </h3>
                    </div>
                </div>

            <?php
        endforeach;
        ?>

        </div>

    <?php
endif;
?>

    <!-- Usuários do leem -->
    <div class="row">
        <?php
        $count = 200;
        if (isset($_REQUEST['count'])) {
            $count = $_REQUEST['count'];
            $count += 9;
        }

        $equipe = read_usuario(array('limit' => $count));

        if ($equipe->num_rows > 0) :
            include_once("include/templates/inc_usuario.php");
        else :
            ?>

            <div class="col-12 pt-5 pb-5 text-center">
                <p class="text-muted m-0 h3">Nenhum usuário econtrado.</p>
            </div>

        <?php
    endif;

    if ($equipe->num_rows > $count - 1) :
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
</div>

<?php
$pag =
    '<script>
    var pag = $(".leem");
    if(!pag.hasClass("active")){
        pag.addClass("active");
    }

    $(".visitantes").slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
              infinite: true,
              dots: false
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          ]
    });
</script>';

include_once("include/inc_rodape.php");
?>
