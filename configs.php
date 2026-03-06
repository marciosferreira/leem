<?php
error_reporting(E_ALL);
// error_reporting(0);
session_name("LEEM_SID");
session_start();
set_include_path(implode(PATH_SEPARATOR, array_filter([
    get_include_path(),
    __DIR__,
    __DIR__ . DIRECTORY_SEPARATOR . 'sects',
    __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'include',
    __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'templates',
])));
require_once __DIR__ . DIRECTORY_SEPARATOR . 'functions.php';
date_default_timezone_set('America/Sao_Paulo');

$disableHttpsRedirect = strtolower((string) getenv('LEEM_DISABLE_HTTPS_REDIRECT')) === '1'
    || strtolower((string) getenv('LEEM_DISABLE_HTTPS_REDIRECT')) === 'true';

$isHttps = false;
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === '1')) {
    $isHttps = true;
} elseif (isset($_SERVER['SERVER_PORT']) && (string) $_SERVER['SERVER_PORT'] === '443') {
    $isHttps = true;
} elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string) $_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
    $isHttps = true;
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = '443';
} elseif (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower((string) $_SERVER['HTTP_X_FORWARDED_SSL']) === 'on') {
    $isHttps = true;
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = '443';
} elseif (isset($_SERVER['HTTP_FORWARDED']) && preg_match('/proto=https/i', (string) $_SERVER['HTTP_FORWARDED'])) {
    $isHttps = true;
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = '443';
}

if (!$disableHttpsRedirect && !$isHttps) {
    if (!headers_sent()) {
        header("Status: 301 Moved Permanently");
        header(sprintf(
            'Location: https://%s%s',
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        ));
        exit();
    }
}

//cruds
require __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'cruds' . DIRECTORY_SEPARATOR . 'crud_avatar.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'cruds' . DIRECTORY_SEPARATOR . 'crud_galeria.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'cruds' . DIRECTORY_SEPARATOR . 'crud_materia.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'cruds' . DIRECTORY_SEPARATOR . 'crud_midia.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'cruds' . DIRECTORY_SEPARATOR . 'crud_pesquisa.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'cruds' . DIRECTORY_SEPARATOR . 'crud_projeto.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'cruds' . DIRECTORY_SEPARATOR . 'crud_usuario.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'cruds' . DIRECTORY_SEPARATOR . 'crud_cronograma.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'sects' . DIRECTORY_SEPARATOR . 'cruds' . DIRECTORY_SEPARATOR . 'crud_apoiador.php';
