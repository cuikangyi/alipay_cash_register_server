<?php
/**
 * Created by PhpStorm.
 * User: Kangyi
 * Date: 2015/1/14
 * Time: 10:08
 */

namespace Home\Controller;
use Think\Controller;

class LoginController extends  Controller{

    public function index(){
        if (IS_POST) {
            $UserDB = M('user');
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

    private function register(){
        if (IS_POST) {
            $UserDB = M('user');
            $validate = array(
                /* 验证用户名 */
                array('username', 'require', '用户名称必须填写！', 1, ''),
                array('username', '', '用户名称已经存在！', 1, 'unique',1),

                /* 验证密码 */
                array('password','require','用户密码必须填写！',0,''),
                array('repassword','password','两次密码不一致',1,'confirm'),
            );

            $auto = array(
                array('password','md5',3,'function') ,
            );

            if($UserDB->validate($validate)->auto($auto)->create()){
                $uid = $UserDB->add();
                session('uid',$uid);
                $this->success('注册成功',U('Index/index'));
            }else{
                $this->error($UserDB->getError());
            }
        }else{
            $this->assign('title','注册');
            $this->display();
        }
    }

    public function logout(){
        session_destroy();
        $this->success('退出成功',U('Index/index'));
    }
}