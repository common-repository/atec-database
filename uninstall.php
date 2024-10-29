<?php
	if (!defined('ABSPATH')) die;
	wp_cache_delete('atec_wpdb_version');
	delete_option('atec_WPDB_settings');
?>