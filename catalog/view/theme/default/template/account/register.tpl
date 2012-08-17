<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
 <h1><?php echo $heading_title; ?></h1>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <p><?php echo $text_account_already; ?></p>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="register">
    <h2><?php echo $text_your_details; ?></h2>
    <div class="content">
      <table class="form">
       <tr>
          <td><span class="required">*</span> <?php echo $entry_email; ?></td>
          <td><input type="text" name="email" value="<?php echo $email; ?>" />
            <?php if ($error_email) { ?>
            <span class="error"><?php echo $error_email; ?></span>
            <?php } ?></td>
        </tr>
      
        <tr>
          <td><span class="required">*</span> <?php echo $entry_password; ?></td>
          <td><input type="password" name="password" value="<?php echo $password; ?>" />
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
          <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
            <?php if ($error_confirm) { ?>
            <span class="error"><?php echo $error_confirm; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span><?php echo $entry_captcha; ?></td>
          <td><input type="text" name="captcha" value="<?php echo $captcha; ?>" class="input-slim" />
   			<img id="captcha" onclick="refreshCaptcha($(this).attr('id'),$(this).attr('src'));" title="<?php echo $text_refresh_captcha; ?>" src="index.php?route=information/contact/captcha" alt="" />
   			<br />
            <?php if ($error_captcha) { ?>
		    <span class="error"><?php echo $error_captcha; ?></span>
		    <?php } ?></td>
        </tr>
        <?php if ($text_agree) { ?>
         <tr>
          <td>&nbsp;</td>
          <td>
        <label>
    <?php if ($agree) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
        <?php } ?>
        
        <?php echo $text_agree; ?>
        </label>
          </td>
        </tr>
        <?php } ?>
        <tr>
          <td>&nbsp;</td>
          <td>
		  <div class="left"><a onclick="$('#register').submit();" class="button highlight"><span><?php echo $button_register; ?></span></a></div>
          </td>
        </tr>
  
      </table>
    </div>
   <input type="hidden" name="newsletter" value="1"  />
   <input type="hidden" name="invite_code" value="<?php echo $invitecode; ?>" />
  </form>
  <?php echo $content_bottom; ?></div>

<script type="text/javascript" src="catalog/view/javascript/jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript"><!--
$('.fancybox').fancybox({
	width: 560,
	height: 560,
	autoDimensions: false
});
//--></script>  
<?php echo $footer; ?>