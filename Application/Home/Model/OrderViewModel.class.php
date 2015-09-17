<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/3/23
 * Time: 10:11
 */

namespace Home\Model;


use Think\Model\ViewModel;

class OrderViewModel extends ViewModel{
    public $viewFields = array(
        'Order'=>array('id','uid','out_trade_no','out_trade_no','subject','total_fee','result_code','trade_status','trade_no','buyer_email','gmt_create','gmt_payment','device_id','cashier_id','_as'=>'Orders','_type'=>'LEFT'),
        'Cashier'=>array('cashier_name','status'=>'cashier_status','_on'=>'Orders.cashier_id=Cashier.id','_type'=>'LEFT'),
        'Device'=>array('device_name','status'=>'device_status','_on'=>'Orders.device_id=Device.id'),
    );

}