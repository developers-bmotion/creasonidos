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
define( 'DB_NAME', 'wpcreasonidos' );

/** MySQL database username */
define( 'DB_USER', 'forge' );

/** MySQL database password */
define( 'DB_PASSWORD', 'ihXY1Iw4ObgkDg1LehcF' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'SF,Aj$*IcEl/G/H$cwp^Om9#_$%z]DfsR(dv^%IBe2nNKvZB8M37k GZ6`p*vND3' );
define( 'SECURE_AUTH_KEY',  'Fl<%14|w+ZxdHhgR,eL_5-RlJ7U$K&`9 >k fs d@iY9O5^Zi&TuAFv`XMC[nt(.' );
define( 'LOGGED_IN_KEY',    'Jm>7u+rQDIG`J]L>%dmWcKU&cEeFX?Q~Tu%CSfpAfWx*%0?nO gVlhPAe@_2Mq{R' );
define( 'NONCE_KEY',        '[Eb7rLu! t7FH<*X-xVPU3p60Nyxt+7&FFJkq*1Um*PHoh72%d5@^Lj.9$IKE69]' );
define( 'AUTH_SALT',        '(w+@^EGNIF bf(-T&yNnb`+>MFev#gE_zf0ym@vTd~TWNbRuvy[njR?r<%kvkKuN' );
define( 'SECURE_AUTH_SALT', 'nTawY,pCYXPi?!T@g@X1BSd6GM.4pWR-xdN{KNN:A4hB3qfii-)>dk #TStr&#Wi' );
define( 'LOGGED_IN_SALT',   'A`?4N)sW$4pyg3{0gVed7ibS>zZkWx%@![!_j di<?fg^<0+e*H$kFRg~Z5l3j,n' );
define( 'NONCE_SALT',       '?GVW:CuHi@t7Hc|Rqar!2v5IX)~B2Hu^[bbU$(2>vrz$?)b&vV)Y;PSXe(X4s0wl' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'cp_';

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
