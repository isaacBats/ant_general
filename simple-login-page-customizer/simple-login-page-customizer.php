<?php

/*
Plugin Name: Simple Login Page Customizer
Plugin URI: https://wordpress.org/plugins/simple-login-page-customizer/
Description: Simple Login Page Customizer
Author: Matt Shirk
Version: 3.5
Author URI: https://said.solutions/
*/


	// Functions for sanitizing, validating and escaping user inputted values

	// Remove bad stuff from any string entered as a color

function slpc_xss_strip($SLPC_input) {
	$SLPC_input = strip_tags($SLPC_input);
	$SLPC_input = htmlspecialchars($SLPC_input);
	$SLPC_input = preg_replace("/['\"&()]<>/","",$SLPC_input);
	return $SLPC_input; 
}

	// Remove all illegal characters from a url

function slpc_sanitize_url($SLPC_thisSUrl){
	$SLPC_thisSUrl = filter_var($SLPC_thisSUrl, FILTER_SANITIZE_URL);
	$SLPC_thisSUrl = urlencode($SLPC_thisSUrl);
	return $SLPC_thisSUrl;
}

	// Remove all illegal characters from a string

function slpc_sanitize_string($SLPC_thisString){
	$SLPC_thisString = filter_var($SLPC_thisString, FILTER_SANITIZE_STRING);
	return $SLPC_thisString;
}

	/* This function checks to see if the "All in One Security" security plugin is installed
	because their "Rename Login Page" feature now also redirects logged in users from the login page to the wp admin dashboard.
	This effectively disables the Login Customizer Preview iFrame */

	function slpc_isAIOBF(){
		$slpc_aio_loc = 'all-in-one-wp-security-and-firewall/wp-security.php';
	// Checks to see if "All in One Security" is activated

		if (is_plugin_active($slpc_aio_loc)){
			$slpc_loginurl_now = wp_login_url();
			$slpc_parsed_urll = parse_url($slpc_loginurl_now);
			$slpc_parsed_urll = $slpc_parsed_urll['path'];
			$slpc_parsed_path = str_replace('/', '', $slpc_parsed_urll);
			global $aio_wp_security;
			$slpc_aio_login_slug = $aio_wp_security->configs->get_value('aiowps_login_page_slug');
			$SLPC_default_image = plugin_dir_url( __FILE__ ) . 'assets/slpc_no_image_selected.jpg';
			if ($slpc_aio_login_slug == $slpc_parsed_path) {
				return '<div id="previewBox"><h1 class="h2Title">Login Page Preview</h1>
				<p><span style="font-weight:bold;color:red;font-style:italic;">UH OH!</span> You need to temporarily <a href="/wp-admin/admin.php?page=aiowpsec_brute_force" target="_blank">disable the All-In-One Security Brute Force "Rename Login Page"</a> feature in order to preview your login page correctly. When you are done customizing your login page you can re-enable it.</p>
				<div class="disabled" style="cursor:pointer;" onclick="window.open(\'/wp-admin/admin.php?page=aiowpsec_brute_force\');" id="overlay" style="background-color:#f5f5f5;background-image:url(' . $SLPC_default_image . ');"></div>
				<div id="renderer" style="border:0px !important;">
					<iframe width="420" height="300" id="frame"  src="" style="-webkit-transform:scale(0.45);-moz-transform-scale(0.45);"></iframe>
				</div></div>';
			}else{
				return '<div id="previewBox"><h1 class="h2Title">Login Page Preview</h1>
				<p><a href="' . wp_login_url() . '" target="_blank">View Live Login Page in another tab</a></p>
				<div id="overlay"></div>
				<div id="renderer">
					<iframe width="420" height="300" id="frame"  src="' . wp_login_url() . '" style="-webkit-transform:scale(0.45);-moz-transform-scale(0.45);"></iframe>
				</div></div>';
			}
		} else {
			return'<div id="previewBox"><h1 class="h2Title">Login Page Preview</h1>
			<p><a href="' . wp_login_url() . '" target="_blank">View Live Login Page in another tab</a></p>
			<div id="overlay"></div>
			<div id="renderer">
				<iframe width="420" height="300" id="frame"  src="' . wp_login_url() . '" style="-webkit-transform:scale(0.45);-moz-transform-scale(0.45);"></iframe>
			</div></div>';
		}
	}

	// Validates and Escapes Image Urls

	function slpc_validate_image_url($SLPC_url) {
		$SLPC_url = urldecode($SLPC_url);
	// Validate url
		if (!filter_var($SLPC_url, FILTER_VALIDATE_URL) === false) {
	//if everything is good escape the url and return
			$SLPC_url = esc_url($SLPC_url);
			$SLPC_urlPlaceholder = esc_url($SLPC_url);
			$slpc_url_error = 0;
		} else {
			if ($SLPC_url == 'none' || $SLPC_url == '') {
				$SLPC_url = 'none';
				$SLPC_urlPlaceholder = 'none';
				$slpc_url_error = 0;
			} else {
				$SLPC_url = 'none';
				$SLPC_urlPlaceholder = "Please Enter a Valid Image URL";
				$slpc_url_error = 1;
			}
		}
		return array($SLPC_url,$SLPC_urlPlaceholder,$slpc_url_error);
	}

	// Validates and Escapes Link Urls

	function slpc_validate_link_url($SLPC_urlb) {
		$SLPC_urlb = urldecode($SLPC_urlb);
	// Validate url
		if (!filter_var($SLPC_urlb, FILTER_VALIDATE_URL) === false) {
	//if everything is good escape the url and return
			$SLPC_urlb = esc_url($SLPC_urlb);
			$SLPC_urlPlaceholderb = esc_url($SLPC_urlb);
			$slpc_link_error = 0;
		} else {
			$SLPC_urlb = '';
			$SLPC_urlPlaceholderb = 'Please Enter a Valid URL';
			$slpc_link_error = 1;
		}
		return array($SLPC_urlb,$SLPC_urlPlaceholderb,$slpc_link_error);
	}


	// Validates hex color, adding #-sign if not found. Checks for a Color Name first to prevent error if a name was entered (optional).

	function slpc_validate_html_color($SLPC_color, $SLPC_named) {

  // $SLPC_color: the color hex value stirng to Validates
  // $SLPC_named: (optional), set to 1 or TRUE to first test if a Named color was passed instead of a Hex value

		if ($SLPC_named) {

			$SLPC_color = slpc_xss_strip($SLPC_color);

			$SLPC_named = array('aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black', 'blanchedalmond', 'blue', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green', 'greenyellow', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgreen', 'lightgrey', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue', 'lightyellow', 'lime', 'limegreen', 'linen', 'magenta', 'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple', 'red', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue', 'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'white', 'whitesmoke', 'yellow', 'yellowgreen');

			if (in_array(strtolower($SLPC_color), $SLPC_named)) {
  		// A color name was entered instead of a Hex Value, so just exit function 
				$SLPC_colorPlaceholder = $SLPC_color;
				$slpc_color_error = 0;
				return array($SLPC_color,$SLPC_colorPlaceholder,$slpc_color_error);
			}
		}

		if (preg_match('/^#[a-f0-9]{6}$/i', $SLPC_color)) {
			$SLPC_colorPlaceholder = $SLPC_color;
			$slpc_color_error = 0;
			return array($SLPC_color,$SLPC_colorPlaceholder,$slpc_color_error);
		}else if (preg_match('/^[a-f0-9]{6}$/i', $SLPC_color)) {
			$SLPC_color = '#' . $SLPC_color;
			$SLPC_colorPlaceholder = $SLPC_color;
			$slpc_color_error = 0;
			return array($SLPC_color,$SLPC_colorPlaceholder,$slpc_color_error);
		} else {
			$SLPC_color = "";
			$SLPC_colorPlaceholder = "Please Enter a Valid Color";
			$slpc_color_error = 1;
			return array($SLPC_color,$SLPC_colorPlaceholder,$slpc_color_error);
		}

	}

	// This function drops the db table upon uninstall */

	function SLPC_pluginUninstall(){
		global $wpdb;
		$SLPCtablee = 'loginCustomizer';
		$SLPCtable = $wpdb->prefix . $SLPCtablee;
		$ffg = "DROP TABLE IF EXISTS $SLPCtable";
		$wpdb->query($ffg);
	}
	register_uninstall_hook( __FILE__, 'SLPC_pluginUninstall' );


	// Load scripts needed for Media File Uploader

	function SLPC_load_wp_media_files() {
		wp_enqueue_media();
	}
	add_action( 'admin_enqueue_scripts', 'SLPC_load_wp_media_files' );

	global $wpdb;

	// function to create the DB / Options / Defaults

	function login_page_customizer_install() {
		global $wpdb;
		$LCDBnamee = 'loginCustomizer';
		$LCDBname = $wpdb->prefix . $LCDBnamee;

	// create the new database table

		if($wpdb->get_var("show tables like '$LCDBname'") != $LCDBname){
			$SLPCsql = 'CREATE TABLE ' . $LCDBname . '(
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`logo` mediumtext NOT NULL,
			`link` mediumtext NOT NULL,
			`color` mediumtext NOT NULL,
			`pgbgimg` mediumtext NOT NULL,
			`pgbgimgsize` mediumtext NOT NULL,
			`bxbgcolor` mediumtext NOT NULL,
			`bxbgimg` mediumtext NOT NULL,
			`bxbgimgsize` mediumtext NOT NULL,
			`bxtextcolor` mediumtext NOT NULL,
			`blwbxtextcolor` mediumtext NOT NULL,
			`buttonbgcolor` mediumtext NOT NULL,
			`buttontextcolor` mediumtext NOT NULL,
			`buttontextshadow` mediumtext NOT NULL,
			`buttontextshadowcolor` mediumtext NOT NULL,
			`buttonborder` mediumtext NOT NULL,
			`ispaid` int NOT NULL,
			UNIQUE KEY id (id)
			);';

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($SLPCsql);
		// Initial styles entered into the db mimic the default Wordpress login page
			$SLPCthisUrl = site_url();
			$SLPCthisLogoUrl = $SLPCthisUrl . '/wp-admin/images/w-logo-blue.png';
			$wpdb->insert( 
				$LCDBname, 
				array( 
					'id' => 0,
					'logo' => $SLPCthisLogoUrl,
					'link' => $SLPCthisUrl,
					'color' => '#f1f1f1',
					'pgbgimg' => 'none',
					'pgbgimgsize' => 'y',
					'bxbgcolor' => '#ffffff',
					'bxbgimg' => 'none',
					'bxbgimgsize' => 'y',
					'bxtextcolor' => '#72777c',
					'blwbxtextcolor' => '#555d66',
					'buttonbgcolor' => '#008ec2',
					'buttontextcolor' => '#ffffff',
					'buttontextshadow' => 'y',
					'buttontextshadowcolor' => '#006799',
					'buttonborder' => '#006799',
					'ispaid' => 0
					), 
				array( 
					'%d', 
					'%s', 
					'%s', 
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d'
					) 
				);
		} else {
			$ggg = "DROP TABLE IF EXISTS $LCDBname";
			$wpdb->query($ggg);

			$SLPCsql = 'CREATE TABLE ' . $LCDBname . '(
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`logo` mediumtext NOT NULL,
			`link` mediumtext NOT NULL,
			`color` mediumtext NOT NULL,
			`pgbgimg` mediumtext NOT NULL,
			`pgbgimgsize` mediumtext NOT NULL,
			`bxbgcolor` mediumtext NOT NULL,
			`bxbgimg` mediumtext NOT NULL,
			`bxbgimgsize` mediumtext NOT NULL,
			`bxtextcolor` mediumtext NOT NULL,
			`blwbxtextcolor` mediumtext NOT NULL,
			`buttonbgcolor` mediumtext NOT NULL,
			`buttontextcolor` mediumtext NOT NULL,
			`buttontextshadow` mediumtext NOT NULL,
			`buttontextshadowcolor` mediumtext NOT NULL,
			`buttonborder` mediumtext NOT NULL,
			`ispaid` int NOT NULL,
			UNIQUE KEY id (id)
			);';

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($SLPCsql);
		// Initial styles entered into the db mimic the default Wordpress login page
			$SLPCthisUrl = site_url();
			$SLPCthisLogoUrl = $SLPCthisUrl . '/wp-admin/images/w-logo-blue.png';
			$wpdb->insert( 
				$LCDBname, 
				array( 
					'id' => 0,
					'logo' => $SLPCthisLogoUrl,
					'link' => $SLPCthisUrl,
					'color' => '#f1f1f1',
					'pgbgimg' => 'none',
					'pgbgimgsize' => 'y',
					'bxbgcolor' => '#ffffff',
					'bxbgimg' => 'none',
					'bxbgimgsize' => 'y',
					'bxtextcolor' => '#72777c',
					'blwbxtextcolor' => '#555d66',
					'buttonbgcolor' => '#008ec2',
					'buttontextcolor' => '#ffffff',
					'buttontextshadow' => 'n',
					'buttontextshadowcolor' => '#006799',
					'buttonborder' => '#0073aa',
					'ispaid' => 0
					), 
				array( 
					'%d', 
					'%s', 
					'%s', 
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d'
					) 
				);
		}
	}
	// run the install scripts upon plugin activation

	register_activation_hook(__FILE__,'login_page_customizer_install');

	// creating admin menu 

	function login_page_customizer_menu() {
		add_options_page( 'Login Page Options', 'Login Page Customizer', 'manage_options', 'login-page-customizer', 'slpc_login_page_options' );
	}
	add_action( 'admin_menu', 'login_page_customizer_menu' );

	function slpc_login_page_options() {

		global $wpdb;
		$LCDBnamee = 'loginCustomizer';
		$LCDBname = $wpdb->prefix . $LCDBnamee;

		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			if (isset($_POST["image_url"])) {
				$coImagee = slpc_sanitize_url($_POST["image_url"]);
			}
			if (isset($_POST["coname"])) {
				$coLinkee = slpc_sanitize_url($_POST["coname"]);
			}
			if (isset($_POST["bgcol"])) {
				$coColor = slpc_sanitize_string($_POST["bgcol"],1);
			}
			if (isset($_POST["pgbgimage"])) {
				$coPgBgImage = slpc_sanitize_url($_POST["pgbgimage"]);
			}
			if (isset($_POST["pgbgimagesize"])) {
				$coPgBgImageSize = slpc_sanitize_string($_POST["pgbgimagesize"]);
			}
			if (isset($_POST["boxbgcolor"])) {
				$coBoxBgColor = slpc_sanitize_string($_POST["boxbgcolor"],1);
			}
			if (isset($_POST["boxbgimage"])) {
				$coBoxBgImage = slpc_sanitize_url($_POST["boxbgimage"]);
			}
			if (isset($_POST["boxbgimagesize"])) {
				$coBoxBgImageSize = slpc_sanitize_string($_POST["boxbgimagesize"]);
			}
			if (isset($_POST["boxtextcolor"])) {
				$coBoxTextColor = slpc_sanitize_string($_POST["boxtextcolor"],1);
			}
			if (isset($_POST["blwboxtextcolor"])) {
				$coBlwBoxTextColor = slpc_sanitize_string($_POST["blwboxtextcolor"],1);
			}
			if (isset($_POST["buttoncolor"])) {
				$coButtonColor = slpc_sanitize_string($_POST["buttoncolor"],1);
			}
			if (isset($_POST["buttontxtcolor"])) {
				$coButtonTxtColor = slpc_sanitize_string($_POST["buttontxtcolor"],1);
			}
			if (isset($_POST["buttontxtshadow"])) {
				$coButtonTxtShadow = slpc_sanitize_string($_POST["buttontxtshadow"],1);
			}
			if (isset($_POST["buttontxtshadowcolor"])) {
				$coButtonTxtShadowColor = slpc_sanitize_string($_POST["buttontxtshadowcolor"],1);
			}
			if (isset($_POST["buttonborder"])) {
				$coButtonBorder = slpc_sanitize_string($_POST["buttonborder"],1);
			}

			if (isset($coImagee)){

				$wpdb->update( 
					$LCDBname, 
					array( 
						'link' => $coLinkee,
						'logo' => $coImagee,
						'color' => $coColor,
						'pgbgimg' => $coPgBgImage,
						'pgbgimgsize' => $coPgBgImageSize,
						'bxbgcolor' => $coBoxBgColor,
						'bxbgimg' => $coBoxBgImage,
						'bxbgimgsize' => $coBoxBgImageSize,
						'bxtextcolor' => $coBoxTextColor,
						'blwbxtextcolor' => $coBlwBoxTextColor,
						'buttonbgcolor' => $coButtonColor,
						'buttontextcolor' => $coButtonTxtColor,
						'buttontextshadow' => $coButtonTxtShadow,
						'buttontextshadowcolor' => $coButtonTxtShadowColor,
						'buttonborder' => $coButtonBorder
						), 
					array( 'id' => 1 ), 
					array( 
        '%s',   // value1
        '%s',   // value2
        '%s',   // value3
        '%s',	// and so on..
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        ), 
					array( '%d' ) 
					);
			}

		}

		global $wpdb;
		if($wpdb->get_var("show tables like '$LCDBname'") == $LCDBname){ 
			$results = $wpdb->get_results( "SELECT id,logo,link,color,pgbgimg,pgbgimgsize,bxbgcolor,bxbgimg,bxbgimgsize,bxtextcolor,blwbxtextcolor,buttonbgcolor,buttontextcolor,buttontextshadow,buttontextshadowcolor,buttonborder,ispaid
				FROM $LCDBname
				GROUP BY id ASC", OBJECT );
			if ($results) {
				$SLPC_ID = $results[0]->id;

			//validating and escaping logo image url and field placeholder
				$SLPC_Logo = $results[0]->logo;
				$SLPC_LogoArray = slpc_validate_image_url($SLPC_Logo);
				if ($SLPC_LogoArray) {
					$SLPC_Logo = $SLPC_LogoArray[0];
					$SLPC_LogoPlaceholder = $SLPC_LogoArray[1];
					$SLPC_LogoError = $SLPC_LogoArray[2];
				}

			//validating and escaping logo link url and field placeholder
				$SLPC_Link = $results[0]->link;
				$SLPC_LinkArray = slpc_validate_link_url($SLPC_Link);
				if ($SLPC_LinkArray) {
					$SLPC_Link = $SLPC_LinkArray[0];
					$SLPC_LinkPlaceholder = $SLPC_LinkArray[1];
					$SLPC_LinkError = $SLPC_LinkArray[2];
				}

			//validating and escaping page background color and field placeholder
				$SLPC_PgBgColor = $results[0]->color;
				$SLPC_PgBgColorArray = slpc_validate_html_color($SLPC_PgBgColor,1);
				if ($SLPC_PgBgColorArray) {
					$SLPC_PgBgColor = $SLPC_PgBgColorArray[0];
					$SLPC_PgBgColorPlaceholder = $SLPC_PgBgColorArray[1];
					$SLPC_PgBgColorError = $SLPC_PgBgColorArray[2];
				}

			//validating and escaping page background image url and image field placeholder
				$SLPC_PageBgImage = $results[0]->pgbgimg;
				$SLPC_PageBgImageArray = slpc_validate_image_url($SLPC_PageBgImage);
				if ($SLPC_PageBgImageArray) {
					$SLPC_PageBgImage = $SLPC_PageBgImageArray[0];
					$SLPC_PageBgImagePlaceholder = $SLPC_PageBgImageArray[1];
					$SLPC_PageBgImageError = $SLPC_PageBgImageArray[2];
				}

			//validating and escaping page background image size radio button value
				$SLPC_PageBgImageSize = $results[0]->pgbgimgsize;

			//validating and escaping box background color and field placeholder
				$SLPC_BoxBgColor = $results[0]->bxbgcolor;
				$SLPC_BoxBgColorArray = slpc_validate_html_color($SLPC_BoxBgColor,1);
				if ($SLPC_BoxBgColorArray) {
					$SLPC_BoxBgColor = $SLPC_BoxBgColorArray[0];
					$SLPC_BoxBgColorPlaceholder = $SLPC_BoxBgColorArray[1];
					$SLPC_BoxBgColorError = $SLPC_BoxBgColorArray[2];
				}

			//validating and escaping login box background image url and placeholder
				$SLPC_BoxBgImage = $results[0]->bxbgimg;
				$SLPC_BoxBgImageArray = slpc_validate_image_url($SLPC_BoxBgImage);
				if ($SLPC_BoxBgImageArray) {
					$SLPC_BoxBgImage = $SLPC_BoxBgImageArray[0];
					$SLPC_BoxBgImagePlaceholder = $SLPC_BoxBgImageArray[1];
					$SLPC_BoxBgImageError = $SLPC_BoxBgImageArray[2];
				}

			//box background image size radio button value
				$SLPC_BoxBgImageSize = $results[0]->bxbgimgsize;

			//validating and escaping box text color and field placeholder
				$SLPC_BoxTextColor = $results[0]->bxtextcolor;
				$SLPC_BoxTextColorArray = slpc_validate_html_color($SLPC_BoxTextColor,1);
				if ($SLPC_BoxTextColorArray) {
					$SLPC_BoxTextColor = $SLPC_BoxTextColorArray[0];
					$SLPC_BoxTextColorPlaceholder = $SLPC_BoxTextColorArray[1];
					$SLPC_BoxTextColorError = $SLPC_BoxTextColorArray[2];
				}

			//validating and escaping color of text below the login box
				$SLPC_BlwBoxTextColor = $results[0]->blwbxtextcolor;
				$SLPC_BlwBoxTextColorArray = slpc_validate_html_color($SLPC_BlwBoxTextColor,1);
				if ($SLPC_BlwBoxTextColorArray) {
					$SLPC_BlwBoxTextColor = $SLPC_BlwBoxTextColorArray[0];
					$SLPC_BlwBoxTextColorPlaceholder = $SLPC_BlwBoxTextColorArray[1];
					$SLPC_BlwBoxTextColorError = $SLPC_BlwBoxTextColorArray[2];
				}

			//validating and escaping login button background color
				$SLPC_ButtonBgColor = $results[0]->buttonbgcolor;
				$SLPC_ButtonBgColorArray = slpc_validate_html_color($SLPC_ButtonBgColor,1);
				if ($SLPC_ButtonBgColorArray) {
					$SLPC_ButtonBgColor = $SLPC_ButtonBgColorArray[0];
					$SLPC_ButtonBgColorPlaceholder = $SLPC_ButtonBgColorArray[1];
					$SLPC_ButtonBgColorError = $SLPC_ButtonBgColorArray[2];
				}

			//validating and escaping login button text color
				$SLPC_ButtonTextColor = $results[0]->buttontextcolor;
				$SLPC_ButtonTextColorArray = slpc_validate_html_color($SLPC_ButtonTextColor,1);
				if ($SLPC_ButtonTextColorArray) {
					$SLPC_ButtonTextColor = $SLPC_ButtonTextColorArray[0];
					$SLPC_ButtonTextColorPlaceholder = $SLPC_ButtonTextColorArray[1];
					$SLPC_ButtonTextColorError = $SLPC_ButtonTextColorArray[2];
				}

			//button text shadow color radio button
				$SLPC_ButtonTextShadow = $results[0]->buttontextshadow;

			//validating and escaping button text shadow color
				$SLPC_ButtonTextShadowColor = $results[0]->buttontextshadowcolor;
				$SLPC_ButtonTextShadowColorArray = slpc_validate_html_color($SLPC_ButtonTextShadowColor,1);
				if ($SLPC_ButtonTextShadowColorArray) {
					$SLPC_ButtonTextShadowColor = $SLPC_ButtonTextShadowColorArray[0];
					$SLPC_ButtonTextShadowColorPlaceholder = $SLPC_ButtonTextShadowColorArray[1];
					$SLPC_ButtonTextShadowColorError = $SLPC_ButtonTextShadowColorArray[2];
				}

			//validating and escaping button border color
				$SLPC_ButtonBorder = $results[0]->buttonborder;
				$SLPC_ButtonBorderArray = slpc_validate_html_color($SLPC_ButtonBorder,1);
				if ($SLPC_ButtonBorderArray) {
					$SLPC_ButtonBorder = $SLPC_ButtonBorderArray[0];
					$SLPC_ButtonBorderPlaceholder = $SLPC_ButtonBorderArray[1];
					$SLPC_ButtonBorderError = $SLPC_ButtonBorderArray[2];
				}
				$SLPC_isPaid = $results[0]->ispaid;

				$SLPCthisUrl = site_url();
				$SLPCthisLogoUrl = $SLPCthisUrl . '/wp-admin/images/w-logo-blue.png';

				if ($SLPC_Logo == $SLPCthisLogoUrl) {

				}
			} else {

			}
		}

	//checks to make sure current user has the correct permissions

		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

	// This is the jQuery that opens the Wordpress Media Library Modal Window for Image selection
	// also adds .different class to image fields that have changed
		echo "<script>


		jQuery(document).ready(function($){
			var _custom_media = true,
			_orig_send_attachment = wp.media.editor.send.attachment;

			$('.buttongg').click(function(e) {
				var send_attachment_bkp = wp.media.editor.send.attachment;
				var buttonz = document.getElementsByClassName('thisButton');
				var button = $(this);
				var id = button.attr('id').replace('_button', '');
				_custom_media = true;
				wp.media.editor.send.attachment = function(props, attachment){
					if ( _custom_media ) {
						$('#image_url').val(attachment.url);
						$('#image_url').addClass('different');
						for(var i = 0; i < buttonz.length; i++)
						{
							$('.thisButton').addClass('thisChanged');
						}
					} else {
						return _orig_send_attachment.apply( this, [props, attachment] );
					};
				}

				wp.media.editor.open(button);
				return false;
			});
			$('.buttonggg').click(function(e) {
				var send_attachment_bkp = wp.media.editor.send.attachment;
				var buttonz = document.getElementsByClassName('thisButton');
				var button = $(this);
				var id = button.attr('id').replace('_button', '');
				_custom_media = true;
				wp.media.editor.send.attachment = function(props, attachment){
					if ( _custom_media ) {
						$('#pgbgimage').val(attachment.url);
						$('#pgbgimage').addClass('different');
						for(var i = 0; i < buttonz.length; i++)
						{
							$('.thisButton').addClass('thisChanged');
						}
					} else {
						return _orig_send_attachment.apply( this, [props, attachment] );
					};
				}

				wp.media.editor.open(button);
				return false;
			});
			$('.buttongggg').click(function(e) {
				var send_attachment_bkp = wp.media.editor.send.attachment;
				var buttonz = document.getElementsByClassName('thisButton');
				var button = $(this);
				var id = button.attr('id').replace('_button', '');
				_custom_media = true;
				wp.media.editor.send.attachment = function(props, attachment){
					if ( _custom_media ) {
						$('#boxbgimage').val(attachment.url);
						$('#boxbgimage').addClass('different');
						for(var i = 0; i < buttonz.length; i++)
						{
							$('.thisButton').addClass('thisChanged');
						}
					} else {
						return _orig_send_attachment.apply( this, [props, attachment] );
					};
				}

				wp.media.editor.open(button);
				return false;
			});

			$('.add_media').on('click', function(){
				_custom_media = false;
			});
		});
	</script>";

	// This script highlights the (non image related) form fields that have been changed

	echo "<script>
	jQuery(document).ready(function () {
		jQuery('input[type=\"text\"]').each(function (i, e) {
			inputIsDifferent(jQuery(e));
		});

		jQuery('input[type=\"text\"]').on('input', function () {
			inputIsDifferent(jQuery(this));
		});

	});

	function inputIsDifferent(elm) {
		var elm = elm;
		var buttonz = document.getElementsByClassName('thisButton');
		if (elm.attr('data-origValue') != elm.val()) {
			elm.addClass('different');
			for(var i = 0; i < buttonz.length; i++)
			{
				jQuery('.thisButton').addClass('thisChanged');
			}
		} else {
			elm.removeClass('different');
			
		}
	}
</script>";


	// Some global CSS styles

echo '<style>

.different {
	background: beige !important;
}
.fielderror {
	border:2px solid red !important;
	box-shadow:2px 2px yellow !important;
}
.greyedout{
	opacity: 0.3;
	cursor: not-allowed;
	pointer-events: none;
}
.thisChanged{
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#fceabb+0,fccd4d+28,fccd4d+70,fbdf93+100 */
	background: #fceabb !important; /* Old browsers */
	background: -moz-linear-gradient(top,  #fceabb 0%, #fccd4d 28%, #fccd4d 70%, #fbdf93 100%)  !important; /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  #fceabb 0%,#fccd4d 28%,#fccd4d 70%,#fbdf93 100%)  !important; /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  #fceabb 0%,#fccd4d 28%,#fccd4d 70%,#fbdf93 100%)  !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#fceabb", endColorstr="#fbdf93",GradientType=0 ); /* IE6-9 */

}
.buttonChange{
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#b4e391+0,61c419+100 */
	background: #b4e391; /* Old browsers */
	background: -moz-linear-gradient(top,  #b4e391 0%, #61c419 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  #b4e391 0%,#61c419 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  #b4e391 0%,#61c419 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#b4e391", endColorstr="#61c419",GradientType=0 ); /* IE6-9 */

}
div.submitButton input{
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f5f6f6+0,e2e2e2+100 */
	background: #f5f6f6; /* Old browsers */
	background: -moz-linear-gradient(top,  #f5f6f6 0%, #e2e2e2 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  #f5f6f6 0%,#e2e2e2 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  #f5f6f6 0%,#e2e2e2 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#f5f6f6", endColorstr="#e2e2e2",GradientType=0 ); /* IE6-9 */
	color: white;
	padding: 10px 20px;
	border-radius: 10px;
	border: 0px none;
	box-shadow: 1px 1px black;
	text-shadow: 1px 1px black;
	cursor: pointer;
	text-align: center;
}
div.submitButton input:hover{
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#61c419+0,b4e391+100 */
	background: #61c419; /* Old browsers */
	background: -moz-linear-gradient(top,  #61c419 0%, #b4e391 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  #61c419 0%,#b4e391 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  #61c419 0%,#b4e391 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#61c419", endColorstr="#b4e391",GradientType=0 ); /* IE6-9 */
}
div.submitButton{
	text-align:center;
	padding-top:20px;
}
div.formItem{
	padding-bottom:20px;
	width:80%;
	margin:0px auto;
}
input.rightField{
	float:right !important;
}
div#activeLogo{
	text-align:center;
}
iframe{
	border:0px !important;
}
div.disabled {
	background-color: white !important;
	background-image: url(http://juliefrankly.com/wp-content/plugins/simple-login-page-customizer/assets/slpc_no_image_selected.jpg) !important;
	background-repeat: no-repeat !important;
	background-size: auto 100% !important;
	background-position: 50% !important;
}
#overlay { 
width: auto;
min-width:450px;
max-width:500px; 
height: 300px; 
padding: 0; 
overflow: hidden;
position:absolute;
z-index:10;
cursor:not-allowed;
}
#renderer { 
width: 100%; 
min-width:450px;
height: 330px; 
padding: 0; 
overflow: hidden;
pointer-events:none;
border:0.5px solid lightgrey;
}
#frame { 
width: 1280px; 
height: 786px; 
border: 1px solid black;
pointer-events:none;
}
#frame {
    // zoom: 0.35;
-moz-transform: scale(0.35);
-moz-transform-origin: 0 0;
-o-transform: scale(0.35);
-o-transform-origin: 0 0;
-webkit-transform: scale(0.35);
-webkit-transform-origin: 0 0;
}
div#adminBox{
	border:2px solid gray; background-color:white; width:auto; padding:40px;
	margin-bottom:5px;
}
div#formBox,div#previewBox{
	display:inline-block;
	width:49%;
	vertical-align:top;
}
h1.h2Title{
	border-bottom:2px solid black;
	padding-bottom:10px;
	margin-bottom: 20px;
	width:90%;
}
p.borderr{
	border-bottom: 2px solid black;
	padding-bottom:10px;
	width:90%;
	margin:0px auto;
	margin-bottom: 20px;
}
div#formBox form label {
	display:inline-block;
}
div#formBox form input {
	display:inline-block;
}
div.notice{
	display:none !important;
}
div#upgradeBox{
	background-color:beige;
	border:2px solid gray; 
	color:white; 
	width:auto; 
	margin-right:20px;
	padding:20px 40px;
	text-align:center;
}
div#purchaseNow{
	width:150px;
	height:32px;
	background: #ffb76b; /* Old browsers */
	background: -moz-linear-gradient(top,  #ffb76b 0%, #ffa73d 19%, #ff7c00 66%, #ff7f04 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  #ffb76b 0%,#ffa73d 19%,#ff7c00 66%,#ff7f04 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  #ffb76b 0%,#ffa73d 19%,#ff7c00 66%,#ff7f04 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#ffb76b", endColorstr="#ff7f04",GradientType=0 ); /* IE6-9 */
	color:white;
	margin:0px auto;
	padding-top:12px;
	border-radius:10px;
	font-weight:bold;
	cursor:pointer;
	box-shadow:1px 1px black;
	text-shadow: 1px 1px black;
	font-size:16px;
}
div#purchaseNow:hover{
	background: #ff7f04; /* Old browsers */
	background: -moz-linear-gradient(top,  #ff7f04 0%, #ff7c00 34%, #ffa73d 71%, #ffb76b 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  #ff7f04 0%,#ff7c00 34%,#ffa73d 71%,#ffb76b 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  #ff7f04 0%,#ff7c00 34%,#ffa73d 71%,#ffb76b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#ff7f04", endColorstr="#ffb76b",GradientType=0 ); /* IE6-9 */
}
canvas{
	max-width:300px !important;
	width:300px !important;
}

