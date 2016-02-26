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
define('DB_NAME', 'wp_offshore');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         ')Jsz.zP|@+Ixr{J::8s:aQ7MhA!|[f8y-CcQ9vf50p`1/WO-R{|ptpT`%CDCs_ya');
define('SECURE_AUTH_KEY',  'X7f^?p}7!@5lq$dIz`IRNc;n-%!~!?!%_{H[LC0Oc=yg}E+&Yy0w 2gv;aQ>%m9m');
define('LOGGED_IN_KEY',    'T^%+*@u*;_-<ODz=_COz531)l}1Jw,7Hy{p!vT|>]Ry;i|eQ| !8n$00?Y+/uU%{');
define('NONCE_KEY',        'S1,u6vvl~~DYV_NNpu?P+``#|JS6+u|(Ny(5*M_R+e !-~t2n,6at5:ZI,D~(x$l');
define('AUTH_SALT',        'foC[r:/}o6oHN;Xt* ee-34#{8CQWk:49nyI  94i O-20BFYgpB=7:{:Zw$.|Ud');
define('SECURE_AUTH_SALT', ' 48S([I2qZ%rhmWTk(A=]Up16d59i}}`&B0m)/VH-KU.=}F:N}:]{+eIPX@<HC?*');
define('LOGGED_IN_SALT',   'MgiO3Vx5uAbXV~O04e8L-^CFUPQlPkZ>[zg`[*@M@T]s+Cq=Qq^5R-KT}4;I=R]I');
define('NONCE_SALT',       'gKDR5[ ++QgSJE]p8z.lNyHE5_%lwr*[kbWI_%dHtFEP>6A9=Q-R6]+:K1@Z,`5{');

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
