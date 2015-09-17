<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/3/23
 * Time: 10:14
 */

namespace Agent\Model;


use Think\Model;

class OrderModel extends Model{

    public function getList($where,$page = NULL,$rows = NULL)
    {
        $ViewModel = D('OrderView');
        $ViewModel->where($where)->order("id DESC");
        if($page && $rows){
            $first_limit = ($page-1) * $rows;
            $ViewModel->limit($first_limit,$rows);
        }
        $list = $ViewModel->select();
        return $list;
    }

    public function getOrderCount($where){
        $ViewModel = D('OrderView');
        $count = $ViewModel->where($where)->count('Orders.id');
        return $count;
    }

    public function getListGroupUID($where){
        $ViewModel = D('OrderView');
        $field = 'uid,user_name,COUNT(1) AS nums,SUM(total_fee) AS total_fee';
        $where['_string'] = "result_code='ORDER_SUCCESS_PAY_SUCCESS'
            or (result_code='ORDER_SUCCESS_PAY_INPROCESS' and (trade_status='TRADE_SUCCESS'or trade_status='TRADE_FINISHED' or trade_status='TRADE_PENDING'))";
        $list = $ViewModel->field($field)->where($where)->group('uid')->order("uid DESC")->select();
        return $list;
    }

    public function getSum($where){
        $ViewModel = D('OrderView');
        $field = 'COUNT(1) AS nums,SUM(total_fee) AS total_fee';
        $where['_string'] = "result_code='ORDER_SUCCESS_PAY_SUCCESS'
            or (result_code='ORDER_SUCCESS_PAY_INPROCESS' and (trade_status='TRADE_SUCCESS'or trade_status='TRADE_FINISHED' or trade_status='TRADE_PENDING'))";
        $all = $ViewModel->field($field)->where($where)->find();
        return $all;
    }
}