<?php
/**
 * Created by PhpStorm.
 * User: Kangyi
 * Date: 2015/1/14
 * Time: 11:23
 */

namespace Agent\Controller;

use Think\Controller;
use Think\Model;

class OrderController extends AgentController
{

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index(){
        $this->assign('uniqid',uniqid());
        $this->display();
    }

    public function getList()
    {
        $where = NULL;
        $where['agent_id'] = $this->uid;
        //uid
        $uid = I('uid');
        if($uid){
            $where['uid'] = $uid;
        }

        //时间
        $start_time = I('start_time');
        $end_time = I('end_time');
        if ($start_time && $end_time) {
            $where['gmt_create']  = array('between',array($start_time,$end_time));
        }elseif($start_time){
            $where['gmt_create'] = array('egt',$start_time);
        }elseif($end_time){
            $where['gmt_create'] = array('elt',$end_time);
        }

        //金额
        $start_fee = I('start_fee') ;
        $end_fee = I('end_fee') ;
        if($start_fee != '' && $end_fee!= ''){
            $where['total_fee'] =   array('between',array($start_fee,$end_fee));
        }elseif($start_fee != ''){
            $where['total_fee'] = array('egt',$start_fee);
        }elseif($end_fee != ''){
            $where['total_fee'] = array('elt',$end_fee);
        }

        //交易状态
        $pay_status = I('pay_status');
        if($pay_status == 'success'){
            $where['_string'] = "result_code='ORDER_SUCCESS_PAY_SUCCESS'
            or (result_code='ORDER_SUCCESS_PAY_INPROCESS' and (trade_status='TRADE_SUCCESS' or trade_status='TRADE_FINISHED' or trade_status='TRADE_PENDING'))";
        }elseif($pay_status == 'fail'){
            $where['_string'] = "result_code='ORDER_SUCCESS_PAY_INPROCESS' and (trade_status='' or trade_status='WAIT_BUYER_PAY' or trade_status='TRADE_CLOSED')";
        }

        //收银员
        $cashier_id = I('cashier_id');
        if($cashier_id){
            $where['cashier_id'] = $cashier_id;
        }
        //收款机
        $device_id = I('device_id');
        if($device_id){
            $where['device_id'] = $device_id;
        }

        //关键词
        $search_key = I('search_key');
        if($search_key != ''){
            $this->assign('search_key',$search_key);
            $search_key_type = I('search_key_type');
            if($search_key_type == "out_trade_no"){
                $where['out_trade_no'] = array('like','%'.$search_key.'%');
            }elseif($search_key_type == "trade_no"){
                $where['trade_no'] = array('like','%'.$search_key.'%');
            }elseif($search_key_type == "buyer_email"){
                $where['buyer_email'] = array('like','%'.$search_key.'%');
            }
        }
        
        $Model = D('order');
        $count = $Model->getOrderCount($where);
        //分页
        $page = I('page');
        $rows = I('rows');
        if(!$page){
            $page = NULL;
            $rows = NULL;
        }
        $list = $Model->getList($where,$page,$rows);

        foreach($list as $k=>$v){
            $list[$k]['pay_status'] = getPayStatus($v['result_code'],$v['trade_status']);
        }
        $result['total'] = $count;
        if(!$list){ $list = ''; }
        $result["rows"] = $list;
        $this->ajaxReturn($result,'json');
    }

    public function countIndex(){
        $this->assign('uniqid',uniqid());
        $this->display();
    }

    public function countOrder(){
        $Model = D('order');
        $where['agent_id'] = $this->uid;

        //时间
        $start_time = I('start_time');
        $end_time = I('end_time');
        if ($start_time && $end_time) {
            $where['gmt_create']  = array('between',array($start_time,$end_time));
        }elseif($start_time){
            $where['gmt_create'] = array('egt',$start_time);
        }elseif($end_time){
            $where['gmt_create'] = array('elt',$end_time);
        }

        $list = $Model->getListGroupUID($where);
        $all = $Model->getSum($where);
        $list[] = array('user_name'=>'总计','total_fee'=>$all['total_fee'],'nums'=>$all['nums']);
        $this->ajaxReturn($list,'JSON');
    }
}