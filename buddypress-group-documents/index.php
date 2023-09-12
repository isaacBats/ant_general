<?php
/*
Plugin Name: BP Group Documents
Description: This BuddyPress component creates a document storage area within each group
Version: 0.3.2
Revision Date: March 19, 2010
Requires at least: WPMU 2.8, BuddyPress 1.1
Tested up to: WPMU 2.9.2, BuddyPress 1.2.2.1
License: Example: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: Peter Anselmo, Studio66
Author URI: http://www.studio66design.com
Site Wide Only: true
*/

define ( 'BP_GROUP_DOCUMENTS_IS_INSTALLED', 1 );
define ( 'BP_GROUP_DOCUMENTS_VERSION', '0.3.2' );
define ( 'BP_GROUP_DOCUMENTS_DB_VERSION', '2' );
define ( 'BP_GROUP_DOCUMENTS_DEFAULT_FORMATS', 'odt,rtf,txt,doc,docx,xls,xlsx,ppt,pps,pptx,pdf,jpg,jpeg,gif,png,zip,tar,gz');

if ( !defined( 'BP_GROUP_DOCUMENTS_SLUG' ) )
	define ( 'BP_GROUP_DOCUMENTS_SLUG', 'documents' );

//we must hook this on to an action, otherwise it will get called before bp-custom.php
function bp_group_documents_set_constants() {

	//This is where to look for bulk uploads
	if( !defined( 'BP_GROUP_DOCUMENTS_ADMIN_UPLOAD_PATH') )
		define ( 'BP_GROUP_DOCUMENTS_ADMIN_UPLOAD_PATH', WP_PLUGIN_DIR . '/buddypress-group-documents/uploads/');

	//Widgets can be set to only show documents in certain (site-admin specified) groups
	if( !defined( 'BP_GROUP_DOCUMENTS_WIDGET_GROUP_FILTER' ) )
		define( 'BP_GROUP_DOCUMENTS_WIDGET_GROUP_FILTER', false );

	//longer text descriptions to go with the documents can be toggled on or off.
	//this will toggle both the textarea input, and the display;
	if ( !defined( 'BP_GROUP_DOCUMENTS_SHOW_DESCRIPTIONS' ) )
		define ( 'BP_GROUP_DOCUMENTS_SHOW_DESCRIPTIONS', true );

}
add_action('plugins_loaded','bp_group_documents_set_constants');

//load i18n files
if ( file_exists( WP_PLUGIN_DIR . '/buddypress-group-documents/languages/' . get_locale() . '.mo' ) )
	load_textdomain( 'bp-group-documents', WP_PLUGIN_DIR . '/buddypress-group-documents/languages/' . get_locale() . '.mo' );

//Go get me some files!
require ( WP_PLUGIN_DIR . '/buddypress-group-documents/include/classes.php' );
require ( WP_PLUGIN_DIR . '/buddypress-group-documents/include/cssjs.php' );
require ( WP_PLUGIN_DIR . '/buddypress-group-documents/include/widgets.php' );
require ( WP_PLUGIN_DIR . '/buddypress-group-documents/include/notifications.php' );
require ( WP_PLUGIN_DIR . '/buddypress-group-documents/include/activity.php' );
require ( WP_PLUGIN_DIR . '/buddypress-group-documents/include/templatetags.php' );
require ( WP_PLUGIN_DIR . '/buddypress-group-documents/include/admin-uploads.php' );
require ( WP_PLUGIN_DIR . '/buddypress-group-documents/include/filters.php' );
require ( WP_PLUGIN_DIR . '/buddypress-group-documents/include/ajax.php' );


/**********************************************************************
******************SETUP AND INSTALLATION*******************************
**********************************************************************/


/**
 * bp_group_documents_install()
 *
 * Installs and/or upgrades the database tables
 */
function bp_group_documents_install() {
	global $wpdb, $bp;
	
	if ( !empty($wpdb->charset) )
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
	
	$sql[] = "CREATE TABLE {$bp->group_documents->table_name} (
		  		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  		user_id bigint(20) NOT NULL,
		  		group_id bigint(20) NOT NULL,
		  		created_ts int NOT NULL,
				modified_ts int NOT NULL,
				file VARCHAR(255) NOT NULL,
				name VARCHAR(255) NULL,
				description TEXT NULL,
				download_count bigint(20) NOT NULL DEFAULT 0,
			    KEY user_id (user_id),
			    KEY group_id (group_id),
				KEY created_ts (created_ts),
				KEY modified_ts (modified_ts),
				KEY download_count (download_count)
		 	   ) {$charset_collate};";

	require_once( ABSPATH . 'wp-admin/upgrade-functions.php' );
	dbDelta($sql);
	
	update_site_option( 'bp-group-documents-db-version', BP_GROUP_DOCUMENTS_DB_VERSION );
}


