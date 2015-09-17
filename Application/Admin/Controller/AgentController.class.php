<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/3/24
 * Time: 10:51
 */

namespace Admin\Controller;


class AgentController extends AdminController{
    protected function _initialize(){
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

        $AgentModel = D('agent');

        $list = $AgentModel->getList($page,$rows);
        $count = $AgentModel->getCount();

        $result['total'] = $count;
        if(!$list){ $list = ''; }
        $result["rows"] = $list;
        $this->ajaxReturn($result,'JSON');
    }

    public function add(){
        $this->assign('uniqid',uniqid());
        if(IS_POST){
            $Model = D('agent');
            $data['name'] = I('name');
            $data['username'] = I('username');
            $data['password'] = I('password');
            $result = $Model->insert($data);
            $this->ajaxReturn($result,'JSON');
        }else{
            $this->display();
        }
    }

    public function edit(){
        $this->assign('uniqid',uniqid());
        $Model = D('agent');
        if(IS_POST){
            $data['id'] = I('id');
            //$data['username'] = I('username');
            $data['name'] = I('name');
            $data['password'] = I('password');
            $data['status'] = I('status');
            $result = $Model->edit($data);
            $this->ajaxReturn($result,'JSON');
        }else{
            $info = $Model->getInfo(I('id'));
            $this->assign('info',$info);
            $this->display();
        }
    }
}