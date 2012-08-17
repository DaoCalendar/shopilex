<?php  
class ControllerModuleOnlineIm extends Controller {
	protected function index() {
		$this->language->load('module/onlineim');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
      	$this->data['ims']= $this->config->get('ims');
      	$this->data['store']= $this->config->get('config_name');
      	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/onlineim.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/onlineim.tpl';
		} else {
			$this->template = 'default/template/module/onlineim.tpl';
		}
		
		$this->render();
	}
}
?>