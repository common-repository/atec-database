<?php
if (!defined( 'ABSPATH' )) { exit; }

class ATEC_wpdb_plugin_names {

private $pluginNames;

public function atec_wpdb_getPluginName($table,$prefix='')
{
	foreach ($this->pluginNames as $key => $value) 
	{ if (str_starts_with($table, $prefix.$key) || (str_starts_with($table, rtrim($key,'_')) && strlen($key)>3)) return $value; }
	return '';
}	

function __construct() {		

$this->pluginNames = array(
	'yoast_'=>'Yoast SEO', 'xsg_'=>'XML Sitemap', 'statistics_'=>'WP Statistics', 'wpstg_'=>'WP Staging', 'WP_SEO_'=>'wpSEO', 'wpr_'=>'WP Rocket', 'wpr_rucss'=>'WP Rocket',
	'wpai_'=>'WP Optimize', 'tm_'=>'WP Optimize', 'icl_'=>'WPML', 'ahm_'=>'WP Download', 'wpfm_'=>'WPBackItUp', 'tve_'=>'Thrive', 'tqb_'=>'Thrive', 'tve_'=>'Thrive',
	'smush_'=>'Smushit', 'revslider_'=>'Slider Rev.', 'revslider_'=>'RevSlider', 'rcb_'=>'Real Cookie', 'rank_math_'=>'Rank Math',
	'ppress_'=>'ProfilePress', 'prli_'=>'Pretty Links', 'nf3_'=>'Ninja Forms', 'mepr_'=>'MemberPress', 'matomo_'=>'Matomo', 'mailpoet_'=>'MailPoet', 'wysija_'=>'MailPoet',
	'mc4wp_'=>'MailChimp', 'koko_analytics'=>'Koko Analytics', 'itsec_'=>'iThemes Sec.', 'gpi_'=>'Google Insights', 'formmaker'=>'Form Maker', 'frmt_form_'=>'Forminator',
	'fluentform_'=>'Fluent Forms', 'ezfc_'=>'Ez Form', 'ewwwio_'=>'EWWW Image', 'evf_'=>'Everest Forms', 'digimember_'=>'Digimember', 'cjtoolbox_'=>'CSS & JS Toolbox',
	'cmplz_'=>'Complianz', 'ms_snippets'=>'Code Snippets', 'blc_'=>'Broken Link', 'borlabs_cookie_'=>'Borlabs Cookie', 'asa2_'=>'ASA 2 Pro', 'aiowps_'=>'AiO WP Security',
	'aioseo_'=>'AiOne SEO', 'aawp_'=>'AAWP', 'mainwp_'=>'MainWP', 
	'ahc_'=>'Visitors Traffic', 'gf_'=>'Gravity Forms', 'rg_'=>'Gravity Forms', 'prli_'=>'Pretty Links', 'redirection_'=>'Redirections', 'sbi_'=>'Smash Balloon','swift_'=>'Swift Perform.',
	'wpfm_backup'=>'WPBackItUp', 'litespeed_'=>'LiteSpeed', 'e_'=>'Elementor', 'brizy_'=>'Brizy','elementor_'=>'Elementor',
	'et_'=>'Elegant Themes™','jetpack_'=>'Jetpack','wcpay_'=>'Woo Payments','snippets'=>'Code Snippets','omgf_'=>'OMGF','updraftplus'=>'Updraft','wphb_'=>'Hummingbird',
	'trp_'=>'TranslatePress');		
}}

?>