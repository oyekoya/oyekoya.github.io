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
define('DB_NAME', 'vizserver');

/** MySQL database username */
define('DB_USER', 'vizserver');

/** MySQL database password */
define('DB_PASSWORD', 'fK~,h4RdAY04');

/** MySQL hostname */
define('DB_HOST', 'mysql.clemson.edu');

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

define('AUTH_KEY',         '9+_an+JK^Viss9U 7|gXlEU,c>vdmB:9t~]/4v}ov3-#_Q1d~|(Q0:p-~|ffiC1$');
define('SECURE_AUTH_KEY',  '{+Js+0g*r]wYfg<JrZas:(L2S7M&4b9<|=Mo2:`!_bjwrvr=vU]Z!(a-_||^>p`J');
define('LOGGED_IN_KEY',    'K?DvgG<qt3mF}(ts-Gi4IyTF;/F}@sNqQ*_i/K1|LTv^p@e:|-ly]kTg[8auS2):');
define('NONCE_KEY',        ',5KE0RVe750H.p8)SP7v-7w~B-7~gfxKqi>NO|l7*i-uK-vvdnUUk=,Qsam23l8+');
define('AUTH_SALT',        ',l;{ds|3]shQBS@G:-./m0f?`4jG45/fe|cQhG.g`a|6616t<=<>w_}Z;N HTJ12');
define('SECURE_AUTH_SALT', ']OssFxC#/_`&zr To2 /b(`n^wF`zp(?Jp(K#=9`&FG]B4 $gKwG%sGGlE> 6YUn');
define('LOGGED_IN_SALT',   '0xm1O<bEvfMp0D$g4 eD(oEM+Vbu+]p$Rd6lN=%N@6+[wUWywRzmTP9Ymp%SG6e$');
define('NONCE_SALT',       ':UZXa-720(8?A/+<29J>i}+x9-g+|TD.8zOnhytq7<t[;-hsb|:wqrj{^KDe7I;P');

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
