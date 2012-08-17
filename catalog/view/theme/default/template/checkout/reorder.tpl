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
 	<div id="shipping-address">
      <div class="checkout-heading"><?php echo $text_checkout_shipping_address; ?>  </div>
      <div class="checkout-content">
     	 <?php echo $shipping_address; ?>
      </div>
    </div>
    <div id="confirm">
    <div class="checkout-heading"><?php echo $text_checkout_product; ?></div>
      <div class="checkout-content">
      		<?php echo $order_confirm;?>
      </div>
    </div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>