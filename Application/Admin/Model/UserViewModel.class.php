<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/3/24
 * Time: 17:37
 */

namespace Admin\Model;

use Think\Model\ViewModel;

class UserViewModel extends ViewModel{
    public $viewFields = array(
        'User'=>array('id','username','name','agent_id','status','_type'=>'LEFT'),
        'Agent'=>array('name'=>'agent_name','_on'=>'User.agent_id=Agent.id'),
    );
}