<?php echo $header; ?>
<div class="container"><?php echo $column_left; ?><?php echo $column_right; ?>
  <div id="content"><?php echo $content_top; ?>
    <div class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
      <?php } ?>
    </div>
    <h1><?php echo $heading_title; ?>
      <?php if ($weight) { ?>
      &nbsp;(<?php echo $weight; ?>)
      <?php } ?>
    </h1>
    <?php if ($attention) { ?>
    <div class="attention"><?php echo $attention; ?></div>
    <?php } ?>    
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="basket">
      <div class="cart-info">
        <table>
          <thead>
            <tr>
              <td class="image"><?php echo $column_image; ?></td>
              <td class="name"><?php echo $column_name; ?></td>
              <td class="model"><?php echo $column_model; ?></td>
              <td class="quantity"><?php echo $column_quantity; ?></td>
              <td class="price"><?php echo $column_price; ?></td>
              <td class="total"><?php echo $column_total; ?></td>
              <td class="remove"><?php echo $column_remove; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="image"><?php if ($product['thumb']) { ?>
                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                <?php } ?></td>
              <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                <?php if (!$product['stock']) { ?>
                <span class="stock">***</span>
                <?php } ?>
                <div>
                  <?php foreach ($product['option'] as $option) { ?>
                  - <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small><br />
                  <?php } ?>
                </div>
                <?php if ($product['points']) { ?>
                <small><?php echo $product['points']; ?></small>
                <?php } ?></td>
              <td class="model"><?php echo $product['model']; ?></td>
              <td class="quantity">
              <input type="button" value=" - " onclick="minus('quantity[<?php echo $product['key']; ?>]');" alt="<?php echo $text_minus; ?>" title="<?php echo $text_minus; ?>">
              <input style="min-width:10px;"type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" size="3" />
              <input type="button" value=" + " onclick="plus('quantity[<?php echo $product['key']; ?>]');" alt="<?php echo $text_plus; ?>" title="<?php echo $text_plus; ?>">
              </td>
              <td class="price"><?php echo $product['price']; ?></td>
              <td class="total"><?php echo $product['total']; ?></td>
              <td class="center">
              <a href="<?php echo $product['remove']; ?>" title="<?php echo $text_remove; ?>">
              	<img src="catalog/view/theme/default/image/remove.png" alt="<?php echo $text_remove; ?>" title="<?php echo $text_remove; ?>">
              </a>
              </td>
            </tr>
            <?php } ?>
            <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td class="image"></td>
              <td class="name"><?php echo $voucher['description']; ?></td>
              <td class="model"></td>
              <td class="quantity">1</td>
              <td class="price"><?php echo $voucher['amount']; ?></td>
              <td class="total"><?php echo $voucher['amount']; ?></td>
              <td></td>
            </tr>
            <?php } ?>
            <tr>
            <td colspan="7" align="right">
            	<a href="<?php echo $continue; ?>"><span><?php echo $button_shopping; ?></span></a>
            	<a onclick="$('#basket').submit();" class="button highlight"><span><?php echo $button_update; ?></span></a>
            </tr>
          </tbody>
        </table>
      </div>
    </form>

    <div class="cart-total">
      <table>
        <?php foreach ($totals as $total) { ?>
        <tr>
          <td colspan="5"></td>
          <td class="right"><b><?php echo $total['title']; ?>:</b></td>
          <td class="right"><?php echo $total['text']; ?></td>
        </tr>
        <?php } ?>
      </table>
    </div>
    <div class="clear"></div>
    <div class="buttons no_border">
    <div class="right">
      <a href="<?php echo $checkout; ?>" class="button highlight"><span><?php echo $button_checkout; ?></span></a>
    </div></div>
    <?php echo $content_bottom; ?></div>
</div>
<script type="text/javascript"><!--

function plus(name){
	var number=parseInt($('.cart-info input[name=\''+name+'\']').val())+ 1
	$('.cart-info input[name=\''+name+'\']').val(number);

	$('#basket').submit();
}

function minus(name){
	var number=parseInt($('.cart-info input[name=\''+name+'\']').val())- 1
	$('.cart-info input[name=\''+name+'\']').val(number);

	$('#basket').submit();
}
//--></script> 
<?php echo $footer; ?>