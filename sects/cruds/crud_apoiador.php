<?php
///////////////////////
//DESTAQUES
///////////////////////
function create_apoiador($nome, $foto){

    if(!sessao_ativa()){die;}

    if(empty($nome)){
        retorna_json(false, "Infome a descrição");
    }

    if(empty($foto['name'])){
        retorna_json(false, "Selecione uma foto");
    }

    $conexao = conexao();
    $foto = app_upload($foto);
    $tag = 'apoiador';

    if($foto == false){
        retorna_json(false, "Falha no upload");
    }

    //Insere o usuário no banco de dados
    $sql = "INSERT INTO leem_foto(titulo, foto, tag) VALUES (?, ?, ?)";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('sss', $nome, $foto, $tag);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if($resultado > 0){
        retorna_json(true, 'apoiador criado com sucesso.');
    }

    retorna_json(false, "Falha ao salvar dados. Tente novamente.");

}

function read_apoiador($id_apoiador=""){

    $conexao = conexao();

    if(!empty($id_apoiador)){
        $where = "WHERE id = ?";
        $sql = "SELECT * FROM leem_foto $where";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('i', $id_apoiador);
    }else{
        $sql = "SELECT * FROM leem_foto";
        $comando = $conexao->prepare($sql);
    }

    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    return $resultado;

}

function delete_apoiador($id_apoiador){
    if(!sessao_ativa()){die;}

    if(empty($id_apoiador)){
        retorna_json(false, "Informe o id do apoiador.");
    }

    $conexao = conexao();

    $id_usuario_sessao = $_SESSION['usuario']['id'];
    $usuario_admin = read_usuario(array('id_usuario'=>$id_usuario_sessao));
    $usuario_admin = $usuario_admin->fetch_assoc();

    $apoiador = read_apoiador($id_apoiador);
    $apoiador = $apoiador->fetch_assoc();
    $foto = $apoiador['foto'];

    $fotoPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'fotos' . DIRECTORY_SEPARATOR . $foto;
    if (file_exists($fotoPath)) {
        @unlink($fotoPath);
    }

    
    

    $sql = "DELETE FROM leem_foto WHERE id = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('i', $id_apoiador);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if($resultado > 0){
        retorna_json(true, 'apoiador apagado');
    }

    retorna_json(false, "Falha ao apagar apoiador. Tente novamente.");

}
