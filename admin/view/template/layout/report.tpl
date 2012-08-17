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
	  			<li class="nav-header">
				  <?php echo $text_sale; ?>
				</li>
				  <li><a href="<?php echo $report_sale_order; ?>"><?php echo $text_report_sale_order; ?></a></li>
	              <li><a href="<?php echo $report_sale_tax; ?>"><?php echo $text_report_sale_tax; ?></a></li>
	              <li><a href="<?php echo $report_sale_shipping; ?>"><?php echo $text_report_sale_shipping; ?></a></li>
	              <li><a href="<?php echo $report_sale_return; ?>"><?php echo $text_report_sale_return; ?></a></li>
	              <li><a href="<?php echo $report_sale_coupon; ?>"><?php echo $text_report_sale_coupon; ?></a></li>
	            <li class="nav-header">
				  <?php echo $text_product; ?>
				</li>
              	  <li><a href="<?php echo $report_product_viewed; ?>"><?php echo $text_report_product_viewed; ?></a></li>
            	  <li><a href="<?php echo $report_product_purchased; ?>"><?php echo $text_report_product_purchased; ?></a></li>
            	 <li class="nav-header">
				   <?php echo $text_customer; ?>
				  </li>
	              <li><a href="<?php echo $report_customer_order; ?>"><?php echo $text_report_customer_order; ?></a></li>
	              <li><a href="<?php echo $report_customer_reward; ?>"><?php echo $text_report_customer_reward; ?></a></li>
	              <li><a href="<?php echo $report_customer_credit; ?>"><?php echo $text_report_customer_credit; ?></a></li>
                 <li class="nav-header">
				    <?php echo $text_affiliate; ?>
				  </li>
            	  <li><a href="<?php echo $report_affiliate_commission; ?>"><?php echo $text_report_affiliate_commission; ?></a></li>
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