<?php

namespace Model;

class AdminRoleModel extends \Think\Model\AdvModel
{

    public function pladd($datalist)
    {
        if ($this->addAll($datalist))
        {
            return TRUE;
        } else
        {
            return false;
        }
    }

}
