<?php


if (version_compare(PHP_VERSION, '5.3.0', '<'))
    die('require PHP > 5.3.0 !');

// 开启调试模式
define('APP_DEBUG', TRUE);

define('APP_NAME', 'App');
//缓存目录
define('RUNTIME_PATH', 'Runtime/App/');
// 定义应用目录
define('APP_PATH', 'App/');

define('DS', DIRECTORY_SEPARATOR);

require './Core/Core.php';
