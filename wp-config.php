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
error_reporting(E_ALL); ini_set('display_errors', 1);

define( 'WP_DEBUG', true);

ini_set('pcre.recursion_limit',20000000);

ini_set('pcre.backtrack_limit',10000000);
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'emoothcl_falcon');

/** MySQL database username */
define('DB_USER', 'emoothcl_falcon');

/** MySQL database password */
define('DB_PASSWORD', 'Emooth2014');

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
define('AUTH_KEY',         '$DFIhG17T7++&{KH|IZN0)Ljtd|yF^(Z,KX>Cj4=]p7X1!}X-i97kAbWJ.JY+8}A');
define('SECURE_AUTH_KEY',  'k_!$X-V68mO}I~$Aw_bX<.KU9<CzCK66v2o+=+h+|.b,MAf>Zsn@R%vzv!MGkH^<');
define('LOGGED_IN_KEY',    '4^h,NQBU04v#r?8oCr7ZJx,AFe6U>b>}X&W^nxpd+080B+LW;IZ+%ZQ>G3D8b~o0');
define('NONCE_KEY',        'hOL3mN]Q.@GUIMSTlo,pgg1aOdpc~<JK?z]?AYa]NqCcc5u^PHbe++TLB|oy=%M4');
define('AUTH_SALT',        '*cJV,P~}a1N~hvx-9)j~>|+N<x?4?:90mx]o`tgA/9$dKoj~e9 amiKE{B2_lZ=o');
define('SECURE_AUTH_SALT', '?hik!AU.u_ R9CoCiF9+L-nEJ!Azh->,n@{7R8#Tk-qNk;YP{v;jF,OWv{l,VWU)');
define('LOGGED_IN_SALT',   'Imjtp:6ymy91yC>)svq,t&;E,Ia~MU7DloWA-ibz-k/BTsZ@E|$~MiE #%-1@G4X');
define('NONCE_SALT',       '$Fc1HL-&4Gi8_>7TWCmZ +` `Sa[([])3M{ m4qTwNN_yik}YH2,X+;oBRP-$lN9');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'fc_';

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
// define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');