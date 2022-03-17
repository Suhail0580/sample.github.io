<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sample' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Z5o#: b<JXS))S,xSEcDE/Y^@vA^E?xo2.*HdOth6ju>*[h~k/4eUl2O10QC@iKk' );
define( 'SECURE_AUTH_KEY',  'Jb2_NO1,NLpA65v,Tt*6/kz<igc<&}89FiZ;2FI5WAQqKUohye (|B_+JM1}mn4/' );
define( 'LOGGED_IN_KEY',    'pp8M?]lH;rv##FeeAH:Eqc$bS_FIjO*)o^*KZvS;b,h5}?|@/imi^7~*g5@g7Y4y' );
define( 'NONCE_KEY',        'NdLK#:SVt!_qwDPNh ^y/4^2{:T.. 2FY5K7%$EVP8j79>/cAH<7{Hi@5jY[cjmH' );
define( 'AUTH_SALT',        'vySz)5/J/Qg[h-;`l9cJEJYbi|vz;8>DX=R]p9^bk%UrF)!{BSD!9g96-j9^vc1O' );
define( 'SECURE_AUTH_SALT', '(vY8D`F5@2BSKT{frq4lHH>)a}97o^&//6^myuV_) *u{jbZm{9T.cU:{fr2&XbF' );
define( 'LOGGED_IN_SALT',   'o&h%9vR,zBAbUt^F]>FY9W%a3dZ2G|S,-H=$0mU;0kd;=XpR$@grh-V]:c$zrTM.' );
define( 'NONCE_SALT',       'xg6+eo?|VSX]lrrc&:]83Q=9T+]r{*H3Mf=9 B%Z)+U< !HJ<!-DI9g>YM*PBxpJ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_admin';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
