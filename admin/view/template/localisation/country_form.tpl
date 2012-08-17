  <?php if ($error_warning) { ?>
  <div class="alert alert-error"><?php echo $error_warning; ?><a class="close" data-dismiss="alert">×</a></div>
  <?php } ?>
  <div class="box">   
   <div class="heading">
      <h2> <?php echo $heading_title; ?></h2>
      <div class="buttons"><button onclick="$('#form').submit();" class="btn btn-primary"  ><?php echo $button_save; ?></button> <button onclick="location = '<?php echo $cancel; ?>';" class="btn"><?php echo $button_cancel; ?></button></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><input type="text" name="name" value="<?php echo $name; ?>" />
              <?php if ($error_name) { ?>
              <span class="error"><?php echo $error_name; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_iso_code_2; ?></td>
            <td><input type="text" name="iso_code_2" value="<?php echo $iso_code_2; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_iso_code_3; ?></td>
            <td><input type="text" name="iso_code_3" value="<?php echo $iso_code_3; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_address_format; ?></td>
            <td><textarea name="address_format" cols="40" rows="5"><?php echo $address_format; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_postcode_required; ?></td>
            <td><?php if ($postcode_required) { ?>
              <input type="radio" name="postcode_required" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="postcode_required" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="postcode_required" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="postcode_required" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="status">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
