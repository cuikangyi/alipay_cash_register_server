<?php
/**
 * Created by PhpStorm.
 * User: That
 * Date: 2015/3/21
 * Time: 8:33
 */

namespace Admin\Model;

use Think\Model;

class AgentModel extends Model
{
    protected $_validate = array(
        array('name', 'require', '代理商名称必须填写！'),
        array('username', 'require', '用户名必须填写！',self::MUST_VALIDATE ,'',self::MODEL_INSERT),
        array('username', '', '用户名已经存在！',self::MUST_VALIDATE ,'unique',self::MODEL_INSERT),
        array('password', 'require', '密码不能为空',self::MUST_VALIDATE,'',self::MODEL_INSERT),
    );

    protected $_auto =  array(
        array('status','1',self::MODEL_INSERT),
        array('username', '', self::MODEL_UPDATE, 'ignore'),
        array('username', NULL, self::MODEL_UPDATE, 'ignore'),
        array('password', '', self::MODEL_UPDATE, 'ignore'),
        array('password', 'md5', self::MODEL_BOTH, 'function'),
        array('password', NULL, self::MODEL_UPDATE, 'ignore'),
    );

    /**
     * @param $id 代理商id
     * @return  信息
     */
    public function getInfo($id){
        $where['id'] = $id;
        $agent = M('agent')->field('id,username,name,status')->where($where)->find();
        return $agent;
    }

    /**
     * 获取所有代理商
     * @param int $uid 用户uid
     * @param int $page 默认为NULL 不分页
     * @param int $rows 默认为NULL 不分页
     * @return array 列表
     */
    public function getList($page = NULL,$rows = NULL)
    {
        $AgentDB = M('agent');
        $AgentDB->order("status DESC,id DESC");
        if($page && $rows){
            $first_limit = ($page-1) * $rows;
            $AgentDB->limit($first_limit,$rows);
        }
        $agents = $AgentDB->field('id,username,name,status')->select();
        return $agents;
    }

    /**
     * 根据代理商数量
     * @return int 数量
     */
    public function getCount(){
        $count =  M('agent')->count('id');
        return $count;
    }

    public function insert($data){
        $Model = D('agent');
        if ($Model->create($data)){
            $Model->add();
            $result['success'] = true;
            $result['message'] = '添加成功';
        }else{
            $result['success'] = false;
            $result['message'] = $Model->getError();
        }
        return $result;
    }

    public function edit($data){
        $Model = D('agent');
        if ($Model->create($data,2)){
            $Model->save();
            $result['success'] = true;
            $result['message'] = '修改成功';
        }else{
            $result['success'] = false;
            $result['message'] = $Model->getError();
        }
        return $result;
    }
}