@media only screen and (max-width: 1200px) {
	div#formBox, div#previewBox {
		display: block;
		width: 100%;
		vertical-align: top;
	}
}
</style>';


echo '<h1>Simple Login Page Customizer</h1>';

	//Leave a Review box HTML

echo '<div id="upgradeBox" style="">';
echo '<h2 style="border-bottom:0px;">Do you find this plugin useful?</h2>';
echo '<div onclick="window.open(\'https://wordpress.org/plugins/simple-login-page-customizer/\');" id="purchaseNow" style="">Leave a Review!</div></div>';

	// Begin Plugin Options Page HTML

echo '<div class="wrap">';

	// Begin Instructions

echo '<div id="adminBox" style=""><h1 class="h2Title">Instructions</h1>';
echo '<p><b>1)</b> Enter the desired logo link (homepage by default).</p>';
echo '<p><b>2)</b> Select the desired logo image from the Media Library or enter an image URL.</p>';
echo '<p><b>3)</b> Enter the desired login page background color as a simple word (red or green) or as a hex value. (#f1f1f1)</p>';
echo '<p><b>3)</b> All other colors are also entered as a simple word (red or green) or as a hex value. (#f1f1f1)</p>';
echo '<p><b>3)</b> Background images can also be selected from the Media Library or entered as an image URL.</p>';
echo '<p><b>4)</b> Update!.</p>';

	// Begin Customizer Form

