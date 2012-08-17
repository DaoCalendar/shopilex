<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if (isset($success) && $success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="password">
    <div class="content">
      <table class="form">
       <tr>
          <td><span class="required">*</span> <?php echo $entry_old_password; ?></td>
          <td><input type="password" name="old_password" class="span4" value="<?php echo $old_password; ?>" />
            <?php if ($error_old_password) { ?>
            <span class="error"><?php echo $error_old_password; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_password; ?></td>
          <td><input type="password" name="password" class="span4" value="<?php echo $password; ?>" />
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
          <td><input type="password" name="confirm" class="span4" value="<?php echo $confirm; ?>" />
            <?php if ($error_confirm) { ?>
            <span class="error"><?php echo $error_confirm; ?></span>
            <?php } ?></td>
        </tr>
         <tr>
        	 <td>&nbsp;</td>
        	 <td>
        	 	<div class="left"><a onclick="$('#password').submit();" class="button"><span><?php echo $button_confirm; ?></span></a></div>
        	 </td>
          </tr>
      </table>
    </div>
  </form>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>