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
define('DB_NAME', 'test');

/** MySQL database username */
define('DB_USER', 'bn_wordpress');

/** MySQL database password */
define('DB_PASSWORD', '10435e68c0');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

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
define('AUTH_KEY',         '19eee21291ee5ef27454b9752c1130eca51737cfd495aff8131cedf0dbc0b804');
define('SECURE_AUTH_KEY',  '53f02cfbf56691bd0b21abb68183aeb8b39103d5706b2414679f69f20b14675a');
define('LOGGED_IN_KEY',    '75fa12ec9908d113442fc355a44e4dab903eabdeba9a2daedb4d635f730f7c32');
define('NONCE_KEY',        'b363b5b757314895ee9cdc71da6d42c09572cd62b02a242e922c98fb852dcd7a');
define('AUTH_SALT',        '8aa9ff2b786b7c72995fcb1ae161e0aced26bbf0acf5e77c329b3e24ad503af8');
define('SECURE_AUTH_SALT', 'ea9cd9e3caefc67daf4ac683f62e6249de1e3c0e04a127b89fb24691d6e94d09');
define('LOGGED_IN_SALT',   '17aafd326d245c0d5f5e64a488a5c9f09d35d840b4d7b02d3b8be4d83abb1cd5');
define('NONCE_SALT',       '3b00576120e58ae259da091a5051f0af8229110f65e4a8039d42117cf5a13e84');

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
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','http://example.com');
 *  define('WP_SITEURL','http://example.com');
 *
*/

define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/gvn');
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/gvn');


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('WP_TEMP_DIR', 'C:/xampp/apps/gvn/tmp');

