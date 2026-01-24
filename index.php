<?php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$rootPath    = __DIR__ . $uri;
$contentPath = __DIR__ . '/content' . $uri;


// serve static files 
if ($uri !== '/' && file_exists($rootPath) && is_file($rootPath)) {
	return false;
}

// dir exists but no index → 404 
if ($uri === '/') {
	require __DIR__ . '/main_page.php';
	exit;
}


if (file_exists($contentPath) && is_file($contentPath)) {
	$mimeType = mime_content_type($contentPath);

    if ($mimeType === 'text/plain' && pathinfo($contentPath, PATHINFO_EXTENSION) === 'css') {
        $mimeType = 'text/css';
    }
	
	if ($mimeType) {
		header('Content-Type: ' . $mimeType);
	}
	
	readfile($contentPath);
	exit;
}


// dir inside /content → serve its index.php or index.html
if (is_dir($contentPath)) {
	foreach (['index.php', 'index.html'] as $indexFile) {
		$index = $contentPath . '/' . $indexFile;
		if (file_exists($index)) {
			if (pathinfo($index, PATHINFO_EXTENSION) === 'php') {
				require $index;
			} else {
				readfile($index);
			}
			exit;
		}
	}
	http_response_code(404);
	readfile(__DIR__ . '/404.html');
	exit;
}

if (!file_exists($contentPath)) {
	http_response_code(404);
	readfile(__DIR__ . '/404.html');
	exit;
}


require __DIR__ . '/main_page.php';
