<?php
// ==============================================================
// VERCEL SERVERLESS FRONT CONTROLLER & ROUTER
// Web-Inventory (SIMTI) & Supabase PostgreSQL
// ==============================================================

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$root = dirname(__DIR__);

// Default route to landing page index.php
if ($uri === '/' || $uri === '' || $uri === '/index.php' || $uri === '/api' || $uri === '/api/index.php') {
    chdir($root);
    require $root . '/index.php';
    exit;
}

$target = $root . $uri;

// 1. Serve static assets if requested through router
if (file_exists($target) && !is_dir($target)) {
    $ext = strtolower(pathinfo($target, PATHINFO_EXTENSION));
    
    // If it's a PHP file, execute it
    if ($ext === 'php') {
        chdir(dirname($target));
        require $target;
        exit;
    }
    
    // Otherwise serve static mime
    $mimes = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'json'  => 'application/json',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'webp'  => 'image/webp',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'eot'   => 'application/vnd.ms-fontobject',
        'map'   => 'application/json'
    ];

    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
        header('Cache-Control: public, max-age=86400');
        readfile($target);
        exit;
    }
}

// 2. Check if .php extension was omitted
if (file_exists($target . '.php')) {
    chdir(dirname($target));
    require $target . '.php';
    exit;
}

// 3. Check for index.php in directory
if (is_dir($target) && file_exists($target . '/index.php')) {
    chdir($target);
    require $target . '/index.php';
    exit;
}

// 4. Fallback 404
http_response_code(404);
header('Content-Type: text/html; charset=utf-8');
echo '<!DOCTYPE html><html><head><title>404 Not Found</title><link rel="stylesheet" href="/assets/css/clean-ui.css"></head><body style="display:flex;align-items:center;justify-content:center;height:100vh;margin:0;"><div style="text-align:center;"><h1 style="color:#ffffff;font-size:3rem;">404</h1><p style="color:#8EB69B;">Halaman yang Anda tuju tidak ditemukan.</p><a href="/login.php" class="bento-btn bento-btn-lime" style="display:inline-flex;margin-top:16px;">Kembali ke Beranda</a></div></body></html>';
exit;
