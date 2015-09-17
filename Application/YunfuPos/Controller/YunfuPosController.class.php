<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace YunfuPos\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class YunfuPosController extends Controller {
	
	protected $uid;
	protected $device_id;
	
	protected function _initialize(){
		if(!IS_POST){
			$result['is_success'] = 'F';
			$result['error_msg'] = '请求失败';
			returnXml($result);
		}
		$device_no = I('device_no');
		if(!$device_no){
			$result['is_success'] = 'F';
			$result['error_msg'] = '机器码为空';
			returnXml($result);
		}
		$where = array('device_no'=>$device_no);
		$device = M('device')->where($where)->find();
		if($device){
			if($device['status'] == 0){
				$result['is_success'] = 'F';
				$result['error_msg'] = '此设备未启用';
				returnXml($result);
			}
			$this->device_id = $device['id'];
			$this->uid = $device['uid'];
		}else{
			$result['is_success'] = 'F';
			$result['error_msg'] = '找不到机器码';
			returnXml($result);
		}
	}
}
