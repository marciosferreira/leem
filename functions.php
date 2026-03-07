<?php

use PHPMailer\PHPMailer\PHPMailer;
use phpmailer\PHPMailer\Exception;
//

require_once __DIR__ . DIRECTORY_SEPARATOR . "phpmailer" . DIRECTORY_SEPARATOR . "Exception.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "phpmailer" . DIRECTORY_SEPARATOR . "PHPMailer.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "phpmailer" . DIRECTORY_SEPARATOR . "SMTP.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "database.php";
//
//set_time_limit(60000);

//Conexão do banco de dados
function conexao()
{
    $app_db = new database();
    $conexao = $app_db->get_conexao();
    if ($conexao instanceof mysqli && $conexao->connect_errno) {
        $accept = isset($_SERVER['HTTP_ACCEPT']) ? (string) $_SERVER['HTTP_ACCEPT'] : '';
        $isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower((string) $_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || stripos($accept, 'application/json') !== false;

        if ($isAjax) {
            retorna_json(false, 'Falha ao conectar no banco de dados.');
        }

        http_response_code(500);
        $_REQUEST['erro_code'] = '500';
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_erro.php';
        exit;
    }
    return $conexao;
}

//Obtém o status da sessão
function sessao_ativa()
{

    if (isset($_SESSION['usuario'])) {
        return true;
    }

    return false;
}

function app_entrada($dados)
{

    if (isset($dados['email']) && isset($dados['senha'])) {

        $conexao = conexao();

        if (empty($dados['email'])) {
            retorna_json(false, 'Por gentileza, informe seu email');
        }
        if (empty($dados['email'])) {
            retorna_json(false, 'Por gentileza, informe sua senha');
        }

        $email = $dados['email'];
        $senha = md5($dados['senha']);

        //Busca pelo dados informados no banco de dados
        $sql = "SELECT * FROM leem_usuario WHERE email = ? AND senha = ?";
        $comando = $conexao->prepare($sql);
        $comando->bind_param('ss', $email, $senha);
        $comando->execute();

        $resultado = $comando->get_result();

        if ($resultado->num_rows == 1) {

            $usuario = $resultado->fetch_assoc();
            $comando->close();

            //Status do usuário
            $status = $usuario['ativo'];

            //Verifica se o usuário está ativo
            if ($status) {
                //Inicia a sessão
                $_SESSION['usuario'] = $usuario;
                retorna_json(true, 'Bem-vindo(a), ' . $usuario['nome'] . '! Aguarde... Você será redirecionado.');
            }

            retorna_json(false, 'Sua conta está inativa. Aguarde a aprovação da sua conta.');
        }

        $comando->close();
        retorna_json(false, 'Os dados parecem incorretos. Tente novamente.');
    }

    retorna_json(false, 'Necessário informar todos os dados');
}

//Encerra a sessão
function app_saida()
{
    session_destroy();
    header('Location: /');
}

//Envia e-mail
function envia_email($email, $assunto, $template)
{

    if (!empty($email) && !empty($assunto) && !empty($template)) {

        $smtpUser = getenv('LEEM_SMTP_USER');
        $smtpPass = getenv('LEEM_SMTP_PASS');
        $smtpFrom = getenv('LEEM_SMTP_FROM');
        if (empty($smtpUser) || empty($smtpPass)) {
            return false;
        }

        $mail = new PHPMailer(true);
        try {
            //            $mail->SMTPDebug  = 2;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Port       = 587;
            $mail->Username   = $smtpUser;
            $mail->Password   = $smtpPass;
            $mail->SMTPSecure = 'tls';
            $mail->setFrom(!empty($smtpFrom) ? $smtpFrom : $smtpUser, 'LEEM');

            if (gettype($email) == 'array') {
                for ($i = 0; $i < count($email); $i++) {
                    $mail->addAddress($email[$i], 'LEEM');
                }
            } else {
                $mail->addAddress($email, 'LEEM');
            }


            //Content
            $mail->isHTML(true);
            $mail->Subject = $assunto;
            $mail->Body    = $template;
            $mail->AltBody = 'Seu cliente de e-mail não suporta HTML.';

            if ($mail->Send()) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            die('Erro: ' . $e->getMessage());
        }
    }

    return false;
}

//Envia e-mail de recuperação da senha
function app_recupera($email)
{

    if (empty($_REQUEST['email'])) {
        retorna_json(false, 'Por gentileza, informe o seu e-mail.');
    }

    $email = $_REQUEST['email'];

    $usuario_econtrado = busca_email($email);
    if ($usuario_econtrado != false) {

        $email_enviado = envia_email($email, 'Recupere sua senha', html_senha($usuario_econtrado));
        if ($email_enviado) {
            retorna_json(false, 'Uma solicitação de recuperação foi enviado para o seu e-mail.');
        }

        retorna_json(false, 'Ocorreu um erro durante o envio. Tente novamente.');
    }

    retorna_json(false, 'Parece que sua conta não existe ou está inativa.');
}

//Envia e-mail de recuperação da senha
function app_email_ativo($dados)
{

    $email_enviado = envia_email($dados['email'], 'Conta ativa', html_ativo($dados));
    if ($email_enviado) {
        retorna_json(false, 'Uma email de ativação foi enviada para o e-mail do usuário.');
    }

    retorna_json(false, 'Ocorreu um erro durante o envio do email.');
}

//Busca o email informado pelo usuário
function busca_email($email)
{

    $conexao = conexao();

    $sql = "SELECT * FROM leem_usuario WHERE email = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param('s', $email);
    $comando->execute();

    $resultado = $comando->get_result();

    if ($resultado->num_rows == 1) {

        $usuario = $resultado->fetch_assoc();
        $comando->close();

        //Status do usuário
        $status = $usuario['ativo'];

        //Verifica se o usuário está ativo
        if ($status) {

            return $usuario;
        }
    }

    return false;
}

function html_senha($dados)
{
    $html = '<div style="display:block;padding:10px;background:#64941e;color:#ffffff;text-align:center;font-size:16px">';
    $html .= '<h1 style="font-size: 52px;font-weight:bold">LEEM</h1>';
    $html .= 'Olá, <span style="font-weight:bold">' . $dados['nome'] . '</span>';
    $html .= '!<br> Você solicitou a recuperação de senha do aplicativo LEEM. <br>';
    $html .= 'Clique no link abaixo para criar uma nova senha. <br>';
    $html .= '<a href="https://leem.net.br/recuperar/' . $dados['senha'];
    $html .= '" style="color:#ffffff;font-size: 24px;text-decoration:none;display:block;border:1px solid #fff;padding:10px;text-align:center;">Recuperar senha</a>';
    $html .= '</div>';

    return $html;
}

function html_ativo($dados)
{
    $html = '<div style="display:block;padding:10px;background:#64941e;color:#ffffff;text-align:center;font-size:16px">';
    $html .= '<h1 style="font-size: 52px;font-weight:bold">LEEM</h1>';
    $html .= 'Olá, <span style="font-weight:bold">' . $dados['nome'] . '</span>';
    $html .= '!<br> Sua conta foi aprovada. <br>';
    $html .= 'Clique no link abaixo para acessa-la. <br>';
    $html .= '<a href="https://leem.net.br/entrada/';
    $html .= '" style="color:#ffffff;font-size: 24px;text-decoration:none;display:block;border:1px solid #fff;padding:10px;text-align:center;">Acesse sua conta</a>';
    $html .= '</div>';

    return $html;
}

function html_bug($bug)
{
    $html = '<div style="display:block;padding:10px 10px 20px 10px;background:#64941e;color:#ffffff;text-align:center;font-size:16px">';
    $html .= '<h1 style="font-size: 52px;font-weight:bold">LEEM</h1>';
    $html .= '<h2 style="font-size: 35px;font-weight:300;border-bottom:1px solid #fff">Um problema foi reportado</h2>';
    $html .= '<p>' . $bug . '</p>';
    $html .= '</div>';

    return $html;
}

//Envia e-mail de bug
function reporta_bug($bug)
{

    if (!empty($bug)) {

        $email_enviado = envia_email(
            ['adaptaleem.inpa@gmail.com', 'danilsonvs04@gmail.com'],
            'Reporte de bug no site',
            html_bug($bug['bug'])
        );

        if ($email_enviado) {
            retorna_json(true, 'O problema foi enviado para análise. Obrigado por nos ajudar com esta informação!');
        }

        retorna_json(false, 'Ocorreu um erro durante o envio das informações. Tente novamente.');
    }

    retorna_json(false, 'Falha. Revise as informações.');
}

///////////////////////
//Upload de arquivos//
///////////////////////
function app_upload($arquivo)
{

    //Retorna o nome do arquivo em caso de suceso
    //ou false se falhar

    if (isset($arquivo)) {
        date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
        //$ext = strtolower(substr($arquivo['name'], -4)); //Pegando extensão do arquivo
        $info = new SplFileInfo($arquivo['name']);
        $ext = strtolower($info->getExtension());
        $nome_arquivo = date("dmYHis") . '.' . $ext; //Definindo um novo nome para o arquivo
        $baseUploadsDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
        $dir = $baseUploadsDir;


        if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif' || $ext == 'jpg' || $ext == "jpeg") {
            $dir = $baseUploadsDir . 'fotos' . DIRECTORY_SEPARATOR;
        }

        if ($ext == 'pdf' || $ext == 'doc') {
            $dir = $baseUploadsDir . 'anexos' . DIRECTORY_SEPARATOR;
        }

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $movido = move_uploaded_file($arquivo['tmp_name'], $dir . $nome_arquivo); //Fazer upload do arquivo

        if ($movido) {
            return $nome_arquivo;
        } else {
            return false;
        }
    }

    return false;
}

