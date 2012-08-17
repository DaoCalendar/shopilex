<h2><?php echo $text_instruction; ?></h2>
<p><b><?php echo $text_payable; ?></b></p>
<p><?php echo $payable; ?></p>
<b><?php echo $text_address; ?></b><br />
<p><?php echo $address; ?></p>
<p><?php echo $text_payment; ?></p>
<div class="buttons">
  <div class="right"><a id="button-confirm" class="button"><span><?php echo $button_confirm; ?></span></a></div>
</div>

<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
	$.ajax({ 
		url: 'index.php?route=checkout/checkout/validate&token=<?php echo $token; ?>',
		type: 'post',
		data: $('#checkout-comment textarea'),
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
				$.ajax({ 
					type: 'GET',
					url: 'index.php?route=payment/cheque/confirm',
					success: function() {
						location = '<?php echo $continue; ?>';
					}		
				});
			}
		}		
	});
});
//--></script> 