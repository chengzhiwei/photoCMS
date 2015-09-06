<?php

namespace Org\Helper;

/**
 * 无限级分类
 */
class Unlimitedclass
{

    public static function cateresult(&$list, $pid = 0, $level = 0, $html = '--')
    {
        static $tree = array();
        foreach ($list as $v)
        {
            if ($v['pid'] == $pid)
            {
                $v['html'] = str_repeat($html, $level);
                $v['deep'] = $level;
                $tree[] = $v;
                self::cateresult($list, $v['id'], $level + 1);
            }
        }
        return $tree;
    }

    public static function catearray(&$list, $pid = 0)
    {
        $tree = array();
        foreach ($list as $v)
        {
            if ($v['pid'] == $pid)
            {
                $v['child'] = $this->catearray($list, $v['id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }

}
