<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace YunfuApi\Controller;
use Think\Controller;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class OrderController extends YunfuApiController {

	protected function  _initialize(){
		parent::_initialize();
	}

	public function getOrderCount(){
		$where['uid'] = $this->uid;
		$where['device_id'] = $this->device_id;

		$orderdb = M('order'); // 实例化User对象
		$count = $orderdb->where($where)->count();// 查询满足要求的总记录数

		$result['is_success'] = 'T';
		$result['count'] = $count;
		returnXml($result);
	}

    public function getOrderLists(){
    	$where['uid'] = $this->uid;
    	$where['device_id'] = $this->device_id;
    	$pageIndex = I('selPageIndex');
    	$pageSize = I('selPageSize');
    	if(!$pageIndex){
			$pageIndex = 1;
    	}
    	if(!$pageSize){
			$pageSize = 10;
    	}
    	$orderdb = D('OrderView'); // 实例化User对象
		$count = $orderdb->where($where)->count();// 查询满足要求的总记录数
		//echo $count.'*';
		$list = $orderdb->where($where)->order('gmt_create desc')->page($pageIndex,$pageSize)->select();
		//echo  $orderdb->getLastSql()."<br>";
		returnXml($list);
    }

	public function getOrderDetail(){
		$where['uid'] = $this->uid;
		$where['out_trade_no'] = I('out_trade_no');

		$order = M('order')->where($where)->find();

		if($order){
			$result['is_success'] = "T";
			$result['order'] = $order;
		}else{
			$result['is_success'] = "F";
		}
		returnXml($result);
	}
}