<?php
foreach($pesquisas as $pesquisa):
$usuario = read_usuario(array('id_usuario'=>$pesquisa['id_usuario']));
$usuario = $usuario->fetch_assoc();
$avatar = read_avatar($usuario['id']);
?>

<div class="pesquisa col-12 col-md-6 col-xl-4 mb-3">
    <article class="h-100 bg-white shadow-md">
        <div class="row m-0 align-items-center border-bottom bg-blue">
            <div class="col-3 col-lg-2 p-1 text-center">
                <img src="/uploads/fotos/<?php echo $avatar;?>" alt="<?php echo $usuario['nome'];?>" 
                     class="m-auto" width="40">
            </div>
            <div class="col-9 col-lg-10 p-1">
                <p class="small d-inline-block m-0"><strong><?php echo $usuario['nome'];?></strong>
                    <span class="text-dark">

                        <?php 
                        $dia = data_dia($pesquisa['data']);
                        $mes = data_mes($pesquisa['data']);
                        $ano = data_ano($pesquisa['data']);
                        $hor = data_hora($pesquisa['data']);

                        echo '<br>Publicado dia ' . $dia .' de '. $mes .' de '. $ano .' às '. $hor;
                        ?>

                    </span>
                </p>
            </div>
        </div>
        <header>
            <div class="navabr p-3">
                <h1 class="h5 font-weight-bold">
                    <a href="/pesquisas/<?php echo $pesquisa['slug'];?>/" class="text-dark">
                        <?php echo $pesquisa['titulo'];?></a>
                </h1>
            </div>
        </header>
        <main class="p-3 bg-white">
            <p class="small text-muted m-0">
                Autor: <strong><?php echo $pesquisa['autor'];?></strong> <br>
                <?php 
                if(!empty($pesquisa['coautor'])){
                    echo 'Coautor: <strong>';
                    echo $pesquisa['coautor']; 
                    echo '</strong>';
                }?>
            </p>

            <?php
            if(sessao_ativa() && $pesquisa['id_usuario'] == $_SESSION['usuario']['id']):
            ?>

            <div class="navbar p-0 border-top bg-white">
                <div class="w-50 pt-2">
                    <a href="/pesquisas/edita/<?php echo $pesquisa['slug'];?>/" 
                       class="btn btn-block btn-sm text-dark">Editar</a>
                </div>
                <div class="w-50 pt-2">
                    <a href="/pesquisas/apaga/<?php echo $pesquisa['slug'];?>/" 
                       class="btn btn-block btn-sm text-danger">Apagar</a>
                </div>
            </div>

            <?php
            endif;
            ?>

        </main>

    </article>
</div>

<?php
endforeach;
?>
