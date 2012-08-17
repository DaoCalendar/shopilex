<form action="<?php echo $action; ?>" method="post" id="payment">
  <input type="hidden" name="ap_merchant" value="<?php echo $ap_merchant; ?>" />
  <input type="hidden" name="ap_amount" value="<?php echo $ap_amount; ?>" />
  <input type="hidden" name="ap_currency" value="<?php echo $ap_currency; ?>" />
  <input type="hidden" name="ap_purchasetype" value="<?php echo $ap_purchasetype; ?>" />
  <input type="hidden" name="ap_itemname" value="<?php echo $ap_itemname; ?>" />
  <input type="hidden" name="ap_itemcode" value="<?php echo $ap_itemcode; ?>" />
  <input type="hidden" name="ap_returnurl" value="<?php echo $ap_returnurl; ?>" />
  <input type="hidden" name="ap_cancelurl" value="<?php echo $ap_cancelurl; ?>" />
  <div class="buttons">
    <div class="right"><a id="button-confirm" class="button"><span><?php echo $button_confirm; ?></span></a></div>
  </div>
</form>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
	$.ajax({ 
		type: 'GET',
		url: 'index.php?route=checkout/checkout/validate',
		dataType: 'json',
		beforeSend: function() {
			$('#button-confirm').attr('disabled', true);
		},	
		complete: function() {
			$('#button-confirm').attr('disabled', false);
		},	
		success: function(json) {
			if (json['error']) {
				if (json['error']['warning']) {
					alert(json['error']['warning']);
				}
			}else{
				$('#payment').submit();
			}
		}		
	});
});
//--></script> 