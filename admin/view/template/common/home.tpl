 <div class="box" style="padding-top:10px;">
	   <?php if ($error_install) { ?>
	  <div class="alert alert-error"><?php echo $error_install; ?><a class="close" data-dismiss="alert">×</a></div>
	  <?php } ?>
	  <?php if ($error_image) { ?>
	  <div class="alert alert-error"><?php echo $error_image; ?><a class="close" data-dismiss="alert">×</a></div>
	  <?php } ?>
	  <?php if ($error_image_cache) { ?>
	  <div class="alert alert-error"><?php echo $error_image_cache; ?><a class="close" data-dismiss="alert">×</a></div>
	  <?php } ?>
	  <?php if ($error_cache) { ?>
	  <div class="alert alert-error"><?php echo $error_cache; ?><a class="close" data-dismiss="alert">×</a></div>
	  <?php } ?>
	  <?php if ($error_download) { ?>
	  <div class="alert alert-error"><?php echo $error_download; ?><a class="close" data-dismiss="alert">×</a></div>
	  <?php } ?>
	  <?php if ($error_logs) { ?>
	  <div class="alert alert-error"><?php echo $error_logs; ?><a class="close" data-dismiss="alert">×</a></div>
	  <?php } ?>
    <div class="content">
 	<div class="row">
 	    <div class="span6">
        <div class="dashboard-heading"><?php echo $text_overview; ?></div>
        <div class="dashboard-content">
          <table>
            <tr>
              <td><?php echo $text_total_sale; ?></td>
              <td><?php echo $total_sale; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_sale_year; ?></td>
              <td><?php echo $total_sale_year; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_order; ?></td>
              <td><?php echo $total_order; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_customer; ?></td>
              <td><?php echo $total_customer; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_customer_approval; ?></td>
              <td><?php echo $total_customer_approval; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_review_approval; ?></td>
              <td><?php echo $total_review_approval; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_affiliate; ?></td>
              <td><?php echo $total_affiliate; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_affiliate_approval; ?></td>
              <td><?php echo $total_affiliate_approval; ?></td>
            </tr>
          </table>
        </div>
      </div>
        <div class="span6">
        <div class="dashboard-heading"><?php echo $text_operation; ?></div>
        <div class="dashboard-content">
       		<dl>
       			<dt><?php echo $text_product; ?></dt>
       			<dd><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></dd>
                <dd><a href="<?php echo $add_category; ?>"><?php echo $text_add_category; ?></a></dd>
                <dd><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></dd>
                <dd><a href="<?php echo $add_product; ?>"><?php echo $text_add_product;?></a> </dd>
                <dd><a href="<?php echo $product; ?>"><?php echo $text_product; ?></a></dd>
        	</dl>
       		<dl>
       			<dt><?php echo $text_product_sth;?></dt>
       			<dd><a href="<?php echo $attribute_group;?>"><?php echo $text_attribute_group;?></a></dd>
                <dd><a href="<?php echo $attribute;?>"><?php echo $text_attribute;?></a></dd>
                <dd><a href="<?php echo $option;?>"><?php echo $text_option;?></a></dd>
                <dd><a href="<?php echo $review;?>"><?php echo $text_review;?></a> </dd>
                <dd><a href="<?php echo $download;?>"><?php echo $text_download;?></a></dd>
        	</dl>
        	<dl>
       			<dt><?php echo $text_customer_order;?></dt>
       			<dd><a href="<?php echo $order;?>"><?php echo $text_order;?></a></dd>
                <dd><a href="<?php echo $customer;?>"><?php echo $text_customer;?></a></dd>
                <dd><a href="<?php echo $customer_group;?>"><?php echo $text_customer_group;?></a></dd>
                <dd><a href="<?php echo $coupon;?>"><?php echo $text_coupon;?></a> </dd>
                <dd><a href="<?php echo $voucher;?>"><?php $text_present;?></a></dd>
        	</dl>
        	<dl>
       			<dt><?php echo $text_system;?></dt>
       			<dd><a href="<?php echo $setting;?>"><?php echo $text_setting;?></a></dd>
                <dd><a href="<?php echo $server;?>"><?php echo $text_server;?></a></dd>
                <dd><a href="<?php echo $custom;?>"><?php echo $text_custom;?></a> </dd>
                <dd><a href="<?php echo $banner;?>"><?php echo $text_banner;?></a></dd>
        	</dl>
         </div>
   	</div>
   </div>
      <div class="latest">
        <div class="dashboard-heading"><?php echo $text_latest_10_orders; ?></div>
        <div class="dashboard-content">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $column_order; ?></td>
                <td class="left"><?php echo $column_customer; ?></td>
                <td class="left"><?php echo $column_status; ?></td>
                <td class="left"><?php echo $column_date_added; ?></td>
                <td class="right"><?php echo $column_total; ?></td>
                <td class="right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($orders) { ?>
              <?php foreach ($orders as $order) { ?>
              <tr>
                <td class="left"><?php echo $order['order_id']; ?></td>
                <td class="left"><?php echo $order['customer']; ?></td>
                <td class="left"><?php echo $order['status']; ?></td>
                <td class="left"><?php echo $order['date_added']; ?></td>
                <td class="right"><?php echo $order['total']; ?></td>
                <td class="right"><?php foreach ($order['action'] as $action) { ?>
                  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                  <?php } ?></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
