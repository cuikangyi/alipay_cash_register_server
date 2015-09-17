<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/3/24
 * Time: 10:51
 */

namespace Admin\Controller;


class UserController extends AdminController{
    
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

        $Model = D('user');
        $where = null;
        $agent_id = I('agent_id');
        if($agent_id != ''){
            $where['agent_id'] = $agent_id;
        }
        $list = $Model->getList($where,$page,$rows);
        $count = $Model->getCount($where);

        $result['total'] = $count;
        if(!$list){ $list = ''; }
        $result["rows"] = $list;
        $this->ajaxReturn($result,'JSON');
    }

    public function add(){
        $this->assign('uniqid',uniqid());
        $Model = D('user');
        if(IS_POST){
            $data['name'] = I('name');
            $data['username'] = I('username');
            $data['password'] = I('password');
            $data['agent_id'] = I('agent_id');
            $result = $Model->insert($data);
            $this->ajaxReturn($result,'JSON');
        }else{
            $this->display();
        }
    }

    public function edit(){
        $this->assign('uniqid',uniqid());
        $Model = D('user');
        if(IS_POST){
            $data['id'] = I('id');
            //$data['username'] = I('username');
            $data['name'] = I('name');
            $data['password'] = I('password');
            $data['agent_id'] = I('agent_id');
            $result = $Model->edit($data);
            $this->ajaxReturn($result,'JSON');
        }else{
            $info = $Model->getInfo(I('id'));
            $this->assign('info',$info);
            $this->display();
        }
    }
}