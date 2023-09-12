<?php
//Crear menú
add_action ( 'admin_menu', 'jgccfr_crear_menu' );
function jgccfr_crear_menu() {
	
	//Submenú en Ajustes
	add_options_page ( 'JGC Content for Registered Users', 'JGC Content for Registered Users', 'manage_options', 'jgccfr_settings', 'jgccfr_setting_page' );
	
	add_action ( 'admin_init', 'jgccfr_register_setting' );
	
}

function jgccfr_register_setting() {
	
	register_setting ( 'jgccfr_grupo_opciones', 'jgccfr_opciones', 'jgccfr_sanitize_options' );
	
}

function jgccfr_sanitize_options($input) {
	
	$input['texto_mensaje'] = sanitize_text_field( $input['texto_mensaje'] );
	$input['color_mensaje'] = ( in_array( $input['color_mensaje'], array( 'azul', 'verde', 'rojo', 'naranja', 'negro' ) ) ) ? $input['color_mensaje'] : 'azul';
	$input['metabox_priority'] = ( in_array( $input['metabox_priority'], array( 'high', 'default' ) ) ) ? $input['metabox_priority'] : 'high';
	
	return $input;
}

function jgccfr_setting_page() { ?>
    
    <div class="wrap">
    <h1 class="title_options">JGC Content for Registered Users | <?php _e( 'Options', 'jgc-content-for-registered-users' ); ?></h1>
    <hr />
	<form id="frm_cfr_opt" name="frm_cfr_opt" method="post" action="options.php" >
		<?php settings_fields('jgccfr_grupo_opciones'); ?>
		<?php $jgccfr_opciones = get_option('jgccfr_opciones'); ?>
		
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e( 'Metabox priority', 'jgc-content-for-registered-users' ); ?></th>
				<td>
					<input type="radio" 
					name="jgccfr_opciones[metabox_priority]"
					<?php echo checked( $jgccfr_opciones['metabox_priority'], 'high', false ); ?>
					value="high" /> <?php _e( 'High', 'jgc-content-for-registered-users' ); ?>&nbsp;&nbsp;&nbsp;
					
					<input type="radio" 
					name="jgccfr_opciones[metabox_priority]"
					<?php echo checked( $jgccfr_opciones['metabox_priority'], 'default', false ); ?>
					value="default" /> <?php _e( 'Default', 'jgc-content-for-registered-users' ); ?>&nbsp;&nbsp;&nbsp;
					
					<p><i>(<?php _e( "'High'  displays the metabox on top of right side on edit screen. 'Default' displays the metabox on right side but no on top", 'jgc-content-for-registered-users' ); ?>)</i></p>
				</td>
			</tr>
		
			<tr valign="top">
				<th scope="row"><?php _e( 'Message text', 'jgc-content-for-registered-users' ); ?></th>
				<td>
					<input type="text"
					name="jgccfr_opciones[texto_mensaje]" 
					value="<?php echo __( esc_attr($jgccfr_opciones['texto_mensaje'] ), 'jgc-content-for-registered-users'); ?>" 
					size="80" >
					
					<p><i>(<?php _e( 'Message to be displayed to users not registered replacing the post content', 'jgc-content-for-registered-users' ); ?>)</i></p>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><?php _e( 'Message color', 'jgc-content-for-registered-users' ); ?></th>
				<td>
					<input type="radio" 
					name="jgccfr_opciones[color_mensaje]"
					<?php echo checked( $jgccfr_opciones['color_mensaje'], 'azul', false ); ?>
					value="azul" /> <?php _e( 'Blue', 'jgc-content-for-registered-users' ); ?>&nbsp;&nbsp;&nbsp;
					
					<input type="radio" 
					name="jgccfr_opciones[color_mensaje]"
					<?php echo checked( $jgccfr_opciones['color_mensaje'], 'verde', false ); ?>
					value="verde" /> <?php _e( 'Green', 'jgc-content-for-registered-users' ); ?>&nbsp;&nbsp;&nbsp;
					
					<input type="radio" 
					name="jgccfr_opciones[color_mensaje]"
					<?php echo checked( $jgccfr_opciones['color_mensaje'], 'naranja', false ); ?>
					value="naranja" /> <?php _e( 'Orange', 'jgc-content-for-registered-users' ); ?>&nbsp;&nbsp;&nbsp;
					
					<input type="radio" 
					name="jgccfr_opciones[color_mensaje]"
					<?php echo checked( $jgccfr_opciones['color_mensaje'], 'rojo', false ); ?>
					value="rojo" /> <?php _e( 'Red', 'jgc-content-for-registered-users' ); ?>&nbsp;&nbsp;&nbsp;
					
					<input type="radio" 
					name="jgccfr_opciones[color_mensaje]"
					<?php echo checked( $jgccfr_opciones['color_mensaje'], 'negro', false ); ?>
					value="negro" /> <?php _e( 'Black', 'jgc-content-for-registered-users' ); ?>&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
		</table>
			
		<hr />
		
		<div class="btn-save">
			<p><input type="submit" class="button-primary" value="<?php _e( 'Save changes', 'jgc-content-for-registered-users' ); ?>" /></p>
		</div>
		
	</form>
	
	</div><!-- .wrapper-options -->
	<?php
} ?>