<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/3/21
 * Time: 8:33
 */

namespace Home\Model;

use Think\Model;

class CashierModel extends Model
{
    protected $_validate = array(
        array('uid', 'require', '获取用户信息错误！'),
        array('cashier_name', 'require', '收银员姓名必须填写！'),
        array('cashier_no', 'require', '收银员编号必须填写！'),
        array('password', 'require', '密码不能为空'),
    );

    protected $_auto =  array(
        array('status','1',self::MODEL_INSERT),
    );

    /**
     * @param $id id
     * @param $uid 用户uid
     * @return obj 信息
     */
    public function getInfo($id,$uid){
        $Model = M('cashier');
        $where['id'] = $id;
        $where['uid'] = $uid;
        $info = $Model->where($where)->find();
        return $info;
    }

    /**
     * 根据uid获取列表
     * @param int $uid 用户uid
     * @param int $page 默认为NULL 不分页
     * @param int $rows 默认为NULL 不分页
     * @return array 列表
     */
    public function getList($uid,$page = NULL,$rows = NULL)
    {
        $Model = M('cashier');
        $where['uid'] = $uid;
        $Model->where($where)->order("status DESC,id DESC");
        if($page && $rows){
            $first_limit = ($page-1) * $rows;
            $Model->limit($first_limit,$rows);
        }
        $list = $Model->select();
        return $list;
    }

    /**
     * 根据用户uid获取数量
     * @param $uid 用户uid
     * @return int 数量
     */
    public function getCount($uid){
        $Model = M('cashier');
        $where['uid'] = $uid;
        $count =  $Model->where($where)->count('id');
        return $count;
    }

    /**
     * 根据用户uid和id删除一条数据
     * @param $id id
     * @param $uid 用户uid
     * @return bool 是否删除
     */
    public function remove($id,$uid){
        $Model = M('cashier');
        $where['uid'] = $uid;
        $where['id'] = $id;
        $rs = $Model->where($where)->delete();
        if($rs){
            return true;
        }else{
            return false;
        }
    }

    public function insert($data){
        $Model = D('cashier');
        if ($Model->create($data)){
            $Model->add();
            $result['success'] = true;
            $result['message'] = '添加成功';
        }else{
            $result['success'] = false;
            $result['message'] = $Model->getError();
        }
        return $result;
    }

    public function edit($data){
        $Model = D('cashier');
        if ($Model->create($data,2)){
            $Model->save();
            $result['success'] = true;
            $result['message'] = '修改成功';
        }else{
            $result['success'] = false;
            $result['message'] = $Model->getError();
        }
        return $result;
    }

}