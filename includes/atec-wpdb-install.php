<?php
if (!defined( 'ABSPATH' )) { exit; }

if (!defined('ATEC_INIT_INC')) require_once('atec-init.php');
add_action('admin_menu', function() { atec_wp_menu(__DIR__,'atec_wpdb','Database'); });

add_action( 'init', function() 
{ 

	if (in_array($slug=atec_get_slug(), ['atec_group','atec_wpdb']))
	{
		if (!defined('ATEC_TOOLS_INC')) require_once('atec-tools.php');	
		add_action( 'admin_enqueue_scripts', function() { atec_reg_style('atec',__DIR__,'atec-style.min.css','1.0.002'); });
		
		if ($slug!=='atec_group')
		{
			function atec_wpdb(): void { require_once('atec-wpdb-dashboard.php'); }
			add_action( 'admin_enqueue_scripts', function()
			{
				atec_reg_style('atec_check',__DIR__,'atec-check.min.css','1.0.001');
			});
		}
	}	
});
?>
