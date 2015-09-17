<?php
/**
 * 得到新订单号
 * @return  string
 */
function getOrderId()
{
    /* 选择一个随机的方案 */
    mt_srand((double) microtime() * 1000000);

    /*年月日 + 6位随机数 */
    return date('YmdHis') . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
}

/**
 * @param $data
 * 输出xml，根为Alipay
 */
function returnXml($data){
    header('Content-Type:text/xml; charset=utf-8');
    exit(xml_encode($data,'Alipay','item'));
}

function get_pay_status($result_code,$trade_status){
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

