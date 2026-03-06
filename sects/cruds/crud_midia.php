<?php
function create_video($dados){
    if(!sessao_ativa()){die;}

    $conexao = conexao();

    if(empty($dados['titulo'])){
        retorna_json(false, "Informe um título");
    }

    if(empty($dados['url'])){
        retorna_json(false, "Informe a URL");
    }

    $url = explode('v=', $dados['url']);
    if(count($url) < 2){
        retorna_json(false, "A URL informada é inválida");
    }

    $id_video = substr($url[1], 0,11);

    $sql = "INSERT INTO leem_video(titulo, url_id) VALUES(?, ?)";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('ss', $dados['titulo'], $id_video);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if($resultado > 0){
        retorna_json(true, "Vídeo adicionado");
    }

    retorna_json(false, "Falhou, tente novamente!");

}

function read_video($busca=""){

    $conexao = conexao();

    if(!empty($busca)){
        $busca = "%$busca%";
        $sql = "SELECT * FROM leem_video WHERE titulo LIKE ? OR url_id = ?";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('ss', $busca, $busca);
    }else{
        $sql = "SELECT * FROM leem_video";
        $comando = $conexao->prepare($sql);
    }

    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    return $resultado;

}

function delete_video($id){
    if(!sessao_ativa()){die;}
    
    $usuario = read_usuario($_SESSION['usuario']['id']);
    $usuario_logado = $usuario->fetch_assoc();

    if(empty($id)){
        retorna_json(false, 'Nenhum video selecionado.');
    }

    if(sessao_ativa() && $usuario_logado['perfil'] == 'admin'){

        $conexao = conexao();

        $sql = "DELETE FROM leem_video WHERE url_id = ?";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('i', $id);
        $comando->execute();
        $resultado = $comando->affected_rows;
        $comando->close();

        if($resultado > 0){
            retorna_json(true, 'Video apagado.');
        }

        retorna_json(false, 'Falha. Não apagado.');
    }

    retorna_json(false, 'Apenas para adms.');

}
