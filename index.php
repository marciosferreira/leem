<?php
if (!function_exists('leem_starts_with')) {
    function leem_starts_with($haystack, $needle)
    {
        if (!is_string($haystack) || !is_string($needle)) {
            return false;
        }
        $len = strlen($needle);
        if ($len === 0) {
            return true;
        }
        return substr($haystack, 0, $len) === $needle;
    }
}

if (isset($_SERVER['REQUEST_URI'])) {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_string($path)) {
        $staticPrefixes = ['/public/', '/css/', '/js/', '/img/', '/libs/', '/uploads/'];
        foreach ($staticPrefixes as $prefix) {
            if (!leem_starts_with($path, $prefix)) {
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
                $contentType = 'application/octet-stream';
                if ($ext === 'css') {
                    $contentType = 'text/css; charset=utf-8';
                } elseif ($ext === 'js') {
                    $contentType = 'application/javascript; charset=utf-8';
                } elseif ($ext === 'png') {
                    $contentType = 'image/png';
                } elseif ($ext === 'jpg' || $ext === 'jpeg') {
                    $contentType = 'image/jpeg';
                } elseif ($ext === 'gif') {
                    $contentType = 'image/gif';
                } elseif ($ext === 'svg') {
                    $contentType = 'image/svg+xml';
                } elseif ($ext === 'ico') {
                    $contentType = 'image/x-icon';
                } elseif ($ext === 'webp') {
                    $contentType = 'image/webp';
                }
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
$segments = array_values(array_filter(explode('/', trim($rawPath, '/')), static function ($s) {
    return $s !== '';
}));
if (isset($segments[0]) && $segments[0] === 'index.php') {
    array_shift($segments);
}

$route = $segments[0] ?? '';

if ($route === '__health') {
    header('Content-Type: application/json; charset=utf-8');

    $dbStatus = null;
    $dbError = null;

    $mysqliAvailable = extension_loaded('mysqli');
    if ($mysqliAvailable && is_file(__DIR__ . DIRECTORY_SEPARATOR . 'database.php')) {
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'database.php';
        if (class_exists('database')) {
            $db = new database();
            $conn = $db->get_conexao();
            if ($conn instanceof mysqli) {
                if ($conn->connect_errno) {
                    $dbStatus = 'error';
                    $dbError = $conn->connect_errno . ': ' . $conn->connect_error;
                } else {
                    $dbStatus = 'ok';
                }
                @$conn->close();
            } else {
                $dbStatus = 'error';
                $dbError = 'No mysqli connection';
            }
        } else {
            $dbStatus = 'error';
            $dbError = 'database class not found';
        }
    } elseif (!$mysqliAvailable) {
        $dbStatus = 'error';
        $dbError = 'mysqli extension not loaded';
    } else {
        $dbStatus = 'error';
        $dbError = 'database.php not found';
    }

    echo json_encode([
        'ok' => true,
        'php' => PHP_VERSION,
        'sapi' => php_sapi_name(),
        'request' => [
            'host' => $_SERVER['HTTP_HOST'] ?? null,
            'uri' => $_SERVER['REQUEST_URI'] ?? null,
            'https' => $_SERVER['HTTPS'] ?? null,
            'server_port' => $_SERVER['SERVER_PORT'] ?? null,
            'x_forwarded_proto' => $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null,
            'x_forwarded_scheme' => $_SERVER['HTTP_X_FORWARDED_SCHEME'] ?? null,
            'request_scheme' => $_SERVER['REQUEST_SCHEME'] ?? null,
        ],
        'db' => [
            'status' => $dbStatus,
            'error' => $dbError,
            'env' => [
                'host' => getenv('LEEM_DB_HOST') ?: null,
                'port' => getenv('LEEM_DB_PORT') ?: null,
                'name' => getenv('LEEM_DB_NAME') ?: null,
                'user' => getenv('LEEM_DB_USER') ?: null,
                'pass_set' => getenv('LEEM_DB_PASS') !== false && getenv('LEEM_DB_PASS') !== '',
            ],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

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
