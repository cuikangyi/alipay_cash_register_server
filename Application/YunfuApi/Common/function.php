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

