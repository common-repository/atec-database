<?php
if (!defined('ABSPATH')) { exit; }

global $wpdb; 
// @codingStandardsIgnoreStart
$transients = $wpdb->get_results($wpdb->prepare('DELETE FROM %1s WHERE option_name LIKE "%\_transient\_timeout\_%"', $wpdb->options));
// @codingStandardsIgnoreEnd
?>