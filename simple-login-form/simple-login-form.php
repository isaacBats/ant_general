<?php
/**
 * Plugin Name: Simple Login Form
 * Plugin URI: https://aftabhusain.wordpress.com/
 * Description: Put simple login form on page or template using shortcode .
 * Version: 1.0.1
 * Author: Aftab Husain
 * Author Email: amu02.aftab@gmail.com
 * Author URI: https://aftabhusain.wordpress.com/
 * License: GPLv2
 */

define('SLF_REGISTRATION_INCLUDE_URL', plugin_dir_url(__FILE__).'includes/');

//add front end css
function slf_slider_trigger(){
	wp_enqueue_style('slf_caro_css_and_js', SLF_REGISTRATION_INCLUDE_URL."front-style.css"); 
	wp_enqueue_script('slf_caro_css_and_js');
}
add_action('wp_footer','slf_slider_trigger');


// function to login Shortcode
function slf_login_shortcode( $atts ) {

   //if looged in rediret to home page
	if ( is_user_logged_in() ) { 
	    wp_redirect( get_option('home') );// redirect to home page
		exit;
	}
	
    global $wpdb; 
	if(sanitize_text_field( $_GET['login'] ) != ''){
	 $login_fail_msg=sanitize_text_field( $_GET['login'] );
	}
	?>
	<div class="alar-login-form">
	<?php if($login_fail_msg=='failed'){?>
	<div class="error"  align="center"><?php _e('Username or password is incorrect','');?></div>
	<?php }?>
		<div class="alar-login-heading">
		<?php _e("Login Form",'');?>
		</div>
		<form method="post" action="<?php echo get_option('home');?>/wp-login.php" id="loginform" name="loginform" >
			<div class="ftxt">
			<label><?php _e('Login ID :','');?> </label>
			 <input type="text" tabindex="10" size="20" value="" class="input" id="user_login" required name="log" />
			</div>
			<div class="ftxt">
			<label><?php _e('Password :','');?> </label>
			  <input type="password" tabindex="20" size="20" value="" class="input" id="user_pass" required name="pwd" />
			</div>
			<div class="fbtn">
			<input type="submit" tabindex="100" value="Log In" class="button" id="wp-submit" name="wp-submit" />
			<input type="hidden" value="<?php echo get_option('home');?>" name="redirect_to">
			</div>
		</form>
	</div>
	<?php
}

//add login shortcoode
add_shortcode( 'simple-login-form', 'slf_login_shortcode' );


//redirect to front end ,when login is failed
add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login

function my_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER']; 
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer . '/?login=failed' );  
      exit;
   }
}
	
?>
