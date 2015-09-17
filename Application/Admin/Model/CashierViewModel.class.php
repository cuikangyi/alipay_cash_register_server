<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/3/21
 * Time: 13:18
 */

namespace Admin\Model;

use Think\Model\ViewModel;

class CashierViewModel extends ViewModel{
    public $viewFields = array(
        'Cashier'=>array('id','cashier_name','cashier_no','status','uid','_type'=>'LEFT'),
        'User'=>array('name'=>'user_name','_on'=>'Cashier.uid=User.id','_type'=>'LEFT'),
        'Agent'=>array('name'=>'agent_name','_on'=>'User.agent_id=Agent.id'),
    );
}