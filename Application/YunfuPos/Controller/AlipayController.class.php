<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace YunfuPos\Controller;
use Think\Controller;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class AlipayController extends YunfuPosController {

	private $configdb;
	
	protected function  _initialize(){
		parent::_initialize();
		$this->configdb = M('config');
	}
	
	public function verify(){
		$device = M('device')->where(array('id'=>$this->device_id))->find();
		$user = M('user')->where(array('id'=>$this->uid))->find();
		$config = $this->configdb->where(array('uid'=>$this->uid))->find();
		$result['is_success'] = 'T';
		$result['device_name'] = $device['device_name'];
		$result['username'] = $user['username'];
		$result['pname'] = $config['pname'];
		returnXml($result);
	}
	
	public function pay() {
		if(IS_POST){
			Vendor('AlipayLib.alipay_submit','','.class.php');
			$config = $this->configdb->where(array('uid'=>$this->uid))->find();
			$alipay_config = array(
					'email' => trim($config['email']),			//合作身份者email
					'partner' => trim($config['partner']),				//合作身份者id，以2088开头的16位纯数字
					'key' => trim($config['pkey']),	//安全检验码，以数字和字母组成的32位字符
					
					//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
					
					'sign_type' =>  strtoupper('MD5'),				//签名方式 不需修改
					'input_charset' => strtolower('utf-8'),			//字符编码格式 目前支持 gbk 或 utf-8
					'cacert' => getcwd().'/cacert.pem',			//ca证书路径地址，用于curl中ssl校验	//请保证cacert.pem文件在当前文件夹目录中	
					'transport' => 'http',							//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
			);
			
			//卖家支付宝帐户
			$seller_email = $alipay_config['email'];
			//必填
			
			//商户订单号
			$orderid = getOrderId();
			$cashier_id = 0;//I('cashier_id');
			$device = M('device')->where('id='.$this->device_id)->find();
			$out_trade_no = $device['device_name'].'_'.$orderid.$this->uid.$this->device_id;
			//商户网站订单系统中唯一订单号，必填

			if(M('order')->where(array('out_trade_no'=>$out_trade_no))->find()){
				$result['is_success'] = 'F';
				$result['error_msg'] = '订单号重复';
				returnXml($result);
			}
			
			//订单名称
			$subject = $config['pname'].$orderid;
			//必填
			
			//付款金额
			$total_fee = I('total_fee');
			//必填
			if(!$total_fee){
				$result['is_success'] = 'F';
				$result['error_msg'] = '必须输入金额';
				returnXml($result);
			}
			
			//订单业务类型
			$product_code = 'BARCODE_PAY_OFFLINE';
			//SOUNDWAVE_PAY_OFFLINE：声波支付，FINGERPRINT_FAST_PAY：指纹支付，BARCODE_PAY_OFFLINE：条码支付
			
			//动态ID类型
			$dynamic_id_type = 'barcode';
			//soundwave：声波，qrcode：二维码，barcode：条码
			
			//动态ID
			$dynamic_id = I('dym_id');
			//例如3856957008a73b7d
			if(!$dynamic_id){
				$result['is_success'] = 'F';
				$result['error_msg'] = '动态id不能为空';
				returnXml($result);
			}
			
			/************************************************************/
			
			//构造要请求的参数数组，无需改动
			$parameter = array(
					"service" => "alipay.acquire.createandpay",
					"partner" => trim($alipay_config['partner']),
					"seller_email"	=> $seller_email,
					"out_trade_no"	=> $out_trade_no,
					"subject"	=> $subject,
					"total_fee"	=> $total_fee,
					"product_code"	=> $product_code,
					"dynamic_id_type"	=> $dynamic_id_type,
					"dynamic_id"	=> $dynamic_id,
					'agent_id' => '11616319a1',
					"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
					'notify_url' => C('SITEURL').str_ireplace('?s=','',U('AlipayNotify/notify',array('uid'=>$this->uid))),
			);
			//var_export($parameter);exit;

			//建立请求
			$alipaySubmit = new \AlipaySubmit($alipay_config);
			$html_text = $alipaySubmit->buildRequestHttp($parameter);
// 			echo $html_text;
			//解析XML
			//注意：该功能PHP5环境及以上支持，需开通curl、SSL等PHP配置环境。建议本地调试时使用PHP开发软件
			$doc = new \DOMDocument();
			$doc->loadXML($html_text);

			if( ! empty($doc->getElementsByTagName( "alipay" )->item(0)->nodeValue) ) {
				//$alipay = $doc->getElementsByTagName( "alipay" )->item(0)->nodeValue;
				$is_success = $doc->getElementsByTagName( "is_success" )->item(0)->nodeValue;

				if($is_success == "T" ){
					$result_code = $doc->getElementsByTagName( "result_code" )->item(0)->nodeValue;

					if ($result_code == "ORDER_SUCCESS_PAY_SUCCESS") {
						$trade_no = $doc->getElementsByTagName( "trade_no" )->item(0)->nodeValue;
						$buyer_email = $doc->getElementsByTagName( "buyer_logon_id" )->item(0)->nodeValue;
						$buyer_id = $doc->getElementsByTagName( "buyer_user_id" )->item(0)->nodeValue;
						$gmt_payment = $doc->getElementsByTagName( "gmt_payment" )->item(0)->nodeValue;

						$orderdb = M('order');
						$orderdata['uid'] = $this->uid;
						$orderdata['device_id'] = $this->device_id;
						$orderdata['cashier_id'] = $cashier_id;
						$orderdata['out_trade_no'] = $out_trade_no;
						$orderdata['subject'] = $subject;
						$orderdata['total_fee'] = $total_fee;
						$orderdata['result_code'] = $result_code;
						$orderdata['trade_no'] = $trade_no;
						$orderdata['seller_email'] = $config['email'];
						$orderdata['seller_id'] = $config['partner'];
						$orderdata['buyer_email'] = $buyer_email;
						$orderdata['buyer_id'] = $buyer_id;
						$orderdata['gmt_create'] = date("Y-m-d H:i:s");
						$orderdata['gmt_payment'] = $gmt_payment;

						if($orderdb->create($orderdata)){
							$orderdb->add();
							$result['is_success'] = 'T';
							$result['result_code'] = 'success';
							$result['out_trade_no'] = $out_trade_no;
							$result['buyer_email'] = $buyer_email;
							returnXml($result);
						}else{
							$result['is_success'] = 'F';
							$result['error_msg'] = '创建订单失败';
							returnXml($result);
						}
					}elseif ($result_code == "ORDER_SUCCESS_PAY_INPROCESS") {
						$trade_no = $doc->getElementsByTagName( "trade_no" )->item(0)->nodeValue;
						$buyer_email = $doc->getElementsByTagName( "buyer_logon_id" )->item(0)->nodeValue;
						$buyer_id = $doc->getElementsByTagName( "buyer_user_id" )->item(0)->nodeValue;

						//exit(date("Y-m-d H:i:s"));

						$orderdb = M('order');
						$orderdata['uid'] = $this->uid;
						$orderdata['device_id'] = $this->device_id;
						$orderdata['cashier_id'] = $cashier_id;
						$orderdata['out_trade_no'] = $out_trade_no;
						$orderdata['subject'] = $subject;
						$orderdata['total_fee'] = $total_fee;
						$orderdata['result_code'] = $result_code;
						$orderdata['trade_no'] = $trade_no;
						$orderdata['seller_email'] = $config['email'];
						$orderdata['seller_id'] = $config['partner'];
						$orderdata['buyer_email'] = $buyer_email;
						$orderdata['buyer_id'] = $buyer_id;
						$orderdata['gmt_create'] = date("Y-m-d H:i:s");


						if($orderdb->create($orderdata)){
							$orderdb->add();
							$result['is_success'] = 'T';
							$result['result_code'] = 'inprocess';
							$result['out_trade_no'] = $out_trade_no;
							$result['buyer_email'] = $buyer_email;
							returnXml($result);
						}else{
							$result['is_success'] = 'F';
							$result['error_msg'] = '创建订单失败';
							returnXml($result);
						}
					}elseif ($result_code == "ORDER_SUCCESS_PAY_FAIL") {
						$detail_error_des = $doc->getElementsByTagName( "detail_error_des" )->item(0)->nodeValue;
						$result['is_success'] = 'F';
						$result['error_msg'] = $detail_error_des;
						returnXml($result);
					}elseif ($result_code == "ORDER_FAIL") {
						$detail_error_des = $doc->getElementsByTagName( "detail_error_des" )->item(0)->nodeValue;
						$result['is_success'] = 'F';
						$result['error_msg'] = $detail_error_des;
						returnXml($result);
					}else{
						$result['is_success'] = 'F';
						$result['error_msg'] = '处理结果未知，请联系系统提供商';
						returnXml($result);
					}
				}else{
					$error = $doc->getElementsByTagName( "error" )->item(0)->nodeValue;
					$result['is_success'] = 'F';
					$result['error_msg'] = $error;
					returnXml($result);
				}
			}else{
				$result['is_success'] = 'F';
				$result['error_msg'] = '获取返回消息失败';
				returnXml($result);
			}
		}
	}
	
	//获取异步支付状态
	public function getPayStatus(){
		$out_trade_no = I('out_trade_no');
		$order = M('order')->where(array('uid'=>$this->uid,'out_trade_no'=>$out_trade_no))->find();
		$result_code = $order['result_code'];
		$trade_status = $order['trade_status'];
        if($result_code == "ORDER_SUCCESS_PAY_SUCCESS"){
            $result['is_success'] = 'T';
            $result['trade_code'] = 'success';
            returnXml($result);
        }else{
            if($trade_status == "TRADE_SUCCESS" || $trade_status == "TRADE_FINISHED" || $trade_status == "TRADE_PENDING"){
                $result['is_success'] = 'T';
                $result['trade_code'] = 'success';
                returnXml($result);
            }else{
                $result['is_success'] = 'T';
                $result['trade_code'] = 'fail';
                returnXml($result);
            }
        }
	}
}