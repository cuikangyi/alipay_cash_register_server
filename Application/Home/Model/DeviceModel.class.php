<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/3/21
 * Time: 8:33
 */

namespace Home\Model;

use Think\Model;

class DeviceModel extends Model
{
    protected $_validate = array(
        array('uid', 'require', '获取用户信息错误！'),
        array('device_name', 'require', '收款机名称必须填写！'),
        array('device_no', 'require', '收款机号必须填写！'),
        array('device_no', '', '收款机号重复！',0,'unique'),
    );

    protected $_auto =  array(
        array('status','1',self::MODEL_INSERT),
        array('device_no', '', self::MODEL_UPDATE, 'ignore'),
        array('device_no', NULL, self::MODEL_UPDATE, 'ignore'),
    );
    /**
     * @param $id id
     * @param $uid 用户uid
     * @return obj 信息
     */
    public function getInfo($id,$uid){
        $Model = M('device');
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
        $Model = M('device');
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
        $Model = M('device');
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
        $Model = M('device');
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
        $Model = D('device');
        $data['device_no'] = self::getUuid();
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

    private function getUuid(){
        $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
        $uuid = $Model->query("select uuid();");
        return $uuid['0']['uuid()'];
    }

    public function edit($data){
        $Model = D('device');
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

    public function resetNo($id,$uid){
        $Model = M('device');
        $where['id'] = $id;
        $where['uid'] = $uid;
        $data['device_no'] = self::getUuid();
        $rs = $Model->where($where)->setField($data);
        if ($rs){
            $result['success'] = true;
            $result['message'] = '重置成功';
        }else{
            $result['success'] = false;
            $result['message'] = '重置失败';
        }
        return $result;
    }
}