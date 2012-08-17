<?php
class ControllerPaymentTenpay extends Controller {
	protected function index() {
    	$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['return'] = HTTPS_SERVER . 'index.php?route=checkout/success';

		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['cancel_return'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
		} else {
			$this->data['cancel_return'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}

		$this->load->library('encryption');

		$encryption = new Encryption($this->config->get('config_encryption'));

		$this->data['custom'] = $encryption->encrypt($this->session->data['order_id']);

		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
		} else {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}

		$this->load->model('checkout/order');

		$order_id = $this->session->data['order_id'];

		$order_info = $this->model_checkout_order->getOrder($order_id);

		$currency_code ='CNY';
		$item_name = $this->config->get('config_title');
		$first_name = $order_info['payment_firstname'];
		$last_name = $order_info['payment_lastname'];
		$cmdno = $this->config->get('tenpay_cmdno');      // 接口类型
		$mch_type=$this->config->get('tenpay_mch_type');  // 虚拟物品还是实际物品
		
		/* 平台商密钥 */
		$key = $this->config->get('tenpay_key');
		
		/* 平台商帐号 */
		$chnid = $this->config->get('tenpay_bargainor_id');
		
		/* 卖家 */
		$seller =  $this->config->get('tenpay_seller');

		$total = $order_info['total'];  

		$currency_value = $this->currency->getValue($currency_code);
		$amount = $total * $currency_value;
		$amount = number_format($amount,2,'.','');

		$charset =2;  //编码类型 1:gbk 2:utf-8
	
	
		$notify_url     = HTTPS_SERVER . 'catalog/controller/payment/tenpay_callback.php';
		$return_url		= HTTPS_SERVER . 'index.php?route=checkout/success';
		
		$data=array(
			'bargainor_id' => $chnid,
			'chnid'        => $chnid,
			'seller'	    => $seller,
			'key'           => $key,
			'order_id'       => $order_id,
			'total_fee'       => $amount*100, // 单位为分
			'store'         => $item_name,  
			'callback'		=> $notify_url, 
			'return'		=> $return_url
		);
		
		if($cmdno=='12'){ // 中介担保支付
			$action = $this->mediPay($data);
		}else{// 直接支付
			$action = $this->pay($data);
		}
		
		if(isset($this->session->data['checkout_token']))
			$this->data['token'] =$this->session->data['checkout_token'];
		
		$this->data['action'] = $action;
		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/tenpay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/tenpay.tpl';
		} else {
			$this->template = 'default/template/payment/tenpay.tpl';
		}

