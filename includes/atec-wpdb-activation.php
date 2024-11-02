<?php
if (!defined('ABSPATH')) { exit; }
if (!defined('ATEC_TOOLS_INC')) require_once('atec-tools.php');

$optName='atec_WPDB_settings';
$options=atec_create_options($optName,['auto_timedout']);
update_option($optName,$options);
?>