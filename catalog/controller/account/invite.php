<?php
class ControllerAccountInvite extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load_language('account/invite');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/customer');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->language->load('mail/invite');
			
			$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
			
			$message  = sprintf($this->language->get('text_greeting'), $this->config->get('config_name')) . "<br/>";
			$message .= $this->language->get('text_invite_link') . "<br/>";
			$message .= "<a href=".$this->url->link('account/register', '&invitecode='.$this->customer->getCode(), 'SSL').">". $this->url->link('account/register', '&invitecode='.$this->customer->getCode(), 'SSL')."</a>";

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');				
			$mail->setTo($this->request->post['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject($subject);
			$mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('account/invite', '', 'SSL'));
		}

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),        	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),     	
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/invite', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
				
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->data['action'] = $this->url->link('account/invite', '', 'SSL');
 
		$this->data['back'] = $this->url->link('account/login', '', 'SSL');
		
		$this->data['invite'] = $this->url->link('account/register', '&invitecode='.$this->customer->getCode(), 'SSL');
		
		$this->history();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/invite.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/invite.tpl';
		} else {
			$this->template = 'default/template/account/invite.tpl';
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

	private function history() {
		$this->load->model('account/customer');
		$this->language->load('account/invite');
		$invited_list=$this->model_account_customer->getInvitedHistory($this->session->data['customer_id']);
		$this->data['invites']=array();
		if($invited_list!=0){
			$this->data['invites']=$invited_list;
		}
	}
	
	private function validate() {
		if ($this->request->post['email']=='') {
			$this->error['warning'] = $this->language->get('error_email');
		} 
		
		if ($this->customer->checkEmailExist($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_email_exist');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>