//Retorna código no formato json
function retorna_json($sucesso, $resposta)
{
    $json = [
        'sucesso' => $sucesso, 'resposta' => $resposta
    ];

    echo json_encode($json);
    die();
}

function data_dia($data)
{
    $date = date_create($data);
    return date_format($date, "d");
}

function data_ano($data)
{
    $date = date_create($data);
    return date_format($date, "Y");
}

function data_hora($data)
{
    $date = date_create($data);
    return date_format($date, "H:i");
}

function data_mes($data)
{
    $date = date_create($data);
    $num_mes = date_format($date, "m");

    switch ($num_mes) {
        case 1:
            $mes_abrev = 'jan';
            break;
        case 2:
            $mes_abrev = 'fev';
            break;
        case 3:
            $mes_abrev = 'mar';
            break;
        case 4:
            $mes_abrev = 'abr';
            break;
        case 5:
            $mes_abrev = 'mai';
            break;
        case 6:
            $mes_abrev = 'jun';
            break;
        case 7:
            $mes_abrev = 'jul';
            break;
        case 8:
            $mes_abrev = 'ago';
            break;
        case 9:
            $mes_abrev = 'set';
            break;
        case 10:
            $mes_abrev = 'out';
            break;
        case 11:
            $mes_abrev = 'nov';
            break;
        case 12:
            $mes_abrev = 'dez';
            break;
        default:
    }

    return $mes_abrev;
}

