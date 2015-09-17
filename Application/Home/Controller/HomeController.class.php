<?php
/**
 * Created by PhpStorm.
 * User: Kangyi
 * Date: 2015/1/14
 * Time: 10:09
 */

namespace Home\Controller;

use Think\Controller;

class HomeController extends Controller{
    protected $uid;
    protected $user;

    protected function _initialize(){
        $this->uid = session('uid');
        if (empty( $this->uid) ) {
            $this->redirect('Login/index');
        }else{
            $this->user = session('user');
            $this->assign('user',$this->user);
        }
    }
}