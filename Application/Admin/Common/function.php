<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/2/16
 * Time: 16:37
 */

function getPayStatus($result_code,$trade_status){
    if($result_code == 'REFUND_SUCCESS'){
        $pay_status= "已退款";
    }elseif($result_code == 'ORDER_SUCCESS_PAY_SUCCESS'){
        $pay_status = "已支付";
    }elseif($result_code == 'ORDER_SUCCESS_PAY_INPROCESS'){
        if($trade_status == 'TRADE_SUCCESS' || $trade_status == 'TRADE_FINISHED' || $trade_status=="TRADE_PENDING"){
            $pay_status = "已支付";
        }else{
            $pay_status = "未付款";
        }
    }else{
        if($trade_status == 'TRADE_SUCCESS' || $trade_status == 'TRADE_FINISHED' || $trade_status=="TRADE_PENDING"){
            $pay_status = "已支付";
        }else{
            $pay_status = "未付款";
        }
    }
    return $pay_status;
}