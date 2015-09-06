<?php


function curl_post($data, $url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
// 这一句是最主要的
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); //timeout on connect add by jobsen
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout on response add by jobsen
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $response;
}

//父级栏目
function parentcate($cid = '')
{
    if (!$cid)
    {
        $cid = I('get.cid');
    }
    $c_mod = DD('Category');
    $parent_info = $c_mod->selectF($cid);
    foreach ($parent_info as $k => $v)
    {
        if ($v['type'] == 1)
        {
            $v['href'] = $v['link'];
        } else
        {
            if ($v['mid'] == 3)//单页面模型
            {
                $v['href'] = ROU('Content/Content/page', array('cid' => $v['id']));
            } else
            {
                if ($v['isleaf'] == 1)//子级调用list
                {
                    $v['href'] = ROU('Content/Content/newslist', array('cid' => $v['id']));
                } else //父级调用CATEGORY
                {
                    $v['href'] = ROU('Content/Content/category', array('cid' => $v['id']));
                }
            }
        }
        $parent_info[$k] = $v;
    }
    return $parent_info;
}

function childcate($cid = '')
{
    if (!$cid)
    {
        $cid = I('get.cid');
    }
    $c_mod = DD('Category');
    $chind_info = $c_mod->selectS($cid);
    foreach ($chind_info as $k => $v)
    {
        if ($v['type'] == 1)
        {
            $v['href'] = $v['link'];
        } else
        {
            if ($v['mid'] == 3)//单页面模型
            {
                $v['href'] = ROU('Content/Content/page', array('cid' => $v['id']));
            } else
            {
                if ($v['isleaf'] == 1)//子级调用list
                {
                    $v['href'] = ROU('Content/Content/newslist', array('cid' => $v['id']));
                } else //父级调用CATEGORY
                {
                    $v['href'] = ROU('Content/Content/category', array('cid' => $v['id']));
                }
            }
        }
        $chind_info[$k] = $v;
    }
    return $chind_info;
}

function nowcate($id, $class)
{
    echo "class='" . $class . "'";
}

//所有菜单 只含有显示部分
function allmenu()
{

    if (!S('menu'))
    {
        $Category = DD('Category');
        $result = $Category->selectByShow(1);
        foreach ($result as $key => $v)
        {
            if ($v['type'] == 1)
            {
                $v['href'] = $v['link'];
            } else
            {
                if ($v['mid'] == -1)//单页面模型
                {
                    $v['href'] = \Org\Helper\Route::CUrl('Content/Content/page', array('cid' => $v['id']));
                } else
                {
                    if ($v['isleaf'] == 1)//子级调用list
                    {
                        $v['href'] = \Org\Helper\Route::CUrl('Content/Content/newslist', array('cid' => $v['id']));
                    } else //父级调用CATEGORY
                    {
                        $v['href'] = \Org\Helper\Route::CUrl('Content/Content/category', array('cid' => $v['id']));
                    }
                }
            }
            $result[$key] = $v;
        }

        S('menu', $result);
    } else
    {
        $result = S('menu');
    }
    return $result;
}

function build_tree($rows, $root_id)
{
    $childs = findChild($rows, $root_id);
    if (empty($childs))
    {
        return null;
    }
    foreach ($childs as $k => $v)
    {
        $rescurTree = build_tree($rows, $v['id']);
        if (null != $rescurTree)
        {
            $childs[$k]['child'] = $rescurTree;
        }
    }
    return $childs;
}

function findChild(&$arr, $id)
{

    $childs = array();
    foreach ($arr as $k => $v)
    {
        if ($v['pid'] == $id)
        {
            $childs[] = $v;
        }
    }
    return $childs;
}

//获取栏目
function getmenu($pid = 0)
{
    if (!S('menu_' . $pid))
    {
        $res = allmenu();
        $menu = build_tree($res, $pid);
        S('menu_' . $lid . '_' . $pid, $menu);
    } else
    {

        $menu = S('menu_' . $lid . '_' . $pid);
    }

    return $menu;
}

function getchildids($cid)
{
    if (!S('childs_' . $cid))
    {
        $catemod = DD('Category');
        $info = $catemod->selectF($cid);
        $menu = allmenu($info['langid']);
        $cids = deepchildids($menu, $cid) . $cid;
        S('childs_' . $cid, $cids);
        return $cids;
    } else
    {
        return S('childs_' . $cid);
    }
}

function deepchildids($rows, $root_id)
{
    static $childids = '';
    $childs = findChild($rows, $root_id);
    if (empty($childs))
    {
        return null;
    }
    foreach ($childs as $k => $v)
    {
        deepchildids($rows, $v['id']);
        $childids.=$v['id'] . ',';
    }
    return $childids;
}

/**
 * 设置当前选择栏目的样式
 * @param int $id
 * @param string $cls
 */
function setcur($id, $cls = 'cur')
{
    $cid = I('get.cid');
    $crumbs = \Common\Cls\ContentCls::breadcrumbs($cid);
    foreach ($crumbs as $c)
    {
        if ($id == $c['id'])
        {
            echo $cls;
            break;
        }
    }
}

function samechildcate($cid)
{
    $arr = getmenu($cid);
    if (!$arr)
    {
        $catemod = DD('Category');
        $info = $catemod->selectF($cid);
        $arr = getmenu($info['pid']);
    }
    return $arr;
}
