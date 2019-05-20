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
define('DB_NAME', 'diploma9_wp674');

/** MySQL database username */
define('DB_USER', 'diploma9_wp674');

/** MySQL database password */
define('DB_PASSWORD', ')0CS4p30(s');

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
 * @since 
 */
define('AUTH_KEY',         'uvf0hkm7v4ctqtnbqkmzhu6xhswoceuw2dxohl0jqm7breyw5c1oqgwqp9ssibcl');
define('SECURE_AUTH_KEY',  'nwgoez48knonak1z7rp84xgpss1z7hpkgsjmizmdgffn71pm91ivi5jd9cyarfnw');
define('LOGGED_IN_KEY',    'fbrqwmr57pb86o7rhbcrs5xk2vzkrjzps6gjhqyc1cgkafws4skf20snsetmdu2y');
define('NONCE_KEY',        '2ypyukadaqdjysfa958hobowhpkrqikmqeweypsxoagwjo0dzhihi2f8qryxrrqu');
define('AUTH_SALT',        'p3ashtv7ic8ouhdirgyrd9xzdpl2fwq8yevvw5enwvasjnsaprnaauruczgyqiag');
define('SECURE_AUTH_SALT', 'nzvug77jd02yrnxpwf0pbllmmung3cjiwfg1xb8bu68mu6vmgfsj5xagfarekekx');
define('LOGGED_IN_SALT',   'lhkuykpx5iopfze6ypw1etywgzyi87ws4bc1jkjqlhghurwogczyla8urgzm2zrg');
define('NONCE_SALT',       'g1rdwnolmmhxif2nicvalsmxsfkrbn54u6yj5p2ayqjzsjgjzalcz0u2czmv4a85');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpaq_';

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
