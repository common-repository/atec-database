<?php
if (!defined('ABSPATH')) { exit; }
if (!defined('ATEC_TOOLS_INC')) require_once('atec-tools.php');

$options=atec_create_options('atec_WPDB_settings',['auto_timedout']);
update_option('atec_WPDB_settings',$options);
?>