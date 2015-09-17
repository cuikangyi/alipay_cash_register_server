<?php
namespace YunfuApi\Controller;
use Think\Controller;

class CashierController extends YunfuApiController {
	
	protected function  _initialize(){
		parent::_initialize();
	}
	
	public function getAllCashiers(){
		$where['uid'] = $this->uid;
		$where['status'] = array('eq',1);

		$cashiers = M('cashier')->where($where)->field('cashier_name')->select();
		returnXml($cashiers);
	}
	
	public function login(){
		$where['uid'] = $this->uid;
		$where['cashier_name'] = I('cashier_name');
		$where['password'] = I('password');

		if(!$where['cashier_name'] || !$where['password']){
			$result['is_success'] = 'F';
			$result['error_msg'] = '用户名或密码为空';
			returnXml($result);
		}
		$cashier = M('cashier')->where($where)->find();
		if($cashier){
			$result['is_success'] = 'T';
			$result['cashier_id'] = $cashier['id'];
			$result['cashier_no'] = $cashier['cashier_no'];
			returnXml($result);
		}else{
			$result['is_success'] = 'F';
			$result['error_msg'] = '密码错误';
			returnXml($result);
		}
	}

	public function update(){
		$where['uid'] = $this->uid;
		$where['cashier_name'] = I('cashier_name');
		$where['password'] = I('password');
		$newpassword = I('newpassword');
		$repassword = I('repassword');
		if($newpassword != $repassword){
			$result['is_success'] = 'F';
			$result['error_msg'] = '两次密码不一致';
			returnXml($result);
		}
		if(!$where['cashier_name'] || !$where['password']){
			$result['is_success'] = 'F';
			$result['error_msg'] = '用户名或密码为空';
			returnXml($result);
		}
		$cashier = M('cashier')->where($where)->find();
		if($cashier){
			M('cashier')->where('id='.$cashier['id'])->save(array('password' => $newpassword ));
			$result['is_success'] = 'T';
			returnXml($result);
		}else{
			$result['is_success'] = 'F';
			$result['error_msg'] = '密码错误';
			returnXml($result);
		}
	}
}