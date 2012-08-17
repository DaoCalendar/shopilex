<p>
  <input type="radio" checked="checked"   name="<?php echo $type; ?>_address" value="new" id="<?php echo $type; ?>-address-new" />
  <label for="<?php echo $type; ?>-address-new"><?php echo $text_address_new; ?></label>
</p>
<div id="<?php echo $type; ?>-new" >
  <table class="form">
    <tr>
      <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
      <td><input type="text" name="firstname" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
      <td><select name="zone_id" class="large-field"  onchange="$('#<?php echo $type; ?>-address select[name=\'city_id\']').load('index.php?route=common/localisation/city&zone_id=' + this.value);$('#tr_city_id').show();">
        </select></td>
    </tr>
    <tr	id="tr_city_id" style="display:none;">
      <td><span class="required">*</span> <?php echo $entry_city; ?></td>
      <td><select name="city_id" class="middle-field" onchange="$('input[name=\'city\']').val($(this).find('option:selected').text())"></td>
    </tr>
    <tr style="display:none;">
      <td><span class="required">*</span> <?php echo $entry_city; ?></td>
      <td><input type="text" name="city" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
      <td><input type="text" name="address_1" value="" class="large-field" /></td>
    </tr>
    <tr>
      <td><?php echo $entry_address_2; ?></td>
      <td><input type="text" name="address_2" value="" class="large-field" /></td>
    </tr>
     <tr>
      <td><span class="required">*</span> <?php echo $entry_postcode; ?></td>
      <td><input type="text" name="postcode" value="" class="large-field" /></td>
    </tr>
      <tr>
          <td><span class="required">*</span> <?php echo $entry_mobile; ?></td>
          <td><input type="text" name="mobile" value="" />
            </td>
        </tr>
        <tr>
          <td> <?php echo $entry_phone; ?></td>
          <td><input type="text" name="phone" value="" />
           </td>
    </tr>
  </table>
  <div class="left"><a id="button-address" class="button highlight"><span><?php echo $button_save; ?></span></a></div>
</div>
<br />

<script type="text/javascript"><!--
$('#<?php echo $type; ?>-address select[name=\'zone_id\']').load('index.php?route=common/localisation/zone&country_id=<?php echo $country_id; ?>');
//--></script> 