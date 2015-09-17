<?php
namespace YunfuApi\Controller;
use Think\Controller;

class AlipayNotifyController extends Controller {
	
	public function notify() {
		file_put_contents ("logNotify.txt", date ( "Y-m-d H:i:s" ) .var_export($_REQUEST,true). "\r\n", FILE_APPEND );
		
		Vendor('AlipayLib.alipay_notify','','.class.php');

		$order_id = $_REQUEST['oid'];
        $where['id'] = $order_id;
        file_put_contents ("logNotify.txt", date ( "Y-m-d H:i:s" ) ."  order_id  ".$order_id. "\r\n", FILE_APPEND );
        if(!$order_id){
            file_put_contents ("logNotify.txt", date ( "Y-m-d H:i:s" ) ."  order_id  id NULL". "\r\n", FILE_APPEND );
            exit('fail');
        }
        $OrderDB = M('order');
        $uid = $OrderDB->where($where)->getField('uid');
        file_put_contents ("logNotify.txt", date ( "Y-m-d H:i:s" ) ."  uid  ".$uid. "\r\n", FILE_APPEND );
		$config =  M('config')->where(array('uid'=>$uid))->find();
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
		// 		var_dump($alipay_config);
		//file_put_contents ("log.txt", date ( "Y-m-d H:i:s" ) ."uid  ".$uid. "\r\n", FILE_APPEND );
		//file_put_contents ("log.txt", date ( "Y-m-d H:i:s" ) .var_export($config,true). "\r\n", FILE_APPEND );
		//计算得出通知验证结果
		$alipayNotify = new \AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
	
		// 		var_dump($verify_result);
	
		if($verify_result) {//验证成功
			//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

			$notify_id = $_POST['notify_id'];

			//商户订单号
			file_put_contents ("logNotify.txt", date ( "Y-m-d H:i:s" ). "  verify_success" ."\r\n", FILE_APPEND );
			//$out_trade_no = $_POST['out_trade_no'];
			//支付宝交易号
			$trade_no = $_POST['trade_no'];
			//交易状态
			$trade_status = $_POST['trade_status'];
				
			//买家信息
			$buyer_email = $_POST['buyer_email'];
			$buyer_id = $_POST['buyer_id'];
			//时间
			$gmt_create = $_POST['gmt_create'];
			$gmt_payment = $_POST['gmt_payment'];
				
			$data =array(
					'trade_no'=>$trade_no,
					'trade_status'=>$trade_status,
					'buyer_email'=>$buyer_email,
					'buyer_id'=>$buyer_id,
					'gmt_create'=>$gmt_create,
					'gmt_payment'=>$gmt_payment,
					'notify_id'=>$notify_id,
			);
            sleep(1);
			$rs = $OrderDB->where($where)->save($data);

            file_put_contents ("logNotify.txt", date ( "Y-m-d H:i:s" ) ."  rs  ".$rs.'  '. M('order')->getLastSql(). "\r\n", FILE_APPEND );

            if(!$rs){
                $rs = $OrderDB->where($where)->save($data);
			    file_put_contents ("logNotifyError.txt", date ( "Y-m-d H:i:s" ) ."  rs ".$rs.'  sql  '. M('order')->getLastSql(). "\r\n", FILE_APPEND );
            }
			//判断是否在商户网站中已经做过了这次通知返回的处理
			//如果没有做过处理，那么执行商户的业务程序
			//如果有做过处理，那么不执行商户的业务程序
			echo "success";		//请不要修改或删除
	
			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
	
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
			//验证失败
			file_put_contents ("logNotify.txt", date ( "Y-m-d H:i:s" ) . " fail ". "\r\n", FILE_APPEND );
			echo "fail";
	
			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}
}