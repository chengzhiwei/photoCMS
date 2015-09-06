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

namespace Model;

class PluginListModel extends \Think\Model\AdvModel
{

    public function addlist($dataList)
    {
        return $this->addAll($dataList);
    }

    public function selByTypePid($type, $pid)
    {
        $condition = array(
            'type' => $type,
            'pid' => $pid,
        );
        return $this->where($condition)->select();
    }

    /**
     * 根据插件ID 删除
     * @param int $pid
     * @return boolean
     */
    public function delbypid($pid)
    {
        return $this->where(array('pid' => $pid))->delete();
    }

    public function selByPid($pid)
    {
        $condition = array(
            'pid' => $pid,
        );
        return $this->where($condition)->select();
    }

    public function edit($data, $id)
    {
        if (!$data)
        {
            $data = I('post.');
        }
        if ($this->create($data, 2))
        {
            $condition = array('id' => $id);
            return $this->where($condition)->save();
        } else
        {
            return false;
        }
    }

}
