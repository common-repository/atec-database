<?php
if (!defined( 'ABSPATH' )) { exit; }

function atec_opt_arr($opt,$slug): array { return array('name'=>$opt, 'opt-name' => 'atec_'.$slug.'_settings' ); }

function atec_button_confirm($url,$nav,$nonce,$action,$dash='trash'): void
{
	echo '
	<td>
		<div class="alignleft atec-btn-bg" style="background: #f0f0f0; min-width:35px; white-space: nowrap;">
			<input title="Confirm action" type="checkbox" onchange="const $btn=jQuery(this).parent().find(\'button\'); $btn.prop(\'disabled\',!$btn.prop(\'disabled\'));">
			<a href="', esc_url($url), '&action=', esc_attr($action), '&nav=', esc_attr($nav), '&_wpnonce=', esc_attr($nonce),'">
				<button style="padding: 0; margin:0; background:#f0f0f0 !important; border:none; line-height: 20px !important; min-height:20px !important;" disabled="true" class="button button-secondary"><span style="padding:0px;" class="'.esc_attr(atec_dash_class($dash)).'"></span></button>
			</a>
		</div>
	</td>';
}

function atec_checkbox_button($id,$str,$disabled,$option,$url,$param,$nonce): void
{
	$option=$option??'false';
	if ($option==1) $option='true';
	echo '
	<div class="atec-ckbx atec-dilb">
		<input name="check_', esc_attr($id), '"', ($disabled?'disabled="true"':''), ' type="checkbox" value="', esc_attr($option), '"', checked($option,'true',true), '>';
	if ($disabled) echo '<label for="check_', esc_attr($id), '" class="check_disabled"></label>';
	else echo '<label for="check_', esc_attr($id), '" onclick="location.href=\'', esc_url($url), esc_attr($param), '&_wpnonce=',esc_attr($nonce),'\'"></label>';
	echo '
	</div>';
}

function atec_checkbox_button_div($id,$str,$disabled,$option,$url,$param,$nonce,$pro=null): void
{
	echo '<div class="alignleft" style="padding: 2px 4px; ', $pro===false?'background: #f0f0f0; border: solid 1px #d0d0d0; border-radius: 3px; marin-right: 10px;':'' ,'">';
	if ($pro===false) 
	{
		$disabled=true;
		$link=get_admin_url().'admin.php?page=atec_group&license=true&_wpnonce='.esc_attr(wp_create_nonce('atec_license_nonce'));
		echo '
		<a class="atec-nodeco atec-blue" href="', esc_url($link), '">
			<span class="atec-dilb atec-fs-9"><span class="', esc_attr(atec_dash_class('awards','atec-blue atec-fs-16')), '"></span>PRO feature – please upgrade.</span>
		</a><br>';
	}
	echo '
		<div class="atec_checkbox_button_div atec-dilb">', esc_attr($str);
			atec_checkbox_button($id,$str,$disabled,$option,$url,$param,$nonce);
	echo '
		</div>
	</div>';
}

function atec_checkbox($args): void
{
	$option = get_option($args['opt-name'],[]); $field=$args['name']; $value=$option[$field]??'false';
	echo '
	<div class="atec-ckbx">
		<input id="check_', esc_attr($field), '" type="checkbox" name="', esc_attr($args['opt-name']), '[', esc_attr($field), ']" value="', esc_attr($value), '" onclick="atec_check_validate(\'', esc_attr($field), '\');" ', checked($value,'true',true), '>
		<label for="check_', esc_attr($field), '">
	</div>';
}
?>
