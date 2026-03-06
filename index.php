<?php
if (isset($_SERVER['REQUEST_URI'])) {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_string($path)) {
        $staticPrefixes = ['/public/', '/css/', '/js/', '/img/', '/libs/', '/uploads/'];
        foreach ($staticPrefixes as $prefix) {
            if (!str_starts_with($path, $prefix)) {
                continue;
            }

            $candidatePaths = [];
            $candidatePaths[] = __DIR__ . $path;
            if ($prefix === '/public/') {
                $candidatePaths[] = __DIR__ . substr($path, strlen('/public'));
            }

            foreach ($candidatePaths as $filePath) {
                if (!is_file($filePath)) {
                    continue;
                }
                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                $contentType = match ($ext) {
                    'css' => 'text/css; charset=utf-8',
                    'js' => 'application/javascript; charset=utf-8',
                    'png' => 'image/png',
                    'jpg', 'jpeg' => 'image/jpeg',
                    'gif' => 'image/gif',
                    'svg' => 'image/svg+xml',
                    'ico' => 'image/x-icon',
                    'webp' => 'image/webp',
                    default => 'application/octet-stream',
                };
                header('Content-Type: ' . $contentType);
                readfile($filePath);
                exit;
            }

            http_response_code(404);
            exit;
        }
    }
}

$rawPath = is_string($path) ? $path : '/';
$segments = array_values(array_filter(explode('/', trim($rawPath, '/')), static fn($s) => $s !== ''));
if (isset($segments[0]) && $segments[0] === 'index.php') {
    array_shift($segments);
}

$route = $segments[0] ?? '';

if ($route === 'rotas') {
    $_REQUEST['rota'] = $segments[1] ?? ($_REQUEST['rota'] ?? '');
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'rotas.php';
    exit;
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'configs.php';

switch ($route) {
    case '':
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_home.php';
        break;
    case 'materia':
        $_REQUEST['slug'] = $segments[1] ?? ($_REQUEST['slug'] ?? '');
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_materia.php';
        break;
    case 'projetos':
        if (isset($segments[1])) {
            $_REQUEST['slug'] = $segments[1];
        }
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_projetos.php';
        break;
    case 'midia':
        if (($segments[1] ?? '') === 'video' && isset($segments[2])) {
            $_REQUEST['id'] = $segments[2];
        }
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_midia.php';
        break;
    case 'equipe':
        if (isset($segments[1])) {
            $_REQUEST['slug'] = $segments[1];
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_usuario.php';
        } else {
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_equipe.php';
        }
        break;
    case 'usuario':
        $_REQUEST['slug'] = $segments[1] ?? ($_REQUEST['slug'] ?? '');
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_usuario.php';
        break;
    case 'busca':
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_busca.php';
        break;
    case 'entrada':
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_entrada.php';
        break;
    case 'cadastro':
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_cadastro.php';
        break;
    case 'recuperar':
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_recuperar.php';
        break;
    case 'senha':
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_senha.php';
        break;
    case 'perfil':
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_perfil.php';
        break;
    case 'publica':
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_publica.php';
        break;
    case 'avatar':
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_avatar.php';
        break;
    case 'bug':
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_bug.php';
        break;
    case 'historia':
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_historia.php';
        break;
    case 'admin':
        $_REQUEST['painel'] = $segments[1] ?? ($_REQUEST['painel'] ?? '');
        $_REQUEST['acao'] = $segments[2] ?? ($_REQUEST['acao'] ?? '');
        $_REQUEST['id'] = $segments[3] ?? ($_REQUEST['id'] ?? '');
        $_REQUEST['slug'] = $segments[3] ?? ($_REQUEST['slug'] ?? '');
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_admin.php';
        break;
    default:
        http_response_code(404);
        $_REQUEST['erro_code'] = '404';
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'sec_erro.php';
        break;
}
