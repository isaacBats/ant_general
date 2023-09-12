<?php

// Hooks your functions into the correct filters
add_action('admin_head', 'jgccfr_boton_tiny_mce');
function jgccfr_boton_tiny_mce() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'jgccfr_add_tinymce_plugin' );
		add_filter( 'mce_buttons', 'jgccfr_register_mce_button' );
	}
}

// Declare script for new button
function jgccfr_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['jgccfr_mce_button'] = plugins_url('../js/jgc-cfr-tiny-button.js', __FILE__);
	return $plugin_array;
}

// Register new button in the editor
function jgccfr_register_mce_button( $buttons ) {
	array_push( $buttons, 'jgccfr_mce_button' );
	return $buttons;
}

?>