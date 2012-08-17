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
					url: 'index.php?route=payment/free_checkout/confirm',
					success: function() {
						location = '<?php echo $continue; ?>';
					}		
				});
			}
		}		
	});
});
//--></script> 