<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/3/21
 * Time: 13:18
 */

namespace Admin\Model;

use Think\Model\ViewModel;

class DeviceViewModel extends ViewModel{
    public $viewFields = array(
        'Device'=>array('id','device_name','device_no','status','uid','_type'=>'LEFT'),
        'User'=>array('name'=>'user_name','_on'=>'Device.uid=User.id','_type'=>'LEFT'),
        'Agent'=>array('name'=>'agent_name','_on'=>'User.agent_id=Agent.id'),
    );
}