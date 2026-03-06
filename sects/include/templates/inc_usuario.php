<?php
//Lista todos os usuários
foreach ($equipe as $usuario) :
    $avatar = read_avatar($usuario['id']);
    ?>

    <div class="col-12 col-md-6 col-lg-4 text-center mb-4">
        <div class="p-3 bg-white h-100">
            <img src="/public/uploads/fotos/<?php echo $avatar; ?>" width="120" height="120" class="mb-3 rounded-circle" alt="<?php echo $usuario['nome']; ?>">
            <h3 class="lead pb-2 font-weight-bold" style="font-size:1em!important">
                <a href="/equipe/<?php echo $usuario['slug']; ?>/" class="btn btn-sm bg-white font-weight-bold text-dark">
                    <?php
                    echo substr($usuario['nome'], 0, 30);
                    if (strlen($usuario['nome']) > 30) {
                        echo '...';
                    }
                    ?>
                </a>
            </h3>
            <p style="height: 100px" class="small p-3 border rounded m-0">
                <?php
                if (!empty($usuario['biografia'])) {
                    echo substr($usuario['biografia'], 0, 120) . '...';
                } else {
                    echo 'Este usuário ainda não adicionou sua biografia.';
                }

                ?>
            </p>
        </div>
    </div>

<?php
endforeach;
?>