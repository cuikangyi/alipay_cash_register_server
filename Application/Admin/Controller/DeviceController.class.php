<?php
/**
 * Created by PhpStorm.
 * User: Kangyi
 * Date: 2015/1/14
 * Time: 11:23
 */

namespace Admin\Controller;
use Think\Controller;
use Think\Model;

class DeviceController extends AdminController{

    public function  _initialize(){
        parent::_initialize();
    }

    public function index(){
        $this->assign('uniqid',uniqid());
        $this->display();
    }

    public function getList(){
        //分页
        $page = I('page');
        $rows = I('rows');
        if(!$page){
            $page = NULL;
            $rows = NULL;
        }
        $Model = D('device');
        $where = NULL;

        $uid = I('uid');
        if($uid){
            $where['uid'] = $uid;
        }

        $list = $Model->getList($where,$page,$rows);
        $count = $Model->getCount($where);
        $result['total'] = $count;
        if(!$list){ $list = ''; }
        $result["rows"] = $list;
        $this->ajaxReturn($result,'JSON');
    }
}