/**
 * bp_group_documents_setup_globals()
 *
 * Sets up global variables for group documents
 */
function bp_group_documents_setup_globals() {
	global $bp, $wpdb;

	/* For internal identification */
	$bp->group_documents->id = 'group_documents';
	$bp->group_documents->table_name = $wpdb->base_prefix . 'bp_group_documents';
	$bp->group_documents->format_notification_function = 'bp_group_documents_format_notifications';
	$bp->group_documents->slug = BP_GROUP_DOCUMENTS_SLUG;
	
	/* Register this in the active components array */
	$bp->active_components[$bp->group_documents->slug] = $bp->group_documents->id;
	
	switch( substr( BP_VERSION, 0, 3 ) ) {
		case '1.2':
			if( 'BuddyPress Classic' == get_current_theme() ) {
				define( 'BP_GROUP_DOCUMENTS_THEME_VERSION', '1.1' );
			} else {
				define( 'BP_GROUP_DOCUMENTS_THEME_VERSION', '1.2' );
			}
		break;
		case '1.1':
			define( 'BP_GROUP_DOCUMENTS_THEME_VERSION', '1.1' );
		break;
	}

	do_action('bp_group_documents_globals_loaded');
}
add_action( 'plugins_loaded', 'bp_group_documents_setup_globals', 5 );	
add_action( 'admin_menu', 'bp_group_documents_setup_globals', 2 );


/**
 * bp_group_documents_check_installed()
 *
 * Checks to see if the DB tables exist or if we are running an old version
 * of the component. If it matches, it will run the installation function.
 */
function bp_group_documents_check_installed() {	
	global $wpdb, $bp;

	if ( !current_user_can('manage_options') )
		return false;

	//Add the component's administration tab under the "BuddyPress" menu for site administrators
	require ( WP_PLUGIN_DIR . '/buddypress-group-documents/include/admin.php' );

	add_submenu_page( 'bp-general-settings', __( 'Group Documents Admin', 'bp-group-documents' ), __( 'Group Documents', 'bp-group-documents' ), 'manage_options', 'bp-group-documents-settings', 'bp_group_documents_admin' );	


	/* Need to check db tables exist, activate hook no-worky in mu-plugins folder. */
	if ( get_site_option('bp-group-documents-db-version') < BP_GROUP_DOCUMENTS_DB_VERSION )
		bp_group_documents_install();

	add_option('bp_group_documents_valid_file_formats', BP_GROUP_DOCUMENTS_DEFAULT_FORMATS );
	add_option('bp_group_documents_items_per_page', 20 );
	add_option('bp_group_documents_display_icons', true );
}
add_action( 'admin_menu', 'bp_group_documents_check_installed',50);


/** bp_group_documents_check_legacy_paths()
 *
 * checks if there are any documents in the old location (documents folder)
 * and if so, moves them to the new location (wp-content/blogs.dir)
 */
function bp_group_documents_check_legacy_paths() {

	if( defined( 'BP_GROUP_DOCUMENTS_PATH' ) ) {
		$legacy_path = BP_GROUP_DOCUMENTS_PATH;
	}else {
		$legacy_path = WP_PLUGIN_DIR . '/buddypress-group-documents/documents/';
	}
	
	if( $dh = @opendir( $legacy_path ) ) {
		$moved_count = 0;
		while( false !== ($file = readdir( $dh ) ) ) {

			if( $file != "." && $file != ".." ) {
				$document = new BP_Group_Documents();
				if( $document->populate_by_file($file) ) {
					rename($legacy_path . $file, $document->get_path(0,1));
					++$moved_count;
				}
			}
		}
	}
}
add_action('bp_group_documents_admin','bp_group_documents_check_legacy_paths');


/**
 * bp_group_documents_setup_nav()
 *
 * Sets up the navigation items for the component.  
 * Adds one item under the group navigation
 */
