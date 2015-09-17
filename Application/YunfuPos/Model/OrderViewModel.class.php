<?php
/**
 * Created by PhpStorm.
 * User: Kangyi
 * Date: 2015/1/20
 * Time: 16:49
 */
namespace YunfuApi\Model;
use Think\Model\ViewModel;

class OrderViewModel extends ViewModel{
    public $viewFields = array(
        'Order'=>array('uid', 'device_id', 'cashier_id', 'out_trade_no', 'subject', 'total_fee', 'result_code', 'trade_no', 'trade_status', 'notify_id', 'seller_email', 'seller_id', 'buyer_email', 'buyer_id', 'gmt_create', 'gmt_payment','_as'=>'Orders','_type'=>'LEFT'),
        'Cashier'=>array('cashier_name', '_on'=>'Orders.cashier_id=Cashier.id','_type'=>'LEFT'),
        'Device'=>array('device_name', '_on'=>'Orders.device_id=Device.id'),
    );
}