<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// ──────────────────────────────────────────────────────────────────
// Serve static files (CSS, JS, images, fonts, etc.) directly
// This bypasses Laravel routing so correct MIME types are sent.
// ──────────────────────────────────────────────────────────────────
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$staticFile = __DIR__ . $uri;

if ($uri !== '/' && file_exists($staticFile) && !is_dir($staticFile)) {
    $ext = strtolower(pathinfo($staticFile, PATHINFO_EXTENSION));
    $mimes = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'mjs'   => 'application/javascript',
        'json'  => 'application/json',
        'map'   => 'application/json',
        'svg'   => 'image/svg+xml',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'eot'   => 'application/vnd.ms-fontobject',
        'txt'   => 'text/plain',
        'webmanifest' => 'application/manifest+json',
    ];
    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
        if (str_starts_with($uri, '/build/')) {
            header('Cache-Control: public, max-age=31536000, immutable');
        } else {
            header('Cache-Control: no-cache, no-store, must-revalidate');
        }
        readfile($staticFile);
        exit;
    }
}
// ──────────────────────────────────────────────────────────────────

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
