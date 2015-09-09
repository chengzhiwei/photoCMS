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

namespace Content\Controller;

class ModelController extends \Auth\Controller\AuthbaseController
{

    /**
     * 模型列表
     */
    public function index()
    {
        $mod = DD('Model');
        $modellist = $mod->selectall();
        $this->assign('modellist', $modellist);
        $this->display();
    }

    /**
     * 添加模型
     */
    public function addmodel()
    {
        if (IS_POST)
        {
            $mod = DD('Model');
            $mod->startTrans();
            $ModelField = DD('ModelField');
            $addmodel = $mod->addmodel();
            $mid = $mod->getLastInsID();
            $addtable = $mod->createTbl(I('post.table'));
            $addfield = $ModelField->addDefaultField($mid);
            if ($addmodel && $addtable && $addfield)
            {
                $mod->commit();
                $this->success('添加成功');
            } else
            {
                $mod->rollback();
                $this->error('发生错误请重试');
            }
        } else
        {

            $this->display();
        }
    }

    public function fields()
    {
        $mid = I('mid');
        $ModelField = DD('ModelField');
        $fields = $ModelField->selFieldByMid($mid);
        $this->assign('fields', $fields);
        $this->display();
    }

    public function addfield()
    {
        if (IS_POST)
        {
            //判断是否存在相同的字段
            $fieldMod = DD('ModelField');
            $fieldinfo = $fieldMod->findByMidFiled(I('post.mid'), I('post.fieldname'));
            if ($fieldinfo)
            {
                $this->error('已存在相同字段');
            }
            //添加模型字段
            $fieldMod->startTrans();
            //添加模型表字段
            $addmodelfile = $fieldMod->addField();
            $addtablefile = $fieldMod->addtablefield();
            if ($addmodelfile !== false && $addtablefile !== false)
            {
                $fieldMod->commit();
                $this->success('添加成功');
            } else
            {
                $fieldMod->rollback();
                $this->error('发生错误，请重试');
            }
        } else
        {
            $plugin = DD('Plugin');
            $pluginlist = $plugin->select();
            $Mod = DD('Model');
            $modelinfo = $Mod->findByID(I('mid'));
            $this->assign('modelinfo', $modelinfo);
            $this->assign('pluginlist', $pluginlist);
            $this->assign('mid', I('mid'));
            $this->display();
        }
    }

    public function getvook()
    {
        if (IS_AJAX)
        {
            $pid = I('post.pid');
            $pluginMod = DD('Plugin');
            $plugininfo = $pluginMod->findbyid($pid);
            $hooklist = DD('HookList');
            $list = $hooklist->selbypid($pid);
            echo json_encode($list);
        }
    }

    public function fieldsort()
    {
        $id = I('post.fid');
        $sort = I('post.sort');
        $ModelFieldMod = DD('ModelField');
        $b = $ModelFieldMod->sort($id, $sort);
        if ($b)
        {
            echo '1';
        } else
        {
            echo '-1';
        }
    }

    public function delfield()
    {
        $id = I('get.id');
        $fieldMod = DD('ModelField');
        $fieldinfo = $fieldMod->find($id);
        //删除语言
        $setLang = new \Org\Helper\SetLang('Content/modelfield', true);
        $b = $setLang->delOneLang($fieldinfo['langconf']);
        $Model = DD('Model');
        $modelinfo = $Model->findByID($fieldinfo['mid']);
        //删除模型字段
        $ModelFieldDel = $fieldMod->delfield($id);
        //删除表字段
        $TableFieldDel = $fieldMod->delTableField($modelinfo['table'], $fieldinfo['filename']);
        if ($ModelFieldDel)
        {
            $this->redirect('Content/Model/fields', array('mid' => $fieldinfo['mid']));
        } else
        {
            $this->error(L('OP_ERROR'));
        }
    }

    /**
     * 修改字段
     */
    public function editfield()
    {
        if (IS_POST)
        {
            $fieldMod = DD('ModelField');
            $b = $fieldMod->updatefield(I('post.id'));
            if ($b)
            {
                $this->success(L('OP_SUCCESS'));
            } else
            {
                $this->error(L('OP_ERROR'));
            }
        } else
        {
            $id = I('get.id');
            $fieldMod = DD('ModelField');
            $fieldinfo = $fieldMod->find($id);
            \Org\Helper\IncludeLang::QuickInc('Content/modelfield');
            //查询控件
            $plugin = $fieldinfo['plugin'];
            if ($plugin != '')
            {
                $plugin_arr = explode('/', $plugin);
                $method = $plugin_arr[count($plugin_arr) - 1];
                unset($plugin_arr[count($plugin_arr) - 1]);
                $path = implode('/', $plugin_arr);
                $hooklistmod = DD('HookList');
                //加载插件语言库
                $hookinfo = $hooklistmod->findByPathMethod($path, $method);
                \Org\Helper\IncludeLang::QuickInc($plugin_arr[0] . '/' . $plugin_arr[count($plugin_arr) - 1], 'Plugin');
                $this->assign('hookinfo', $hookinfo);
            }

            $pluginMod = DD('Plugin');
            $pluginlist = $pluginMod->select();
            foreach ($pluginlist as $p)
            {
                \Org\Helper\IncludeLang::QuickInc($p['filetitle'] . '/' . $p['filetitle'], 'Plugin');
            }

            $this->assign('pluginlist', $pluginlist);
            $this->assign('fieldinfo', $fieldinfo);
            $this->display();
        }
    }

    /**
     * 删除模型
     */
    public function delmodel()
    {
        $id = I('get.id');
        $mod = DD('Model');
        $fieldmod = DD('ModelField');
        $modinfo = $mod->findByID($id);
        $fields = $fieldmod->selFieldByMid($id);
        if ($modinfo['issys'] != 1)
        {
            $mod->startTrans();
            //删除字段 
            $delfield = $fieldmod->delByMid($id);
            //删除模型数据
            $delmod = $mod->delByID($id);
            //删除表
            $deltable = $mod->dropTbl($modinfo['table']);
            if ($delfield && $delmod && $deltable)
            {
                //删除语言
                $setLang = new \Org\Helper\SetLang('Content/modelfield', true);
                $lang = array();
                foreach ($fields as $v)
                {
                    if ($v['issys'] == 1)
                        continue;
                    $lang[] = $v['langconf'];
                }
                $setLang->delAllLang($lang);
                $setLang->setLangFilePath('Content/model', true);
                $setLang->delOneLang('MDL_' . strtoupper($modinfo['table']));
                $mod->commit(); //事务提交
                $this->redirect('Content/Model/index');
            } else
            {
                $mod->rollback();
                $this->error('OP_ERROR');
            }
        }
    }

}
