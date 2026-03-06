<?php
///////////////////////
//USUÁRIOS
///////////////////////

function create_usuario($dados)
{

    if (empty($dados['nome'])) {
        retorna_json(false, "Infome o nome");
    }
    if (empty($dados['sexo'])) {
        retorna_json(false, "Infome o sexo");
    }
    if (empty($dados['email'])) {
        retorna_json(false, "Infome o email");
    }
    if (empty($dados['senha'])) {
        retorna_json(false, "Infome a senha");
    }

    //Se o perfil e o status não forem informados
    //Carrega os valores padrões
    if (empty($dados['perfil'])) {
        $perfil = 'pesquisador';
    } else {
        $perfil = $dados['perfil'];
    }

    if (empty($dados['ativo'])) {
        $ativo = 0;
    } else {
        $ativo = $dados['ativo'];
    }

    $conexao = conexao();

    //Verifica se o usuário já existe
    $sql = "SELECT * FROM leem_usuario WHERE email = ? ORDER BY acesso DESC";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('s', $dados['email']);
    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    if ($resultado->num_rows === 0) {

        //Criptografa a senha
        $senha = md5($dados['senha']);
        $slug = create_slug($dados['nome']);

        //Insere o usuário no banco de dados
        $sql = "INSERT INTO leem_usuario(nome, sexo, email, senha, perfil, ativo, slug) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $comando = $conexao->prepare($sql);
        $comando->bind_param(
            'sssssss',
            $dados['nome'],
            $dados['sexo'],
            $dados['email'],
            $senha,
            $perfil,
            $ativo,
            $slug
        );
        $comando->execute();
        $resultado = $comando->affected_rows;
        $comando->close();

        if ($resultado) {

            //Notifica o LEEM
            envia_email(
                'adaptaleem.inpa@gmail.com',
                'Solicitacao de conta de usuario',
                'Uma nova solicitação de conta de usuário está disponível. '
                    . 'Visite o site <a href="leem.net.br">leem.net.br</a>'
                    . ' e acesse o painel <b>Solicitações</b> para aprovar, recusar e alterar.'
            );
            retorna_json(true, 'Cadastro realizado com sucesso. O cadastro precisa ser validado pelos administradores. Uma confirmação será enviada ao e-mail cadastrado após aprovação.');
        }

        retorna_json(false, "Falha ao salvar dados. Tente novamente.");
    }

    retorna_json(false, "Este usuário já possui cadastro");
}

function create_usuario_projeto($dados)
{

    $usuario_logado = $_SESSION['usuario'];

    if ($usuario_logado['perfil'] != 'admin') {
        retorna_json(false, "Não permitido");
    }

    if (empty($dados['id_projeto']) || $dados['id_projeto'] == 0) {
        retorna_json(false, "Infome o projeto");
    }
    if (empty($dados['id_usuario']) || $dados['id_usuario'] == 0) {
        retorna_json(false, "Infome o usuário");
    }

    $conexao = conexao();

    //Verifica se o usuário já existe
    $sql = "SELECT * FROM leem_usuario_projeto WHERE id_projeto=? AND id_usuario=?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('ss', $dados['id_projeto'], $dados['id_usuario']);
    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    if ($resultado->num_rows == 0) {

        //Insere o usuário no banco de dados
        $sql = "INSERT INTO leem_usuario_projeto(id_projeto, id_usuario) VALUES (?, ?)";
        $comando = $conexao->prepare($sql);
        $comando->bind_param(
            'ss',
            $dados['id_projeto'],
            $dados['id_usuario']
        );
        $comando->execute();
        $resultado = $comando->affected_rows;
        $comando->close();

        if ($resultado > 0) {

            retorna_json(true, 'Usuário adicionado com sucesso.');
        }

        retorna_json(false, "Falha ao salvar dados. Tente novamente.");
    }

    retorna_json(false, "Este usuário já foi adicionado ao projeto");
}

