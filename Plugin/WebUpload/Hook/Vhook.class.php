<?php

namespace WebUpload\Hook;

import('Common/Controller/SitevhookController', 'Plugin');

class Vhook extends \Common\Controller\SitevhookController
{

    public function multiimgupload()
    {
        $this->display('multiimgupload');
    }

    public function multifileupload()
    {
        $this->display('multifileupload');
    }

    public function thumbupload($arr = array())
    {
        $this->assign('data', $arr);
        $this->display('thumbupload');
    }

}
