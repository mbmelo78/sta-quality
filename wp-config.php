<?php

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
define( 'DB_NAME', 'wwpt_sta' );

/** Database username */
define( 'DB_USER', 'wwpt_sta' );

/** Database password */
define( 'DB_PASSWORD', '2!pSu]7M6n' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'u6umx6bdngxvxhq46wqd1fyirflajo0ca2pfgd3noiaq1agvlrn8oa25p9wf63wd' );
define( 'SECURE_AUTH_KEY',  '01rrbbmlnfbmmtmiuylpwy1ys0bixxgwkhiroslhwobiv4guoeipd983ncwjvxsp' );
define( 'LOGGED_IN_KEY',    'vxvv4zyczkgcl8twpl7fkglscd1piziyufkhjl3k4ay5tskonp28zrug2gvjferx' );
define( 'NONCE_KEY',        'qnumrvf9wjpcldl17phrpgufrmfhvdk01d4saqprxnay0vp3u2ypxdlqydif1spa' );
define( 'AUTH_SALT',        'bic8egcxsajnksbuu1xfzgrlcjzyb1ssutqwonypdzf8eqieilgj0hkpf8nwerst' );
define( 'SECURE_AUTH_SALT', 'zk62tc6qionwxb5ugwryqs59ykwfym73t1tebdcodqwltvwy1qri8uq8z4qi3auv' );
define( 'LOGGED_IN_SALT',   'jzhmfuvjlqmg9ojgxldpg7o945yflxxa06htuuvtxkhm69mfgtyg3curmf5b0n2l' );
define( 'NONCE_SALT',       'b0kvghqb8qgzywkmmajcomztriybm1b3aide1ongum9q3bevukdagxjwjslfxp6a' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wpev_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
