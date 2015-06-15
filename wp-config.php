<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'mont8');

/** MySQL database username */
define('DB_USER', 'homestead');

/** MySQL database password */
define('DB_PASSWORD', 'secret');

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
define('AUTH_KEY',         '-$.By7A|>Rky(1j9zL]YUj4A%8+ryZ=.7C),#H+_}|aK~`0|*odm5mz_.`1OqlJ7');
define('SECURE_AUTH_KEY',  'sMEx}DDk3yY-r!Cy#q]&ugnJq5Qxb.~yb]d&K&gCC%l6g!/8%qeN{.)`]L8la#&i');
define('LOGGED_IN_KEY',    ':M2Ul94LQxVCjXtK_UY*5yFuW-(E28OskoH!{Lwc^S*,Ot%K~sc/):=3w[.WcS>~');
define('NONCE_KEY',        'a?{Pf:cPIF%:jEg7-d9N,??1zZ@{hwA`FEDx36(GWOw+iGF<2?Je] }n07uf+UKE');
define('AUTH_SALT',        ',PL[hyAxxyUKA-5#sP-ov6f#PM_(Y%(q(AchZt]3.1&O=I`H-PS*8-Od -%c)I#a');
define('SECURE_AUTH_SALT', 'koXmbT$f{%2S3NPRIzzb-;dVb;.:;~}*p`z 6c8YkA^`{#zNXw{QMs3Q6#=f~yTW');
define('LOGGED_IN_SALT',   'q,4V4agU6`$l8ER%ux2G~Pf9j$qc|0/p{Uj2[VP^,1ry%b=B>Q2IgDd-lR*{9sy7');
define('NONCE_SALT',       'GiXh&ga.tjbh,EA|QCm1e|a!R;:Q^j|+q7EFFul8zd]$#5mLU*fTHLw@T5hp#d}L');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'mo_';

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