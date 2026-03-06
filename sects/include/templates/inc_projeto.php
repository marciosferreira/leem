<?php
foreach($projetos as $projeto):
?>

<div class="col-12 col-sm-6 col-lg-4 mb-5">
    <article class="h-100 bg-white shadow-md">

        <header>
            <div class="p-3">
                <h1 class="h3 m-0 font-weight-bold">
                    <a href="/index.php/projetos/<?php echo $projeto['slug'];?>/" class="text-dark"><?php echo $projeto['titulo'];?></a></h1>
            </div>

            <?php if($projeto['foto'] != NULL):?>

            <figure>
                <a href="/index.php/projetos/<?php echo $projeto['slug'];?>/">
                    <img src="/uploads/fotos/<?php echo $projeto['foto'];?>" 
                         class="img-fluid" alt="<?php echo $projeto['titulo'];?>">
                </a>
            </figure>

            <?php endif;?>

        </header>

        <main class="p-3">

            <p>
                <?php echo strip_tags($projeto['descricao']);?>
            </p>

        </main>

    </article>
</div>

<?php
endforeach;
?>
