<?php
/*
 * Este archivo crea el metabox y filtra el contenido de posts y páginas
 */

function jgccfr_sanitize_checkbox( $input ) {
    if ( $input != '' ) {
        return 1;
    } else {
        return '';
    }
}

// Crear metabox
add_action( 'add_meta_boxes', 'jgccfr_meta_box_init' );
function jgccfr_meta_box_init() {
	
    $screens = array( 'post', 'page' );
	$priority = ( jgccfr_option( 'metabox_priority' ) != '' ) ? jgccfr_option( 'metabox_priority' ) : 'high' ;
	
	
	foreach ($screens as $screen){
		add_meta_box( 'jgccfr_meta_box_id', 'JGC Content for Registered Users', 'jgccfr_form_meta_box', $screen, 'side', $priority );
	}
	
}

function jgccfr_form_meta_box( $post, $box ) {
	
    // Recuperar valores del metabox
	$jgccfr_ocultar_contenido = get_post_meta( $post->ID, '_jgccfr_ocultar_contenido', true );
	
    // Nonce
    wp_nonce_field( plugin_basename( __FILE__ ), 'jgccfr_guardar_meta_box' );
    
    ?>
   
	<input name="ocultar_contenido" id="ocultar_contenido" type="checkbox" 
	<?php echo checked($jgccfr_ocultar_contenido, 1, false); ?> /> <?php _e('Content for registered users only.', 'jgc-content-for-registered-users'); 
		jgccfr_by();
	?>
	
	
<?php
}

// Guardar los datos del metabox al guardar el post
add_action( 'save_post', 'jgccfr_guardar_meta_box' );

function jgccfr_guardar_meta_box( $post_id ) {
    
    // Comprobar si se ha establecido el valor de $_POST para guardar los datos del meta-box
    if( isset( $_POST['ocultar_contenido'] ) ) {
	
		// Comprobar que no es un guardado automático, si lo es, no se guardan los datos
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
			return;
		}

		// Comprobar el nonce por seguridad
		check_admin_referer( plugin_basename( __FILE__ ), 'jgccfr_guardar_meta_box' );
		
		// Actualizamos lod datos
        update_post_meta( $post_id, '_jgccfr_ocultar_contenido',  jgccfr_sanitize_checkbox( $_POST['ocultar_contenido'] ) );
		
    }else{ 
		// IMPORTANTE: Si el checkbox está desmarcado no se envía con el array de $_POST, solo se envía si está marcado. En este caso borramos el meta.
		delete_post_meta( $post_id, '_jgccfr_ocultar_contenido' );
	}
    
}

add_filter('the_content', 'jgccfr_ocultar_contenido');
function jgccfr_ocultar_contenido($content){
	global $post;
	
	$ocultar_contenido = get_post_meta( $post->ID, '_jgccfr_ocultar_contenido', true );
	
	if ($ocultar_contenido == 1 && !is_user_logged_in()) {
			
			$texto_msg = __( jgccfr_option( 'texto_mensaje'), 'jgc-content-for-registered-users' );
			$color_msg = jgccfr_option( 'color_mensaje' );
			
			// Si cualquiera puede registrarse, se muestra el enlace, si no, no
			$register_link = (get_option('users_can_register') == 1) ? ' | <a href="' . wp_registration_url() . '">' . __( 'Register', 'jgc-content-for-registered-users' ) . '</a>' : '';
			
			?>
			
			<div class="mensaje-hc mensaje-hc-<?php echo esc_html( $color_msg ); ?>">
			
				<?php echo esc_html( $texto_msg ); ?> &nbsp;<a href="<?php echo esc_url( wp_login_url( get_the_permalink() ) ); ?>"><?php _e( 'Log in', 'jgc-content-for-registered-users' ); ?></a>
				<?php echo $register_link; ?>
				
			</div>
			
			<?php
			
		}else{ // Usuario logueado
		
			return $content;
			
		}
}

?>