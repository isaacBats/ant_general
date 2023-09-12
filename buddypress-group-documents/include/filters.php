<?php

add_filter('bp_group_documents_name_out','htmlspecialchars');
add_filter('bp_group_documents_description_out','htmlspecialchars');

add_filter('bp_group_documents_filename_in','bp_group_documents_prepare_filename');

function bp_group_documents_prepare_filename($file) {
	
	$file = time() . '-' . $file;
	$file = preg_replace('/[^0-9a-zA-Z-_.]+/','',$file);
	return $file;
}

