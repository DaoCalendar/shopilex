<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
<div class="breadcrumb"><?php foreach ($breadcrumbs as $breadcrumb) { ?>
<?php echo $breadcrumb['separator']; ?><a
	href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
<?php } ?></div>

<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?> <?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="login-content">
<div class="right">
<div class="content">
<h2><?php echo $text_new_customer; ?></h2>
<form action="<?php echo $register; ?>" method="post" enctype="multipart/form-data" id="register">

  <table class="form">
	<tr>
		<td><span class="required">*</span> <?php echo $entry_email; ?></td>
		<td><input type="text" name="email" value="<?php echo $email; ?>" /> <?php if ($error_email) { ?>
		<span class="error"><?php echo $error_email; ?></span> <?php } ?></td>
	</tr>
	<tr>
		<td><span class="required">*</span> <?php echo $entry_password; ?></td>
		<td><input type="password" name="password"
			value="<?php echo $password; ?>" /> <?php if ($error_password) { ?> <span
			class="error"><?php echo $error_password; ?></span> <?php } ?></td>
	</tr>
	<tr>
		<td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
		<td><input type="password" name="confirm"
			value="<?php echo $confirm; ?>" /> <?php if ($error_confirm) { ?> <span
			class="error"><?php echo $error_confirm; ?></span> <?php } ?></td>
	</tr>
	<tr>
		<td><span class="required">*</span><?php echo $entry_captcha; ?></td>
		<td>
		<input type="text" name="captcha" value="<?php echo $captcha; ?>" class="input-slim" /> 
		<img id="captcha" src="index.php?route=information/contact/captcha" onclick="refreshCaptcha($(this).attr('id'),$(this).attr('src'));" title="<?php echo $text_refresh_captcha; ?>" alt="" />
		<br />
		<?php if ($error_captcha) { ?> 
		<span class="error"><?php echo $error_captcha; ?></span>
		<?php } ?>
		</td>
	</tr>
	<script type="text/javascript">
	
	</script>
	<?php if ($text_agree) { ?>
	<tr>
		<td>&nbsp;</td>
		<td>
		<?php if ($agree) { ?> 
		<label><input type="checkbox" name="agree" value="1" checked="checked" /></label> 
		<?php } else { ?> 
		<input type="checkbox" name="agree" value="1" /> 
		<?php } ?> <?php echo $text_agree; ?>
		</label></td>
	</tr>
	<?php } ?>
	<tr>
		<td>&nbsp;</td>
		<td>
		<div class="left"><a onclick="$('#register').submit();"
			class="button highlight"><span><?php echo $button_register; ?></span></a></div>
		</td>
	</tr>
  </table>
<input type="hidden" name="newsletter" value="1" /> 
<input type="hidden" name="invite_code" value="<?php echo $invitecode; ?>" />
</form>
</div>
</div>

<div class="left">
<div class="content">
<h2><?php echo $text_returning_customer; ?></h2>
<form action="<?php echo $action; ?>" method="post"
	enctype="multipart/form-data" id="login">
<div style="width: 300px; margin: 0 auto;"><b><?php echo $entry_email; ?></b><br />
<input type="text" name="email" value="" class="span4" /><br />
<br />
<b><?php echo $entry_password; ?></b><br />
<input type="password" name="password" value="" class="span4" /><br />
<br />
<div class="left"><a onclick="$('#login').submit();" class="button"><span><?php echo $button_login; ?></span></a>
<a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>
	<?php if ($redirect) { ?> <input type="hidden" name="redirect"
	value="<?php echo $redirect; ?>" /> <?php } ?></div>
</form>
</div>
</div>
</div>
	<?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});
//--></script>

<script
	type="text/javascript"
	src="catalog/view/javascript/jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css"
	href="catalog/view/javascript/jquery/fancybox/jquery.fancybox-1.3.4.css"
	media="screen" />
<script type="text/javascript"><!--
$('.fancybox').fancybox({
	width: 560,
	height: 560,
	autoDimensions: false
});
//--></script>
<?php echo $footer; ?>