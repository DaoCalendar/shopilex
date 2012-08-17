<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="forgotten">
    <p><?php echo $text_email; ?></p>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_email; ?></td>
          <td><input type="text" name="email" value="" class="span4" /></td>
        </tr>
         <tr>
        	 <td>&nbsp;</td>
        	 <td>
        	 	<div class="left">
        	 		<input type="submit" class="button" value="<?php echo $button_submit; ?>" />
        	 	</div>
        	 </td>
        </tr>
      </table>
    </div>
 </form>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>