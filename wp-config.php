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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'agroexpo' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'izadnamtanetz' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '@!|!PV;>?H!s[r<3][iNl{aX,x.r]b~gh&d([M+N#jf~c=w<oTJ}nBuE!vPLM;Kk' );
define( 'SECURE_AUTH_KEY',  '&LumY}+X9%y)99Um>A?]U b_<ZOE#N!+;oce^_JPZXYj~d|k$n/h#h8Z3:gh$_LW' );
define( 'LOGGED_IN_KEY',    'Vv&.pIo&3._b->FoNDZ,mHp6eWiMQ&0Qxa J5WRO`!yU]VUmo;nUG$]W:S?L@zrs' );
define( 'NONCE_KEY',        'pGL 5_O@H.4.NUj6MZ]b3<q`m<aEMyvc3b]St*i_e?tw4na%Iyzu4YXn$>,o7!GW' );
define( 'AUTH_SALT',        'R6^ulBC|V&X9Vq#)2|U91PpjbV.=YhZ[`Iiq,R*w3)h-k&?+^j_X`1I8E+6x5OEV' );
define( 'SECURE_AUTH_SALT', '43 :E64BDBBIE<#7g_e_V1+a%uBeWL:#G26wK/MCDq*N4)J][!dBgnec$e;o0^*(' );
define( 'LOGGED_IN_SALT',   '*)Su{p:bIhV#LmJOAEx1Q1|R+v=Ez#~40-J9#77|NamY6YOM*XZqd>c=6*R>$if7' );
define( 'NONCE_SALT',       '~qMk*tuObF_h2]BduBFRZ6%TnKAUp!&-=ZG/y?{c$7158/1XTjjP9,vOx)OEE,Mp' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'agxpo_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
