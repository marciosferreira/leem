<?php
///////////////////////
//MATÉRIAS
///////////////////////

function create_materia($dados, $file){
    if(!sessao_ativa()){die;}
    //Este metodo recebe os dados de $_REQUEST
    //$dados(array): $_REQUEST

    $conexao = conexao();

    if(empty($dados['projeto'])){
        retorna_json(false, 'Informe o projeto.');
    }

    if(empty($dados['titulo'])){
        retorna_json(false, 'Informe o título da matéria.');
    }

    if(empty($dados['descricao'])){
        retorna_json(false, 'Informe a descrição da matéria.');
    }

    if(empty($dados['texto'])){
        retorna_json(false, 'Informe o texto da matéris.');
    }

    $foto = '';

    if($file['foto']['size'] != 0){
        $upload = app_upload($file['foto']);

        if($upload != false){
            $foto = $upload;
        }else{
            retorna_json(false, 'Falha ao subir a foto.');
        }
    }

    $slug = create_slug($dados['titulo']);

    if(isset($dados['id'])){
        $id_autor = $dados['id'];
    }else{
        $id_autor = $_SESSION['usuario']['id'];
    }
    
    if(!empty($dados['data'])){
        $data = $dados['data'];
    }else{
        $data = date('Y-m-d H:i');
    }

    $sql = "INSERT INTO leem_materia(titulo, data, descricao, texto, foto, slug, id_usuario, destaque, tipo) VALUES(?,?,?,?,?,?,?,?,?)";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('sssssssss', $dados['titulo'], $data, $dados['descricao'], $dados['texto'], $foto, $slug, $id_autor, $dados['destaque'], $dados['tipo']);
    $comando->execute();
    $resultado = $comando->affected_rows; 
    $comando->close();

    if($resultado > 0){
        retorna_json(true, 'Matéria criada com sucesso.');
    }

    retorna_json(false, 'Falha ao criar a matéria.');

}

function read_materia($busca="", $limit=10){

    //Este metodo recebe dois parâmetros opicionais

    $conexao = conexao();

    $limit =  (isset($limit)) ? " limit " . $limit : '8';

    if(!empty($busca['id_projeto'])){

        $sql = "SELECT * FROM leem_materia WHERE id_projeto = ? ORDER BY data DESC" . $limit;
        $comando = $conexao->prepare($sql);
        $comando->bind_param('i', $busca['id_projeto']);

    }
    elseif(!empty($busca['id_usuario'])){

        $sql = "SELECT * FROM leem_materia WHERE id_usuario = ? ORDER BY data DESC";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('i', $busca['id_usuario']);

    }
    elseif(isset($busca['tipo'])){
        $sql = "SELECT * FROM leem_materia WHERE tipo=? ORDER BY data DESC " . $limit;
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $busca['tipo']);
    }
    elseif(isset($busca['destaque'])){
        $sql = "SELECT * FROM leem_materia WHERE destaque=? ORDER BY data DESC";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $busca['destaque']);
    }
    elseif(!empty($busca['id'])){

        $id = $busca['id'];

        $sql = "SELECT * FROM leem_materia WHERE id= ? ORDER BY data DESC LIMIT 1";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $id);

    }
    elseif(!empty($busca['slug'])){

        $busca = $busca['slug'];

        $sql = "SELECT * FROM leem_materia WHERE slug= ? ORDER BY data DESC" . $limit;
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $busca);

    }
    elseif(!empty($busca)){

        $busca = "%$busca%";

        $sql = "SELECT * FROM leem_materia 
                WHERE id = ?
                OR titulo LIKE ? 
                OR descricao LIKE ? 
                OR texto LIKE ? 
                OR slug LIKE ?
                OR data LIKE ?
                ORDER BY data DESC" . $limit;
        $comando = $conexao->prepare($sql);
        $comando->bind_param('ssssss', $busca, $busca, $busca, $busca, $busca, $busca);

    }else{

        $sql = "SELECT * FROM leem_materia ORDER BY data DESC" . $limit;
        $comando = $conexao->prepare($sql);

    }

    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    return $resultado;

}

function update_materia($dados, $file){
    if(!sessao_ativa()){die;}

    $conexao = conexao();

    if(empty($dados['id_materia'])){
        retorna_json(false, 'Informe uma matéria.');
    }

    if(empty($dados['titulo'])){
        retorna_json(false, 'Informe o título da matéria.');
    }

    if(empty($dados['descricao'])){
        retorna_json(false, 'Informe a descrição da matéria.');
    }

    if(empty($dados['texto'])){
        retorna_json(false, 'Informe a descrição.');
    }

    $foto = $dados['foto_atual'];
    
    if($file['foto']['size'] != 0){
        $upload = app_upload($file['foto']);

        if($upload != false){
            $foto = $upload;
        }else{
            retorna_json(false, 'Falha ao subir a foto.');
        }
    }

    $slug = create_slug($dados['titulo']);

    if(isset($dados['id'])){
        $id_autor = $dados['id'];
    }else{
        $id_autor = $_SESSION['usuario']['id'];
    }
    
    if(empty($dados['data'])){
        $data = date('Y-m-d H:i');
    }else{
        $data = str_replace('/', '-', $dados['data']);
        $data = strtotime($data);
        $data = date('Y-m-d H:i', $data);
    }

    $sql = "UPDATE leem_materia SET titulo=?, data=?, descricao=?, texto=?, foto=?, slug=?, destaque=?, tipo=? WHERE id=?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('sssssssss', $dados['titulo'], $data, $dados['descricao'], $dados['texto'], $foto, $slug, $dados['destaque'], $dados['tipo'], $dados['id_materia']);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();
    //09/07/2019 13:04

    retorna_json(true, 'Matéria alterada com sucesso.');

    // if($resultado > 0){
    //     retorna_json(true, 'Matéria alterada com sucesso.');
    // }

    // retorna_json(false, 'Falha ao alterar a matéria.');

}

function delete_materia($id_materia){
    if(!sessao_ativa()){die;}

    if(empty($id_materia)){
        retorna_json(false, "Informe o id da materia.");
    }

    $conexao = conexao();

    $sql = "DELETE FROM leem_materia WHERE id = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('s', $id_materia);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if($resultado > 0){
        retorna_json(true, 'Matéria apagada');
    }

    retorna_json(false, "Falha ao apagar matéria. Tente novamente.");

}