echo '<div id="formBox"><h1 class="h2Title">Login Page Design Options</h1>';
echo '<form style="height:auto;" action="/wp-admin/options-general.php?page=login-page-customizer" method="post">
<h2>Logo Options</h2>';

	// Logo Link Field

echo '<div class="formItem" style="">Logo Links To:  <input class="rightField';

/* If there is an error add the fielderror class to the input field */
if ($SLPC_LinkError) {
	echo ' fielderror';
}
echo'" type="text" id = "coname" name="coname" data-origValue="' . $SLPC_Link . '" value="' . $SLPC_Link . '" placeholder="' . $SLPC_LinkPlaceholder . '"/></div>';

	// Logo Image Field

echo '<div class="formItem" style=""><input style="display:inline-block;" id="_unique_name_button" class="buttongg" name="_unique_name_button" type="button" value="Select Logo Image" /><input data-origValue="' . $SLPC_Logo . '" class="rightField';
/* If there is an error add the fielderror class to the input field */
if ($SLPC_LogoError) {
	echo ' fielderror';
}
echo'" style="display:inline-block;" type="text" value="' . $SLPC_Logo . '" placeholder="' . $SLPC_LogoPlaceholder . '" name="image_url" id="image_url"';

echo 'class="regular-text"></div>';

	// Active Logo Image Area

