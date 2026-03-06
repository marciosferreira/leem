<?php
$id_usuario = $usuario_logado['id'];
$usuario = read_usuario(array('id_usuario'=>$id_usuario));
$avatar = read_avatar($id_usuario);
?>

<li class="nav-item p-0 botao-menu">
    <a class="nav-link" href="javascript:void(0)">
        <img src="/uploads/fotos/<?php echo $avatar;?>" width="40" height="40" class="rounded-circle align-middle avatar">

        <?php
        $usuario = $usuario->fetch_assoc();
        $nome = explode(' ', $usuario['nome']);
        echo $nome[0];
        ?>

    </a>
</li>
