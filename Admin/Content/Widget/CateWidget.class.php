<?php

namespace Content\Widget;

class CateWidget extends \Think\Controller
{

    public function allcate()
    {
        
        $Category = DD('Category');
        $catelist = $Category->select();
        $Category_arr = \Org\Helper\Unlimitedclass::cateresult($catelist);
        $this->assign( 'Category_arr',$Category_arr);
        $this->display('Widget:allcate');
    }

}
