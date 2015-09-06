<?php

namespace Common\Controller;

class AdminbaseController extends \Think\Controller
{

    public $OpSiteLangInfo = array();
    public $AdminLang = '';

    public function __construct()
    {
        parent::__construct();
        if (!defined(TMPL_PATH))
        {
            define('TMPL_PATH', C('TMPL_PATH') . '/' . C('ADMIN_APP_NAME') . '/' . C('ADMIN_THEME') . '/');
            define('ADMIN_CSS_PATH', __ROOT__ . '/' . TMPL_PATH . 'Layout/Css/');
            define('ADMIN_JS_PATH', __ROOT__ . '/' . TMPL_PATH . 'Layout/Js/');
            define('ADMIN_IMG_PATH', __ROOT__ . '/' . TMPL_PATH . 'Layout/Images/');
            define('ADMIN_LAYOUT', C('TMPL_PATH') . '/' . C('ADMIN_APP_NAME') . '/' . C('ADMIN_THEME') . '/');
        }
    }

}
