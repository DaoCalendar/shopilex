<?php if ($error_warning) { ?>
  <div class="alert alert-error"><?php echo $error_warning; ?><a class="close" data-dismiss="alert">×</a></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="alert alert-success"><?php echo $success; ?><a class="close" data-dismiss="alert">×</a></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h2> <?php echo $heading_title; ?></h2>
      <div class="buttons"><a onclick="$('#form').submit();" class="btn btn-primary"><span><?php echo $button_save; ?></span></a> <a onclick="location = '<?php echo $cancel; ?>';" class="btn"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <table class="form">
             <tr>
              <td><span class="required">*</span> <?php echo $entry_admin_limit; ?></td>
              <td><input type="text" name="config_admin_limit" value="<?php echo $config_admin_limit; ?>" size="3" />
                <?php if ($error_admin_limit) { ?>
                <span class="help-inline error"><?php echo $error_admin_limit; ?></span>
                <?php } ?></td>
            </tr>
              <tr>
              <td><?php echo $entry_invoice_prefix; ?></td>
              <td><input type="text" name="config_invoice_prefix" value="<?php echo $config_invoice_prefix; ?>" /></td>
            </tr>
          	<tr>
              <td><?php echo $entry_active; ?></td>
              <td><?php if ($config_active) { ?>
                <input type="radio" name="config_active" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_active" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_active" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_active" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_review; ?></td>
              <td><?php if ($config_review) { ?>
                <input type="radio" name="config_review" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_review" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_review" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_review" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
            
             <tr>
              <td><?php echo $entry_review_status; ?></td>
              <td><?php if ($config_review_status) { ?>
                <input type="radio" name="config_review_status" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_review_status" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_review_status" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_review_status" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
            
            <tr>
              <td><?php echo $entry_invite_points; ?></td>
              <td><?php if ($config_invite_points) { ?>
              		<input type="text" name="config_invite_points" value="<?php echo $config_invite_points; ?>" size="20" />
                <?php } else { ?>
                	<input type="text" name="config_invite_points" value="0" size="20" />
                <?php } ?></td>
            </tr>
               <tr>
              <td><?php echo $entry_admin_language; ?></td>
              <td><select name="config_admin_language">
                  <?php foreach ($languages as $language) { ?>
                  <?php if ($language['code'] == $config_admin_language) { ?>
                  <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_length_class; ?></td>
              <td><select name="config_length_class_id">
                  <?php foreach ($length_classes as $length_class) { ?>
                  <?php if ($length_class['length_class_id'] == $config_length_class_id) { ?>
                  <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_weight_class; ?></td>
              <td><select name="config_weight_class_id">
                  <?php foreach ($weight_classes as $weight_class) { ?>
                  <?php if ($weight_class['weight_class_id'] == $config_weight_class_id) { ?>
                  <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_affiliate; ?></td>
              <td><select name="config_affiliate_id">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($informations as $information) { ?>
                  <?php if ($information['information_id'] == $config_affiliate_id) { ?>
                  <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
           <tr>
              <td><?php echo $entry_commission; ?></td>
              <td><input type="text" name="config_commission" value="<?php echo $config_commission; ?>" size="3" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_stock_status; ?></td>
              <td><select name="config_stock_status_id">
                  <?php foreach ($stock_statuses as $stock_status) { ?>
                  <?php if ($stock_status['stock_status_id'] == $config_stock_status_id) { ?>
                  <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
      
            <tr>
              <td><?php echo $entry_stock_warning; ?></td>
              <td><?php if ($config_stock_warning) { ?>
                <input type="radio" name="config_stock_warning" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_stock_warning" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_stock_warning" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_stock_warning" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
           <tr>
              <td><?php echo $entry_complete_status; ?></td>
              <td><select name="config_complete_status_id">
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $config_complete_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>            
            <tr>
              <td><?php echo $entry_return_status; ?></td>
              <td><select name="config_return_status_id">
                  <?php foreach ($return_statuses as $return_status) { ?>
                  <?php if ($return_status['return_status_id'] == $config_return_status_id) { ?>
                  <option value="<?php echo $return_status['return_status_id']; ?>" selected="selected"><?php echo $return_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $return_status['return_status_id']; ?>"><?php echo $return_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
           
            <tr>
              <td><?php echo $entry_download; ?></td>
              <td><?php if ($config_download) { ?>
                <input type="radio" name="config_download" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_download" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_download" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_download" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_upload_allowed; ?></td>
              <td><textarea name="config_upload_allowed" cols="40" rows="5"><?php echo $config_upload_allowed; ?></textarea></td>
            </tr>
            <tr>
              <td><?php echo $entry_cart_weight; ?></td>
              <td><?php if ($config_cart_weight) { ?>
                <input type="radio" name="config_cart_weight" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_cart_weight" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_cart_weight" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_cart_weight" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
          </table>
      </form>
    </div>
  </div>
