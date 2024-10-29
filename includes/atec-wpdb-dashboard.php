<?php
if (!defined( 'ABSPATH' )) { exit; }

function atec_str_starts_with_array($str, $arr)
{
	foreach ($arr as $a) { if (str_starts_with($str,$a)) return true; }
	return false;
}

class ATEC_wpdb_dashboard { 

function __construct() {		
	
echo '
<div class="atec-page">';
	atec_header(__DIR__,'wpdb','Database');
	
	echo '
	<div class="atec-main">';

		require_once('atec-check.php');
		require_once('atec-wpdb-plugins.php');
		$pluginTools=new ATEC_wpdb_plugin_names();

		$url		= atec_get_url();
		$nonce = wp_create_nonce(atec_nonce());
		$nav 	= atec_clean_request('nav');
		$action = atec_clean_request('action');
		$id 		= atec_clean_request('id');			

		if ($nav=='') $nav='Tables';

		global $wpdb; 	

		atec_progress();
		
		$actions=['#table Tables'];
		if ($nav==='Table') $actions[] = 'Table';
		$actions = array_merge($actions, ['#rocket Optimize','#comment Comments','#blog Posts','#clock-rotate-left Revisions','#hourglass-end Transients','#settings Options']);
		$licenseOk=atec_check_license();
		atec_nav_tab($url, $nonce, $nav, $actions, $licenseOk?999:($nav==='Table'?2:1), !$licenseOk);

		// @codingStandardsIgnoreStart
		$prefix=$wpdb->prefix;
		// @codingStandardsIgnoreEnd

		echo '
		<div class="atec-g atec-border">';
		
		if ($nav=='Info') { require_once('atec-info.php'); new ATEC_info(__DIR__); }
		elseif ($nav=='Optimize') 
		{ if (atec_pro_feature('`Optimize´ reorganizes the physical storage of table and index data, to reduce storage space and increase speed')) 
			{ require_once('atec-wpdb-optimize-pro.php'); new ATEC_wpdb_optimize($url, $nonce, $action, $prefix); } 
		}
		elseif ($nav=='Comments') 
		{ if (atec_pro_feature('`Comments´ shows all comments with status SPAM/TRASH – cleanup with a single click')) 
			{ require_once('atec-wpdb-comments-pro.php'); new ATEC_wpdb_comments($url, $nonce, $action, $prefix); } 
		}
		elseif ($nav=='Posts') 
		{ 
			if (atec_pro_feature('`Posts´ shows all pages and posts with status TRASH – cleanup with a single click')) 
			{ require_once('atec-wpdb-posts-pro.php'); new ATEC_wpdb_posts($url, $nonce, $action, $prefix); } 
		}
		elseif ($nav=='Revisions') 
		{ 
			if (atec_pro_feature('`Revisions´ shows all revisions – cleanup with a single click')) 
			{ require_once('atec-wpdb-revisions-pro.php'); new ATEC_wpdb_revisions($url, $nonce, $action, $prefix); } 
		}
		elseif ($nav=='Table') { require_once('atec-wpdb-table.php'); new ATEC_wpdb_table($url, $nonce, $action); }
		elseif ($nav=='Transients') 
		{
			if (atec_pro_feature('`Transients´ shows all timed out transients´ – cleanup with a single click')) 
			{ require_once('atec-wpdb-transients-pro.php'); new ATEC_wpdb_transients($url, $nonce, $action, $prefix); } 
		}
		elseif ($nav=='Options') 
		{ 
			if (atec_pro_feature('`Options´ shows all entries in the options table. You can selectively delete them and set the autoload value'))
			{ require_once('atec-wpdb-options-pro.php'); new ATEC_wpdb_options($url, $nonce, $action, $prefix); }
		}
		else
		{
		
		$result 	= true;
		if ($action==='delete_table') 
		{ 
			if (($id=atec_clean_request('id'))!=='') 
			{
				// @codingStandardsIgnoreStart
				$result = $wpdb->query($wpdb->prepare('TRUNCATE TABLE %1s', sanitize_key($id)));
				// @codingStandardsIgnoreEnd
				atec_badge('Table '.esc_attr($id).' truncated','Truncation failed ('.$wpdb->last_error.')', $result);	
			}
		}
		elseif ($action==='drop') 
		{ 
			if (($id=atec_clean_request('id'))!=='') 
			{
				// @codingStandardsIgnoreStart
				$result = $wpdb->query($wpdb->prepare('DROP TABLE %1s', sanitize_key($id)));
				// @codingStandardsIgnoreEnd
				atec_badge('Table '.esc_attr($id).' droped','Droping failed ('.$wpdb->last_error.')', $result);	
			}
		}
		elseif ($action==='optimize') 
		{ 
			// @codingStandardsIgnoreStart
			// Optimizing can take some time.
			set_time_limit(600);
			// @codingStandardsIgnoreEnd
			if (($id=atec_clean_request('id'))!=='') 
			{
				// @codingStandardsIgnoreStart
				$result = $wpdb->query($wpdb->prepare('OPTIMIZE TABLE %1s', sanitize_key($id)));
				// @codingStandardsIgnoreEnd
				atec_badge('Table '.esc_attr($id).' optimized','Optimization of table '.esc_attr($id).' failed ('.$wpdb->last_error.')', $result);	
			}
		}
		
		$arr=array('#database Server'=>$wpdb->db_server_info(), '#database Name'=>$wpdb->dbname, '#database Prefix'=>$prefix);
		atec_little_block_with_info('Tables', $arr, '', array('update'),$url, $nonce);
				
		echo '
		<table class="atec-table atec-table-tiny atec-table-fit">
			<thead>
				<tr><th>#</th><th>Name</th><th><span class="', esc_attr(atec_dash_class('admin-plugins')), '"></span></th><th>Engine</th><th>Format</th><th>Size</th><th>Items</th><th>Updated</th><th>Optimize</th><th>Truncate</th><th>Drop</th></tr>
			</thead>
			<tbody>';
		
			//https://www.gradually.ai/wordpress-datenbank-tabellen/	
				
			$wpTables=['commentmeta','comments','links','options','postmeta','posts','terms','termmeta','term_relationships','term_taxonomy','usermeta','users'];	
			$c 			= 0;
			$totalSize = 0;
			$table='Tables_in_'.esc_attr($wpdb->dbname);
			// @codingStandardsIgnoreStart
			$tables = $wpdb->get_results('SHOW TABLES');
			// @codingStandardsIgnoreEnd
			$iconPath=plugin_dir_url(__DIR__).'assets/img/';
			$atec_icon=$iconPath.'atec-group/atec_logo_blue.png';
			$woo_icon=$iconPath.'WooCommerce_logo.svg';
			$ls_icon=$iconPath.'litespeed_logo.svg';	
			$test=(array) $tables[0];
			if (!isset($test[$table])) $table='name';
			unset($test);
			foreach ($tables as $t) 
			{
				$c++;
				$isAtec = str_contains($t->$table,'atec_');
				$isWp 	= in_array(str_ireplace($prefix,'',$t->$table), $wpTables);
				$isWoo 	= str_contains($t->$table,'woocommerce_') || str_contains($t->$table,'wc_') || str_contains($t->$table,'actionscheduler_');
				$isLS 	= str_contains($t->$table,'litespeed_');
				echo '
				<tr>
					<td>', esc_attr($c), '</td>';
					echo '
					<td class="atec-anywrap">',
					'<a class="atec-cursor" onclick="window.location.assign(\'', esc_url($url), '&action=&nav=Table&id=', esc_attr($t->$table), '&_wpnonce=', esc_attr($nonce),'\');">', (str_starts_with($t->$table,$prefix)?'<span class="atec-grey">'.esc_attr($prefix).'</span>'.esc_attr(str_replace($prefix,'',$t->$table)):esc_attr($t->$table)), '</a>',
					'</td>',
					'<td>', 
						(
						($isAtec?'<img class="atec-logo" src="'.esc_url($atec_icon).'">':
						($isLS?'<img class="atec-logo" src="'.esc_url($ls_icon).'">':
						($isWp?'<span class="'.esc_attr(atec_dash_class('wordpress','atec-grey')).'"></span>':
						($isWoo?'<img class="atec-logo" src="'.esc_url($woo_icon).'">':
						'<span class="atec-small">'.esc_attr($pluginTools->atec_wpdb_getPluginName($t->$table,'_')))))).'</span>'
						),
					'</td>';
	
					// @codingStandardsIgnoreStart
					$items =$wpdb->get_results($wpdb->prepare('SELECT count(*) AS count FROM %1s', $t->$table));
					$info = $wpdb->get_results($wpdb->prepare('SHOW TABLE STATUS LIKE %s', $t->$table));
					$size = $info[0]->Data_length+$info[0]->Index_length;
					$totalSize+=$size;
					// @codingStandardsIgnoreEnd
					echo '
					<td>', esc_attr($info[0]->Engine), '</td>
					<td ', ($info[0]->Row_format==='Compressed'?'class="atec-green"':''), '>', esc_attr($info[0]->Row_format), '</td>
					<td class="atec-table-right">', esc_attr(size_format($size)), '</td>
					<td class="atec-table-right">', esc_attr($items[0]->count), '</td>
					<td class="atec-table-right">', esc_attr($info[0]->Update_time), '</td>';
					atec_create_button('optimize','performance',true,$url,$t->$table,$nonce);
					if (!$isWp && $items[0]->count>0) atec_button_confirm($url,$nav,$nonce,'delete_table&id='.$t->$table);
					else echo '<td></td>';	
					if (!$isWp && $items[0]->count==0) atec_create_button('drop','trash',true,$url,$t->$table,$nonce);
					else echo '<td></td>';	
				echo '
				</tr>';
			}
			echo '
			<tr>
				<td class="atec-bold">', esc_attr($c), '</td><td colspan="4"></td><td class="atec-bold atec-table-right">', esc_attr(size_format($totalSize)) ,'</td><td colspan="5"></td>
			</tr>
			</tbody>
		</table>';
	}
	
	echo'
		</div>
	</div>
</div>';  

if (!class_exists('ATEC_footer')) require_once('atec-footer.php');

}}

new ATEC_wpdb_dashboard();
?>