function create_slug($str, $replace = array(), $delimiter = '-')
{
    if (!empty($replace)) {
        $str = str_replace((array) $replace, ' ', $str);
    }

    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return $clean;
}

function get_paises($selecionados = '', $resto=false)
{
    $str_paises = 'Áustria,Austrália,Bélgica,Brasil,Canadá,Colômbia,Eslovênia,Espanha,Portugal';

    $paises = explode(',', $str_paises);
    $paises_selecionados = explode(',', $selecionados);

    if($selecionados != '' && !$resto){
        $paises = $paises_selecionados;
    }

    $icones = array(
        'Áustria' => 'austria.svg',
        'Austrália' => 'australia.svg',
        'Bélgica' => 'belgica.svg',
        'Brasil' => 'brasil.svg',
        'Canadá' => 'canada.svg',
        'Colômbia' => 'colombia.svg',
        'Eslovênia' => 'eslovenia.svg',
        'Espanha' => 'espanha.svg',
        'Portugal' => 'portugal.svg'
    );

    $html = '';

    foreach ($paises as $pais) {

        if (isset($icones[$pais])) {

            if ($selecionados != '' && $resto) {

                if (strstr($selecionados, $pais)) {
                    continue;
                }
            }

            $icone = $icones[$pais];

            $html .= '<div class="pais col-12 col-sm-6 col-md-3 mb-4 text-dark d-inline-block font-weight-bold" data-pais="' . $pais . '">';
            $html .= '<img src="/img/paises/' . $icone . '" alt="' . $pais . '">' . $pais;
            $html .= '</div>';
            
        }
    }

    echo $html;
}

