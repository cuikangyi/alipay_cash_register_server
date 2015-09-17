<?php
/**
 * Created by PhpStorm.
 * User: Kangyi
 * Date: 2015/1/14
 * Time: 11:23
 */

namespace Home\Controller;
use Think\Controller;
use Think\Model;

class DeviceController extends HomeController{

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
        $list = $Model->getList($this->uid,$page,$rows);
        $count = $Model->getCount($this->uid);
        $result['total'] = $count;
        if(!$list){ $list = ''; }
        $result["rows"] = $list;
        $this->ajaxReturn($result,'JSON');

    }

    public function add(){
        $this->assign('uniqid',uniqid());
        if(IS_POST){
            $Model = D('device');
            $data['uid'] = $this->uid;
            $data['device_name'] = I('device_name');
            $result = $Model->insert($data);
            $this->ajaxReturn($result,'JSON');
        }else{
            $this->display();
        }
    }



    public function remove(){
        $Model = D('device');
        $id = I('id');
        $rs = $Model->remove($id,$this->uid);
        if($rs){
            $result['success'] = true;
        }else{
            $result['success'] = false;
        }
        $this->ajaxReturn($result,'JSON');
    }

    public function edit(){
        $this->assign('uniqid',uniqid());
        $Model = D('device');
        if(IS_POST){
            $data['id'] = I('id');
            $data['uid'] = $this->uid;
            $data['device_name'] = I('device_name');
            $data['status'] = I('status');
            $result = $Model->edit($data);
            $this->ajaxReturn($result,'JSON');
        }else{
            $info = $Model->getInfo(I('id'),$this->uid);
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function resetNo(){
        $Model = D('device');
        $id = I('id');
        $uid = $this->uid;
        $result = $Model->resetNo($id,$uid);
        $this->ajaxReturn($result,'JSON');
    }
}