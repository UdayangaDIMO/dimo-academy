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
define( 'DB_NAME', 'dats' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'XoI*vpo1WK}bJE|H^KKbDU3[9=^#xSYgDu:%smWi7bQPVMs cKpH`2hduYg4H[!z' );
define( 'SECURE_AUTH_KEY',  '}Z^n?{81.UdPS;XVYfZ)kiy(;d36L%s2B}@MRZc9;kU8I413RU+8kR,Tb%dVl-P=' );
define( 'LOGGED_IN_KEY',    ',/%l]Wly_n{C)LFe7iL^L**K6x,29:so45_D<FehP$v[;kwJeY!LH/]}YHFBftaf' );
define( 'NONCE_KEY',        '<,C3d=0|T9.i6Sla9J#p67CWP_&,1LT(Dt6o_|NQVO>?u]D Ee[ t+s2Bc%?x+6n' );
define( 'AUTH_SALT',        ':^&0WMQYKGdK3$z,e2*[ IHRC*&fZ=NWt=..h`CGC1n-n#tMVI+&}m7RK$dp@vzX' );
define( 'SECURE_AUTH_SALT', 'bu>Vr/p`*Gy_dB<ytj<V8XM@YZBOY0^+r-?F?!,w5(N=13/K4J;iYjOv4g`,`={L' );
define( 'LOGGED_IN_SALT',   '9Ov9#E_/!ySwT0 GOBGIfl/b^_6<G2($5-{9]5Ah*/);h(CitRS*yJ&0yO4JB~L<' );
define( 'NONCE_SALT',       '}^c!:DRg ?x,61N~ (UhOfGzf~$3r@P:&0ZOJVT6q^E+NVx@q=?ilSlxEvNjn(gw' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_dats';

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