if ($SLPC_Logo && $SLPC_Logo !== 'none') {
	echo '<div id="activeLogo"><h3>Active Logo Image</h3>';
	echo '<img src="' . $SLPC_Logo . '" style="max-width:300px;max-height:200px;" /></div>
	<div class="submitButton" style="padding-bottom:10px;"><input class="thisButton" type="submit" name="submit" value="Update" /></div>';
}

if ($SLPC_Logo && $SLPC_Logo == 'none') {
	$SLPC_default_image = plugin_dir_url( __FILE__ ) . 'assets/slpc_no_image_selected.jpg';
	echo '<div id="activeLogo"><h3>Active Logo Image</h3>';
	echo '<img src="' . $SLPC_default_image . '" style="max-width:300px;max-height:200px;" /></div>
	<div class="submitButton" style="padding-bottom:10px;"><input class="thisButton" type="submit" name="submit" value="Update" /></div>';
}

	// Begin Page Background Options

echo '<p class="borderr"></p>
<h2>Page Options</h2>';

	// Page Background Color

echo '<div class="formItem" style="">Page Background Color:  <input class="rightField';

/* If there is an error add the fielderror class to the input field */
if ($SLPC_PgBgColorError) {
	echo ' fielderror';
}
echo'" data-origValue="' . $SLPC_PgBgColor . '" type="text" id = "bgcol" name="bgcol" placeholder="' . $SLPC_PgBgColorPlaceholder .'" value="' . $SLPC_PgBgColor . '" /></div>';

	// Page Background Image 