		$this->render();
	}

	protected function reorder() {
		$this->data['button_confirm'] = $this->language->get('button_reoder_confirm');
		$this->data['button_back'] = $this->language->get('button_back');
	
		$this->data['return'] = HTTPS_SERVER . 'index.php?route=account/paysuccess';
	
		$this->load->library('encryption');
	
		$encryption = new Encryption($this->config->get('config_encryption'));
	
		$order_id=$this->request->get['order_id'];
		
		$this->data['custom'] = $encryption->encrypt($order_id);
	
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($order_id);
	
		$currency_code ='CNY';
		$item_name = $this->config->get('config_title');
		$first_name = $order_info['payment_firstname'];
		$last_name = $order_info['payment_lastname'];
		$cmdno = $this->config->get('tenpay_cmdno');      // 接口类型
		$mch_type=$this->config->get('tenpay_mch_type');  // 虚拟物品还是实际物品
	
		/* 平台商密钥 */
		$key = $this->config->get('tenpay_key');
	
		/* 平台商帐号 */
		$chnid = $this->config->get('tenpay_bargainor_id');
	
		/* 卖家 */
		$seller =  $this->config->get('tenpay_seller');
	
		$total = $order_info['total'];
	
		$currency_value = $this->currency->getValue($currency_code);
		$amount = $total * $currency_value;
		$amount = number_format($amount,2,'.','');
	
		$charset =2;  //编码类型 1:gbk 2:utf-8
	
		$notify_url     = HTTPS_SERVER . 'catalog/controller/payment/tenpay_callback.php';
		$return_url		= HTTPS_SERVER . 'index.php?route=account/paysuccess';
	
		$data=array(
				'bargainor_id' => $chnid,
				'chnid'        => $chnid,
				'seller'	    => $seller,
				'key'           => $key,
				'order_id'       => $order_id,
				'total_fee'       => $amount*100, // 单位为分
				'store'         => $item_name,  
				'callback'		=> $notify_url, 
				'return'		=> $return_url
		);
	
		if($cmdno=='12'){
			// 中介担保支付
			$action = $this->mediPay($data);
		}else{// 直接支付
			$action = $this->pay($data);
		}
		
		$this->data['reorder'] = true;
		$this->data['action'] = $action;
		$this->id = 'payment';
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/tenpay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/tenpay.tpl';
		} else {
			$this->template = 'default/template/payment/tenpay.tpl';
		}
	
		$this->render();
	}
	
	private function pay($data=array()) {
		$this->log->debug("Tenpay :: exciting tenpay init.");
		require_once ("tenpay_class/PayRequestHandler.class.php");
		/* 商户号 */
		$bargainor_id = $data['bargainor_id'];
		
		/* 密钥 */
		$key = $data['key'];
		
		/* 返回处理地址 */
		$callback_url = $data['callback'];
		
		//date_default_timezone_set(PRC);
		$strDate = date("Ymd");
		$strTime = date("His");
		
		//4位随机数
		$randNum = rand(1000, 9999);
		
		//10位序列号,可以自行调整。
		$strReq = $strTime . $randNum;
		
		/* 商家订单号,长度若超过32位，取前32位。财付通只记录商家订单号，不保证唯一。 */
		$sp_billno = $data['order_id'];
		
		/* 财付通交易单号，规则为：10位商户号+8位时间（YYYYmmdd)+10位流水号 */
		$transaction_id = $bargainor_id . $strDate . $strReq;
		
		/* 商品价格（包含运费），以分为单位 */
		$total_fee = $data['total_fee'];
		
		/* 商品名称 */
		
		$desc    =  iconv('utf-8', 'gbk', $data['store'].", 订单号：".$data['order_id']); 
		
		/* 创建支付请求对象 */
		$reqHandler = new PayRequestHandler();
		$reqHandler->init();
		$reqHandler->setKey($key);
		
		//----------------------------------------
		//设置支付参数
		//----------------------------------------
		$reqHandler->setParameter("attach", "1");
		$reqHandler->setParameter("bargainor_id", $bargainor_id);			//商户号
		$reqHandler->setParameter("sp_billno", $sp_billno);					//商户订单号
		$reqHandler->setParameter("transaction_id", $transaction_id);		//财付通交易单号
		$reqHandler->setParameter("total_fee", $total_fee);					//商品总金额,以分为单位
		$reqHandler->setParameter("return_url", $callback_url);				//返回处理地址
		$reqHandler->setParameter("desc", $desc);	//商品名称	
		$reqHandler->setParameter("encode_type", "2");		
		//用户ip,测试环境时不要加这个ip参数，正式环境再加此参数
		$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);
		
		//请求的URL
		$reqUrl = $reqHandler->getRequestURL();
		return $reqUrl;
	}
	
	
	private function mediPay($data=array()) {
		require_once ("tenpay_class/MediPayRequestHandler.class.php");
		//date_default_timezone_set(PRC);
		$curDateTime = date("YmdHis");
		$randNum = rand(1000, 9999);
		
		/* 平台商密钥 */
		$key = $data['key'];
		
		/* 平台商帐号 */
		$chnid = $data['chnid'];
		
		/* 卖家 */
		$seller = $data['seller'];
		
		/* 交易说明 */
		$mch_desc = $data['store'].", 订单号：".$data['order_id'];
		
		/* 商品名称 */
		$mch_name = $data['store']."订单号：".$data['order_id'];
		
		/* 商品总价，单位为分 */
		$mch_price = $data['total_fee'];
		
		/* 回调通知URL */
		$mch_returl = $data['callback'];
		
		/* 商家的定单号 */
		$mch_vno = $curDateTime . $randNum;
		
		/* 支付后的商户支付结果展示页面 */
		$show_url = $data['return'];
		
		/* 物流公司或物流方式说明 */
		$transport_desc = "";
		
		/* 需买方另支付的物流费用,以分为单位 */
		$transport_fee = "";
		
		/* 创建支付请求对象 */
		$reqHandler = new MediPayRequestHandler();
		$reqHandler->init();
		$reqHandler->setKey($key);
		
		//----------------------------------------
		//设置支付参数
		//----------------------------------------
		$reqHandler->setParameter("chnid", $chnid);						//平台商帐号
		$reqHandler->setParameter("encode_type", "2");					//编码类型 1:gbk 2:utf-8
		$reqHandler->setParameter("mch_desc", $mch_desc);				//交易说明
		$reqHandler->setParameter("mch_name", $mch_name);				//商品名称
		$reqHandler->setParameter("mch_price", $mch_price);				//商品总价，单位为分
		$reqHandler->setParameter("mch_returl", $mch_returl);			//回调通知URL
		$reqHandler->setParameter("mch_type", "1");						//交易类型：1、实物交易，2、虚拟交易
		$reqHandler->setParameter("mch_vno", $mch_vno);					//商家的定单号
		$reqHandler->setParameter("need_buyerinfo", "2");				//是否需要在财付通填定物流信息，1：需要，2：不需要。
		$reqHandler->setParameter("seller", $seller);					//卖家财付通帐号
		$reqHandler->setParameter("show_url",	$show_url);				//支付后的商户支付结果展示页面
		$reqHandler->setParameter("transport_desc", $transport_desc);	//物流公司或物流方式说明
		$reqHandler->setParameter("transport_fee", $transport_fee);		//需买方另支付的物流费用
		
		//请求的URL
		$reqUrl = $reqHandler->getRequestURL();
		return $reqUrl;
	}
	
	public function callback() {
		// Order status for Opencart
		$order_status = array(
			"Canceled"        => 7,
			"Canceled_Reversal"   => 9,
			"Chargeback"     	=> 13,
			"Complete"     		=> 5,
			"Denied" 			=> 8,
			"Failed"        	=> 10 ,
			"Pending"           => 1,
			"Processing"  		 => 2,
			"Refunded"        	  => 11,
			"Reversed"  		 => 12,
			"Shipped"     	  => 3
		);
		$this->log->debug("Tenpay :: exciting callback function.");
		$cmdno = $this->config->get('tenpay_cmdno');  
		if($cmdno==1){
			$this->log->debug("Tenpay :: exciting callback function pay.");
			$this->func_pay($order_status);
		}
	}
	
	
	
	// 直接到帐
	private function func_pay($order_status){
			require_once ("tenpay_class/PayResponseHandler.class.php");
			/* 密钥 */
			$key = $this->config->get('tenpay_key');
				
			/* 创建支付应答对象 */
			$resHandler = new PayResponseHandler();
			$resHandler->setKey($key);
			$this->log->debug("Tenpay :: exciting PayResponseHandler.");
		//判断签名
			if($resHandler->isTenpaySign()) {
					$this->load->model('checkout/order');
					// 获取订单号
					$order_id = $resHandler->getParameter("sp_billno");
					$this->log->debug(' order_id '.$order_id);
					$this->load->model('checkout/order');
					$order_info = $this->model_checkout_order->getOrder($order_id);
				if ($order_info) {
					$order_status_id = $order_info["order_status_id"];
					$order_info = $this->model_checkout_order->getOrder($order_id);
					
					//交易单号
					$transaction_id = $resHandler->getParameter("transaction_id");
					
					//金额,以分为单位
					$total_fee = $resHandler->getParameter("total_fee");
					
					//支付结果
					$pay_result = $resHandler->getParameter("pay_result");
					
					if( "0" == $pay_result ) {
						$this->log->debug(' pay_result '.$pay_result);
						//------------------------------
						//处理业务开始
						//------------------------------
						$this->log->debug();
						$this->log->debug(' order_status_id '.$this->config->get('tenpay_order_status_id').' order_status_id '.$order_status_id);
						$this->model_checkout_order->confirm($order_id, $this->config->get('tenpay_order_status_id'));
						//注意交易单不要重复处理
						//注意判断返回金额
						
						//------------------------------
						//处理业务完毕
						//------------------------------	
						
						//调用doShow, 打印meta值跟js代码,告诉财付通处理成功,并在用户浏览器显示$show页面.
						$show = HTTPS_SERVER . 'index.php?route=checkout/success';
						$resHandler->doShow($show);
					
					} else {
						//当做不成功处理
						echo "<br/>" . iconv('utf-8', 'gbk', "支付失败" ) . "<br/>";
					}
				} else {
					echo "<br/>" . iconv('utf-8', 'gbk', "支付失败" ) . "<br/>";
				}
			}else{
				echo "<br/>" . iconv('utf-8', 'gbk', "认证签名失败" ). "<br/>";
			}
	}

}

?>