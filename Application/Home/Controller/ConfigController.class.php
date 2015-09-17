<?php
/**
 * Created by PhpStorm.
 * User: Kangyi
 * Date: 2015/1/14
 * Time: 11:23
 */

namespace Home\Controller;
use Think\Controller;

class ConfigController extends HomeController{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index(){
        $this->display();
    }

    public function getConfig(){
        $Model = M('config');
        $where['uid'] = $this->uid;
        $config = M('config')->where($where)->find();
        if($config){
            $result['success'] = true;
            $result['config'] = $config;
        }else{
            $result['success'] = false;
        }
        exit(json_encode($result));
    }

    public function setConfig(){
        $where=array('uid'=>$this->uid);
        $configdb = M('config');
        $config = $configdb->where($where)->find();
        if(IS_POST){
            $row['uid']=$this->uid;
            $row['email'] = trim(I('email'));
            $row['partner'] = trim(I('partner'));
            $row['pkey'] = trim(I('pkey'));
            $row['pname'] = trim(I('pname'));
            if ($config){
                $configdb->where($where)->save($row);
            }else {
                $configdb->add($row);
            }
            $result['success'] = true;
            exit(json_encode($result));

            //$this->success('设置成功');
        }
    }
}