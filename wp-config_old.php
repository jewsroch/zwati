<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'spicyfis_wrd2');

/** MySQL database username */
define('DB_USER', 'spicyfis_wrd2');

/** MySQL database password */
define('DB_PASSWORD', 'Fovnklutz2');

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
define('AUTH_KEY',         'y54WWGYtkcSRCZNCZ6Ur1PeTjKIrqJ3A3Saz9k3UM9JT6AS0HCMLVKYOmgRuFTjH');
define('SECURE_AUTH_KEY',  '4Pd1rZNfat8LYRgvU8A9pjCIUbdfBJQm5m6A4LIpVJnf3oQM4q66RwgrUdYAHATL');
define('LOGGED_IN_KEY',    '0JgN10rSSkQAmSMxVqCAi5QjKUEm6vjIOdhpaKlM4V4jurSynXsAcB8QNpg5aTVE');
define('NONCE_KEY',        '4GcqBO6GfWyOvsBDKB3e30e2jLh2YS8p8TIyau0nGqn53NtGVQoCj8RLegHDJ32p');
define('AUTH_SALT',        'MEUQG8wG0wHr3JyWUborKQLcDFQCWJp5I86MAOdj5f6m9aEJEs9PrgQWG5KLW3KG');
define('SECURE_AUTH_SALT', 'nAhUuDNkxD9BKkRK9M8yqdunl8ZlJtnFWMMFxlfzFN0NgHj54ikyKrNdUSpZdlIU');
define('LOGGED_IN_SALT',   '6VCf5aLFbcqDxrFQ9KeSKaPAYSvCBVEBtwwBwVkl04Ih0B8g39qBGvKKlHkCMtJi');
define('NONCE_SALT',       '89JK6h0vsHvwgpoxtTOS37PH1LiOvzcjSvNWwBAN9vIoETtD5dKNywQFn6qBqjLa');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/*Added manually for Multisite Capability */
define('WP_ALLOW_MULTISITE', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
