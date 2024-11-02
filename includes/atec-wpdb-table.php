<?php
if (!defined( 'ABSPATH' )) { exit; }

class ATEC_wpdb_table { function __construct($url, $nonce, $action) {		

global $wpdb; 
$id = atec_clean_request('id');

echo '
<div class="atec-btn-div">
	  <div class="tablenav">';
	  atec_nav_button($url,$nonce,'','Table&id='.$id,'Reload');
	  atec_nav_button_confirm($url,$nonce,'delete_table','Table&id='.$id,'Delete all');
	 echo '
	 </div>
</div>';

atec_little_block('Table · List');

if ($id==='') { atec_error_msg('No table selected'); }
else
{
	if ($action==='delete_table') 
	{ 
		// @codingStandardsIgnoreStart
		$result = $wpdb->query($wpdb->prepare('TRUNCATE TABLE %1s', sanitize_key($id)));
		// @codingStandardsIgnoreEnd
		atec_badge('Table '.esc_attr($id).' truncated','Truncation failed ('.$wpdb->last_error.')', $result);	
	}

	// @codingStandardsIgnoreStart
	$total_rows		= intval($wpdb->get_var($wpdb->prepare('SELECT COUNT(*) AS total FROM %1s', sanitize_key($id))));
	$tblPage 		= atec_clean_request('tblPage');
	$tblPage		= $tblPage==''?1:absint($tblPage);
	$per_page		= $total_rows>10000?500:($total_rows>10000?250:($total_rows>1000?100:50));
	$calc_page 		= ($tblPage - 1) * $per_page;
	$results	 	= $wpdb->get_results($wpdb->prepare('SELECT * FROM %1s LIMIT %d, %d', sanitize_key($id), sanitize_key($calc_page), sanitize_key($per_page)));
	$colsName 		= $wpdb->get_col_info('name');
	// @codingStandardsIgnoreEnd
	
	echo '
	<p class="atec-mt-0"><strong>Table:</strong> ', esc_attr($id), ' | <strong>Items:</strong> ', esc_attr(number_format($total_rows)) , '</p>
	<table class="atec-table atec-table-tiny fixed">
		<thead><tr><th>#</th>'; foreach ($colsName as $col) { echo '<th>', esc_attr($col), '</th>'; } 	echo '</tr></thead>
		<tbody>';

	$c=($tblPage-1)*$per_page;
	foreach ($results as $row) 
	{
		$c++;
		echo '<tr><td class="atec-TDBR">', esc_attr($c), '</td>'; foreach ($row as $col) { echo '<td>', esc_attr(atec_short_string($col,256)), '</td>'; } echo '</tr>';
	}
	echo '
		</tbody>
	</table>';

	$url=$url.'&nav=Table&id='.$id.'&_wpnonce='.$nonce.'&tblPage='; 
	require_once('atec-pagination.php'); new ATEC_pagination($url, $nonce, $total_rows, $per_page, $tblPage);
}

}}
?>