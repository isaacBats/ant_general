<?php

/*
 * bp_group_documents_increment_download_count()
 *
 * instanciates a document object based on the POST id, 
 * then increments the download_count field in the database by 1.
 *
 * This fires in the background when a user clicks on a document link
 */
function bp_group_documents_increment_download_count(){
	$document_id = (string)$_POST['document_id'];
	if( isset( $document_id ) && ctype_digit( $document_id ) ){
		$document = new BP_Group_Documents( $document_id );
		$document->increment_download_count();
	}
}
add_action('wp_ajax_bp_group_documents_increment_downloads','bp_group_documents_increment_download_count');



/*
 * bp_group_documents_ajax_move()
 * the function this calls checks the POST array for any filenames, assigns
 * the meta information and moves them to the selected group.
 *
 * this fires when a user selects "move file" from the bulk uploads section
 * of the site admin screen
 */
function bp_group_documents_ajax_move() {
	echo bp_group_documents_check_uploads_submit();
}
add_action('wp_ajax_bp_group_documents_admin_upload_submit','bp_group_documents_ajax_move');


