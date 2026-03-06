<?php
///////////////////////
//DESTAQUES
///////////////////////

function create_destaque($descricao, $foto){
    if(!sessao_ativa()){die;}

    if(empty($descricao)){
        retorna_json(false, "Infome a descrição");
    }

    if(empty($foto['name'])){
        retorna_json(false, "Selecione uma foto");
    }

    $conexao = conexao();
    $foto = app_upload($foto);

    if($foto == false){
        retorna_json(false, "Falha no upload");
    }

    //Insere o usuário no banco de dados
    $sql = "INSERT INTO leem_destaque(descricao, foto) VALUES (?, ?)";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('ss', $descricao, $foto);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if($resultado){
        retorna_json(true, 'Destaque criado com sucesso.');
    }

    retorna_json(false, "Falha ao salvar dados. Tente novamente.");

}

function read_destaque($id_destaque=""){

    $conexao = conexao();

    if(!empty($id_destaque)){
        $where = "WHERE id = ?";
        $sql = "SELECT * FROM leem_destaque $where";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('i', $id_destaque);
    }else{
        $sql = "SELECT * FROM leem_destaque";
        $comando = $conexao->prepare($sql);
    }

    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    return $resultado;

}

function delete_destaque($id_destaque){
    if(!sessao_ativa()){die;}

    if(empty($id_destaque)){
        retorna_json(false, "Informe o id do destaque.");
    }

    $conexao = conexao();

    $id_usuario_sessao = $_SESSION['usuario']['id'];
    $usuario_admin = read_usuario(array('id_usuario'=>$id_usuario_sessao));
    $usuario_admin = $usuario_admin->fetch_assoc();

    $destaque = read_destaque($id_destaque);
    $destaque = $destaque->fetch_assoc();
    $foto = $destaque['foto'];

    $fotoPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'fotos' . DIRECTORY_SEPARATOR . $foto;
    if (file_exists($fotoPath)) {
        @unlink($fotoPath);
    }

    $sql = "DELETE FROM leem_destaque WHERE id = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('i', $id_destaque);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if($resultado > 0){
        retorna_json(true, 'Destaque apagado');
    }

    retorna_json(false, "Falha ao apagar destaque. Tente novamente.");

}
