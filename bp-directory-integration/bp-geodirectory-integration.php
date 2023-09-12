<?php

/**
 * Plugin Name:       Buddypress Geodirectory Integration
 * Plugin URI:        http://wordpressmanaged.hosting/
 * Description:       A light weight plugin which integrates Geodirectory plugin with Buddypress.
 * Version:           1.0.0
 * Author:            MinimalPink
 * Author URI:        http://minimalpink.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bp-geodirectory-integration
 */


/**
 * Add profile nav and subnav tabs
 */

function add_geodirectory_tabs() {
global $bp;
bp_core_new_nav_item( array(
'name'                  => 'Directory',
'slug'                  => 'directory',
'parent_url'            => $bp->displayed_user->domain,
'parent_slug'           => $bp->profile->slug,
'position'              => 25,
'default_subnav_slug'   => 'directory_listings',
'show_for_displayed_user' => false
) );
bp_core_new_subnav_item( array(
'name'              => 'Directory Listings',
'slug'              => 'directory_listings',
'parent_url'        => trailingslashit( bp_displayed_user_domain() . 'directory' ),
'parent_slug'       => 'directory',
'screen_function'   => 'directory_screen',
'position'          => 100,
'user_has_access'   => bp_is_my_profile()
) );
bp_core_new_subnav_item( array(
'name'              => 'My Listings',
'slug'              => 'my_listings',
'parent_url'        => trailingslashit( bp_displayed_user_domain() . 'directory' ),
'parent_slug'       => 'directory',
'screen_function'   => 'my_listings_screen',
'position'          => 200,
'user_has_access'   => bp_is_my_profile()
) );
bp_core_new_subnav_item( array(
'name'              => 'Add Listing',
'slug'              => 'add-listing',
'parent_url'        =>  trailingslashit( bp_displayed_user_domain() . 'directory' ),
'parent_slug'       => 'directory',
'screen_function'   => 'add_listing_screen',
'position'          => 300,
'user_has_access'   => bp_is_my_profile()
) );
}
add_action( 'bp_setup_nav', 'add_geodirectory_tabs', 20 );

/**
 * Add relavent output for the directory tabs
 */

function directory_screen() {
    add_action( 'bp_template_content', 'directory_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
function directory_screen_content() { 
echo '[gd_homepage_map width=100% height=300 scrollwheel=false][gd_listings]'; 
}

function my_listings_screen() {
    add_action( 'bp_template_content', 'my_listings_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
function my_listings_screen_content() { 
global $current_user;
      get_currentuserinfo();
	  echo do_shortcode( '[gd_listings post_author="'.$current_user->ID.'"]');
}

function add_listing_screen() {
    add_action( 'bp_template_content', 'add_listing_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
function add_listing_screen_content() { 
echo '[gd_add_listing]'; 
}