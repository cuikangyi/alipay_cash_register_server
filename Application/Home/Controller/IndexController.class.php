<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends HomeController {
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index(){
        $this->display();
    }

    public function chartData(){
        $Model = M('Order');
        $where['uid'] = $this->uid;
        $success_sql = "result_code='ORDER_SUCCESS_PAY_SUCCESS'
            or (result_code='ORDER_SUCCESS_PAY_INPROCESS' and (trade_status='TRADE_SUCCESS'or trade_status='TRADE_FINISHED' or trade_status='TRADE_PENDING'))";
        $where['_string'] = $success_sql;
        $field = array('substr(gmt_create,6,5)'=>'days','COUNT(id)'=>'nums','SUM(total_fee)'=>'total_fee');
        $list = $Model->field($field)->where($where)->group("LEFT( gmt_create, 10)")->order("LEFT( gmt_create, 10) desc")->limit(10)->select();
        $total_count = $Model->where($where)->count('id');
        $total_fee = $Model->where($where)->sum('total_fee');

        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        $where['gmt_create'] = array(array('gt',date("Y-m-d H:i:s",$beginToday)),array('lt',date("Y-m-d H:i:s",$endToday)));

        $day_count = $Model->where($where)->count('id');
        $day_fee = $Model->where($where)->sum('total_fee');
        if(!$day_fee){$day_fee = '0';}

        $result['day_count'] = $day_count;
        $result['day_fee'] = $day_fee;
        $result['total_count'] = $total_count;
        $result['total_fee'] = $total_fee;
        $result['list'] = $list;
        $this->ajaxReturn($result,'JSON');
    }
}