echo '<div class="formItem" style=""><input style="display:inline-block;" id="_unique_name_buttonn" class="buttonggg" name="_unique_name_buttonn" type="button" value="Page Background Image" /><input data-origValue="' . $SLPC_PageBgImage . '" class="rightField';
/* If there is an error add the fielderror class to the input field */
if ($SLPC_PageBgImageError) {
	echo ' fielderror';
}
echo'" style="display:inline-block;" type="text" id = "pgbgimage" name="pgbgimage" value="' . $SLPC_PageBgImage . '" placeholder="' . $SLPC_PageBgImagePlaceholder . '" /></div>';

	// Radio buttons for Page Background Image Size

if ($SLPC_PageBgImageSize == 'y') {
	echo '<div class="formItem" style="">Page Background Image Size: 
	<input type="radio" id = "pgbgimagesize" name="pgbgimagesize" value="y" checked><label for="pgbgimagesize"> Full</label>
	<input type="radio" id = "pgbgimagesizee" name="pgbgimagesize" value="n"><label for="pgbgimagesizee"> Auto</label><br></div>

	<div class="submitButton" style="padding-bottom:10px;"><input class="thisButton" type="submit" name="submit" value="Update" /></div>';
}

if ($SLPC_PageBgImageSize == 'n') {
	echo '<div class="formItem" style="">Page Background Image Size:  
	<input type="radio" id = "pgbgimagesize" name="pgbgimagesize" value="y"><label for="pgbgimagesize"> Full</label>
	<input type="radio" id = "pgbgimagesizee" name="pgbgimagesize" value="n" checked><label for="pgbgimagesizee"> Auto</label><br></div>

	<div class="submitButton" style="padding-bottom:10px;"><input class="thisButton" type="submit" name="submit" value="Update" /></div>';
}

	// Begin login box options

