<?php
////////////////////////////////////////////
//Projetos
////////////////////////////////////////////

function create_projeto($dados, $foto){
    if(!sessao_ativa()){die;}

    if(empty($dados['titulo'])){
        retorna_json(false, 'Informe o nome do projeto.');
    }

    if(empty($dados['paises'])){
        retorna_json(false, 'Informe os países.');
    }

    if(empty($dados['programas'])){
        retorna_json(false, 'Informe os programas.');
    }

    if(empty($dados['descricao'])){
        retorna_json(false, 'Informe a descrição.');
    }

    $foto_ok = app_upload($foto);

    if($foto_ok != ""){
        $foto = $foto_ok;
    }else{
        $foto = 'default.png';
    }

    $conexao = conexao();

    $slug = create_slug($dados['titulo']);

    $sql = "INSERT INTO leem_projeto(titulo, paises, programas, descricao, foto, slug) VALUES(?,?,?,?,?,?)";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('ssssss', $dados['titulo'], $dados['paises'], $dados['programas'], $dados['descricao'], $foto, $slug);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if($resultado > 0){
        retorna_json(true, 'Projeto criado com sucesso.');
    }

    retorna_json(false, 'Falha ao criar o projeto.');

}

function read_projeto($busca="", $limit=10){

    $conexao = conexao();

    $limit =  (isset($limit)) ? " limit " . $limit : '';

    if(isset($busca['id'])){
        $sql = "SELECT * FROM leem_projeto WHERE id=? ORDER BY data DESC $limit";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $busca['id']);
    }elseif(isset($busca['slug'])){
        $sql = "SELECT * FROM leem_projeto WHERE slug=?";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $busca['slug']);
    }elseif(!empty($busca)){

        $busca = "%$busca%";
        $sql = "SELECT * FROM leem_projeto 
        WHERE id = ? 
        OR titulo LIKE ? 
        OR slug LIKE ? 
        OR descricao LIKE ? 
        ORDER BY data DESC $limit";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('ssss', $busca, $busca, $busca, $busca);
    }else{
        $sql = "SELECT * FROM leem_projeto ORDER BY data DESC $limit";
        $comando = $conexao->prepare($sql);
    }

    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    return $resultado;

}

function read_projeto_usuario($param = "")
{

    $conexao = conexao();

    $limit = (isset($param['limit'])) ? "LIMIT " . $param['limit'] : "LIMIT 20";

    $sql = 'SELECT * FROM leem_projeto INNER JOIN leem_usuario_projeto ON leem_usuario_projeto.id_projeto = leem_projeto.id WHERE leem_usuario_projeto.id_usuario=? '.$limit;
    $comando = $conexao->prepare($sql);
    $comando->bind_param('s', $param['id_usuario']);
    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();
    
    return $resultado;
}

function update_projeto($dados, $foto){
    if(!sessao_ativa()){die;}

    if(empty($dados['id_projeto'])){
        retorna_json(false, 'Informe o nome do projeto.');
    }

    if(empty($dados['titulo'])){
        retorna_json(false, 'Informe o nome do projeto.');
    }

    if(empty($dados['paises'])){
        retorna_json(false, 'Informe os países.');
    }

    if(empty($dados['programas'])){
        retorna_json(false, 'Informe os programas.');
    }

    if(empty($dados['descricao'])){
        retorna_json(false, 'Informe a descrição.');
    }

    $conexao = conexao();

    $foto_ok = app_upload($foto);
    $slug = create_slug($dados['titulo']);

    if($foto_ok != ""){
        $sql = "UPDATE leem_projeto SET titulo = ?, paises = ?, programas = ?, descricao = ?, foto = ?, slug = ? WHERE id = ?";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('sssssss', $dados['titulo'], $dados['paises'], $dados['programas'], $dados['descricao'], $foto_ok, $slug, $dados['id_projeto']);

    }else{
        $sql = "UPDATE leem_projeto SET titulo = ?, paises = ?, programas = ?, descricao = ?, slug = ? WHERE id = ?";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('ssssss', $dados['titulo'], $dados['paises'], $dados['programas'], $dados['descricao'], $slug, $dados['id_projeto']);
    }

    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    retorna_json(true, 'Projeto alterado com sucesso.');

}

function delete_projeto($id){
    if(!sessao_ativa()){die;}

    $usuario = read_usuario(array('id_usuario'=>$_SESSION['usuario']['id']));
    $usuario_logado = $usuario->fetch_assoc();

    if(empty($id)){
        retorna_json(false, 'Nenhum projeto selecionado.');
    }

    if(sessao_ativa() && $usuario_logado['perfil'] == 'admin'){

        $conexao = conexao();

        $sql = "DELETE FROM leem_projeto WHERE id = ?";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('i', $id);
        $comando->execute();
        $resultado = $comando->affected_rows;
        $comando->close();

        if($resultado > 0){

            retorna_json(true, 'Projeto apagado.');
        }

        retorna_json(false, 'Falha. Não apagado.');
    }

    retorna_json(false, 'Apenas para adms.');

}
