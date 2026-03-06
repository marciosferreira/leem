<?php
////////////////////////////////////////////
//Projetos
////////////////////////////////////////////

function create_cronograma($dados){
    if(!sessao_ativa()){die;}

    if(empty($dados['projeto'])){
        retorna_json(false, 'Informe o projeto.');
    }

    if(empty($dados['texto'])){
        retorna_json(false, 'Informe o texto.');
    }

    if(empty($dados['ano'])){
        retorna_json(false, 'Informe o ano.');
    }

    $conexao = conexao();

    $sql = "INSERT INTO leem_cronograma(texto, ano, id_projeto) VALUES(?,?,?)";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('sss', $dados['texto'], $dados['ano'], $dados['projeto']);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if($resultado > 0){
        retorna_json(true, 'Cronograma criado com sucesso.');
    }

    retorna_json(false, 'Falha ao criar o Cronograma.');

}

function read_cronograma($busca=""){

    $conexao = conexao();

    if(!empty($busca['id'])){
        $sql = "SELECT * FROM leem_cronograma WHERE id=? ORDER BY ano ASC";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $busca['id']);
    }elseif(!empty($busca['id_projeto'])){
        $sql = "SELECT * FROM leem_cronograma WHERE id_projeto=? ORDER BY ano ASC";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $busca['id_projeto']);
    }else{
        $sql = "SELECT * FROM leem_cronograma ORDER BY ano ASC";
        $comando = $conexao->prepare($sql);
    }

    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    return $resultado;

}

function update_cronograma($dados){
    if(!sessao_ativa()){die;}

    if(empty($dados['id'])){
        retorna_json(false, 'Informe o id do cronograma.');
    }

    if(empty($dados['texto'])){
        retorna_json(false, 'Informe o texto.');
    }

    if(empty($dados['ano'])){
        retorna_json(false, 'Informe o ano.');
    }

    $conexao = conexao();

    $sql = "UPDATE leem_cronograma SET texto = ?, ano = ? WHERE id = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('sss', $dados['texto'], $dados['ano'], $dados['id']);

    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    retorna_json(true, 'Cronograma alterado com sucesso.');

}

function delete_cronograma($id){
    if(!sessao_ativa()){die;}

    $usuario = read_usuario($_SESSION['usuario']['id']);
    $usuario_logado = $usuario->fetch_assoc();

    if(empty($id)){
        retorna_json(false, 'Nenhum Cronograma selecionado.');
    }

    if(sessao_ativa() && $usuario_logado['perfil'] == 'admin'){

        $conexao = conexao();

        $sql = "DELETE FROM leem_cronograma WHERE id = ?";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('i', $id);
        $comando->execute();
        $resultado = $comando->affected_rows;
        $comando->close();

        if($resultado > 0){

            retorna_json(true, 'Cronograma apagado.');
        }

        retorna_json(false, 'Falha. Não apagado.');
    }

    retorna_json(false, 'Apenas para adms.');

}
