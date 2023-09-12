<?php
// Salir si desinstalar/borrar no es llamado por WordPress
if( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit ();

// Eliminar las opciones del plugin de la base de datos
delete_option( 'jgccfr_opciones' );
