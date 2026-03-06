<?php
foreach ($materias as $materia) :
    $usuario = read_usuario(array('id_usuario' => $materia['id_usuario']));
    $usuario = $usuario->fetch_assoc();
    $avatar = read_avatar($usuario['id']);
    ?>

<div class="col-12 p-0 h-100 m-0 border-bottom">
    <article class="h-100 bg-white">
        <div class="row m-0 align-items-center border-bottom">
            <div class="col-3 col-lg-2 p-1 pb-3 text-center">
                <img src="/uploads/fotos/<?php echo $avatar; ?>" alt="<?php echo $usuario['nome']; ?>" class="m-auto" width="60">
            </div>
            <div class="col-9 col-lg-10 p-1 pb-3">
                <p class="small d-inline-block m-0"><strong><?php echo $usuario['nome']; ?></strong>
                    <span class="text-muted">

                        <?php
                            $dia = data_dia($materia['data']);
                            $mes = data_mes($materia['data']);
                            $ano = data_ano($materia['data']);
                            $hor = data_hora($materia['data']);

                            echo '<br>Publicado dia ' . $dia . ' de ' . $mes . ' de ' . $ano . ' às ' . $hor;
                            ?>

                    </span>
                </p>
            </div>
        </div>

        <div class="position-relative">

            <div class="row m-0">
                <div class="col-12 m-auto p-0 materia">

                    <header>
                        <h1 class="h3 p-3 font-weight-bold">
                            <?php echo $materia['titulo']; ?>
                        </h1>
                    </header>

                    <main class="p-3">
                        <p class="text-dark"><?php echo $materia['descricao']; ?></p>

                        <?php if ($materia['foto'] != NULL) : ?>

                        <figure>
                            <a href="/index.php/materia/<?php echo $materia['slug']; ?>/">
                                <img src="/uploads/fotos/<?php echo $materia['foto']; ?>" class="img-fluid" alt="<?php echo $materia['titulo']; ?>">
                            </a>
                        </figure>

                        <?php endif; ?>

                        <div class="text-dark materia position-relative">
                            <?php
                                $texto = str_replace('http://', 'https://', $materia['texto']);
                                echo $texto;
                                ?>
                        </div>

                    </main>
                </div>
            </div>

        </div>
    </article>
</div>

<?php
endforeach;
?>
