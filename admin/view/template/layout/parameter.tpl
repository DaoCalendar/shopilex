<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="view/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="view/bootstrap/css/bootstrap-responsive.css" />
<script src="view/bootstrap/js/jquery.js"></script>
<script src="view/bootstrap/js/bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.9.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/ui/themes/flick/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="view/javascript/jquery/ui/external/jquery.bgiframe-2.1.2.js"></script>
<script type="text/javascript" src="view/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="view/javascript/jquery/superfish/js/superfish.js"></script>

<link rel="stylesheet" type="text/css" href="view/javascript/upload/fileuploader.css" />
<script type="text/javascript" src="view/javascript/upload/fileuploader.js"></script>

<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<script type="text/javascript">
//-----------------------------------------
// Confirm Actions (delete, uninstall)
//-----------------------------------------

$(document).ready(function(){
	// Confirm Delete
    $('#form').submit(function(){
        if ($(this).attr('action').indexOf('delete',1) != -1) {
            if (!confirm ('<?php echo $text_confirm; ?>')) {
                return false;
            }
        }
    });

    // Confirm Uninstall
    $('a').click(function(){
        if ($(this).attr('href') != null && $(this).attr('href').indexOf('uninstall',1) != -1) {
            if (!confirm ('<?php echo $text_confirm; ?>')) {
                return false;
            }
        }
    });
});
</script>
</head>
<body>
<div id="container">
	<div id="header">
	  <?php echo $header; ?>
	</div>
	<div id="content" style="padding-top:80px;">
		<?php if(isset($breadcrumbs)&&$breadcrumbs) {?>
		<div id="breadcrumb" class="navbar navbar-fixed-top" style="margin-top:40px;z-index:100;">
		<ul class="breadcrumb">
		<i class="icon-home"></i>
			<?php foreach ($breadcrumbs as $index => $breadcrumb) { ?>
				<li ><a href="<?php echo $breadcrumb['href']; ?>" style="z-index: <?php echo count($breadcrumbs)-$index; ?>;"><span class="left-yarn"></span><?php echo $breadcrumb['text']; ?></a><span class="divider">/</span></li>
			<?php } ?>
		</ul>
		</div>
		<?php } ?>
	  	<div class="container-fluid" style="padding:0px 10px 10px 10px;">
	  	<div class="row-fluid">
	  		<div class="span2 ">
	  		<ul class="nav nav-list well">
				<li><a href="<?php echo $custom; ?>"><?php echo $text_custom;?></a></li>
				<li><a href="<?php echo $server; ?>"><?php echo $text_server;?></a></li>
				<li><a href="<?php echo $mail; ?>"><?php echo $text_mail;?></a></li>
				<li><a href="<?php echo $im; ?>"><?php echo $text_im;?></a></li>
		        <li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li>
              	<li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li>
              	<li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li>
              	<li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li>
              	<li><a href="<?php echo $logistics; ?>"><?php echo $text_logistics;?></a></li>
	              <li class="nav-header">
				    <?php echo $text_return;?>
				  </li>
			      <li><a href="<?php echo $return_status; ?>"><?php echo $text_return_status; ?></a></li>
                  <li><a href="<?php echo $return_action; ?>"><?php echo $text_return_action; ?></a></li>
                  <li><a href="<?php echo $return_reason; ?>"><?php echo $text_return_reason; ?></a></li>
        		<li class="nav-header">
				    <?php echo $text_localisation_zone;?>
				  </li>
	              <li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li>
	              <li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li>
	              <li><a href="<?php echo $city; ?>"><?php echo $text_city;?></a></li>
	              <li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li>
	             <li class="nav-header">
					<?php echo $text_tax;?>
				</li>
	             <li><a href="<?php echo $tax_class; ?>"><?php echo $text_tax_class; ?></a></li>
	             <li class="nav-header">
					 <?php echo $text_specification;?>
				 </li>
              <li><a href="<?php echo $length_class; ?>"><?php echo $text_length_class; ?></a></li>
              <li><a href="<?php echo $weight_class; ?>"><?php echo $text_weight_class; ?></a></li>
		      </ul>
	  		</div>
	  		<div class="span10"><?php echo $content; ?></div>
	  	</div>
	  	</div>
	</div>
	<div id="footer">
		<?php echo $footer; ?>
	</div>
</div>
		<div id="myguide" class="modal hide fade" style="display: none; ">
            <div class="modal-header">
              <a class="close" data-dismiss="modal">×</a>
              <h3><?php echo $text_help;?> - <?php echo $title;?></h3>
            </div>
            <div class="modal-body">
            	<?php if(isset($guide)) echo $guide;?>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn " data-dismiss="modal"><?php echo $text_close;?></a>
            </div>
         </div>
</body>
</html>