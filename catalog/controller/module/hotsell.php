<?php
class ControllerModuleHotsell extends Controller {
	protected function index($setting) {
		$this->load_language('module/hotsell');
 
      	$this->data['heading_title'] = $this->language->get('heading_title');
				
		$this->data['button_cart'] = $this->language->get('button_cart');
		
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');

		$this->data['products'] = array();
		
		$product_data = array();
		
		$cate_sql='';
		if(isset($this->request->get['path'])){
			$path=str_replace('_',',',$this->request->get['path']);  
			$cate_sql.="LEFT JOIN  ( SELECT product_id FROM  " . DB_PREFIX . "product_to_category  WHERE category_id IN ('".$path."') ) ptc ON (op.product_id = ptc.product_id)  ";
		}else{
			if(isset($this->request->get['product_id'])){
				$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category p WHERE product_id ='".$this->request->get['product_id']."'");
				$cate_id="";
				$count=0;
				foreach ($query->rows as $result) {
					if($count==0)
						$cate_id.=$result['category_id'];
					else
						$cate_id.=','.$result['category_id'];
					$count++;
				}
				$cate_sql.="LEFT JOIN  ( SELECT product_id FROM  " . DB_PREFIX . "product_to_category  WHERE category_id IN ('".$cate_id."') ) ptc ON (op.product_id = ptc.product_id) ";
			}
		}
		$sql="SELECT op.product_id ,count(op.product_id) AS count  FROM " . DB_PREFIX . "order_product op ";
		
		if($cate_sql!='')
			$sql.=$cate_sql;
		$sql.=" LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = op.product_id)  WHERE p.status = '1' AND p.date_available <= NOW() GROUP BY op.product_id ORDER BY count DESC  LIMIT " . (int)$setting['limit'];
		
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) { 		
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}
					 	 		
		$results = $product_data;
		
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', $setting['image_width'], $setting['image_height']);
			}
			
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}	
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
							
			$this->data['products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/hotsell.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/hotsell.tpl';
		} else {
			$this->template = 'default/template/module/hotsell.tpl';
		}

		$this->render();
	}
}
?>