echo '<p class="borderr"></p>
<h2>Login Box Options</h2>';

	// Login Box Background Color

echo '<div class="formItem" style="">Login Box Background Color:  
<input data-origValue="' . $SLPC_BoxBgColor . '" class="rightField';
/* If there is an error add the fielderror class to the input field */
if ($SLPC_BoxBgColorError) {
	echo ' fielderror';
}
echo'" type="text" id = "boxbgcolor" name="boxbgcolor" value="' . $SLPC_BoxBgColor . '" placeholder="' . $SLPC_BoxBgColorPlaceholder . '"/></div>';

	// Login Box Background Image

echo '<div class="formItem" style=""><input style="display:inline-block;" id="_unique_name_buttonnn" class="buttongggg" name="_unique_name_buttonnn" type="button" value="Login Box Background Image" /><input data-origValue="' . $SLPC_BoxBgImage . '" class="rightField';
/* If there is an error add the fielderror class to the input field */
if ($SLPC_BoxBgImageError) {
	echo ' fielderror';
}
echo'" style="display:inline-block;" type="text" id = "boxbgimage" name="boxbgimage" value="' . $SLPC_BoxBgImage . '" placeholder="' . $SLPC_BoxBgImagePlaceholder . '" /></div>';


	// Radio buttons for Box Background Image Size

if ($SLPC_BoxBgImageSize == 'y') {
	echo '<div class="formItem" style="">Login Box Background Image Size:  <input type="radio" id = "boxbgimagesize" name="boxbgimagesize" value="y" checked><label for="boxbgimagesize"> Full</label><input type="radio" id = "boxbgimagesizee" name="boxbgimagesize" value="n"><label for="boxbgimagesizee"> Auto</label><br></div>';
}

if ($SLPC_BoxBgImageSize == 'n') {
	echo '<div class="formItem" style="">Login Box Background Image Size:  <input type="radio" id = "boxbgimagesize" name="boxbgimagesize" value="y"><label for="boxbgimagesize"> Full</label><input type="radio" id = "boxbgimagesizee" name="boxbgimagesize" value="n" checked><label for="boxbgimagesizee"> Auto</label><br></div>';
}

	// Login Box Text Color

echo '<div class="formItem" style="padding-bottom:10px;">Login Box Text Color:  <input data-origValue="' . $SLPC_BoxTextColor . '" class="rightField';
/* If there is an error add the fielderror class to the input field */
if ($SLPC_BoxTextColorError) {
	echo ' fielderror';
}
echo'" type="text" id = "boxtextcolor" name="boxtextcolor" value="' . $SLPC_BoxTextColor . '" placeholder="' . $SLPC_BoxTextColorPlaceholder . '"/></div>';

	// Below Login Box Text Color

echo '<div class="formItem" style="">Below Login Box Text Color:  <input data-origValue="' . $SLPC_BlwBoxTextColor . '" class="rightField';
/* If there is an error add the fielderror class to the input field */
if ($SLPC_BlwBoxTextColorError) {
	echo ' fielderror';
}
echo'" type="text" id = "blwboxtextcolor" name="blwboxtextcolor" value="' . $SLPC_BlwBoxTextColor . '" placeholder="' . $SLPC_BlwBoxTextColorPlaceholder . '"/></div>
<div class="submitButton" style="padding-bottom:10px;"><input class="thisButton" type="submit" name="submit" value="Update" /></div>';

	// Begin login button styles