function read_usuario($param = "")
{

    //Este metodo recebe dois parâmetros opicionais
    //$param(array): id_usuario(int), busca(string), perfil(string)[visitante | pesquisador], ativo(void) ou home(void)

    $conexao = conexao();

    $limit = (isset($param['limit'])) ? "LIMIT " . $param['limit'] : "";

    //Usuários da busca
    if (isset($param['busca'])) {

        $busca = "%{$param['busca']}%";
        $sql = "SELECT * FROM leem_usuario 
                WHERE id = ? 
                OR nome LIKE ? 
                OR email LIKE ? 
                AND id > 1
                ORDER BY visitas DESC $limit";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('sss', $busca, $busca, $busca);

        //Usuários por perfil
    } elseif (isset($param['perfil'])) {

        $sql = "SELECT * FROM leem_usuario WHERE perfil= ? AND ativo='1' ORDER BY acesso DESC $limit";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $param['perfil']);

        //Usuários por id
    } elseif (isset($param['id_usuario'])) {

        $sql = "SELECT * FROM leem_usuario WHERE id= ?";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $param['id_usuario']);

        //Usuários por slug
    } elseif (isset($param['slug'])) {

        $sql = "SELECT * FROM leem_usuario WHERE slug=?";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $param['slug']);

        //Usuários por status ativo
    } elseif (isset($param['ativo'])) {

        $sql = "SELECT * FROM leem_usuario WHERE ativo= ? ORDER BY acesso DESC $limit";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('s', $param['ativo']);
    } else {
        $sql = "SELECT * FROM leem_usuario WHERE id > 1 ORDER BY visitas DESC $limit";
        $comando = $conexao->prepare($sql);
    }

    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    return $resultado;
}

function read_usuario_projeto($param = "")
{

    $conexao = conexao();

    $limit = (isset($param['limit'])) ? "LIMIT " . $param['limit'] : "LIMIT 20";

    $sql = 'SELECT * FROM leem_usuario INNER JOIN leem_usuario_projeto ON leem_usuario_projeto.id_usuario = leem_usuario.id WHERE leem_usuario_projeto.id_projeto=? ' . $limit;
    $comando = $conexao->prepare($sql);
    $comando->bind_param('s', $param['id_projeto']);

    $comando->execute();
    $resultado = $comando->get_result();
    $comando->close();

    return $resultado;
}

function update_usuario($dados)
{
    if (!sessao_ativa()) {
        die;
    }

    $id_usuario = $dados['id_usuario'];

    $usuario_logado = $_SESSION['usuario'];

    if ($usuario_logado['perfil'] != 'admin') {
        retorna_json(false, "Não permitido");
    }

    if (empty($dados['nome'])) {
        retorna_json(false, "Informe o nome");
    }

    if (empty($dados['email'])) {
        retorna_json(false, "Informe o email");
    }

    if (empty($dados['sexo'])) {
        retorna_json(false, "Informe o sexo");
    }

    if (empty($dados['perfil'])) {
        retorna_json(false, "Informe o perfil");
    }

    $conexao = conexao();
    $slug = create_slug($dados['nome']);

    $sql = "UPDATE leem_usuario SET nome = ?, email = ?, sexo = ?, perfil = ?, ativo = ?, slug = ? WHERE id = ? AND id > 1";
    $comando = $conexao->prepare($sql);
    $comando->bind_param(
        'ssssssi',
        $dados['nome'],
        $dados['email'],
        $dados['sexo'],
        $dados['perfil'],
        $dados['ativo'],
        $slug,
        $id_usuario
    );
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    $usuario = read_usuario(array('id_usuario' => $id_usuario));
    $usuario = $usuario->fetch_assoc();

    if (!empty($dados['senha'])) {
        $update_senha = array(
            'email' => $dados['email'],
            'token' => $dados['token'],
            'senha' => $dados['senha']
        );
        update_senha($update_senha);
    }

    if ($dados['ativo'] == 1) {

        envia_email(
            $dados['email'],
            'LEEM - Conta ativada com sucesso',
            'Sua conta do LEEM foi aprovada. Visite o site <a href="leem.net.br">leem.net.br</a> para acessar.'
        );
    } else {

        envia_email(
            $dados['email'],
            'LEEM - Conta desativada',
            'Sua conta do LEEM foi desativada pelo administrador do site.'
        );
    }

    retorna_json(true, 'Usuário alterado com sucesso.');
}

function ativa_usuario($dados)
{
    if (!sessao_ativa()) {
        die;
    }

    if (empty($dados['id_usuario'])) {
        retorna_json(false, "Erro");
    }

    $id_usuario = $dados['id_usuario'];
    $email = $dados['email'];

    $usuario_logado = $_SESSION['usuario'];

    if ($usuario_logado['perfil'] != 'admin') {
        retorna_json(false, "Não permitido");
    }

    $conexao = conexao();

    $sql = "UPDATE leem_usuario SET ativo=? WHERE id=? AND id > 1";
    $comando = $conexao->prepare($sql);
    $comando->bind_param(
        'ss',
        $dados['ativo'],
        $id_usuario
    );
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if ($resultado > 0) {
        envia_email(
            $email,
            'Conta ativada com sucesso',
            'Sua conta do LEEM foi aprovada. Visite o site <a href="leem.net.br">leem.net.br</a> para acessar.'
        );

        retorna_json(true, 'Sucesso.');
    }

    retorna_json(false, 'Falhou.');
}

