<?php
if (!defined( 'ABSPATH' )) { exit; }

class ATEC_pagination { function __construct($url, $nonce, $total_rows, $per_page, $tblPage) {		

	if (ceil($total_rows / $per_page) > 0)
	{ 
		atec_reg_inline_style('', '
		.pagination { list-style-type: none; padding: 10px 0; display: inline-flex; width: fit-content; justify-content: space-between; box-sizing: border-box; }
		.pagination li { box-sizing: border-box; padding-right: 10px; }
		.pagination li a { box-sizing: border-box; background-color: #e2e6e6; padding: 8px; text-decoration: none; font-weight: bold; color: #616872; border-radius: 4px; }
		.pagination li a:hover { background-color: #d4dada; }
		.pagination .next a, .pagination .prev a { text-transform: uppercase; }
		.pagination .currentpage a { background-color: #518acb; color: #fff; }
		.pagination .currentpage a:hover { background-color: #518acb; }');
	
		echo '<ul class="pagination">';
	
		if ($tblPage > 1) echo '<li class="prev"><a class="atec-nodeco" href="', esc_url($url.$tblPage-1), '">Prev</a></li>';
		if ($tblPage > 3) echo '<li class="start"><a class="atec-nodeco" href="', esc_url($url.'1'), '">1</a></li><li class="dots">...</li>';
	
		if ($tblPage-2 > 0) echo '<li class="page"><a class="atec-nodeco" href="', esc_url($url.$tblPage-2), '">', esc_attr($tblPage-2), '</a></li>';
		if ($tblPage-1 > 0) echo '<li class="page"><a class="atec-nodeco" href="', esc_url($url.$tblPage-1), '">', esc_attr($tblPage-1), '</a></li>';
	
		echo '<li class="currentpage"><a class="atec-nodeco" href="', esc_url($url.$tblPage), '">', esc_attr($tblPage), '</a></li>';
	
		if ($tblPage+1 < ceil($total_rows / $per_page)+1) echo '<li class="page"><a class="atec-nodeco" href="', esc_url($url.$tblPage+1), '">', esc_attr($tblPage+1), '</a></li>';
		if ($tblPage+2 < ceil($total_rows / $per_page)+1) echo '<li class="page"><a class="atec-nodeco" href="', esc_url($url.$tblPage+2), '">', esc_attr($tblPage+2), '</a></li>';
	
		if ($tblPage < ceil($total_rows / $per_page)-2)
		{
			echo '<li class="dots">...</li>
			<li class="end"><a class="atec-nodeco" href="', esc_url($url.$tblPage+ceil($total_rows / $per_page)), '">', esc_attr(ceil($total_rows / $per_page)), '</a></li>';
		}				
		if ($tblPage < ceil($total_rows / $per_page)) echo '<li class="next"><a class="atec-nodeco" href="', esc_url($url.$tblPage+1), '">Next</a></li>';
		echo '</ul>';
	}

}}
?>