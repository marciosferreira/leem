<?php
///////////////////////
//DESTAQUES
///////////////////////

function create_imagem($imagem)
{
    if (!sessao_ativa()) {
        die;
    }

    if (empty($imagem['name'])) {
        retorna_json(false, "Selecione uma imagem");
    }

    $conexao = conexao();
    $imagem = app_upload($imagem);

    if ($imagem == false) {
        retorna_json(false, "Falha no upload");
    }

    //Insere o usuário no banco de dados
    $sql = "INSERT INTO leem_imagem(nome) VALUES (?)";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('s', $imagem);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if ($resultado) {
        retorna_json(true, 'Imagem criada com sucesso.');
    }

    retorna_json(false, "Falha ao salvar dados. Tente novamente.");
}

function read_imagem($id_destaque = "")
{

    $conexao = conexao();

    if (!empty($id_imagem)) {
        $where = "WHERE id = ?";
        $sql = "SELECT * FROM leem_imagem $where";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('i', $id_imagem);
    } else {
        $sql = "SELECT * FROM leem_imagem";
        $comando = $conexao->prepare($sql);
    }

    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    return $resultado;
}

function delete_imagem($id_imagem)
{
    if (!sessao_ativa()) {
        die;
    }

    if (empty($id_imagem)) {
        retorna_json(false, "Informe o id da imagem.");
    }

    $conexao = conexao();

    $id_usuario_sessao = $_SESSION['usuario']['id'];
    $usuario_admin = read_usuario(array('id_usuario' => $id_usuario_sessao));
    $usuario_admin = $usuario_admin->fetch_assoc();

    $imagem = read_imagem($id_imagem);
    $imagem = $imagem->fetch_assoc();
    $imagem = $imagem['nome'];

    $imagemPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'fotos' . DIRECTORY_SEPARATOR . $imagem;
    if (file_exists($imagemPath)) {
        @unlink($imagemPath);
    }

    $sql = "DELETE FROM leem_imagem WHERE id = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('i', $id_imagem);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if ($resultado > 0) {
        retorna_json(true, 'Imagem apagada');
    }

    retorna_json(false, "Falha ao apagar imagem. Tente novamente.");
}