function delete_usuario($id_usuario)
{
    if (!sessao_ativa()) {
        die;
    }

    if (empty($id_usuario)) {
        retorna_json(false, "Informe o id do usuário.");
    }

    $conexao = conexao();
    $id_sessao = $_SESSION['usuario']['id'];

    if ($id_sessao == $id_usuario) {
        retorna_json(false, "Você não pode apagar a própria conta.");
    }

    $usuario_admin = read_usuario(array('id_usuario' => $id_sessao));
    $usuario_admin = $usuario_admin->fetch_assoc();

    $sql = "DELETE FROM leem_usuario WHERE id = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('i', $id_usuario);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if ($resultado > 0) {
        retorna_json(true, 'Usuário apagado');
    }

    retorna_json(false, "Falha ao apagar usuário. Tente novamente.");
}

///////////////////////
//Atualiza o perfil  //
///////////////////////

function update_perfil($dados)
{
    if (!sessao_ativa()) {
        die;
    }

    $id_usuario = $_SESSION['usuario']['id'];

    $conexao = conexao();

    if (empty($dados['email'])) {
        retorna_json(false, "Informe seu email");
    }

    if (empty($dados['biografia'])) {
        retorna_json(false, "Informe sua biografia");
    }

    //Verifica as opções de currículo foram preenchidas
    if (!empty($dados['lattes'])) {
        $lattes = $dados['lattes'];
    } else {
        $lattes = null;
    }

    if (!empty($dados['research'])) {
        $research = $dados['research'];
    } else {
        $research = null;
    }

    if (!empty($dados['orcid'])) {
        $orcid = $dados['orcid'];
    } else {
        $orcid = null;
    }

    if (!empty($dados['curriculo'])) {
        $curriculo = $dados['curriculo'];
    } else {
        $curriculo = null;
    }

    $sql = "UPDATE leem_usuario SET email = ?, biografia = ?, lattes = ?, research = ?, orcid = ?, curriculo = ?, contato=?, instagram=?, twitter=?, facebook=? WHERE id = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('sssssssssss', $dados['email'], $dados['biografia'], $lattes, $research, $orcid, $curriculo, $dados['contato'], $dados['instagram'], $dados['twitter'], $dados['facebook'], $id_usuario);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    retorna_json(true, 'Perfil alterado com sucesso.');
}

//Busca o email informado pelo usuário
function update_senha($dados)
{

    if (empty($dados['email'])) {
        retorna_json(false, 'Por gentileza, informe seu e-mail.');
    }
    if (empty($dados['senha'])) {
        retorna_json(false, 'Por gentileza, informe sua nova senha.');
    }
    if (empty($dados['token'])) {
        retorna_json(false, 'Falha. Abra novamente o e-mail de recuperação de senha.');
    }

    if(isset($_SESSION['usuario'])){
        if ($dados['email'] != $_SESSION['usuario']['email']) {
            retorna_json(false, 'Por gentileza, informe seu e-mail.');
        }
    }

    $email = $dados['email'];
    $senha = md5($dados['senha']);
    $senha_atual = $dados['token'];

    $conexao = conexao();

    $sql = "UPDATE leem_usuario SET senha = ? WHERE email = ? AND senha = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('sss', $senha, $email, $senha_atual);
    $comando->execute();
    $resultado = $comando->affected_rows;
    $comando->close();

    if ($resultado == 0) {

        retorna_json(
            false,
            'Algo errado. Utilizar a mesma senha ou informar e-mail incorreto'
        );
    }

    retorna_json(true, 'Dados alterados com sucesso. Faça login com a nova senha.');
}

function update_visitas($id_usuario)
{
    $usuario = read_usuario($id_usuario);
    $usuario = $usuario->fetch_assoc();
    $visitas = $usuario['visitas'];
    $visitas++;

    $conexao = conexao();

    $sql = "UPDATE leem_usuario SET visitas = ? WHERE id = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('ii', $visitas, $id_usuario);
    $comando->execute();
    $comando->close();
}
