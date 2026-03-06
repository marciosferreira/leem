<?php
function create_pesquisa($dados, $anexo)
{

    if (!sessao_ativa()) {
        die;
    }

    if (empty($dados['projeto'])) {
        retorna_json(false, 'Faltou informar o projeto');
    }
    if (empty($dados['autor'])) {
        retorna_json(false, 'Faltou informar o autor');
    }
    if (empty($dados['titulo'])) {
        retorna_json(false, 'Faltou informar o titulo');
    }
    if (empty($dados['editor'])) {
        retorna_json(false, 'Faltou informar o editor');
    }
    if (empty($dados['id_usuario'])) {
        $id_usuario = $_SESSION['usuario']['id'];
    } else {
        $id_usuario = $dados['id_usuario'];
    }

    if (empty($dados['coautor'])) {
        $coautor = null;
    } else {
        $coautor = $dados['coautor'];
    }

    if (empty($dados['doi'])) {
        $doi = null;
    } else {
        $doi = $dados['doi'];
    }

    $projeto = $dados['projeto'];
    $autor   = $dados['autor'];
    $titulo  = $dados['titulo'];
    $texto   = $dados['editor'];
    $slug    = create_slug($titulo);

    $conexao = conexao();

    $sql = "SELECT slug FROM leem_pesquisa WHERE slug=?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('s', $slug);
    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    if ($resultado->num_rows == 0) {

        $sql = "INSERT INTO leem_pesquisa (doi, autor, coautor, titulo, texto, slug, id_usuario, id_projeto) VALUES(?,?,?,?,?,?,?,?)";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('ssssssss', $doi, $autor, $coautor, $titulo, $texto, $slug, $id_usuario, $projeto);

        $comando->execute();
        $resultado = $comando->affected_rows;
        $comando->close();

        if ($resultado > 0) {
            retorna_json(true, 'Pesquisa enviada com sucesso.');
        }

        retorna_json(false, 'Erro: Não foi possível enviar a pesquisa.');
    }

    retorna_json(false, 'Erro: Já existe uma pesquisa com esse título');
}

function read_pesquisa($busca = "", $limit = 10)
{

    $conexao = conexao();

    $limit = (isset($limit)) ? $limit : 10;

    if (isset($busca['id'])) {
        $sql = "SELECT * FROM leem_pesquisa WHERE id = ? ORDER BY data DESC LIMIT $limit";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('i', $busca['id']);
    } elseif (isset($busca['id_projeto'])) {
        $sql = "SELECT * FROM leem_pesquisa WHERE id_projeto = ? ORDER BY data DESC LIMIT $limit";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('i', $busca['id_projeto']);
    } elseif (isset($busca['id_usuario'])) {
        $sql = "SELECT * FROM leem_pesquisa WHERE id_usuario = ? ORDER BY data DESC LIMIT $limit";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('i', $busca['id_usuario']);
    } elseif (isset($busca['slug'])) {
        $sql = "SELECT * FROM leem_pesquisa WHERE slug= ? ORDER BY data DESC LIMIT $limit";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $busca['slug']);
    } elseif (!empty($busca)) {

        $busca = "%$busca%";
        $sql = "SELECT * FROM leem_pesquisa 
                WHERE id = ? OR autor LIKE ? OR coautor LIKE ? OR titulo LIKE ? OR slug LIKE ? OR texto LIKE ? 
                ORDER BY data DESC LIMIT $limit";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('ssssss', $busca, $busca, $busca, $busca, $busca, $busca);
    } else {
        $sql = "SELECT * FROM leem_pesquisa ORDER BY data DESC LIMIT $limit";
        $comando = $conexao->prepare($sql);
    }

    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    return $resultado;
}

function update_pesquisa($dados, $anexo = "")
{
    if (!sessao_ativa()) {
        die;
    }

    if (empty($dados['slug'])) {
        retorna_json(false, 'Faltou uma informação');
    }
    if (empty($dados['autor'])) {
        retorna_json(false, 'Faltou informar o autor');
    }
    if (empty($dados['editor'])) {
        retorna_json(false, 'Faltou informar o editor');
    }

    if (empty($dados['coautor'])) {
        $coautor = null;
    } else {
        $coautor = $dados['coautor'];
    }

    if (empty($dados['doi'])) {
        $doi = null;
    } else {
        $doi = $dados['doi'];
    }

    $slug  = $dados['slug'];
    $autor = $dados['autor'];
    $texto = $dados['editor'];

    $conexao = conexao();
    $sql = "UPDATE leem_pesquisa SET doi=?, autor=?, coautor=?, texto=? WHERE slug=?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('sssss', $doi, $autor, $coautor, $texto, $slug);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if ($resultado > 0) {
        retorna_json(true, 'Pesquisa editada com sucesso.');
    }

    retorna_json(false, 'Erro: Não foi possível editar a pesquisa.');
}

function delete_pesquisa($slug)
{
    if (!sessao_ativa()) {
        die;
    }

    if (empty($slug)) {
        retorna_json(false, 'Faltou uma informação');
    }

    $conexao = conexao();
    $sql = "DELETE FROM leem_pesquisa WHERE slug=?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('s', $slug);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if ($resultado > 0) {
        retorna_json(true, 'Pesquisa apagada com sucesso.');
    }

    retorna_json(false, 'Erro: Não foi possível apagar a pesquisa.');
}

