<?php
if (!defined( 'ABSPATH' )) { exit; }
  /**
  * Plugin Name:  atec Database
  * Plugin URI: https://atecplugins.com/
  * Description: Optimize WP database tables.
  * Version: 1.0.8
  * Requires at least: 5.2
  * Tested up to: 6.6.3
  * Requires PHP: 7.4
  * Author: Chris Ahrweiler
  * Author URI: https://atec-systems.com
  * License: GPL2
  * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
  * Text Domain:  atec-database
  */

if (is_admin()) 
{
	wp_cache_set('atec_wpdb_version','1.0.8');
	register_activation_hook( __FILE__, function() { require_once('includes/atec-wpdb-activation.php'); });
    require_once('includes/atec-wpdb-install.php');
}

function atec_wpdb_auto_timedout() { require_once('includes/atec-wpdb-del_timeout.php'); }
add_action( 'atec_wpdb_auto_timedout', 'atec_wpdb_auto_timedout' );

?>