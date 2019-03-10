<?php
if (
    isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && 
    $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https"
) {
    $_SERVER["HTTPS"] = "on";
}
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
 define(‘WP_MAX_MEMORY_LIMIT’, ‘512M’);
define( 'WP_MEMORY_LIMIT', '512M' );

//define('DB_NAME', 'programm_db');

/** MySQL database username */
//define('DB_USER', 'programm_user');

/** MySQL database password */
//define('DB_PASSWORD', 'user@123!@');

/** MySQL hostname */
//define('DB_HOST', 'localhost');

define('DB_NAME', 'programmerlab');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Kandy@123!');

/** MySQL hostname */
define('DB_HOST', 'localhost');


/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'uHxrCvvR+mJhD8Rx}rZ/qD%u1HA.izZ5Q`@)m@w))Uc?vB3)^wvO60|V^!gwltQU');
define('SECURE_AUTH_KEY',  'oLoI^e6DZ0/-;z+XqS,J!*;[w[m^!P}K:Bj.l6JXuYLH3Msl+<Fp;Cno-R+Ri ~m');
define('LOGGED_IN_KEY',    ';|Jz}.DCAaws4*vDD#6u2mS75hu3zai5lb&9WBu%~OEEA:EC[Mm60MR`v$+YNo=Z');
define('NONCE_KEY',        'p#Y*h)0lPZ4I]K>o<,@zyHECxi7pcP&LfQ$cpC(XYx7%_P=tU8x@nl>!a:VqGrE;');
define('AUTH_SALT',        'n+[<05577O)&K05a}r-Q^:3XD/ira` x^_YfwX2gA{Po4p,L8ZQ(OoG0%sL&Fzn|');
define('SECURE_AUTH_SALT', 'lb8?gAzjWtM4i Q$bWqI4ON>|$x4pyRIUlyD~Z`N5h`@YN,4h<D)=5,?/|V7@pB!');
define('LOGGED_IN_SALT',   'f-NU_d8)YOz8.fdR-u`uxrcC25x6Y~<>j /jq5@LhGw5cK`F61?2YnC1%29Py8V8');
define('NONCE_SALT',       'T/?Kd`B:>$`beo=J5!NMp|V.4<I;;c|XGd[wnPW.b0-X-_bPbP)l`!4tMp:i~q1(');

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
