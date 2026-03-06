<footer class="rodape pt-2 pb-3 text-white-50" style="background:#1e1e1f">
    <div class="container">
        <div class="row m-0 align-items-center">
            <div class="col-12 mb-5">
                <ul class="row m-0 list-unstyled text-center border-dashed pb-1">
                    <li class="col-6 col-md-3 nav-item p-1">
                        <a class="nav-link text-white" href="/projetos/">Projetos</a>
                    </li>
                    <li class="col-6 col-md-3 nav-item p-1">
                        <a class="nav-link text-white" href="/midia/">Midia</a>
                    </li>
                    <li class="col-6 col-md-3 nav-item p-1">
                        <a class="nav-link text-white" href="/equipe/">Quem somos</a>
                    </li>
                    <li class="col-6 col-md-3 nav-item p-1">
                        <a class="nav-link text-white" href="/nossa-historia/">Nossa história</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-6">
                <div class=" pt-3 pb-3 mb-3 text-center">
                    <div class="rounded mb-3 p-3">
                        <h1 class="pl-3 lead font-weight-bold m-0 p-0 d-inline-block">
                            <a class="navbar-brand" href="/">
                                <img src="/img/logo-leem.png" width="120" class="rounded-circle bg-green p-3" alt="LEEM">
                            </a>
                            <span class="d-none">LEEM</span>
                        </h1>
                    </div>
                    <p class="m-0 small">&copy; LEEM <span id="anoCopyright" class="font-weight-bold"></span>. Todos os direitos reservados.</p>
                </div>
            </div>
            <div class="col-12 col-md-6 text-center">
                <!--  Mapa clicável  -->
                <h2 class="h5 mt-1 text-white">Nossa localização</h2>
                <div class="embed-responsive embed-responsive-16by9 border-dashed mt-1 mb-1 p-1 bg-white rounded">
                    <iframe class="embed-responsive-item" src="https://maps.google.com.br/maps?q=INPA,MANAUS&amp;output=embed"></iframe>
                </div>
                <!-- <div class="border-dashed mt-1 mb-1 p-1 bg-white rounded">
                    <a href="https://www.google.com.br/maps/dir//endere%C3%A7o+do+inpa/@-3.0948812,-59.9878055,15z/data=!4m8!4m7!1m0!1m5!1m1!1s0x926c0534ffbf3c99:0x1a7fea8b77c41cf1!2m2!1d-59.9892519!2d-3.0945611" target="_blank"><img src="/img/mapa-leem.jpg" class="img-fluid"></a>
                </div> -->
            </div>

            <?php
            $apoiadores = read_apoiador();
            if ($apoiadores->num_rows > 0) : ?>

                <div class="col-12 p-0 text-center">
                    <div class="w-100 border-dashed mt-5 mb-5"></div>
                    <!--  Mapa clicável  -->
                    <h2 class="h5 mb-3 mt-1 text-white">Apoiadores</h2>
                    <div class="apoiadores bg-white rounded p-3">

                        <?php
                        foreach ($apoiadores as $apoiador) :
                            ?>

                            <div class="d-inline-block text-center">
                                <img src="/uploads/fotos/<?php echo $apoiador['foto']; ?>" alt="<?php echo $apoiador['titulo']; ?>" width="200" height="200" class="m-auto">
                            </div>

                        <?php
                    endforeach;
                    ?>

                    </div>
                </div>

            <?php
        endif;
        ?>

        </div>
        <div class="w-100 border-dashed mt-5 mb-5"></div>

        <p class="small text-right text-center">
            Feito com <span class="text-danger"><i class="material-icons align-middle"> favorite </i></span> por
            <a href="mailto:danilsonvs04@gmail.com" class="bg-white small rounded text-dark pl-1 pr-1 font-weight-bold">Danilson Veloso</a>
        </p>

        <script>
            var data = new Date();
            var ano = data.getFullYear();
            document.getElementById("anoCopyright").innerHTML = ano;
        </script>
    </div>
</footer>

<?php include_once("inc_dialogo.php"); ?>
<?php include_once("inc_scripts.php"); ?>
<?php
if (isset($pag)) {
    echo $pag;
}
?>

<script>
    $(document).ready(function() {
        $('.apoiadores').slick({
            dots: false,
            infinite: true,
            autoplay: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
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
    });
</script>

</body>

</html>
