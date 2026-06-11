<?php

// Route all requests through Laravel's public folder
// This lets the app run at localhost/project/digital_basketball_league_management_system/
// without needing /public in the URL

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Remove the project subfolder prefix from the URI so Laravel routing works correctly
$base = '/project/digital_basketball_league_management_system';
if (str_starts_with($uri, $base)) {
    $uri = substr($uri, strlen($base));
}

$publicPath = __DIR__ . '/public';

// Serve existing static files (CSS, JS, images) directly
if ($uri !== '/' && file_exists($publicPath . $uri)) {
    return false;
}

// Otherwise hand off to Laravel's front controller
$_SERVER['SCRIPT_FILENAME'] = $publicPath . '/index.php';
$_SERVER['SCRIPT_NAME']     = $base . '/index.php';
$_SERVER['PHP_SELF']        = $base . '/index.php';

chdir($publicPath);
require $publicPath . '/index.php';