function bp_group_documents_setup_nav() {
	global $bp,$current_blog,$group_object;

	if( !class_exists('BP_Groups_Group') ) {
		return;
	}

	if ( $group_id = BP_Groups_Group::group_exists($bp->current_action) ) {

		/* This is a single group page. */
		$bp->is_single_item = true;
		$bp->groups->current_group = &new BP_Groups_Group( $group_id );

	}	

	//$groups_link = $bp->loggedin_user->domain . $bp->groups->slug . '/';
	$groups_link = $bp->root_domain . '/' . $bp->groups->slug . '/' . $bp->groups->current_group->slug . '/';

	/* Add the subnav item only to the single group nav item*/
	if ( $bp->is_single_item )
    bp_core_new_subnav_item( array( 
		'name' => __( 'Documents', 'bp-group-documents' ), 
		'slug' => $bp->group_documents->slug, 
		'parent_url' => $groups_link, 
		'parent_slug' => $bp->groups->slug, 
		'screen_function' => 'bp_group_documents_display', 
		'position' => 35, 
		'user_has_access' => $bp->groups->current_group->user_has_access,
		'item_css_id' => 'group-documents' ) );

	do_action('bp_group_documents_nav_setup');
}
add_action( 'wp', 'bp_group_documents_setup_nav', 2 );
add_action( 'admin_menu', 'bp_group_documents_setup_nav', 2 );


/**
 * bp_group_document_set_cookies()
 *
 * Set any cookies for our component.  This will usually be for sorting.
 * We must create a dedicated function for this, to fire before the headers
 * are sent (doing this in the template object with the rest of the sorting is too late)
 */
function bp_group_documents_set_cookies() {
	if( isset( $_GET['order'] ) ){
		setcookie('bp-group-documents-order',$_GET['order'],time()+60*60+24*7); //expires in one week
	}
}
add_action('plugins_loaded','bp_group_documents_set_cookies');


/**
 * bp_group_documents_display()
 *
 * Sets up the plugin template file and calls the dislay output function
 */
function bp_group_documents_display() {
	global $bp;

	do_action( 'bp_group_documents_display' );
	
	add_action( 'bp_template_content_header', 'bp_group_documents_display_header' );
	add_action( 'bp_template_title', 'bp_group_documents_display_title' );
	add_action( 'bp_template_content', 'bp_group_documents_display_content' );

	// Load the plugin template file.
	// BP 1.1 includes a generic "plugin-template file
	// BP 1.2 breaks it out into a group-specific template
	if( '1.1' == BP_GROUP_DOCUMENTS_THEME_VERSION ) {
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'plugin-template' ) );
	} else {
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'groups/single/plugins' ) );
	}
}


function bp_group_documents_display_header() {
	_e( 'Group Documents', 'bp-group-documents' );
}
function bp_group_documents_display_title() {
	_e( 'Document List', 'bp-group-documents' );
}

/**********************************************************************
******************BEGIN MAIN DISPLAY***********************************
**********************************************************************/

