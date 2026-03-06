<?php
if (isset($_SERVER['REQUEST_URI'])) {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_string($path) && str_starts_with($path, '/public/')) {
        $filePath = __DIR__ . $path;
        if (is_file($filePath)) {
            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $contentType = match ($ext) {
                'css' => 'text/css; charset=utf-8',
                'js' => 'application/javascript; charset=utf-8',
                'png' => 'image/png',
                'jpg', 'jpeg' => 'image/jpeg',
                'gif' => 'image/gif',
                'svg' => 'image/svg+xml',
                'ico' => 'image/x-icon',
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
require_once __DIR__ . '/sects/index.php';