echo '<p class="borderr"></p>
<h2>Login Button Options</h2>
<div class="formItem" style="">Login Button Background Color:  <input data-origValue="' . $SLPC_ButtonBgColor . '" class="rightField';
	/* If there is an error add the fielderror class to the input field */
	if ($SLPC_ButtonBgColorError) {
		echo ' fielderror';
	}
	echo'" type="text" id = "buttoncolor" name="buttoncolor" value="' . $SLPC_ButtonBgColor . '" placeholder="' . $SLPC_ButtonBgColorPlaceholder . '"/></div>
	<div class="formItem" style="">Login Button Text Color:  <input data-origValue="' . $SLPC_ButtonTextColor . '" class="rightField';
		/* If there is an error add the fielderror class to the input field */
		if ($SLPC_ButtonTextColorError) {
			echo ' fielderror';
		}
		echo'" type="text" id = "buttontxtcolor" name="buttontxtcolor" value="' . $SLPC_ButtonTextColor . '" placeholder="' . $SLPC_ButtonTextColorPlaceholder . '"/></div>';

	// Radio buttons for login button text shadow

		if ($SLPC_ButtonTextShadow == 'y') {
			echo '<div class="formItem" style="">Login Button Text Shadow:  <input type="radio" id = "buttontxtshadow" name="buttontxtshadow" value="y" checked><label for="buttontxtshadow"> Yes</label><input type="radio" id = "buttontxtshadoww" name="buttontxtshadow" value="n"><label for="buttontxtshadoww"> No</label><br></div>';
		}

		if ($SLPC_ButtonTextShadow == 'n') {
			echo '<div class="formItem" style="">Login Button Text Shadow:  <input type="radio" id = "buttontxtshadow" name="buttontxtshadow" value="y"><label for="buttontxtshadow"> Yes</label><input type="radio" id = "buttontxtshadoww" name="buttontxtshadow" value="n" checked><label for="buttontxtshadoww"> No</label><br></div>';
		}

		// Login Button Text Shadow Color

		echo '<div class="formItem" style="">Login Button Text Shadow Color:  <input data-origValue="' . $SLPC_ButtonTextShadowColor . '" class="rightField';
		/* If there is an error add the fielderror class to the input field */
		if ($SLPC_ButtonTextShadowColorError) {
			echo ' fielderror';
		}
		echo'" type="text" id = "buttontxtshadowcolor" name="buttontxtshadowcolor" value="' . $SLPC_ButtonTextShadowColor . '" placeholder="' . $SLPC_ButtonTextShadowColorPlaceholder . '"/></div>';

		// Login Button Border Color
		
		echo '<div class="formItem" style="">Login Button Border Color:  <input data-origValue="' . $SLPC_ButtonBorder . '" class="rightField';
		/* If there is an error add the fielderror class to the input field */
		if ($SLPC_ButtonBorderError) {
			echo ' fielderror';
		}
		echo'" type="text" id = "buttonborder" name="buttonborder" value="' . $SLPC_ButtonBorder . '" placeholder="' . $SLPC_ButtonBorderPlaceholder . '"/></div>';

		echo '<div class="submitButton" style="padding-bottom:10px;"><input class="thisButton" type="submit" name="submit" value="Update" /></div>
	</form></div>';

		// Login Page Preview Section

	echo slpc_isAIOBF();

	echo '</div>';

}


