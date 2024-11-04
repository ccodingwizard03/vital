<?php
//Begin Really Simple Security session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple Security cookie settings
//Begin Really Simple Security key
define('RSSSL_KEY', 'nqJRKCgPAwZ3BchpLLrZgO9gpRevMWk8a8gH6PdNtHEAhxJPFtC8wdRaJGrOuQbp');
//END Really Simple Security key

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'vpoids_db' );

/** Database username */
define( 'DB_USER', 'vpoids_db_admin' );

/** Database password */
define( 'DB_PASSWORD', 'poids_db1' );

/** Database hostname */
define( 'DB_HOST', 'vpoids-prod-db.mysql.database.azure.com' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '^M2--N#%Al}c7);Z-*(UyAM1=Z,G9loV11j]l$v#H_[[c)Szfx$C5(,jfB9pwG2@' );
define( 'SECURE_AUTH_KEY',  'I=*YNQ[?2lPa{~Fp`$x#>yIi*A!hp!o4HsM4D6!xNn2=W(tC#GQ(I3dE:Ra[7g8D' );
define( 'LOGGED_IN_KEY',    'XQ4bB3B=`5HZ@4b#aV b}mK}D4i,K*:>YwI^ef. *l/*gLfLoD{I^@};`kMGx{*,' );
define( 'NONCE_KEY',        'x!<#9y^q6Ff7hZ@C3<d0l}]n0y6SF0Ji[cdobl>V00_/U.1 }lh`u5XKh&-qWkk(' );
define( 'AUTH_SALT',        'tA^k?FJ7.M~&JbO6*M.nOkYfw_K8gt2Uk^uJf]/mfkUD(`n~Y!=ckY_0gAmUcL#k' );
define( 'SECURE_AUTH_SALT', 'd_Bn:ht!Hp?hlzxvMFRsouf[(C |P:-`S|]oK~E<N 0DP-&m1ts=`1;v]rk^AH<J' );
define( 'LOGGED_IN_SALT',   'JLE2-:!vdf |y+8AC_8j=,?BeGcg7Bbg]BDeeS:`p`nuM6g)m%cbBYZyiyYfgo#!' );
define( 'NONCE_SALT',       'tEiDF]=KZ9~/4EBu1vJ)dSqGpSYKfBJ1 V,BH{/]g6Ti4 .AP/Hu;o00Fl}($hdQ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
