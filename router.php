<?php
// If the request is for an actual existing file (image, CSS, etc), let the server handle it
$path = $_SERVER['DOCUMENT_ROOT'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (is_file($path)) {
    return false; // hand off to the built-in static file server
}

// Otherwise, route everything else to your main entry point
// (for now, serve index.html until you have index.php)
require __DIR__ . '/index.html';
