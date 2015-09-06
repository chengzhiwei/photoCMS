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

namespace Org\Helper;

/**
 * 模板操作类
 * 仅用于前台
 */
class TMP
{

    /**
     * 菜单
     * @param int $pid 父级
     * @param int $menushow 是否菜单栏显示
     * @return array
     */
    public static function CATE($pid = 0, $menushow = -1)
    {
        return \getmenu($pid);
    }

    /**
     * 推荐位文章
     * @param int $pid 推荐位编号
     * @param int $cid 分类 5,6,7
     * @param string $limit limit
     * @param int $cache 缓存时间
     * @return array
     */
    public static function POSITION($pid, $cid, $limit, $cache = 3600)
    {
        $Category = DD('Category');
        $Category->findbyid($cid);
    }

    /**
     * 文章列表 
     * @param int $cid 分类
     * @param int $limit limit
     * @param string $sidetable 是否查询附表
     * @param int $cache 缓存时间
     * @return array
     */
    public static function SIMPLEARTICLES($cid, $limit, $sidetable = 0, $cache = 3600)
    {

        $contentdata = self::QCREADCACHE('SIMPLEARTICLES_' . $cid);
        if (!$contentdata)
        {
            $Category = DD('Category');
            $cateinfo = $Category->findbyid($cid);
            $model = DD('Model');
            $modelinfo = $model->findByID($cateinfo['mid']);
            $content = DD('Content', array($modelinfo['table']));
            $contentinfo = $content->SimpleLimit($cid, $limit);
            $contentdata = array();
            $newcontentinfo = array();
            $ids = '';
            foreach ($contentinfo as $k => $c)
            {
                $ids.=$c['id'] . ',';
                $newcontentinfo[$c['id']] = $c;
                $newcontentinfo[$c['id']]['href'] = Route::CUrl('Content/Content/news', array('id' => $c['id'], 'cid' => $cid));
            }
            if ($sidetable == 1)
            {

                //查询副表
                $contentdata = DD('ContentData', $modelinfo['table']);
                $contentdatainfo = $contentdata->selByIds($ids);
                foreach ($contentdatainfo as $c => $d)
                {
                    $contentdata[] = array_merge($newcontentinfo[$d['aid']], $d);
                }
            } else
            {
                $contentdata = $newcontentinfo;
            }
            self::QCWRITECACHE('SIMPLEARTICLES_' . $cid, $contentdata, $cache);
        }
        return $contentdata;
    }

    /**
     * 自定义SQL 语句查询
     * @param string $sql
     */
    public static function QUERY($sql)
    {
        
    }

    /**
     * 执行自定义的SQL语句
     * @param string $sql
     */
    public static function EXECUTE($sql)
    {
        
    }

    /**
     * 快速获取单页面内容 只支持一个
     * @param int $cid 分类ID
     * @return array
     */
    public static function SINGLEPAGE($cid, $cache = 3600)
    {

        $info = self::QCREADCACHE('SINGLEPAGE_' . $cid);
        if (!$info)
        {
            $Page = DD('Page');
            $info = $Page->findbycid($cid);
            self::QCWRITECACHE('SINGLEPAGE_' . $cid, $info);
        }
        return $info;
    }

    /**
     * 快速写缓存
     * @param string $key
     * @param mixed $val
     */
    private static function QCWRITECACHE($key, $val, $cache)
    {
        S($key, $val, $cache);
    }

    /**
     * 快速读缓存
     * @param string $key
     * @return mixed
     */
    private static function QCREADCACHE($key)
    {
        return S($key);
    }

}
