<div class="wrap">
	<h2><?php echo TITLE_GOMAPS ?></h2>
	<p><?php echo DESCRIPTION_GOMAPS; ?></p>
	
	<h3><?php echo TITLE_USE_GOMAPS ?></h3>
	<p><?php echo DESCRI_USE_GOMAPS; ?></p>
	<p><?php echo EXAMPLE_USE_GOMAPS; ?></p>
	
	<div style="float: left;">
		<form action="" name="" id="" method="POST">
			<table class="form-table">
			<tr>
				<td><label><?php echo LABEL_GOMAPS; ?></label></td>
				<td>
					<input type="text" name="api_gomaps" value="<?php echo isset($code_api)?$code_api:''; ?>" size="50" />
					<span class="description"><a href="http://code.google.com/intl/es-ES/apis/maps/signup.html" target="_blank"><?php echo GET_API; ?></a></span>
				</td>
			</tr>
			<tr>
				<td><label><?php echo WHERE_GOMAPS; ?></label></td>
				<td>
					<?php
						$check_post=''; $check_user='';
						if(isset($type_api) && is_array($type_api) && count($type_api)>0) {
							if(in_array('post',$type_api)) $check_post='CHECKED'; else $check_post='';
							if(in_array('user',$type_api)) $check_user='CHECKED'; else $check_user='';
						}
					?>
					<input type="checkbox" name="gomaps_user" value="user" <?php echo $check_user; ?> /><?php echo USER_GOMAPS; ?><br />
					<input type="checkbox" name="gomaps_post" value="post" <?php echo $check_post; ?> /><?php echo POST_GOMAPS; ?>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="bgomaps" value="<?php echo BUTTOM_GOMAPS; ?>" /></td>
			</tr>
			</table>
		</form>
	</div>
	
	<div style="float: right;">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="L87VHXMWUYM9S">
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypal.com/es_XC/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>
	<div style="clear:both;"></div>
</div>