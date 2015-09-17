<?php
/**
 * Created by PhpStorm.
 * User: Kangyi
 * Date: 2015/1/14
 * Time: 11:23
 */

namespace Home\Controller;

use Think\Controller;
use Think\Model;

class OrderController extends HomeController
{

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index(){
        $this->assign('uniqid',uniqid());
        $this->display();
    }

    public function getList()
    {
        //uid
        $where['uid'] = $this->uid;

        //时间
        $start_time = I('start_time');
        $end_time = I('end_time');
        if ($start_time && $end_time) {
            $where['gmt_create']  = array('between',array($start_time,$end_time));
        }elseif($start_time){
            $where['gmt_create'] = array('egt',$start_time);
        }elseif($end_time){
            $where['gmt_create'] = array('elt',$end_time);
        }

        //金额
        $start_fee = I('start_fee') ;
        $end_fee = I('end_fee') ;
        if($start_fee != '' && $end_fee!= ''){
            $where['total_fee'] =   array('between',array($start_fee,$end_fee));
        }elseif($start_fee != ''){
            $where['total_fee'] = array('egt',$start_fee);
        }elseif($end_fee != ''){
            $where['total_fee'] = array('elt',$end_fee);
        }

        //交易状态
        $pay_status = I('pay_status');
        if($pay_status == 'success'){
            $where['_string'] = "result_code='ORDER_SUCCESS_PAY_SUCCESS'
            or (result_code='ORDER_SUCCESS_PAY_INPROCESS' and (trade_status='TRADE_SUCCESS' or trade_status='TRADE_FINISHED' or trade_status='TRADE_PENDING'))";
        }elseif($pay_status == 'fail'){
            $where['_string'] = "result_code='ORDER_SUCCESS_PAY_INPROCESS' and (trade_status='' or trade_status='WAIT_BUYER_PAY' or trade_status='TRADE_CLOSED')";
        }

        //收银员
        $cashier_id = I('cashier_id');
        if($cashier_id){
            $where['cashier_id'] = $cashier_id;
        }
        //收款机
        $device_id = I('device_id');
        if($device_id){
            $where['device_id'] = $device_id;
        }

        //关键词
        $search_key = I('search_key');
        if($search_key != ''){
            $this->assign('search_key',$search_key);
            $search_key_type = I('search_key_type');
            if($search_key_type == "out_trade_no"){
                $where['out_trade_no'] = array('like','%'.$search_key.'%');
            }elseif($search_key_type == "trade_no"){
                $where['trade_no'] = array('like','%'.$search_key.'%');
            }elseif($search_key_type == "buyer_email"){
                $where['buyer_email'] = array('like','%'.$search_key.'%');
            }
        }

        $Model = D('order');
        $count = $Model->getOrderCount($where);
        //分页
        $page = I('page');
        $rows = I('rows');
        if(!$page){
            $page = NULL;
            $rows = NULL;
        }
        $list = $Model->getList($where,$page,$rows);

        foreach($list as $k=>$v){
            $list[$k]['pay_status'] = getPayStatus($v['result_code'],$v['trade_status']);
        }
        $result['total'] = $count;
        if(!$list){ $list = ''; }
        $result["rows"] = $list;
        $this->ajaxReturn($result,'json');
    }

    public function countIndex(){
        $this->assign('uniqid',uniqid());
        $this->display();
    }

    public function countOrderDevice(){
        $Model = D('order');
        $where['uid'] = $this->uid;
        //时间
        $start_time = I('start_time');
        $end_time = I('end_time');
        if ($start_time && $end_time) {
            $where['gmt_create']  = array('between',array($start_time,$end_time));
        }elseif($start_time){
            $where['gmt_create'] = array('egt',$start_time);
        }elseif($end_time){
            $where['gmt_create'] = array('elt',$end_time);
        }
        $list = $Model->getListGroupDevice($where);
        $this->ajaxReturn($list,'JSON');
    }

    public function countOrderCashier(){
        $Model = D('order');
        $where['uid'] = $this->uid;
        //时间
        $start_time = I('start_time');
        $end_time = I('end_time');
        if ($start_time && $end_time) {
            $where['gmt_create']  = array('between',array($start_time,$end_time));
        }elseif($start_time){
            $where['gmt_create'] = array('egt',$start_time);
        }elseif($end_time){
            $where['gmt_create'] = array('elt',$end_time);
        }
        $list = $Model->getListGroupCashier($where);
        $this->ajaxReturn($list,'JSON');
    }

    public function countOrderAll(){
        $Model = D('order');
        $where['uid'] = $this->uid;

        //时间
        $start_time = I('start_time');
        $end_time = I('end_time');
        if ($start_time && $end_time) {
            $where['gmt_create']  = array('between',array($start_time,$end_time));
        }elseif($start_time){
            $where['gmt_create'] = array('egt',$start_time);
        }elseif($end_time){
            $where['gmt_create'] = array('elt',$end_time);
        }

        $list = $Model->getSum($where);
        $this->ajaxReturn($list,'JSON');
    }

    public function countOrder(){
        $Model = D('order');
        $where['agent_id'] = $this->uid;

        //时间
        $start_time = I('start_time');
        $end_time = I('end_time');
        if ($start_time && $end_time) {
            $where['gmt_create']  = array('between',array($start_time,$end_time));
        }elseif($start_time){
            $where['gmt_create'] = array('egt',$start_time);
        }elseif($end_time){
            $where['gmt_create'] = array('elt',$end_time);
        }

        $list = $Model->getListGroupUID($where);
        $all = $Model->getSum($where);
        $list[] = array('user_name'=>'总计','total_fee'=>$all['total_fee'],'nums'=>$all['nums']);
        $this->ajaxReturn($list,'JSON');
    }

