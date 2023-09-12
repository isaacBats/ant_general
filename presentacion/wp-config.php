<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'generalf_wp785');

/** MySQL database username */
define('DB_USER', 'generalf_wp785');

/** MySQL database password */
define('DB_PASSWORD', 'P8e4758S[)');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '3wtohsw7nleeslcdvsb4le2hljqwafhxrkdiii3xfzo0v3twzmviwxnoxrlyf1cj');
define('SECURE_AUTH_KEY',  'doa87v54bpcmwqoztypffnkmaozgzjs2ttp3sxkqn6odlfdh6jc7cjg9ujsjzlca');
define('LOGGED_IN_KEY',    'udc7yii81tlhkkaxjwivyqw8qzyfdwck4brcm1sbhe1ipuoou9mhkq4iu3xueaj3');
define('NONCE_KEY',        'qczvl1cvt2ltarpzc84klcliy294i9xtjenpvoygjtsnqdojdpfwvgstnnkyfv3f');
define('AUTH_SALT',        'icytwjouyirbcs4ocw5exy0pkp2gafycce5j3aluhl6eydli3jjasoio0dlphrlw');
define('SECURE_AUTH_SALT', '9jduz2ydknph2dbflutlpvmccmwz8zvle8xsrjrikkzz1nii8o44wykskd8ymtaa');
define('LOGGED_IN_SALT',   'mizseqs0qcq8m9n32bpnykmieimj8zkn9aevvwnd6bg055vlbxwn04ijvlhwsxz0');
define('NONCE_SALT',       'j4orfxnbzeutq2nzotsmj9fzskfwhhhtyqa5lhzayoa1xwsrgo8kqros7nkf92dv');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
