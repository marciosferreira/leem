<?php
    if ($videos->num_rows > 0) :
        foreach ($videos as $video) :
            ?>
    <div class="col-12 col-md-4 col-lg-3 p-3 mb-2 p-0">
        <div class="bg-white rounded h-100 shadow-md">
            <a href="/index.php/midia/video/<?php echo $video['url_id']; ?>/" class="btn btn-sm btn-block bg-white text-white p-0">
                <img src="https://img.youtube.com/vi/<?php echo $video['url_id']; ?>/hqdefault.jpg" class="img-fluid" alt="<?php echo $video['titulo']; ?>" title="<?php echo $video['titulo']; ?>">
            </a>
            <div class="p-2">
                <h3 class="font-weight-bold" style="font-size: 14px!important;"><?php echo $video['titulo']; ?></h3>
            </div>
        </div>
    </div>
    <?php
endforeach;
else :
    ?>

    <div class="col-12 p-3 text-center">
        <p class="h4 text-muted">Nenhuma mídia encontrada.</p>
    </div>

    <?php
endif;
?> 
