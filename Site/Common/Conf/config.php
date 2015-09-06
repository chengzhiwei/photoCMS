<?php

$lang_config = require("Config/langset.php");
$mysql_config = require("Config/config.php");
$site_config = array(
    'DEFAULT_MODULE' => 'Content', // 默认模块
    'DEFAULT_CONTROLLER' => 'Content', // 默认模块
    'LAYOUT_ON' => false,
    'VAR_LANGUAGE' => 'l',
    'LANG_AUTO_DETECT' => true,
    'URL_MODEL' => 1,
    'URL_ROUTER_ON' => true,
    // 'MODULE_ALLOW_LIST' => array('Content', 'Component', 'Spldem'),
    'SITE_THEME' => 'BootStrap',
    'URL_ROUTE_RULES' => include  'Config/router.php',
);
return array_merge($site_config, $mysql_config, $lang_config);
