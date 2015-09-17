<?php
/**
 * Created by PhpStorm.
 * User: Kangyi
 * Date: 2015/1/26
 * Time: 10:21
 */

namespace Home\Controller;
use Think\Controller;

class SafeController extends HomeController{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index(){
        $this->display();
    }

    public function changePwd(){
        if(IS_POST){
            $where['id'] = $this->uid;
            $user = M('user')->where($where)->find();

            $oldpassword = I('oldpassword');
            if(md5($oldpassword) != $user['password']){
                $result['success'] = false;
                $result['message'] = '原密码不正确！';
                $this->ajaxReturn($result,'JSON');
            }
            $password = I('password');
            $repassword = I('repassword');
            if($password != $repassword){
                $result['success'] = false;
                $result['message'] = '两次密码不一致！';
                $this->ajaxReturn($result,'JSON');
            }
            $data['password'] = md5($password);
            $rs = M('admin')->where($where)->save($data);
            if($rs){
                $result['success'] = true;
                $result['message'] = '密码修改成功';
            }else{
                $result['success'] = false;
                $result['message'] = '密码修改失败';
            }
            $this->ajaxReturn($result,'JSON');
        }
    }
}