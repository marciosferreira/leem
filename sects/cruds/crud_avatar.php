<?php
///////////////////////
//AVATAR
///////////////////////

function update_avatar($dados){
    if(!sessao_ativa()){die;}

    if(!$dados['avatar']){
        retorna_json(false, 'Foto inválida.');
    }

    $foto = $dados['avatar'];
    $id_usuario = $_SESSION['usuario']['id'];

    $conexao = conexao();

    $foto_ok = app_upload($foto);

    if($foto_ok != false){

        $sql = "UPDATE leem_usuario SET avatar = ? WHERE id = ?";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('ss', $foto_ok, $id_usuario);
        $comando->execute();
        $comando->close();

        retorna_json(true, 'Foto alterada com sucesso.');

    }

    retorna_json(false, 'Falha ao alterar foto.');

}

function read_avatar($id_usuario){

    $conexao = conexao();

    $sql = "SELECT avatar, sexo FROM leem_usuario WHERE id = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('i', $id_usuario);
    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();
    $usuario = $resultado->fetch_assoc();

    if($usuario['avatar'] != null){
        $avatar  = $usuario['avatar'];
    }else{
        $avatar  = 'user-' . $usuario['sexo'] . '.png';
    }

    return $avatar;

}