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
define('DB_NAME', 'nhadatdangban_db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'I/tlxHt=Hh};<y{>7.6th>j5W5Lx32~1QYeq=mi_gv,=,)9E+;q9|~Gg?HQLV`{L');
define('SECURE_AUTH_KEY',  'X5TBwu0n]f1E%ZT<*])GY-Oss0;>Fxj3+RE>Xkn$8+S0>:1+&qhFMJ})-mS4[W<^');
define('LOGGED_IN_KEY',    '|;|}.7U-Z?6kns*>I9.L0=|VoB/Vx|Zq=6VK?=(ymdixZYp?F)>1:?a;%!{#C1Y+');
define('NONCE_KEY',        '&^)trbVv<_Ya+m)qaex(MO4gL@{f,-B6Ay.Y:C]]_32q2un7|Ux|,8kv;v5$!S4<');
define('AUTH_SALT',        'l0T%y.m0DcX6xSmbI4Em1-#9c(8@Nl2`Pyxu549vhS4lgf86vizCvIYRn5,IIyt3');
define('SECURE_AUTH_SALT', 'fG})^[4$eHi|Z*O.Zj_P#)Wza-R-YkN%vJ~y!kz8pyIhxg>+P.*K+Y80g -[C-{m');
define('LOGGED_IN_SALT',   'mj/#T8|rFr4D(U.i@R}T}8T%fD0}r$G02V|,UN6uwWU9i 0aM!GjdpE=O1Eoa9b[');
define('NONCE_SALT',       ']%p:St,~iO#*Zl<v<]+~N*Nh -^4`/U2nG|OK)&m, ,R~6=P/A=iE#FtfFD;0]9i');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