function bp_group_documents_display_content() {
	global $bp;

	$template = new BP_Group_Documents_Template();?>

	<div class="bp-widget">
	<div id="bp-group-documents">

	<?php do_action( 'template_notices' ) // (error/success feedback) ?>

	<?php //-------------------------------------------------------LIST VIEW-- ?>

	<?php if( $template->document_list && count($template->document_list >= 1) ) { ?>

		<div class="sorting">
			<form id="bp-group-documents-sort-form" method="get" action="">
			<?php _e('Order by:','bp-group-documents'); ?>
			<select name="order">
				<option value="newest" <?php if( 'newest' == $template->order ) echo 'selected="selected"'; ?>><?php _e('Newest','bp-group-documents'); ?></option>
				<option value="alpha" <?php if( 'alpha' == $template->order ) echo 'selected="selected"'; ?>><?php _e('Alphabetical','bp-group-documents'); ?></option>
				<option value="popular" <?php if( 'popular' == $template->order ) echo 'selected="selected"'; ?>><?php _e('Most Popular','bp-group-documents'); ?></option>
			</select>
			<input type="submit" class="button" value="<?php _e('Go','bp-group-documents'); ?>" />
			</form>
		</div>

		<?php if( '1.1' != BP_GROUP_DOCUMENTS_THEME_VERSION ) { ?>
		<h3><?php _e('Document List','bp-group-documents'); ?></h3>
		<?php } ?>


		<div class="pagination no-ajax">
			<div id="group-documents-page-count" class="pag-count">
				<?php $template->pagination_count(); ?>
			</div>
		<?php if( $template->show_pagination() ){ ?>
			<div id="group-documents-page-links" class="pagination-links">
				<?php $template->pagination_links(); ?>
			</div>
		<?php } ?>
		</div>

		<?php if( '1.1' == substr(BP_VERSION,0,3) ) { ?>
			<ul id="forum-topic-list" class="item-list">
		<?php } else { ?>
			<ul id="bp-group-documents-list" class="item-list">
		<?php } ?>

		<?php //loop through each document and display content along with admin options
		$count = 0;
		foreach( $template->document_list as $document_params ) {
			$document = new BP_Group_Documents($document_params['id'], $document_params); ?>

			<li <?php if( ++$count%2 ) echo 'class="alt"';?> >

			<?php if( get_option( 'bp_group_documents_display_icons' )) $document->icon(); ?>

			<a class="group-documents-title" id="group-document-link-<?php echo $document->id; ?>" href="<?php $document->url(); ?>" target="_blank"><?php echo $document->name; ?>

			<?php if( get_option( 'bp_group_documents_display_file_size' )) { echo ' <span class="group-documents-filesize">(' . get_file_size( $document ) . ')</span>'; } ?></a> &nbsp;
			
			<span class="group-documents-meta"><?php printf( __( 'Uploaded by %s on %s', 'bp-group-documents'),bp_core_get_userlink($document->user_id),date( 'n/j/Y', $document->created_ts )); ?></span>

			<?php if( BP_GROUP_DOCUMENTS_SHOW_DESCRIPTIONS && $document->description ){ echo '<br /><span class="group-documents-description">' . nl2br($document->description) . '</span>'; }

			//show edit and delete options if user is privileged
			echo '<div class="admin-links">';
			if( $document->current_user_can('edit') ) {
				$edit_link = wp_nonce_url( $template->action_link . '/edit/' . $document->id, 'group-documents-edit-link' );
				echo "<a href='$edit_link'>" . __('Edit','bp-group-documents') . "</a> | ";
			}
			if( $document->current_user_can('delete') ) {
				$delete_link = wp_nonce_url( $template->action_link . '/delete/' . $document->id, 'group-documents-delete-link' );
				echo "<a href='$delete_link' id='bp-group-documents-delete'>" . __('Delete','bp-group-documents') . "</a>";
			}

			echo '</div>';
			echo '</li>';		
		} ?>
		</ul>

	<?php } else { ?>
	<div id="message" class="info">
		<p><?php _e( 'There have been no documents uploaded for this group', 'bp-group-documents') ?></p>
	</div>

	<?php } ?>
	<div class="spacer">&nbsp;</div>

	<?php //-------------------------------------------------------DETAIL VIEW-- ?>
	<?php if( $template->show_detail ){ ?>

	<?php if( $template->operation == 'add' ) { ?>
	<div id="bp-group-documents-upload-new">
	<?php } else { ?>
	<div id="bp-group-documents-edit">
	<?php } ?>

	<h3><?php echo $template->header ?></h3>

	<form method="post" id="bp-group-documents-form" class="standard-form" action="<?php echo $template->action_link; ?>" enctype="multipart/form-data" />
	<input type="hidden" name="bp_group_documents_operation" value="<?php echo $template->operation; ?>" />
	<input type="hidden" name="bp_group_documents_id" value="<?php echo $template->id; ?>" />
			<?php if( $template->operation == 'add' ) { ?>
			<label><?php _e('Choose File:','bp-group-documents'); ?></label>
			<input type="file" name="bp_group_documents_file" id="bp-group-documents-file" />
			<?php } ?>
			<label><?php _e('Display Name:','bp-group-documents'); ?></label>
			<input type="text" name="bp_group_documents_name" id="bp-group-documents-name" value="<?php echo $template->name ?>" />
			<?php if( BP_GROUP_DOCUMENTS_SHOW_DESCRIPTIONS ) { ?>
			<label><?php _e('Description:', 'bp-group-documents'); ?></label>
			<textarea name="bp_group_documents_description" id="bp-group-documents-description"><?php echo $template->description; ?></textarea>
			<?php } ?>
			<label></label>
			<input type="submit" class="button" value="<?php _e('Submit','bp-group-documents'); ?>" />
	</form>
	</div><!--end #post-new-topic-->

	<?php if( $template->operation == 'add' ) { ?>
	<a class="button" id="bp-group-documents-upload-button" href="" style="display:none;"><?php _e('Upload a New Document','bp-group-documents'); ?></a>
	<?php } ?>

	<?php } ?>
		
	</div><!--end #group-documents-->
	</div><!--end .bp-widget-->
<?php }



