<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($orders) { ?>
   <table class="list">
  	<thead>
  		<tr>
  			<td class="left"><?php echo $text_order_id; ?></td>
  			<td><?php echo $text_status; ?></td>
  			<td><?php echo $text_products; ?></td>
  			<td><?php echo $text_total; ?></td>
  			<td><?php echo $text_date_added; ?></td>
  			
  			<td class="center"><?php echo $text_action; ?></td>
  		</tr>
  	</thead>
  	<tbody>
  	<?php foreach ($orders as $order) { ?>
  		<tr>
  			<td class="left">#<?php echo $order['order_id']; ?></td>
  			<td><?php echo $order['status']; ?></td>
  			<td><?php echo $order['products']; ?></td>
  			<td><?php echo $order['total']; ?></td>
  			<td><?php echo $order['date_added']; ?></td>
  			
  			<td class="center"><a href="<?php echo $order['href']; ?>"><span><?php echo $button_view; ?></span></a></td>
  		</tr>
  	<?php } ?>
  	</tbody>
  </table>
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <?php } ?>

  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>