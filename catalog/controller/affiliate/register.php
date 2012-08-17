<?php 
class ControllerAffiliateRegister extends Controller {
	private $error = array();
	      
  	public function index() {
		if ($this->affiliate->isLogged()) {
	  		$this->redirect($this->url->link('affiliate/account', '', 'SSL'));
    	}

    	$this->load_language('affiliate/register');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('affiliate/affiliate');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_affiliate_affiliate->addAffiliate($this->request->post);

			$this->affiliate->login($this->request->post['email'], $this->request->post['password']);

	  		$this->redirect($this->url->link('affiliate/success'));
    	} 

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),        	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('affiliate/account', '', 'SSL'),      	
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_register'),
			'href'      => $this->url->link('affiliate/register', '', 'SSL'),      	
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('affiliate/login', '', 'SSL'));
  
    	$errors=array(
    		'warning' => 'error_warning',
    	'firstname' => 'error_firstname',
    	'email' => 'error_email',
    	'telephone' => 'error_telephone',
    	'password' => 'error_password',
    	'confirm' => 'error_confirm',
    	'address_1' => 'error_address_1',
    	'city' => 'error_city',
    	'postcode' => 'error_postcode',
    	'country' => 'error_country',
    	'zone' => 'error_zone',
    		
    	);
    	
    	foreach ($errors as $key => $value) {
    		if (isset($this->error[$key])) {
    			$this->data[$value] = $this->error[$key];
    		} else {
    			$this->data[$value] = '';
    		}
    	}
    
		$this->data['action'] = $this->url->link('affiliate/register', '', 'SSL');

		if (isset($this->request->post['firstname'])) {
    		$this->data['firstname'] = $this->request->post['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['email'])) {
    		$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (isset($this->request->post['telephone'])) {
    		$this->data['telephone'] = $this->request->post['telephone'];
		} else {
			$this->data['telephone'] = '';
		}
		
		if (isset($this->request->post['fax'])) {
    		$this->data['fax'] = $this->request->post['fax'];
		} else {
			$this->data['fax'] = '';
		}
		
		if (isset($this->request->post['company'])) {
    		$this->data['company'] = $this->request->post['company'];
		} else {
			$this->data['company'] = '';
		}

		if (isset($this->request->post['website'])) {
    		$this->data['website'] = $this->request->post['website'];
		} else {
			$this->data['website'] = '';
		}
				
		if (isset($this->request->post['address_1'])) {
    		$this->data['address_1'] = $this->request->post['address_1'];
		} else {
			$this->data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
    		$this->data['address_2'] = $this->request->post['address_2'];
		} else {
			$this->data['address_2'] = '';
		}

		if (isset($this->request->post['postcode'])) {
    		$this->data['postcode'] = $this->request->post['postcode'];
		} else {
			$this->data['postcode'] = '';
		}
		
		if (isset($this->request->post['city_id'])) {
    		$this->data['city_id'] = $this->request->post['city_id'];
		} else {
			$this->data['city_id'] = '';
		}

    		
      	$this->data['country_id'] = $this->config->get('config_country_id');
    	

    	if (isset($this->request->post['zone_id'])) {
      		$this->data['zone_id'] = $this->request->post['zone_id']; 	
		} else {
      		$this->data['zone_id'] = '';
    	}
		
		$this->load->model('localisation/country');
		
    	$this->data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['tax'])) {
    		$this->data['tax'] = $this->request->post['tax'];
		} else {
			$this->data['tax'] = '';
		}
		
		if (isset($this->request->post['payment'])) {
    		$this->data['payment'] = $this->request->post['payment'];
		} else {
			$this->data['payment'] = 'cheque';
		}

		if (isset($this->request->post['cheque'])) {
    		$this->data['cheque'] = $this->request->post['cheque'];
		} else {
			$this->data['cheque'] = '';
		}

		if (isset($this->request->post['paypal'])) {
    		$this->data['paypal'] = $this->request->post['paypal'];
		} else {
			$this->data['paypal'] = '';
		}

		if (isset($this->request->post['bank_name'])) {
    		$this->data['bank_name'] = $this->request->post['bank_name'];
		} else {
			$this->data['bank_name'] = '';
		}

		if (isset($this->request->post['bank_branch_number'])) {
    		$this->data['bank_branch_number'] = $this->request->post['bank_branch_number'];
		} else {
			$this->data['bank_branch_number'] = '';
		}

		if (isset($this->request->post['bank_swift_code'])) {
    		$this->data['bank_swift_code'] = $this->request->post['bank_swift_code'];
		} else {
			$this->data['bank_swift_code'] = '';
		}

		if (isset($this->request->post['bank_account_name'])) {
    		$this->data['bank_account_name'] = $this->request->post['bank_account_name'];
		} else {
			$this->data['bank_account_name'] = '';
		}
		
		if (isset($this->request->post['bank_account_number'])) {
    		$this->data['bank_account_number'] = $this->request->post['bank_account_number'];
		} else {
			$this->data['bank_account_number'] = '';
		}
																		
		if (isset($this->request->post['password'])) {
    		$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}
		
		if (isset($this->request->post['confirm'])) {
    		$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		}

		if ($this->config->get('config_affiliate_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_affiliate_id'));
			
			if ($information_info) {
				$this->data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_affiliate_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}
		
		if (isset($this->request->post['agree'])) {
      		$this->data['agree'] = $this->request->post['agree'];
		} else {
			$this->data['agree'] = false;
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/register.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/register.tpl';
		} else {
			$this->template = 'default/template/affiliate/register.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
				
		$this->response->setOutput($this->render());	
  	}

  	private function validate() {
    	if ((strlen(utf8_decode($this->request->post['firstname'])) < 1) || (strlen(utf8_decode($this->request->post['firstname'])) > 32)) {
      		$this->error['firstname'] = $this->language->get('error_firstname');
    	}

    	if ((strlen(utf8_decode($this->request->post['email'])) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ($this->model_affiliate_affiliate->getTotalAffiliatesByEmail($this->request->post['email'])) {
      		$this->error['warning'] = $this->language->get('error_exists');
    	}
		
    	if ((strlen(utf8_decode($this->request->post['telephone'])) < 1) || (strlen(utf8_decode($this->request->post['telephone'])) > 32)) {
      		$this->error['telephone'] = $this->language->get('error_telephone');
    	}

    	if ((strlen(utf8_decode($this->request->post['address_1'])) < 1) || (strlen(utf8_decode($this->request->post['address_1'])) > 128)) {
      		$this->error['address_1'] = $this->language->get('error_address_1');
    	}

    	if ($this->request->post['city_id'] == '') {
    		$this->error['city'] = $this->language->get('error_city');
    	}
    	
		$this->load->model('localisation/country');
		
		$country_info = $this->model_localisation_country->getCountry($this->config->get('config_country_id'));
		
		if ($country_info && $country_info['postcode_required'] && (strlen(utf8_decode($this->request->post['postcode'])) < 2) || (strlen(utf8_decode($this->request->post['postcode'])) > 10)) {
			$this->error['postcode'] = $this->language->get('error_postcode');
		}

    	if ($this->request->post['zone_id'] == '') {
      		$this->error['zone'] = $this->language->get('error_zone');
    	}

    	if ((strlen(utf8_decode($this->request->post['password'])) < 4) || (strlen(utf8_decode($this->request->post['password'])) > 20)) {
      		$this->error['password'] = $this->language->get('error_password');
    	}

    	if ($this->request->post['confirm'] != $this->request->post['password']) {
      		$this->error['confirm'] = $this->language->get('error_confirm');
    	}
		
		if ($this->config->get('config_affiliate_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_affiliate_id'));
			
			if ($information_info && !isset($this->request->post['agree'])) {
      			$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}
		
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}

}
?>