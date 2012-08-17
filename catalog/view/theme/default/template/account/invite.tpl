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
    <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="invite">
    <p><?php echo $text_invite_description; ?></p>
    <h2><?php echo $text_your_email; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_email; ?></td>
          <td><input type="text" name="email" value="" /></td>
          <td><a onclick="$('#invite').submit();" class="button"><span><?php echo $button_invite; ?></span></a></td>
        </tr>
       </table>
    </div>
     <h2><?php echo $text_invite_copy; ?></h2>
     
    <div class="content">
    	<table class="form">
      	<tr>
          <td><?php echo $entry_invite; ?></td>
          <td>
          <input type="text" size="50" value="<?php echo $invite; ?>" name="link" >
          <input type="hidden" value="<?php echo $invite; ?>" name="sns" id="sns">
          </td>
          <td>	
           <div id="copy-botton">
          	 <a  class="button"><span><?php echo $button_copy_link;?></span></a>
           </div>
        </td>
        </tr>
   		
       </table>
	</div>
    <script type="text/javascript" src="catalog/view/javascript/ZeroClipboard.js"></script>

    <script type="text/javascript">

			clip = new ZeroClipboard.Client();

			clip.setHandCursor(true); // 设置鼠标为手型
			
			clip.setText(document.getElementById('sns').value);
			
			clip.glue("copy-botton"); // 和上一句位置不可调换
			
			clip.addEventListener( "complete", function(){
			    alert("<?php echo $text_success_invite_copy;?>");
			});
	</script>
	
    <h2><?php echo $text_invite_sns; ?></h2>
    <div class="content">
    	<table class="form">
   		<tr>
          <td colspan="2"> <!-- AddThis Button BEGIN -->
          <div class="addthis_default_style"><a class="addthis_button_compact" u="<?php echo $invite;?>" ></a> <a class="addthis_button_email"></a><a class="addthis_button_print"></a> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a></div>
          <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script> 
          <!-- AddThis Button END -->  </td>
        </tr>
       </table>
    </div>
    <?php if($invites){?>
    <h2><?php echo $text_invite_list; ?></h2>
    <div class="content">
      <table class="form">
       <?php foreach ($invites as $invite) { ?>
        <tr>
          <td><?php echo $invite['email']; ?></td>
          <td><?php echo $invite['firstname']; ?>&nbsp;&nbsp;<?php echo $invite['lastname']; ?></td>
          <td><?php echo $invite['date_added']; ?></td>
        </tr>
        <?php }?>
      </table>
    </div>
     <?php }?>
  </form>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>