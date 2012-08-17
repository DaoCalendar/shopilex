<?php
class ControllerCheckoutCheckout extends Controller {
	private $direct_payments= array('cod','cheque','free_checkout','bank_transfer');

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
			 
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) || !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->redirect($this->url->link('checkout/cart'));
		}
		 
		if(!isset($this->session->data['checkout_token']))
		$this->session->data['checkout_token'] = md5(mt_rand());
		 
		$this->log->debug('IlexDebug:: Begin Checkout  : '.$this->session->data['checkout_token']);

		$this->load_language('checkout/checkout');

		$this->document->setTitle($this->language->get('heading_title'));

		// Minimum quantity validation
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($this->session->data['cart'] as $key => $quantity) {
				$product_2 = explode(':', $key);
					
				if ($product_2[0] == $product['product_id']) {
					$product_total += $quantity;
				}
			}
				
			if ($product['minimum'] > $product_total) {
				$this->session->data['error'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);

				$this->redirect($this->url->link('checkout/cart'));
			}
		}
		 
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
          	 'text'      => $this->language->get('text_home'),
			 'href'      => $this->url->link('common/home'),
        	 'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
	       'text'      => $this->language->get('text_cart'),
	       'href'      => $this->url->link('checkout/cart'),
	       'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
	       'text'      => $this->language->get('heading_title'),
	       'href'      => $this->url->link('checkout/checkout', '', 'SSL'),
	       'separator' => $this->language->get('text_separator')
		);

		$this->data['cart'] = $this->url->link('checkout/cart');
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['shipping_required'] = $this->cart->hasShipping();
		$this->data['has_address']=1;

		if($this->customer->getAddressId()){
			$this->data['shipping_address']=$this->shipping_address();
			$this->data['shipping_methods']=$this->shipping_method();
		}else{
			$this->data['has_address']=0;
			$this->data['shipping_address']=$this->shipping_new_address();
			$this->data['shipping_methods']=$this->default_shipping_method();
		}

		$this->data['payment_methods']=$this->payment_method();

		$this->data['comment']='';
		if (isset($this->session->data['comment'])) {
			$this->data['comment']=$this->session->data['comment'];
		}

		$results = $this->model_setting_extension->getExtensions('total');

		// Modules
		$this->data['modules'] = array();
			
		if (isset($results)) {
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status') && file_exists(DIR_APPLICATION . 'controller/total/' . $result['code'] . '.php')) {
					$this->data['modules'][] = $this->getChild('total/' . $result['code']);
				}
			}
		}

		$this->data['modules'][] = $this->getChild('total/comment');

		$this->data['order_confirm']=$this->confirm();

		$this->data['payment']	=$this->payment();

		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

		$this->load->model('setting/extension');
			
		$sort_order = array();
			
		$results = $this->model_setting_extension->getExtensions('total');
			
		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		}
			
		array_multisort($sort_order, SORT_ASC, $results);
			
		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('total/' . $result['code']);

				$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
			}
		}
			
		$sort_order = array();

		foreach ($total_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $total_data);

		$this->data['totals'] = $total_data;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/checkout.tpl';
		} else {
			$this->template = 'default/template/checkout/checkout.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/checkout_header'
		);

		$this->response->setOutput($this->render());
	}

	 
	public function shipping_address() {
		$this->load_language('checkout/checkout');

		$this->load->model('account/address');

		$this->data['type'] = 'shipping';

		if (isset($this->session->data['shipping_address_id'])) {
			$this->data['address_id'] = $this->session->data['shipping_address_id'];
			$this->log->debug('IlexDebug:: session   : '.$this->session->data['shipping_address_id']);
		} else {
			$this->data['address_id'] = $this->customer->getAddressId();
			$this->session->data['shipping_address_id']=$this->data['address_id'];
			$this->log->debug('IlexDebug:: default address_id   : '.$this->session->data['shipping_address_id']);
		}

		$this->data['addresses'] = $this->model_account_address->getAddresses();
			
		$this->data['country_id'] = $this->config->get('config_country_id');
			
		$this->load->model('localisation/country');
			
		$this->data['countries'] = $this->model_localisation_country->getCountries();
			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/address.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/address.tpl';
		} else {
			$this->template = 'default/template/checkout/address.tpl';
		}

		return $this->render();
	}
	 
	private function shipping_new_address() {
		$this->load_language('checkout/checkout');
		 
		$this->load->model('account/address');
		 
		$this->data['type'] = 'shipping';
		 
		$this->data['country_id'] = $this->config->get('config_country_id');
			
		$this->load->model('localisation/country');
			
		$this->data['countries'] = $this->model_localisation_country->getCountries();
			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/address_new.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/address_new.tpl';
		} else {
			$this->template = 'default/template/checkout/address_new.tpl';
		}
		 
		return $this->render();
	}
	 
	public function shipping_method() {
		$this->load_language('checkout/checkout');

		$this->load->model('account/address');

		if(isset($this->session->data['shipping_address_id']))
		$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
		else
		$shipping_address = $this->model_account_address->getAddress($this->customer->getAddressId());

		$this->tax->setZone($shipping_address['country_id'], $shipping_address['zone_id']);
		 
		if (!isset($this->session->data['shipping_methods'])) {
			$quote_data = array();

			$this->load->model('setting/extension');

			$results = $this->model_setting_extension->getExtensions('shipping');

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('shipping/' . $result['code']);
						
					$quote = $this->{'model_shipping_' . $result['code']}->getQuote($shipping_address);
					if ($quote) {
						$quote_data[$result['code']] = array(
  							  'title'          => $quote['title'],
  							  'quote'          => $quote['quote'], 
  							  'description'    => $quote['description'],
  							  'sort_order'     => $quote['sort_order'],
  							  'error'          => $quote['error']
						);
					}
				}
			}

			$sort_order = array();

			foreach ($quote_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $quote_data);

			$this->session->data['shipping_methods'] = $quote_data;

		}

		if (isset($this->session->data['shipping_methods']) && !$this->session->data['shipping_methods']) {
			$this->data['error_warning'] = sprintf($this->language->get('error_no_shipping'), $this->url->link('information/contact'));
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['shipping_methods'])) {
			$this->data['shipping_methods'] = $this->session->data['shipping_methods'];
		} else {
			$this->data['shipping_methods'] = array();
		}
			
		if (isset($this->session->data['shipping_method']['code'])) {
			$this->data['shipping_code'] = $this->session->data['shipping_method']['code'];
			$this->customer->setShippingMethod($this->session->data['shipping_method']['code']);
		} else {
			$this->data['shipping_code'] = $this->customer->getShippingMethod();
				
			$shipping = explode('.', $this->data['shipping_code']);
			if(isset($shipping[0])&&isset($shipping[1])){
				if(isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]]))
					$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
				else
					$this->data['shipping_code']='';
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/shipping.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/shipping.tpl';
		} else {
			$this->template = 'default/template/checkout/shipping.tpl';
		}
			
		return $this->render();
	}

	public function default_shipping_method() {
		$this->load_language('checkout/checkout');
			
		$shipping_address['country_id']=$this->config->get('config_country_id');
		$shipping_address['zone_id']=$this->config->get('config_zone_id');
		$this->tax->setZone($shipping_address['country_id'], $shipping_address['zone_id']);

		$this->tax->setZone($shipping_address['country_id'], $shipping_address['zone_id']);
			
		$quote_data = array();
			
		$this->load->model('setting/extension');
			
		$results = $this->model_setting_extension->getExtensions('shipping');
			
		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('shipping/' . $result['code']);
					
				$quote = $this->{'model_shipping_' . $result['code']}->getQuote($shipping_address);
					
				if ($quote) {
					$quote_data[$result['code']] = array(
  	  					'title'          => $quote['title'],
  	  					'quote'          => $quote['quote'], 
               		    'description'    => $quote['description'],
  	  					'sort_order'     => $quote['sort_order'],
  	  					'error'          => $quote['error']
					);
				}
			}
		}
			
		$sort_order = array();
			
		foreach ($quote_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}
			
		array_multisort($sort_order, SORT_ASC, $quote_data);
			
		$this->session->data['shipping_methods'] = $quote_data;

		$this->data['error_warning'] = '';

		if (isset($this->session->data['shipping_methods'])) {
			$this->data['shipping_methods'] = $this->session->data['shipping_methods'];
		} else {
			$this->data['shipping_methods'] = array();
		}

		if (isset($this->session->data['shipping_method']['code'])) {
			$this->data['shipping_code'] = $this->session->data['shipping_method']['code'];
			$this->customer->setShippingMethod($this->session->data['shipping_method']['code']);
		} else {
			$this->data['shipping_code'] =  $this->customer->getShippingMethod();
		}
		 
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/shipping.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/shipping.tpl';
		} else {
			$this->template = 'default/template/checkout/shipping.tpl';
		}

		return $this->render();
	}
	 
	public function payment_method() {
		$this->load_language('checkout/checkout');

		$this->load->model('account/address');

		if(isset($this->session->data['shipping_address_id']))
		$this->session->data['payment_address_id']=$this->session->data['shipping_address_id'];
		else
		$this->session->data['payment_address_id']=$this->customer->getAddressId();
			
		$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);

		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

		$this->load->model('setting/extension');

		$sort_order = array();

		$results = $this->model_setting_extension->getExtensions('total');

		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		}

		array_multisort($sort_order, SORT_ASC, $results);

		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('total/' . $result['code']);
					
				$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
			}
		}
		// Payment Methods
		$method_data = array();
			
		$this->load->model('setting/extension');
			
		$results = $this->model_setting_extension->getExtensions('payment');
			
		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('payment/' . $result['code']);

				$method = $this->{'model_payment_' . $result['code']}->getMethod($payment_address, $total);
					
				if ($method) {
					$method_data[$result['code']] = $method;
				}
			}
		}
			
		$sort_order = array();

		foreach ($method_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}
			
		array_multisort($sort_order, SORT_ASC, $method_data);
			
		$this->session->data['payment_methods'] = $method_data;

		if (isset($this->session->data['payment_methods']) && !$this->session->data['payment_methods']) {
			$this->data['error_warning'] = sprintf($this->language->get('error_no_payment'), $this->url->link('information/contact'));
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['payment_methods'])) {
			$this->data['payment_methods'] = $this->session->data['payment_methods'];
		} else {
			$this->data['payment_methods'] = array();
		}

		if (isset($this->session->data['payment_method']['code'])) {
			$this->data['payment_code'] = $this->session->data['payment_method']['code'];
			$this->customer->setPaymentMethod($this->data['payment_code']);
			$this->log->debug('IlexDebug:: Checkout payment_method 1 '. $this->data['payment_code']);
		} else if($this->customer->getPaymentMethod()!=''){
			$this->data['payment_code'] =  $this->customer->getPaymentMethod();
			$this->log->debug('IlexDebug:: Checkout payment_method 2 '. $this->data['payment_code']);
		} else{
			$this->data['payment_code']=$this->config->get('config_default_payment');
			$this->log->debug('IlexDebug:: Checkout payment_method 3 '. $this->data['payment_code']);
		}

		$this->session->data['payment_method']['code'] = $this->data['payment_code'] ;

		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

			if ($information_info) {
				$this->data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_checkout_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/payment.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/payment.tpl';
		} else {
			$this->template = 'default/template/checkout/payment.tpl';
		}
		return $this->render();

	}

	public function payment() {
		if (isset($this->session->data['payment_method'])) {
			$this->data['payment_code'] = $this->session->data['payment_method']['code'];
			$this->customer->setPaymentMethod($this->data['payment_code']);
			$this->log->debug('IlexDebug:: payment comfirm payment_method '. $this->data['payment_code']);
		} else if($this->customer->getPaymentMethod()!=''){
			$this->data['payment_code'] =  $this->customer->getPaymentMethod();
			$this->log->debug('IlexDebug:: payment comfirm 2 getPaymentMethod '. $this->data['payment_code']);
		} else{
			$this->data['payment_code']=$this->config->get('config_default_payment');
			$this->log->debug('IlexDebug:: payment comfirm 3  '. $this->data['payment_code']);
		}
			
		return $this->getChild('payment/' . $this->data['payment_code']);
	}

	public function confirm() {
		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) || !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		$this->load->model('account/address');
			
		if ($this->cart->hasShipping()) {
			$this->load->model('account/address');

			if ($this->customer->isLogged()) {
				if(isset($this->session->data['shipping_address_id']))
					$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
				else
					$shipping_address = $this->model_account_address->getAddress($this->customer->getAddressId());
			} else{
				$this->redirect($this->url->link('account/login', '', 'SSL'));
			}

			if (!isset($shipping_address)) {
				$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
			}

			if (!isset($this->session->data['shipping_method'])) {
				$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
			}
		} else {
			unset($this->session->data['guest']['shipping']);
			unset($this->session->data['shipping_address_id']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}

		$json = array();
		
		if (!$json) {
			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			$this->load->model('setting/extension');

			$sort_order = array();

			$results = $this->model_setting_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
					
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}

			$sort_order = array();

			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
				$this->log->debug('IlexDebug:: get total data '.$value['code']);
			}

			array_multisort($sort_order, SORT_ASC, $total_data);

			$this->language->load('checkout/checkout');

			$data = array();

			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');

			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');
			} else {
				$data['store_url'] = HTTP_SERVER;
			}

			if ($this->customer->isLogged()) {
				$data['customer_id'] = $this->customer->getId();
				$data['customer_group_id'] = $this->customer->getCustomerGroupId();
				$data['firstname'] = $this->customer->getFirstName();
				$data['lastname'] = $this->customer->getLastName();
				$data['email'] = $this->customer->getEmail();
				$data['telephone'] = $this->customer->getTelephone();
				$data['fax'] = $this->customer->getFax();
					
				$this->load->model('account/address');
				if(isset($this->session->data['payment_address_id'])){
					$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
				}
			} elseif (isset($this->session->data['guest'])) {
				$data['customer_id'] = 0;
				$data['customer_group_id'] = $this->config->get('config_customer_group_id');
				$data['firstname'] = $this->session->data['guest']['firstname'];
				$data['lastname'] = $this->session->data['guest']['lastname'];
				$data['email'] = $this->session->data['guest']['email'];
				$data['telephone'] = $this->session->data['guest']['telephone'];
				$data['fax'] = $this->session->data['guest']['fax'];

				$payment_address = $this->session->data['guest']['payment'];
			}

			if(isset($payment_address)){
				$data['payment_firstname'] = $payment_address['firstname'];
				$data['payment_lastname'] = $payment_address['lastname'];
				$data['payment_company'] = $payment_address['company'];
				$data['payment_address_1'] = $payment_address['address_1'];
				$data['payment_address_2'] = $payment_address['address_2'];
				$data['payment_city'] = $payment_address['city'];
				$data['payment_postcode'] = $payment_address['postcode'];
				$data['payment_zone'] = $payment_address['zone'];
				$data['payment_zone_id'] = $payment_address['zone_id'];
				$data['payment_country'] = $payment_address['country'];
				$data['payment_country_id'] = $payment_address['country_id'];
				$data['payment_address_format'] = $payment_address['address_format'];
			}else{
				$data['payment_firstname'] = '';
				$data['payment_lastname'] = '';
				$data['payment_company'] = '';
				$data['payment_address_1'] = '';
				$data['payment_address_2'] = '';
				$data['payment_city'] = '';
				$data['payment_postcode'] = '';
				$data['payment_zone'] = '';
				$data['payment_zone_id'] = '';
				$data['payment_country'] = '';
				$data['payment_country_id'] = '';
				$data['payment_address_format'] = '';
			}

			if (isset($this->session->data['payment_method']['title'])) {
				$data['payment_method'] = $this->session->data['payment_method']['title'];
			} else {
				$data['payment_method'] = $this->customer->getPaymentMethodTitle();
			}

			if ($this->cart->hasShipping()) {
				if ($this->customer->isLogged()) {
					$this->load->model('account/address');
					if(isset($this->session->data['shipping_address_id']))
						$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
					else
						$shipping_address = $this->model_account_address->getAddress($this->customer->getAddressId());

				} else{
					$this->redirect($this->url->link('account/login', '', 'SSL'));
				}

				$data['shipping_firstname'] = $shipping_address['firstname'];
				$data['shipping_lastname'] = $shipping_address['lastname'];
				$data['shipping_mobile'] = $shipping_address['mobile'];
				$data['shipping_phone'] = $shipping_address['phone'];
				$data['shipping_company'] = $shipping_address['company'];
				$data['shipping_address_1'] = $shipping_address['address_1'];
				$data['shipping_address_2'] = $shipping_address['address_2'];
				$data['shipping_city'] = $shipping_address['city'];
				$data['shipping_postcode'] = $shipping_address['postcode'];
				$data['shipping_zone'] = $shipping_address['zone'];
				$data['shipping_zone_id'] = $shipping_address['zone_id'];
				$data['shipping_country'] = $shipping_address['country'];
				$data['shipping_country_id'] = $shipping_address['country_id'];
				$data['shipping_address_format'] = $shipping_address['address_format'];
					
				if (isset($this->session->data['shipping_method']['title'])) {
					$data['shipping_method'] = $this->session->data['shipping_method']['title'];
				} else {
					$data['shipping_method'] = $this->customer->getShippingMethodTitle();
				}
			} else {
				$data['shipping_firstname'] = '';
				$data['shipping_lastname'] = '';
				$data['shipping_mobile'] ='';
				$data['shipping_phone'] = '';
				$data['shipping_company'] = '';
				$data['shipping_address_1'] = '';
				$data['shipping_address_2'] = '';
				$data['shipping_city'] = '';
				$data['shipping_postcode'] = '';
				$data['shipping_zone'] = '';
				$data['shipping_zone_id'] = '';
				$data['shipping_country'] = '';
				$data['shipping_country_id'] = '';
				$data['shipping_address_format'] = '';
				$data['shipping_method'] = '';
			}

			if ($this->cart->hasShipping()) {
				$this->tax->setZone($shipping_address['country_id'], $shipping_address['zone_id']);
			} else {
				$this->tax->setZone($payment_address['country_id'], $payment_address['zone_id']);
			}

			$product_data = array();

			foreach ($this->cart->getProducts() as $product) {
				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
  									'product_option_id'       => $option['product_option_id'],
  									'product_option_value_id' => $option['product_option_value_id'],
  									'product_option_id'       => $option['product_option_id'],
  									'product_option_value_id' => $option['product_option_value_id'],
  									'option_id'               => $option['option_id'],
  									'option_value_id'         => $option['option_value_id'],								   
  									'name'                    => $option['name'],
  									'value'                   => $option['option_value'],
  									'type'                    => $option['type']
						);
					} else {
						$this->load->library('encryption');

						$encryption = new Encryption($this->config->get('config_encryption'));

						$option_data[] = array(
  									'product_option_id'       => $option['product_option_id'],
  									'product_option_value_id' => $option['product_option_value_id'],
  									'product_option_id'       => $option['product_option_id'],
  									'product_option_value_id' => $option['product_option_value_id'],
  									'option_id'               => $option['option_id'],
  									'option_value_id'         => $option['option_value_id'],								   
  									'name'                    => $option['name'],
  									'value'                   => $encryption->decrypt($option['option_value']),
  									'type'                    => $option['type']
						);
					}
				}

				$product_data[] = array(
  							'product_id' => $product['product_id'],
  							'href' 		=> $this->url->link('product/product', '&product_id=' . $product['product_id']),
  							'name'       => $product['name'],
  							'model'      => $product['model'],
  							'option'     => $option_data,
  							'download'   => $product['download'],
  							'quantity'   => $product['quantity'],
  							'subtract'   => $product['subtract'],
  							'price'      => $product['price'],
  							'total'      => $product['total'],
  							'tax'        => $this->tax->getRate($product['tax_class_id'])
				);
			}

			// Gift Voucher
			if (isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$product_data[] = array(
  								'product_id' => 0,
  								'href' 		=> '#',
  								'name'       => $voucher['description'],
  								'model'      => '',
  								'option'     => array(),
  								'download'   => array(),
  								'quantity'   => 1,
  								'subtract'   => false,
  								'price'      => $voucher['amount'],
  								'total'      => $voucher['amount'],
  								'tax'        => 0
					);
				}
			}

			$data['products'] = $product_data;
			$this->data['products'] = $product_data;
			
			$data['totals'] = $total_data;
			
			if(isset($this->session->data['comment'])){
				$data['comment'] = $this->session->data['comment'];
			}else{
				$data['comment'] = '';
			}
			$data['total'] = $total;
			$data['reward'] = $this->cart->getTotalRewardPoints();

			if (isset($this->request->cookie['tracking'])) {
				$this->load->model('affiliate/affiliate');

				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

				if ($affiliate_info) {
					$data['affiliate_id'] = $affiliate_info['affiliate_id'];
					$data['commission'] = ($total / 100) * $affiliate_info['commission'];
				} else {
					$data['affiliate_id'] = 0;
					$data['commission'] = 0;
				}
			} else {
				$data['affiliate_id'] = 0;
				$data['commission'] = 0;
			}

			$data['language_id'] = $this->config->get('config_language_id');
			$data['currency_id'] = $this->currency->getId();
			$data['currency_code'] = $this->currency->getCode();
			$data['currency_value'] = $this->currency->getValue($this->currency->getCode());
			$data['ip'] = $this->request->server['REMOTE_ADDR'];

			$this->load->model('checkout/order');

			if (isset($this->session->data['payment_method'])) {
				$this->data['payment_code'] = $this->session->data['payment_method']['code'];
				$this->customer->setPaymentMethod($this->data['payment_code']);
				$this->log->debug('IlexDebug:: Checkout comfirm payment_method '. $this->data['payment_code']);
			} else if($this->customer->getPaymentMethod()!=''){
				$this->data['payment_code'] =  $this->customer->getPaymentMethod();
				$this->log->debug('IlexDebug:: Checkout comfirm 2 getPaymentMethod '. $this->data['payment_code']);
			} else{
				$this->data['payment_code']=$this->config->get('config_default_payment');
				$this->log->debug('IlexDebug:: Checkout comfirm 3  '. $this->data['payment_code']);
			}
				
			$data['payment_code']=$this->data['payment_code'];
				
			if(!isset($this->session->data['order_id']))
				$this->session->data['order_id'] = $this->model_checkout_order->create($data);
			else
				$this->model_checkout_order->modify($data);
				
			// Gift Voucher
			if (isset($this->session->data['vouchers']) && is_array($this->session->data['vouchers'])) {
				$this->load->model('checkout/voucher');

				foreach ($this->session->data['vouchers'] as $voucher) {
					$this->model_checkout_voucher->addVoucher($this->session->data['order_id'], $voucher);
				}
			}

			// Gift Voucher
			$this->data['vouchers'] = array();

			if (isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$this->data['vouchers'][] = array(
  						'description' => $voucher['description'],
  						'amount'      => $this->currency->format($voucher['amount'])
					);
				}
			}
				
			$this->data['totals'] = $total_data;
				
			if (isset($this->session->data['shipping_method']['title'])) {
				$this->data['shipping_method'] = $this->session->data['shipping_method']['title'];
			} else {
				$this->data['shipping_method'] = $this->customer->getShippingMethodTitle();
			}
				
			if (isset($this->session->data['payment_method']['title'])) {
				$this->data['payment_method'] = $this->session->data['payment_method']['title'];
			} else {
				$this->data['payment_method']= $this->customer->getPaymentMethodTitle();
			}
				
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/confirm.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/checkout/confirm.tpl';
			} else {
				$this->template = 'default/template/checkout/confirm.tpl';
			}

		}

		return $this->render();
	}
	
	
	public function update() {
		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) || !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}
	
		$this->load->model('account/address');
			
		if ($this->cart->hasShipping()) {
			$this->load->model('account/address');
	
			if ($this->customer->isLogged()) {
				if(isset($this->session->data['shipping_address_id']))
				$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
				else
				$shipping_address = $this->model_account_address->getAddress($this->customer->getAddressId());
			} else{
				$this->redirect($this->url->link('account/login', '', 'SSL'));
			}
	
			if (!isset($shipping_address)) {
				$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
			}
	
			if (!isset($this->session->data['shipping_method'])) {
				$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
			}
		} else {
			unset($this->session->data['guest']['shipping']);
			unset($this->session->data['shipping_address_id']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}
	
		$json = array();
	
		if (!$json) {
			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();
	
			$this->load->model('setting/extension');
	
			$sort_order = array();
	
			$results = $this->model_setting_extension->getExtensions('total');
	
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
	
			array_multisort($sort_order, SORT_ASC, $results);
	
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
						
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}
	
			$sort_order = array();
	
			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
				$this->log->debug('IlexDebug:: get total data '.$value['code']);
			}
	
			array_multisort($sort_order, SORT_ASC, $total_data);
	
			$this->language->load('checkout/checkout');
	
			$data = array();
	
			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');
	
			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');
			} else {
				$data['store_url'] = HTTP_SERVER;
			}
	
			if ($this->customer->isLogged()) {
				$data['customer_id'] = $this->customer->getId();
				$data['customer_group_id'] = $this->customer->getCustomerGroupId();
				$data['firstname'] = $this->customer->getFirstName();
				$data['lastname'] = $this->customer->getLastName();
				$data['email'] = $this->customer->getEmail();
				$data['telephone'] = $this->customer->getTelephone();
				$data['fax'] = $this->customer->getFax();
					
				$this->load->model('account/address');
				if(isset($this->session->data['payment_address_id'])){
					$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
				}
			} elseif (isset($this->session->data['guest'])) {
				$data['customer_id'] = 0;
				$data['customer_group_id'] = $this->config->get('config_customer_group_id');
				$data['firstname'] = $this->session->data['guest']['firstname'];
				$data['lastname'] = $this->session->data['guest']['lastname'];
				$data['email'] = $this->session->data['guest']['email'];
				$data['telephone'] = $this->session->data['guest']['telephone'];
				$data['fax'] = $this->session->data['guest']['fax'];
	
				$payment_address = $this->session->data['guest']['payment'];
			}
	
			if(isset($payment_address)){
				$data['payment_firstname'] = $payment_address['firstname'];
				$data['payment_lastname'] = $payment_address['lastname'];
				$data['payment_company'] = $payment_address['company'];
				$data['payment_address_1'] = $payment_address['address_1'];
				$data['payment_address_2'] = $payment_address['address_2'];
				$data['payment_city'] = $payment_address['city'];
				$data['payment_postcode'] = $payment_address['postcode'];
				$data['payment_zone'] = $payment_address['zone'];
				$data['payment_zone_id'] = $payment_address['zone_id'];
				$data['payment_country'] = $payment_address['country'];
				$data['payment_country_id'] = $payment_address['country_id'];
				$data['payment_address_format'] = $payment_address['address_format'];
			}else{
				$data['payment_firstname'] = '';
				$data['payment_lastname'] = '';
				$data['payment_company'] = '';
				$data['payment_address_1'] = '';
				$data['payment_address_2'] = '';
				$data['payment_city'] = '';
				$data['payment_postcode'] = '';
				$data['payment_zone'] = '';
				$data['payment_zone_id'] = '';
				$data['payment_country'] = '';
				$data['payment_country_id'] = '';
				$data['payment_address_format'] = '';
			}
	
			if (isset($this->session->data['payment_method']['title'])) {
				$data['payment_method'] = $this->session->data['payment_method']['title'];
			} else {
				$data['payment_method'] = $this->customer->getPaymentMethodTitle();
			}
	
			if ($this->cart->hasShipping()) {
				if ($this->customer->isLogged()) {
					$this->load->model('account/address');
					if(isset($this->session->data['shipping_address_id']))
					$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
					else
					$shipping_address = $this->model_account_address->getAddress($this->customer->getAddressId());
	
				} else{
					$this->redirect($this->url->link('account/login', '', 'SSL'));
				}
	
				$data['shipping_firstname'] = $shipping_address['firstname'];
				$data['shipping_lastname'] = $shipping_address['lastname'];
				$data['shipping_mobile'] = $shipping_address['mobile'];
				$data['shipping_phone'] = $shipping_address['phone'];
				$data['shipping_company'] = $shipping_address['company'];
				$data['shipping_address_1'] = $shipping_address['address_1'];
				$data['shipping_address_2'] = $shipping_address['address_2'];
				$data['shipping_city'] = $shipping_address['city'];
				$data['shipping_postcode'] = $shipping_address['postcode'];
				$data['shipping_zone'] = $shipping_address['zone'];
				$data['shipping_zone_id'] = $shipping_address['zone_id'];
				$data['shipping_country'] = $shipping_address['country'];
				$data['shipping_country_id'] = $shipping_address['country_id'];
				$data['shipping_address_format'] = $shipping_address['address_format'];
					
				if (isset($this->session->data['shipping_method']['title'])) {
					$data['shipping_method'] = $this->session->data['shipping_method']['title'];
				} else {
					$data['shipping_method'] = $this->customer->getShippingMethodTitle();
				}
			} else {
				$data['shipping_firstname'] = '';
				$data['shipping_lastname'] = '';
				$data['shipping_mobile'] ='';
				$data['shipping_phone'] = '';
				$data['shipping_company'] = '';
				$data['shipping_address_1'] = '';
				$data['shipping_address_2'] = '';
				$data['shipping_city'] = '';
				$data['shipping_postcode'] = '';
				$data['shipping_zone'] = '';
				$data['shipping_zone_id'] = '';
				$data['shipping_country'] = '';
				$data['shipping_country_id'] = '';
				$data['shipping_address_format'] = '';
				$data['shipping_method'] = '';
			}
	
			if ($this->cart->hasShipping()) {
				$this->tax->setZone($shipping_address['country_id'], $shipping_address['zone_id']);
			} else {
				$this->tax->setZone($payment_address['country_id'], $payment_address['zone_id']);
			}
	
			$product_data = array();
	
			foreach ($this->cart->getProducts() as $product) {
				$option_data = array();
	
				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
	  									'product_option_id'       => $option['product_option_id'],
	  									'product_option_value_id' => $option['product_option_value_id'],
	  									'product_option_id'       => $option['product_option_id'],
	  									'product_option_value_id' => $option['product_option_value_id'],
	  									'option_id'               => $option['option_id'],
	  									'option_value_id'         => $option['option_value_id'],								   
	  									'name'                    => $option['name'],
	  									'value'                   => $option['option_value'],
	  									'type'                    => $option['type']
						);
					} else {
						$this->load->library('encryption');
	
						$encryption = new Encryption($this->config->get('config_encryption'));
	
						$option_data[] = array(
	  									'product_option_id'       => $option['product_option_id'],
	  									'product_option_value_id' => $option['product_option_value_id'],
	  									'product_option_id'       => $option['product_option_id'],
	  									'product_option_value_id' => $option['product_option_value_id'],
	  									'option_id'               => $option['option_id'],
	  									'option_value_id'         => $option['option_value_id'],								   
	  									'name'                    => $option['name'],
	  									'value'                   => $encryption->decrypt($option['option_value']),
	  									'type'                    => $option['type']
						);
					}
				}
	
				$product_data[] = array(
	  							'product_id' => $product['product_id'],
	  							'href' 		=> $this->url->link('product/product', '&product_id=' . $product['product_id']),
	  							'name'       => $product['name'],
	  							'model'      => $product['model'],
	  							'option'     => $option_data,
	  							'download'   => $product['download'],
	  							'quantity'   => $product['quantity'],
	  							'subtract'   => $product['subtract'],
	  							'price'      => $product['price'],
	  							'total'      => $product['total'],
	  							'tax'        => $this->tax->getRate($product['tax_class_id'])
				);
			}
	
			// Gift Voucher
			if (isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$product_data[] = array(
	  								'product_id' => 0,
	  								'href' 		=> '#',
	  								'name'       => $voucher['description'],
	  								'model'      => '',
	  								'option'     => array(),
	  								'download'   => array(),
	  								'quantity'   => 1,
	  								'subtract'   => false,
	  								'price'      => $voucher['amount'],
	  								'total'      => $voucher['amount'],
	  								'tax'        => 0
					);
				}
			}
	
			$data['products'] = $product_data;
			$this->data['products'] = $product_data;
				
			$data['totals'] = $total_data;
				
			if(isset($this->session->data['comment'])){
				$data['comment'] = $this->session->data['comment'];
			}else{
				$data['comment'] = '';
			}
			$data['total'] = $total;
			$data['reward'] = $this->cart->getTotalRewardPoints();
	
			if (isset($this->request->cookie['tracking'])) {
				$this->load->model('affiliate/affiliate');
	
				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);
	
				if ($affiliate_info) {
					$data['affiliate_id'] = $affiliate_info['affiliate_id'];
					$data['commission'] = ($total / 100) * $affiliate_info['commission'];
				} else {
					$data['affiliate_id'] = 0;
					$data['commission'] = 0;
				}
			} else {
				$data['affiliate_id'] = 0;
				$data['commission'] = 0;
			}
	
			$data['language_id'] = $this->config->get('config_language_id');
			$data['currency_id'] = $this->currency->getId();
			$data['currency_code'] = $this->currency->getCode();
			$data['currency_value'] = $this->currency->getValue($this->currency->getCode());
			$data['ip'] = $this->request->server['REMOTE_ADDR'];
	
			$this->load->model('checkout/order');
	
			if (isset($this->session->data['payment_method'])) {
				$this->data['payment_code'] = $this->session->data['payment_method']['code'];
				$this->customer->setPaymentMethod($this->data['payment_code']);
				$this->log->debug('IlexDebug:: Checkout comfirm payment_method '. $this->data['payment_code']);
			} else if($this->customer->getPaymentMethod()!=''){
				$this->data['payment_code'] =  $this->customer->getPaymentMethod();
				$this->log->debug('IlexDebug:: Checkout comfirm 2 getPaymentMethod '. $this->data['payment_code']);
			} else{
				$this->data['payment_code']=$this->config->get('config_default_payment');
				$this->log->debug('IlexDebug:: Checkout comfirm 3  '. $this->data['payment_code']);
			}
	
			$data['payment_code']=$this->data['payment_code'];
	
			if(!isset($this->session->data['order_id']))
			$this->session->data['order_id'] = $this->model_checkout_order->create($data);
			else
			$this->model_checkout_order->modify($data);
	
			// Gift Voucher
			if (isset($this->session->data['vouchers']) && is_array($this->session->data['vouchers'])) {
				$this->load->model('checkout/voucher');
	
				foreach ($this->session->data['vouchers'] as $voucher) {
					$this->model_checkout_voucher->addVoucher($this->session->data['order_id'], $voucher);
				}
			}
	
			// Gift Voucher
			$this->data['vouchers'] = array();
	
			if (isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$this->data['vouchers'][] = array(
	  						'description' => $voucher['description'],
	  						'amount'      => $this->currency->format($voucher['amount'])
					);
				}
			}
	
			$this->data['totals'] = $total_data;
	
			if (isset($this->session->data['shipping_method']['title'])) {
				$this->data['shipping_method'] = $this->session->data['shipping_method']['title'];
			} else {
				$this->data['shipping_method'] = $this->customer->getShippingMethodTitle();
			}
	
			if (isset($this->session->data['payment_method']['title'])) {
				$this->data['payment_method'] = $this->session->data['payment_method']['title'];
			} else {
				$this->data['payment_method']= $this->customer->getPaymentMethodTitle();
			}
	
	
		}
	
		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
	 
	 
	public function validate() {
		$this->load_language('checkout/checkout');

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		if($this->request->get['token']==''){
			return true;
		}

		$json = array();

		if(!isset($this->session->data['payment_method']))
		$json['error']['warning'] = $this->language->get('error_payment');

		if($this->cart->hasShipping()){
			if(!isset($this->session->data['shipping_method']))
			$json['error']['warning'] = $this->language->get('error_shipping');
			 
			 
			if(!isset($this->session->data['shipping_address_id']))
			$json['error']['warning'] = $this->language->get('error_address');
		}

		if(!isset($json['error'])){
			$this->load->model('checkout/order');
			// added comment to order
			/*if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_checkout_order->updateOrderComment($this->session->data['order_id'],$this->request->post['comment']);
			}
			*/
			//TODO update order status to nonpay
			if($this->request->get['token']==$this->session->data['checkout_token']){
				if(isset($this->session->data['order_id'])){
					if(isset($this->session->data['payment_method']['code'])){
						if(!in_array($this->session->data['payment_method']['code'],$this->direct_payments)){
							$this->log->debug('IlexDebug:: Checkout Update updateOrderStatus() : order '.$this->session->data['order_id'] .' payment_method '.$this->session->data['payment_method']['code']);
							$this->model_checkout_order->updateOrderStatus($this->session->data['order_id'],$this->config->get('config_order_nopay_status_id'));
							$this->cart->clear();
							unset($this->session->data['shipping_method']);
							unset($this->session->data['shipping_methods']);
							unset($this->session->data['payment_method']);
							unset($this->session->data['payment_methods']);
							unset($this->session->data['guest']);
							unset($this->session->data['comment']);
							unset($this->session->data['order_id']);
							unset($this->session->data['coupon']);
							unset($this->session->data['voucher']);
							unset($this->session->data['vouchers']);
							unset($this->session->data['order_id']);
							unset($this->session->data['checkout_token']);
						}
					}
				}
			}
				
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}

}
?>