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

class CashierController extends HomeController{

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
        $Model = D('cashier');
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
            $Model = D('cashier');
            $data['uid'] = $this->uid;
            $data['cashier_name'] = I('cashier_name');
            $data['cashier_no'] = I('cashier_no');
            $data['password'] = I('password');
            $result = $Model->insert($data);
            $this->ajaxReturn($result,'JSON');
        }else{
            $this->display();
        }
    }

    public function remove(){
        $Model = D('cashier');
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
        $Model = D('cashier');
        if(IS_POST){
            $data['id'] = I('id');
            $data['uid'] = $this->uid;
            $data['cashier_name'] = I('cashier_name');
            $data['cashier_no'] = I('cashier_no');
            $data['password'] = I('password');
            $data['status'] = I('status');
            $result = $Model->edit($data);
            $this->ajaxReturn($result,'JSON');
        }else{
            $info = $Model->getInfo(I('id'),$this->uid);
            $this->assign('info',$info);
            $this->display();
        }
    }
}
