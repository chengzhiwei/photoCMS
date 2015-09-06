<?php
/*
 * +----------------------------------------------------------------------
 * | DreamCMS [ WE CAN  ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2006-2014 DreamCMS All rights reserved.
 * +----------------------------------------------------------------------
 * | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * +----------------------------------------------------------------------
 * | Author: 孔雀翎 <284909375@qq.com>
 * +----------------------------------------------------------------------
 */
namespace Modules\Controller;

/**
 * 留言本
 */
class GuestbookController extends \Auth\Controller\AuthbaseController {

    public function index() {
        $gb = DD('Guestbook');
        $result = $gb->guestlist();
        $this->assign('result', $result);
        $this->display();
    }

    public function del() {
        $data = I('get.');
        $gb = DD('Guestbook');
        $result = $gb->del($data['id']);
        $this->redirect('index');
    }
}
