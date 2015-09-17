<?php
/**
 * Created by PhpStorm.
 * User: Kangyi
 * Date: 2015/1/14
 * Time: 10:08
 */

namespace Admin\Controller;
use Think\Controller;

class LoginController extends  Controller{

    public function index(){
        if (IS_POST) {
            $UserDB = M('admin')    ;
            $where['username'] = I('username');
            $where['password'] = md5(I('password'));

            $user = $UserDB->where($where)->find();
            if($user){
                session('uid',$user['id']);
                session('user',$user);
                $this->redirect('Index/index');
            }else{
                $this->error('用户名或密码错误');
            }
        }else{
            $this->display();
        }
    }

    public function logout(){
        session_destroy();
        $this->success('退出成功',U('Index/index'));
    }
}