$LCDBnamee = 'loginCustomizer';
$LCDBname = $wpdb->prefix . $LCDBnamee;
global $wpdb;
if($wpdb->get_var("show tables like '$LCDBname'") == $LCDBname){
	$results = $wpdb->get_results( "SELECT id,logo,link,color,pgbgimg,pgbgimgsize,bxbgcolor,bxbgimg,bxbgimgsize,bxtextcolor,blwbxtextcolor,buttonbgcolor,buttontextcolor,buttontextshadow,buttontextshadowcolor,buttonborder,ispaid 
		FROM $LCDBname
		GROUP BY id ASC", OBJECT );
	if ($results) {
		$SLPC_ID = $results[0]->id;

			//validating and escaping logo image url and field placeholder
		$SLPC_Logo = $results[0]->logo;
		$SLPC_LogoArray = slpc_validate_image_url($SLPC_Logo);
		if ($SLPC_LogoArray) {
			$SLPC_Logo = $SLPC_LogoArray[0];
			$SLPC_LogoPlaceholder = $SLPC_LogoArray[1];
			$SLPC_LogoError = $SLPC_LogoArray[2];
		}

			//validating and escaping logo link url and field placeholder
		$SLPC_Link = $results[0]->link;
		$SLPC_LinkArray = slpc_validate_link_url($SLPC_Link);
		if ($SLPC_LinkArray) {
			$SLPC_Link = $SLPC_LinkArray[0];
			$SLPC_LinkPlaceholder = $SLPC_LinkArray[1];
			$SLPC_LinkError = $SLPC_LinkArray[2];
		}

			//validating and escaping page background color and field placeholder
		$SLPC_PgBgColor = $results[0]->color;
		$SLPC_PgBgColorArray = slpc_validate_html_color($SLPC_PgBgColor,1);
		if ($SLPC_PgBgColorArray) {
			$SLPC_PgBgColor = $SLPC_PgBgColorArray[0];
			$SLPC_PgBgColorPlaceholder = $SLPC_PgBgColorArray[1];
			$SLPC_PgBgColorError = $SLPC_PgBgColorArray[2];
		}

			//validating and escaping page background image url and image field placeholder
		$SLPC_PageBgImage = $results[0]->pgbgimg;
		$SLPC_PageBgImageArray = slpc_validate_image_url($SLPC_PageBgImage);
		if ($SLPC_PageBgImageArray) {
			$SLPC_PageBgImage = $SLPC_PageBgImageArray[0];
			$SLPC_PageBgImagePlaceholder = $SLPC_PageBgImageArray[1];
			$SLPC_PageBgImageError = $SLPC_PageBgImageArray[2];
		}

			//validating and escaping page background image size radio button value
		$SLPC_PageBgImageSize = $results[0]->pgbgimgsize;

			//validating and escaping box background color and field placeholder
		$SLPC_BoxBgColor = $results[0]->bxbgcolor;
		$SLPC_BoxBgColorArray = slpc_validate_html_color($SLPC_BoxBgColor,1);
		if ($SLPC_BoxBgColorArray) {
			$SLPC_BoxBgColor = $SLPC_BoxBgColorArray[0];
			$SLPC_BoxBgColorPlaceholder = $SLPC_BoxBgColorArray[1];
			$SLPC_BoxBgColorError = $SLPC_BoxBgColorArray[2];
		}

			//validating and escaping login box background image url and placeholder
		$SLPC_BoxBgImage = $results[0]->bxbgimg;
		$SLPC_BoxBgImageArray = slpc_validate_image_url($SLPC_BoxBgImage);
		if ($SLPC_BoxBgImageArray) {
			$SLPC_BoxBgImage = $SLPC_BoxBgImageArray[0];
			$SLPC_BoxBgImagePlaceholder = $SLPC_BoxBgImageArray[1];
			$SLPC_BoxBgImageError = $SLPC_BoxBgImageArray[2];
		}

			//box background image size radio button value
		$SLPC_BoxBgImageSize = $results[0]->bxbgimgsize;

			//validating and escaping box text color and field placeholder
		$SLPC_BoxTextColor = $results[0]->bxtextcolor;
		$SLPC_BoxTextColorArray = slpc_validate_html_color($SLPC_BoxTextColor,1);
		if ($SLPC_BoxTextColorArray) {
			$SLPC_BoxTextColor = $SLPC_BoxTextColorArray[0];
			$SLPC_BoxTextColorPlaceholder = $SLPC_BoxTextColorArray[1];
			$SLPC_BoxTextColorError = $SLPC_BoxTextColorArray[2];
		}

			//validating and escaping color of text below the login box
		$SLPC_BlwBoxTextColor = $results[0]->blwbxtextcolor;
		$SLPC_BlwBoxTextColorArray = slpc_validate_html_color($SLPC_BlwBoxTextColor,1);
		if ($SLPC_BlwBoxTextColorArray) {
			$SLPC_BlwBoxTextColor = $SLPC_BlwBoxTextColorArray[0];
			$SLPC_BlwBoxTextColorPlaceholder = $SLPC_BlwBoxTextColorArray[1];
			$SLPC_BlwBoxTextColorError = $SLPC_BlwBoxTextColorArray[2];
		}

			//validating and escaping login button background color
		$SLPC_ButtonBgColor = $results[0]->buttonbgcolor;
		$SLPC_ButtonBgColorArray = slpc_validate_html_color($SLPC_ButtonBgColor,1);
		if ($SLPC_ButtonBgColorArray) {
			$SLPC_ButtonBgColor = $SLPC_ButtonBgColorArray[0];
			$SLPC_ButtonBgColorPlaceholder = $SLPC_ButtonBgColorArray[1];
			$SLPC_ButtonBgColorError = $SLPC_ButtonBgColorArray[2];
		}

			//validating and escaping login button text color
		$SLPC_ButtonTextColor = $results[0]->buttontextcolor;
		$SLPC_ButtonTextColorArray = slpc_validate_html_color($SLPC_ButtonTextColor,1);
		if ($SLPC_ButtonTextColorArray) {
			$SLPC_ButtonTextColor = $SLPC_ButtonTextColorArray[0];
			$SLPC_ButtonTextColorPlaceholder = $SLPC_ButtonTextColorArray[1];
			$SLPC_ButtonTextColorError = $SLPC_ButtonTextColorArray[2];
		}

			//button text shadow color radio button
		$SLPC_ButtonTextShadow = $results[0]->buttontextshadow;

			//validating and escaping button text shadow color
		$SLPC_ButtonTextShadowColor = $results[0]->buttontextshadowcolor;
		$SLPC_ButtonTextShadowColorArray = slpc_validate_html_color($SLPC_ButtonTextShadowColor,1);
		if ($SLPC_ButtonTextShadowColorArray) {
			$SLPC_ButtonTextShadowColor = $SLPC_ButtonTextShadowColorArray[0];
			$SLPC_ButtonTextShadowColorPlaceholder = $SLPC_ButtonTextShadowColorArray[1];
			$SLPC_ButtonTextShadowColorError = $SLPC_ButtonTextShadowColorArray[2];
		}

			//validating and escaping button border color
		$SLPC_ButtonBorder = $results[0]->buttonborder;
		$SLPC_ButtonBorderArray = slpc_validate_html_color($SLPC_ButtonBorder,1);
		if ($SLPC_ButtonBorderArray) {
			$SLPC_ButtonBorder = $SLPC_ButtonBorderArray[0];
			$SLPC_ButtonBorderPlaceholder = $SLPC_ButtonBorderArray[1];
			$SLPC_ButtonBorderError = $SLPC_ButtonBorderArray[2];
		}
		$SLPC_isPaid = $results[0]->ispaid;


		if ($SLPC_Logo == '/wp-admin/images/w-logo-blue.png') {

		}
	} else {

	}
}


// This function adds the new logo image and all the css styles on login page 
function login_page_logo() {
	global $SLPC_Logo; 
	global $SLPC_PgBgColor; 
	global $SLPC_PageBgImage;
	global $SLPC_PageBgImageSize;
	if ($SLPC_PageBgImageSize == 'y') {
		$SLPC_PageBgImageSize = '100%';
	}
	if ($SLPC_PageBgImageSize == 'no') {
		$SLPC_PageBgImageSize = 'auto';
	}
	global $SLPC_BoxBgColor;
	global $SLPC_BoxBgImage;
	global $SLPC_BoxBgImageSize;
	if ($SLPC_BoxBgImageSize == 'y') {
		$SLPC_BoxBgImageSize = '100%';
	}
	if ($SLPC_BoxBgImageSize == 'no') {
		$SLPC_BoxBgImageSize = 'auto';
	}
	global $SLPC_BoxTextColor;
	global $SLPC_BlwBoxTextColor;
	global $SLPC_ButtonBgColor;
	global $SLPC_ButtonTextColor;
	global $SLPC_ButtonTextShadow;
	global $SLPC_ButtonTextShadowColor;
	global $SLPC_ButtonBorder;
	global $SLPC_isPaid;
	echo "<style type='text/css'>
            #login h1 a, .login h1 a {
	background-image: url('" . $SLPC_Logo . "');
	padding-bottom: 0px;
	width: auto;
	height: 100%;
	max-width: 320px;
	min-height: 84px;
	background-size: auto 100%;
}";

if ($SLPC_PageBgImage == 'none' ||  $SLPC_PageBgImage == '') {
	echo "body, html {
		background-color: " . $SLPC_PgBgColor . " !important;
	}";
} else {
	echo "body, html {
		background-color: transparent !important;
	}
	html{
		background-image:url('" . $SLPC_PageBgImage . "');
		background-size:" . $SLPC_PageBgImageSize . ";
	}";

}
echo ".wp-core-ui .button.button-large {
	color:" . $SLPC_ButtonTextColor . ";
	background-color:" . $SLPC_ButtonBgColor . ";
	border-color:" . $SLPC_ButtonBorder . ";";

	if ($SLPC_ButtonTextShadow == 'y') {
		echo "text-shadow: 0 -1px 1px " . $SLPC_ButtonTextShadowColor . ",1px 0 1px " . $SLPC_ButtonTextShadowColor . ",0 1px 1px " . $SLPC_ButtonTextShadowColor . ",-1px 0 1px " . $SLPC_ButtonTextShadowColor . ";
	}";	

}
if ($SLPC_ButtonTextShadow == 'n') {
	echo "
	text-shadow: none;
}";	
}

echo ".wp-core-ui .button.button-large:hover {

}

.login form#loginform {
	background-color:" . $SLPC_BoxBgColor . ";
	background-image:url('" . $SLPC_BoxBgImage . "');
	background-size:" . $SLPC_BoxBgImageSize . ";
}

.login label {
	color:" . $SLPC_BoxTextColor . ";
}
p#nav, p#backtoblog, p#nav a, p#backtoblog a{
	color:" . $SLPC_BlwBoxTextColor . ";
}
</style>";
}
add_action( 'login_enqueue_scripts', 'login_page_logo' );


	// This function adds url to image link on login page

function SLPC_login_page_logo_url() {
	global $SLPC_Link;
	if ($SLPC_Link) {
		return $SLPC_Link;
	} else {
		return home_url();
	}
}
add_filter( 'login_headerurl', 'SLPC_login_page_logo_url' );


	// This function adds image title to logo image on login page 

function SLPC_login_page_logo_url_title() {
	return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'SLPC_login_page_logo_url_title' );?>