<?php
function materia($materias){
?>
<div class="row m-0">
    <?php
    $i = 0;
    foreach ($materias as $materia) :
        $usuario = read_usuario(array('id_usuario' => $materia['id_usuario']));
        $usuario = $usuario->fetch_assoc();

        $texto_materia = '';
        $arrayWords = explode(' ', $materia['titulo']);
        $count = 0;
        foreach($arrayWords as $word){

            $texto_materia .= $word . ' ';

            if($count == 8) {
                trim($word);
                break;
            }

            $count++;
        }
                                        //echo substr($destaque['titulo'], 0, 80); 
        // <!-- substr($materia['titulo'], 0, 50); -->
        ?>

        <div class="col-12 col-md-6 col-lg-3 mb-3 align-items-start flex-column border-bottom">
            <article class="bg-white">
                <div class="row m-0 align-items-top">
                    <div class="col-12 p-0">
                        <?php
                        $foto = (isset($materia['foto'])) ? '/uploads/fotos/' . $materia['foto'] : '/img/LOGO.svg'; ?>

                        <figure class="materia-imagem rounded" style="background: #313131 url(<?php echo $foto; ?>) center center;background-size: cover">
                            <a href="/index.php/materia/<?php echo $materia['slug']; ?>/">
                                <img src="<?php echo $foto; ?>" class="img-fluid bg-green rounded d-none" alt="<?php echo $materia['titulo']; ?>">
                            </a>
                        </figure>

                    </div>
                    <div class="col-12 p-0">
                        <header>
                            <h1 class="h5 font-weight-bold mt-2" style="height: 90px">
                                <a href="/index.php/materia/<?php echo $materia['slug']; ?>/" class="text-dark"><?php echo $texto_materia; ?>...</a>
                            </h1>
                        </header>
                        <main>
                            <p class="text-dark">
                                <?php 
                                //echo substr($materia['descricao'], 0, 250); 
                                $arrayWords = explode(' ', $materia['descricao']);
                                $count = 0;
                                foreach($arrayWords as $word){

                                    echo $word . ' ';

                                    if($count == 20) {
                                        trim($word);
                                        break;
                                    }

                                    $count++;
                                }
                                ?>...
                                </p>
                        </main>
                    </div>
                </div>
            </article>
        </div>

        <?php
        $i++;
    endforeach;
    ?>
</div>
<?php
}
