<?php

function jgccfr_option($opcion) {
	
	$jgccfr_options = get_option( 'jgccfr_opciones' );
	$valor = $jgccfr_options[$opcion];
	return $valor;
	
}

add_shortcode('jgc_cfr', 'jgc_content_for_registered_sc');
function jgc_content_for_registered_sc($atts, $content = null){
	
    if ( !is_user_logged_in() ){
		
		$texto_msg = __( jgccfr_option('texto_mensaje'), 'jgc-content-for-registered-users' );
		$color_msg = jgccfr_option( 'color_mensaje' );
		
		// Si cualquiera puede registrarse (user_can_register = 1), se muestra el enlace, si no (user_can_register = 0), no
		$register_link = ( get_option( 'users_can_register' ) == 1 ) ? ' | <a href="' . wp_registration_url() . '">' . __( 'Register', 'jgc-content-for-registered-users' ) . '</a>' : '';
		
		$content = '<div class="mensaje-hc mensaje-hc-'.$color_msg.'">'.$texto_msg . ' <a href="'. wp_login_url(get_the_permalink()).'">' . __( 'Log in', 'jgc-content-for-registered-users' ) . '</a>' . $register_link . '</div>';
		
		return $content;
		
    }else{
		
        return $content;
		
	}
 
}
?>