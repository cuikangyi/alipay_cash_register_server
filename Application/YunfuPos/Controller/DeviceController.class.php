<?php
/**
 * Created by PhpStorm.
 * User: Kangyi
 * Date: 2015/1/17
 * Time: 11:30
 */

namespace YunfuPos\Controller;
use Think\Controller;

class DeviceController extends Controller{

    public function device(){

        if(!IS_POST){
            $result['is_success'] = 'F';
            $result['error_msg'] = '请求失败';
            returnXml($result);
        }
        $device_no = I('device_no');
        $username = I('username');
        $device_name = I('device_name');
        if(!$device_no){
            $result['is_success'] = 'F';
            $result['error_msg'] = '机器码为空';
            returnXml($result);
        }
        if(!$username){
            $result['is_success'] = 'F';
            $result['error_msg'] = '用户名为空';
            returnXml($result);
        }
        if(!$device_name){
            $result['is_success'] = 'F';
            $result['error_msg'] = '设备名称为空';
            returnXml($result);
        }
        $user = M('user')->where(array('username'=>$username))->find();
        if(!$user){
            $result['is_success'] = 'F';
            $result['error_msg'] = '用户名不存在';
            returnXml($result);
        }else{
            $uid = $user['id'];
        }

        $device = M('device')->where(array('device_no'=>$device_no))->find();
        $data['uid'] = $uid;
        $data['device_name'] = $device_name;
        $data['status'] = 0;
        if($device){
            M('device')->where(array('id'=>$device['id']))->save($data);
        }else{
            $data['device_no'] = $device_no;
            M('device')->data($data)->add();
        }
        $result['is_success'] = 'T';
        returnXml($result);
    }
}