    public function ExportExcel(){
        //uid
        $where['uid'] = $this->uid;

        //时间
        $start_time = I('start_time');
        $end_time = I('end_time');
        if ($start_time && $end_time) {
            $where['gmt_create']  = array('between',array($start_time,$end_time));
        }elseif($start_time){
            $where['gmt_create'] = array('egt',$start_time);
        }elseif($end_time){
            $where['gmt_create'] = array('elt',$end_time);
        }

        //金额
        $start_fee = I('start_fee') ;
        $end_fee = I('end_fee') ;
        if($start_fee != '' && $end_fee!= ''){
            $where['total_fee'] =   array('between',array($start_fee,$end_fee));
        }elseif($start_fee != ''){
            $where['total_fee'] = array('egt',$start_fee);
        }elseif($end_fee != ''){
            $where['total_fee'] = array('elt',$end_fee);
        }

        //交易状态
        $pay_status = I('pay_status');
        if($pay_status == 'success'){
            $where['_string'] = "result_code='ORDER_SUCCESS_PAY_SUCCESS'
            or (result_code='ORDER_SUCCESS_PAY_INPROCESS' and (trade_status='TRADE_SUCCESS' or trade_status='TRADE_FINISHED' or trade_status='TRADE_PENDING'))";
        }elseif($pay_status == 'fail'){
            $where['_string'] = "result_code='ORDER_SUCCESS_PAY_INPROCESS' and (trade_status='' or trade_status='WAIT_BUYER_PAY' or trade_status='TRADE_CLOSED')";
        }

        //收银员
        $cashier_id = I('cashier_id');
        if($cashier_id){
            $where['cashier_id'] = $cashier_id;
        }
        //收款机
        $device_id = I('device_id');
        if($device_id){
            $where['device_id'] = $device_id;
        }

        //关键词
        $search_key = I('search_key');
        if($search_key != ''){
            $this->assign('search_key',$search_key);
            $search_key_type = I('search_key_type');
            if($search_key_type == "out_trade_no"){
                $where['out_trade_no'] = array('like','%'.$search_key.'%');
            }elseif($search_key_type == "trade_no"){
                $where['trade_no'] = array('like','%'.$search_key.'%');
            }elseif($search_key_type == "buyer_email"){
                $where['buyer_email'] = array('like','%'.$search_key.'%');
            }
        }

        $Model = D('order');
        $OrdersData = $Model->getList($where);

        vendor("Phpexcel.PHPExcel");

        // Create new PHPExcel object
        $objPHPExcel = new \PHPExcel();
        // Set properties
        $objPHPExcel->getProperties()->setCreator("ctos")
            ->setLastModifiedBy("ctos")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        //set width
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);

        //设置行高度
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        //set font size bold
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

        //设置水平居中
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        //合并cell
        $objPHPExcel->getActiveSheet()->mergeCells('A1:J1');

        // set table header content
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '订单数据汇总  时间:'.date('Y-m-d H:i:s'))
            ->setCellValue('A2', '订单名称')
            ->setCellValue('B2', '商户订单号')
            ->setCellValue('C2', '金额')
            ->setCellValue('D2', '支付状态')
            ->setCellValue('E2', '顾客支付宝账户')
            ->setCellValue('F2', '创建时间')
            ->setCellValue('G2', '付款时间')
            ->setCellValue('H2', '设备名称')
            ->setCellValue('I2', '收银员')
            ->setCellValue('J2', '支付宝交易号');

        // Miscellaneous glyphs, UTF-8
        for($i = 0; $i < count($OrdersData); $i++){
            $objPHPExcel->getActiveSheet(0)->setCellValue('A'.($i+3), $OrdersData[$i]['subject']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('B'.($i+3), "'".$OrdersData[$i]['out_trade_no']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C'.($i+3), $OrdersData[$i]['total_fee']);

            $pay_status = getPayStatus($OrdersData[$i]['result_code'],$OrdersData[$i]['trade_status']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D'.($i+3), $pay_status);

            $buyer_email = substr_replace($OrdersData[$i]['buyer_email'],'***',3,3);
            $objPHPExcel->getActiveSheet(0)->setCellValue('E'.($i+3), $buyer_email);

            $objPHPExcel->getActiveSheet(0)->setCellValue('F'.($i+3), $OrdersData[$i]['gmt_create']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('G'.($i+3), $OrdersData[$i]['gmt_payment']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('H'.($i+3), $OrdersData[$i]['device_name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('I'.($i+3), $OrdersData[$i]['cashier_name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('J'.($i+3), "'".$OrdersData[$i]['trade_no']);
            $objPHPExcel->getActiveSheet()->getStyle('A'.($i+3).':J'.($i+3))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('A'.($i+3).':J'.($i+3))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getRowDimension($i+3)->setRowHeight(16);
        }

        //  sheet命名
        $objPHPExcel->getActiveSheet()->setTitle('订单汇总表');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // excel头参数
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="订单汇总表('.date('Ymd-His').').xls"');  //日期为文件名后缀
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //excel5为xls格式，excel2007为xlsx格式
        $objWriter->save('php://output');

    }
}