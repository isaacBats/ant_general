<?php

/**
 * bp_group_documents_admin()
 *
 * Checks for form submission, saves component settings and outputs admin screen HTML.
 */
function bp_group_documents_admin() { 
	global $bp, $bbpress_live;
		
	do_action('bp_group_documents_admin');

	/* If the form has been submitted and the admin referrer checks out, save the settings */
	if ( isset( $_POST['submit'] ) && check_admin_referer('group-documents-settings') ) {
		//strip whitespace from comma separated list
		$formats = preg_replace('/\s+/','',$_POST['valid_file_formats']);
		//keep everything lowercase for consistancy
		$formats = strtolower( $formats);

		if( isset($_POST['display_file_size']) && $_POST['display_file_size'] ) {
			$size = 1;
		} else {
			$size = 0;
		}

		if( isset( $_POST['display_icons'] ) && $_POST['display_icons'] ) {
			$icons = 1;
		} else {
			$icons = 0;
		}
		update_option( 'bp_group_documents_valid_file_formats', $formats );
		update_option( 'bp_group_documents_display_file_size', $size );
		update_option( 'bp_group_documents_display_icons', $icons );

		if( ctype_digit( $_POST['items_per_page'] ) ){
			update_option( 'bp_group_documents_items_per_page', $_POST['items_per_page'] );
		}
		$updated = true;
	}
	
	$valid_file_formats = get_option( 'bp_group_documents_valid_file_formats');
	//add consistant whitepace for readability
	$valid_file_formats = str_replace( ',',', ',$valid_file_formats);
	$display_file_size = get_option( 'bp_group_documents_display_file_size' );
	$display_icons = get_option( 'bp_group_documents_display_icons' );
	$items_per_page = get_option( 'bp_group_documents_items_per_page' );
?>
	<div class="wrap">
		<h2><?php _e( 'Group Documents Admin', 'bp-group-documents' ) ?></h2>
		<br />
		
		<?php if( isset($moved_count)) echo "<div id='message' class='updated fade'><p>" . sprintf(__( '%s Documents Moved.', 'bp-group-documents' ),$moved_count) . "</p></div>"; ?>
		<?php if ( isset($updated) ) echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'bp-group-documents' ) . "</p></div>"; ?>
			
		<form action="<?php echo site_url() . '/wp-admin/admin.php?page=bp-group-documents-settings' ?>" name="group-documents-settings-form" id="group-documents-settings-form" method="post">				

			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="target_uri"><?php _e( 'Valid File Formats', 'bp-group-documents' ) ?></label></th>
					<td>
						<textarea style="width:95%" cols="45" rows="5" name="valid_file_formats" id="valid_file_formats"><?php echo attribute_escape( $valid_file_formats ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label><?php _e('Items per Page','bp-group-documents') ?></label></th>
					<td>
						<input type="text" name="items_per_page" id="items_per_page" value="<?php echo $items_per_page; ?>" /></td>
				</tr>
				<tr>
					<th><label><?php _e('Display Icons','bp-group-documents') ?></label></th>
					<td>
						<input type="checkbox" name="display_icons" id="display_icons" <?php if( $display_icons ) echo 'checked="checked"'; ?> value="1" /></td>
				</tr>
				<tr>
					<th><label><?php _e('Display File Size','bp-group-documents') ?></label></th>
					<td>
						<input type="checkbox" name="display_file_size" id="display_file_size" <?php if( $display_file_size ) echo 'checked="checked"'; ?> value="1" /></td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" name="submit" value="<?php _e( 'Save Settings', 'bp-group-documents' ) ?>"/>
			</p>
			
			<?php wp_nonce_field( 'group-documents-settings' ); ?>
		</form>
		<?php do_action('bp_group_documents_admin_end'); ?>
	</div><!-- .wrap -->
<?php }

/*
 * bp_group_documents_group_admin()
 *
 * This section extends the "Group Management" plugin by Boone Gorges
 * It adds download reporting to the individual group screens.
 *
 * TODO: Make this happen
 */
function bp_group_documents_group_admin() { ?>
	<div id="bp-group-documents-group-admin" style="clear:both;padding-top:20px;">
	<h3>Document Management</h3>
	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
	</div>
<?php }
//add_action('bp_gm_more_group_actions','bp_group_documents_group_admin');
