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
if ($_SERVER['HTTP_HOST'] == 'projects') {
	// ** MySQL settings - DEVELOPMENT SERVER ** //
	define('DB_NAME', '801divorce2010_d6');
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'edit');
	define('DB_HOST', 'localhost');
	define('DB_CHARSET', 'utf8');
	define('DB_COLLATE', '');
} else {
	// ** MySQL settings - LIVE SERVER ** //
	define('DB_NAME', '497276_801divorce2010_d6');
	define('DB_USER', '497276_divorce6');
	define('DB_PASSWORD', 'szkWyD9oiwJ7');
	define('DB_HOST', 'mysql50-92.wc2.dfw1.stabletransit.com');
	define('DB_CHARSET', 'utf8');
	define('DB_COLLATE', '');
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ';Sd2|UR{5EN(53{$/+u$:5|SebEV?5pQy>C)E<zD4#n<fKwxa?OlF{qf2ZK/w3yO');
define('SECURE_AUTH_KEY',  'h|j;/8uRK#;XW-R4(Cpbycf8wn^tImpc[PaFX6UcJ<W*:L`@H-_BF3+Ne]0(2 y`');
define('LOGGED_IN_KEY',    'bVr@3H6Eo.bfJQW:8=i7+;A;++Trx4_1j<h]1KTIGdPW,SCK*?MPT~(fgR5#Z7kn');
define('NONCE_KEY',        'w!@GC.Qc.1TQN~|)>2GV:696.reN2GO*t*^~Ztcbv|3!N zZny~qgZ1ls1bmmgA-');
define('AUTH_SALT',        '4]r#sBX)-U]BQopSI7T4M>1vnF&/!/)wbE-`LHy?YpQABcQNc+PI1H ;NnPS4I|e');
define('SECURE_AUTH_SALT', 'lE)s*]^3-C f}AOTJO  G=8lUBzUK(uz5fCW[--BFZ_CfGod9YKV8?2gS)FS|+5f');
define('LOGGED_IN_SALT',   'x`6K#Lia>6;AksG{L|Q(3jE|x{;Y|>ozFrCy+B.^D|.HI&K{`oO}c*<)X}^|16di');
define('NONCE_SALT',       '.F.-2MR,+hIP:zbCdbU7KT 13R9H t?`1[1h<sliS%%kt1rs+]`5q+-8<@a Z|-g');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = '801divorce_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

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
