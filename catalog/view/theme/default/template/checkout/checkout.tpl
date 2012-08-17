<?php echo $checkout_header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <input name="verified" type="hidden" id="verified" vvalue="1" >
  <div id="warnning">
  </div>
  <div class="checkout">
 	<?php if ($shipping_required) { ?>
    <div id="shipping-address">
      <div class="checkout-heading"><?php echo $text_checkout_shipping_address; ?> <?php if($has_address) { ?>  <a><?php echo $text_modify; ?></a> <?php } ?> </div>
      <div class="checkout-content">
     	 <?php echo $shipping_address; ?>
      </div>
    </div>
     <div id="shipping-method">
	    <div class="checkout-heading"><?php echo $text_checkout_shipping_method; ?></div>
	      <div class="checkout-content">
	         <?php echo $shipping_methods; ?>
	        </div>
	 </div>
	<?php } ?>
    <div id="payment-method">
      <div class="checkout-heading"><?php echo $text_checkout_payment_method; ?></div>
      <div class="checkout-content">
      		 <?php echo $payment_methods; ?> 
      </div>
    </div>
	<div id="confirm">
	   <div class="checkout-heading"><?php echo $text_checkout_product; ?><a href="<?php echo $cart; ?>"><?php echo $text_modify_cart;?></a></div>
       <div class="checkout-content">
      		<?php echo $order_confirm;?>
      </div>
    </div>
    
    <div class="cart-module">
      <?php foreach ($modules as $module) { ?>
      <?php echo $module; ?>
      <?php } ?>
    </div>
    
     <div id="payment-button">
	    <div class="checkout-content">
	     <div class="columns">
	    <div class="c30l">
	    <?php if($has_address&&isset($payment_method)&&$payment_method!=''&&isset($shipping_method)&&$shipping_method!='') { ?> 
			<?php echo $text_checkout_payment_method;?> : <b><?php echo $payment_method;?></b>   
			<br /><br />
			<?php echo $text_checkout_shipping_method;?> : <b><?php echo $shipping_method;?></b>
  		<?php } ?>
  		</div>
  		<div class="c30l checkout-total">
  			<?php foreach ($totals as $total) { ?>
		      <div class="<?php echo $total['code']; ?>">
		      	<span class="price"><?php echo $total['title']; ?>:</span>
		      	<span class="total number"><b><?php echo $total['text']; ?></b></span>
		      </div><br />
		    <?php } ?>
  		</div>
  		
  		<div class="payment c30r">
			<?php echo $payment; ?>
		</div>
		
  		</div>
		
	    	
	    </div>
    </div>
 </div>
  <?php echo $content_bottom; ?>
</div>
<script type="text/javascript"><!--
$('.cart-module .cart-heading').bind('click', function() {
	if ($(this).hasClass('active')) {
		$(this).removeClass('active');
	} else {
		$(this).addClass('active');
	}
		
	$(this).parent().find('.cart-content').slideToggle('slow');
});

$('#checkout-comment .checkout-heading').bind('click', function() {
	$('#checkout-comment .checkout-content').slideDown('slow');
});

// Shipping Address			
$('#shipping-address #button-address').live('click', function() {
	$('#warnning').html('');
	$.ajax({
		url: 'index.php?route=checkout/address/shipping',
		type: 'post',
		data: $('#shipping-address input[type=\'text\'], #shipping-address input[type=\'password\'], #shipping-address input[type=\'checkbox\']:checked, #shipping-address input[type=\'radio\']:checked, #shipping-address select'),
		dataType: 'json',
		beforeSend: function() {
			$('#shipping-address #button-address').attr('disabled', true);
			$('#shipping-address #button-address').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},	
		complete: function() {
			$('#shipping-address #button-address').attr('disabled', false);
			$('.wait').remove();
		},			
		success: function(json) {
			$('.error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['error']) {
				if (json['error']['firstname']) {
					$('#shipping-address input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}

				if (json['error']['email']) {
					$('#shipping-address input[name=\'email\']').after('<span class="error">' + json['error']['email'] + '</span>');
				}
				
				if (json['error']['mobile']) {
					$('#shipping-address input[name=\'mobile\']').after('<span class="error">' + json['error']['mobile'] + '</span>');
				}		
										
				if (json['error']['address_1']) {
					$('#shipping-address input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}	
				
				if (json['error']['city']) {
					$('#shipping-address input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					$('#shipping-address input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
			
				
				if (json['error']['zone']) {
					$('#shipping-address select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
			} else {
				if (json['address']) {
					$('#shipping-address .checkout-content').html(json['address']);
				}	
				
				$.ajax({
					url: 'index.php?route=checkout/shipping',
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}
									
						if (json['output']) {
							$('#shipping-method .checkout-content').html(json['output']);
							
							$('#shipping-address .checkout-heading a').remove();
							$('#shipping-address .checkout-heading').prepend('<a><?php echo $text_modify; ?></a>');							
						}
					}
				});	

				$.ajax({
					url: 'index.php?route=checkout/payment',
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}
									
						if (json['output']) {
							$('#payment-method .checkout-content').html(json['output']);
						}
					}
				});	

				checkoutComfirm();
			}  
		}
	});	
});

 $('#shipping-address .checkout-heading a').live('click', function() {
	$(document).ready(function() {
		
	    $('#shipping-address .checkout-heading a').remove();
		$.ajax({
			url: 'index.php?route=checkout/address/shipping&action=modifyad',
			dataType: 'json',
			success: function(json) {
				if (json['output']) {
					$('#shipping-address .checkout-content').html(json['output']);
					
					$('#shipping-address .checkout-content').slideDown('slow');
					
				}
			}
		});	
	});
});

$("input[name='shipping_method']").live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/shipping',
		type: 'post',
		data: $('#shipping-method input[type=\'radio\']:checked, #shipping-method textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-shipping').attr('disabled', true);
			$('#button-shipping').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},	
		complete: function() {
			$('#button-shipping').attr('disabled', false);
			$('.wait').remove();
		},			
		success: function(json) {
			$('.warning').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['error']) {
				if (json['error']['warning']) {
					$('#shipping-method .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');
					
					$('.warning').fadeIn('slow');
				}			
			} else {
				
				checkoutComfirm();		
			}
		}
	});	
});


$("input[name='payment_method']").live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/payment', 
		type: 'post',
		data: $('#payment-method input[type=\'radio\']:checked, #payment-method input[type=\'checkbox\']:checked, #payment-method textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-payment').attr('disabled', true);
			$('#button-payment').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},	
		complete: function() {
			$('#button-payment').attr('disabled', false);
			$('.wait').remove();
		},			
		success: function(json) {
			$('.warning').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['error']) {
				if (json['error']['warning']) {
					$('#payment-method .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');
					
					$('.warning').fadeIn('slow');
				}			
			} else {
				checkoutComfirm();			
			}
		}
	});	
});



function checkoutComfirm(){
	$.ajax({
		url: 'index.php?route=checkout/checkout/update',
		dataType: 'json',
		success: function(json) {
			if (json['redirect']) {
				location = json['redirect'];
			}	
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});

		
	$.ajax({
		url: 'index.php?route=checkout/confirm/payment',
		dataType: 'json',
		success: function(json) {
			if (json['redirect']) {
				location = json['redirect'];
			}	
		
			if (json['output']) {
				$('#payment-button').html(json['output']);

			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});	
	
}

//--></script> 
<?php echo $footer; ?>