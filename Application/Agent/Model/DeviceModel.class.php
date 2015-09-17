<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/3/21
 * Time: 8:33
 */

namespace Agent\Model;

use Think\Model;

class DeviceModel extends Model
{
    /**
     * 根据uid获取设备列表
     * @param $where
     * @param int $page 默认为NULL 不分页
     * @param int $rows 默认为NULL 不分页
     * @return array 列表
     */
    public function getList($where,$page = NULL,$rows = NULL)
    {
        $ViewModel = D('DeviceView');
        $ViewModel->where($where);
        $ViewModel->order("status DESC,id DESC");
        if($page && $rows){
            $first_limit = ($page-1) * $rows;
            $ViewModel->limit($first_limit,$rows);
        }
        $list = $ViewModel->select();
        return $list;
    }

    /**
     * 根据用户uid获取设备数量
     * @param $where
     * @return int 数量
     */
    public function getCount($where){
        $Model = M('device');
        $count =  $Model->where($where)->count('id');
        return $count;
    }
}