<?php
/*
Plugin Name: GoMaps
Version: 1.0
Author URI: http://www.gopymes.pe/
Plugin URI: http://blog.gopymes.pe/wordpress-plugin-simple-gomaps-1-0/
Description: A simple plugin for add a custom field in Admin Post or User Profile, and capture of latitude and longitude.
Author: Alexander Gonz&aacute;les
*/

require_once WP_PLUGIN_DIR.'/simple-gomaps-10/language.php';

class gomaps {

	/*	Function for verify if exists API 	*/
	function verify_gomaps() {
		$api_gomaps = get_option('api_gomaps');
		if(isset($api_gomaps) && !empty($api_gomaps))
			return 1;
		else
			return 0;
	}

	
	/*************************************************************
		ADD
		This function add the custom field with  the map
	**************************************************************/
	function add_gomaps_post() {
		//$type_gomaps = explode(',',get_option('type_gomaps');
		add_meta_box(SUBTITLE_GOMAPS, SUBDESCRIP_GOMAPS,array(&$this,'get_gomaps_post'),'post','normal','low');
	}

	function get_gomaps_post() {
		global $wpdb, $post;

		$pto_gomaps  = (get_post_meta($post->ID, pto_gomaps, true));
		echo '<input type="text" name="pto_gomaps" id="pmaps" value="'.$pto_gomaps.'" size="55" /><br />
			<div id="map_admin" style="width: 100%; height: 500px" align="center"></div>';
	}
	
	function add_gomaps_user($user) {

		$pto_gomaps = get_user_meta($user->ID, 'pto_gomaps', true);
		
		echo '<table class="form-table">
			<tr>
				<th><label for="pmaps">'.SUBTITLE_GOMAPS.'</label></th>
				<td>
					<input type="text" name="pto_gomaps" id="pmaps" value="'.$pto_gomaps.'" size="55" /><br />
					<div id="map_admin" style="width: 100%; height: 500px" align="center"></div>
				</td>
			</tr>
		</table>';
	}

	/*****************************************************************
		SAVE FIELD POST
		this function save the field "pto_gomaps" in the table META
	******************************************************************/
	function safields_gomaps_post() {
		global $wpdb, $post;
		if (!$post_id) $post_id = $_POST['post_ID'];
		if (!$post_id) return $post;
	
		// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
		// to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;
	
		$pto_gomaps = $_POST['pto_gomaps'];

		/*	Edicion rápida	*/
		if($_POST['post_view']!='list') {
			update_post_meta($post_id, 'pto_gomaps', $pto_gomaps);
		}
	}
	
	/*****************************************************************
		SAVE FIELD USER
		this function save the field "pto_gomaps" in the table META
	******************************************************************/
	function safields_gomaps_user($user_id) {
		$pto_gomaps = $_POST['pto_gomaps'];
		update_user_meta($user_id, 'pto_gomaps', (isset($pto_gomaps)?$pto_gomaps:''));
	}

	/*********************************
		DELETE FIELD POST
	**********************************/
	function defields_gomaps_post() {
		global $wpdb, $post;
		if (!$post_id) $post_id = $_POST['post_ID'];
		if (!$post_id) return $post;

		delete_post_meta($post_id, 'pto_gomaps');
	}


	/************************
		HEAD ADMIN
	*************************/
	function head_gomaps() {
		echo '<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key='.get_option('api_gomaps').'" type="text/javascript"></script>';
		echo '<script src="'.WP_PLUGIN_URL.'/simple-gomaps-10/gomaps.js" type="text/javascript"></script>';
	
		return true;
	}

	/*****************************
		FUNCTION ADMIN
	******************************/
	function add_admin_menu_gomaps() {		
		//add_menu_page('GoMaps','GoMaps',1, __FILE__, "gomaps_config");
		add_options_page('GoMaps', 'GoMaps','manage_options', 'gomaps', array(&$this,'config_gomaps'));
	}

	function config_gomaps() {
		if (!current_user_can('manage_options')) 
			wp_die( __('You do not have sufficient permissions to access this page.'));
		
		/*	If POST	*/
		if(isset($_POST['bgomaps']) && isset($_POST['api_gomaps'])) {
			update_option('api_gomaps',$_POST['api_gomaps']);
			
			$array_gomaps = array();
			if(isset($_POST['gomaps_user'])) $array_gomaps[] = $_POST['gomaps_user'];
			if(isset($_POST['gomaps_post'])) $array_gomaps[] = $_POST['gomaps_post'];
			
			if(count($array_gomaps)>0) update_option('type_gomaps',implode(',',$array_gomaps));
			else update_option('type_gomaps','');
		}
		
		if($this->verify_gomaps()) {
			$code_api = get_option('api_gomaps');
			$type_api = explode(',',get_option('type_gomaps'));
		}
		require_once WP_PLUGIN_DIR.'/simple-gomaps-10/template_admin.php';
	
		return true;
	}
}

/*	Class Gomaps	*/
$gomaps = new gomaps();

if (is_admin()) {
	/*	Add the menu in options_page	*/
	add_action('admin_menu', array(&$gomaps,'add_admin_menu_gomaps'));
}

if($gomaps->verify_gomaps()) {
	$type_gomaps = explode(',',get_option('type_gomaps'));
	
	/*	Add head	*/
	add_action('admin_head', array(&$gomaps,'head_gomaps'));

	/*	If actived POST	*/
	if(in_array('post',$type_gomaps)) {
		/*	Add fields	*/
		add_action('admin_menu', array(&$gomaps,'add_gomaps_post'));
		/*	When a post is saved	*/
		add_action('save_post', array(&$gomaps,'safields_gomaps_post'));
		add_action('publish_post', array(&$gomaps,'safields_gomaps_post'));
		/*	When delete a post	*/
		add_action('delete_post', array(&$gomaps,'defields_gomaps_post'));
	}
	
	/*	IF activated USER	*/
	if(in_array('user',$type_gomaps)) {
		/*	When edit a user profile	*/
		add_action('show_user_profile', array(&$gomaps,'add_gomaps_user'));
		add_action('edit_user_profile', array(&$gomaps,'add_gomaps_user'));
		/*	When save a user profile	*/
		add_action('personal_options_update', array(&$gomaps,'safields_gomaps_user'));
		add_action('edit_user_profile_update', array(&$gomaps,'safields_gomaps_user'));

	}
}


?>