/**********************************************************************
********************NOTIFICATION SETTINGS******************************
**********************************************************************/

/**
 * bp_group_documents_screen_notification_settings()
 *
 * Adds notification settings for the component, so that a user can turn off email
 * notifications set on specific component actions.
 */
function bp_group_documents_screen_notification_settings() { 
	global $current_user; ?>
	
		<tr>
			<td></td>
			<td><?php _e( 'A member uploads a document to a group you belong to', 'bp-group-documents' ) ?></td>
			<td class="yes"><input type="radio" name="notifications[notification_group_documents_upload_member]" value="yes" <?php if ( !get_usermeta( $current_user->id,'notification_group_documents_upload_member') || 'yes' == get_usermeta( $current_user->id,'notification_group_documents_upload_member') ) { ?>checked="checked" <?php } ?>/></td>
			<td class="no"><input type="radio" name="notifications[notification_group_documents_upload_member]" value="no" <?php if ( get_usermeta( $current_user->id,'notification_group_documents_upload_member') == 'no' ) { ?>checked="checked" <?php } ?>/></td>
		</tr>
		<tr>
			<td></td>
			<td><?php _e( 'A member uploads a document to a group for which you are an moderator/admin', 'bp-group-documents' ) ?></td>
			<td class="yes"><input type="radio" name="notifications[notification_group_documents_upload_mod]" value="yes" <?php if ( !get_usermeta( $current_user->id,'notification_group_documents_upload_mod') || 'yes' == get_usermeta( $current_user->id,'notification_group_documents_upload_mod') ) { ?>checked="checked" <?php } ?>/></td>
			<td class="no"><input type="radio" name="notifications[notification_group_documents_upload_mod]" value="no" <?php if ( 'no' == get_usermeta( $current_user->id,'notification_group_documents_upload_mod') ) { ?>checked="checked" <?php } ?>/></td>
		</tr>
		
		<?php do_action( 'bp_group_documents_notification_settings' ); ?>
<?php	
}
add_action( 'groups_screen_notification_settings', 'bp_group_documents_screen_notification_settings' );


/**********************************************************************
********************EVERYTHING ELSE************************************
**********************************************************************/

function bp_group_documents_delete( $id ) {
	if( !ctype_digit( $id ) ) {
		bp_core_add_message( __('The item to delete could not be found','bp-group-documents'),'error');
		return false;
	}

	//check nonce
	if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'group-documents-delete-link')) {
	  bp_core_add_message( __('There was a security problem', 'bp-group-documents'), 'error' );
	  return false;
	}
	
	$document = new BP_Group_Documents($id);
	if( $document->current_user_can('delete') ){
		if( $document->delete() ){
			do_action('bp_group_documents_delete_success',$document);
			return true;
		}
	}
	return false;
}

/*
 * bp_group_documents_check_ext()
 *
 * checks whether the passed filename ends in an extension
 * that is allowed by the site admin
 */
function bp_group_documents_check_ext( $filename ) {

	if( !$filename ) {
		return false;
	}

	$valid_formats_string = get_option( 'bp_group_documents_valid_file_formats');
	$valid_formats_array = explode( ',', $valid_formats_string );

	$extension = substr($filename,(strrpos($filename, ".")+1));
	$extension =  strtolower($extension);

	if(in_array($extension, $valid_formats_array)){
		return true;
	}
	return false;
}


/*
 * get_file_size()
 *
 * returns a human-readable file-size for the passed file
 * adapted from a function in the php manual comments
 */
function get_file_size( $document, $precision = 1 ) {

    $units = array('b', 'k', 'm', 'g');
  
	$bytes = filesize( $document->get_path(1) );
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
  
    $bytes /= pow(1024, $pow);
  
    return round($bytes, $precision) .  $units[$pow];
} 

/**
 * bp_group_documents_remove_data()
 *
 * Cleans out both the files and the database records when a group is deleted
 */
function bp_group_documents_remove_data( $group_id ) {
	
	$results = BP_Group_Documents::get_list_by_group( $group_id );
	if( count( $results ) >= 1 ) {
		foreach($results as $document_params) {
			$document = new BP_Group_Documents( $document_params['id'], $document_params);
			$document->delete();
			do_action('bp_group_documents_delete_with_group',$document);
		}
	}
}
add_action('groups_group_deleted','bp_group_documents_remove_data');

?>
