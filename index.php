<?php
/*
Plugin Name: WEHEWEHE Hawaiian English Dictionary Widget
Plugin URI: http://wordpress.ieonly.com/category/my-plugins/wehewehe/
Author: Eli Scheetz
Author URI: http://wordpress.ieonly.com/category/my-plugins/
Contributors: scheeeli
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8VWNB5QEJ55TJ
Description: Place this widget on your sidebar to let visiters to your site translate words from Hawaiian to English or English to Hawaiian.
Version: 4.14.49
*/

$WEHEWEHE_Version='4.14.49';
$WEHEWEHE_plugin_dir='WEHEWEHE';
if (isset($_SERVER["SCRIPT_FILENAME"]) && substr(__FILE__, -1 * strlen($_SERVER["SCRIPT_FILENAME"])) == substr($_SERVER["SCRIPT_FILENAME"], -1 * strlen(__FILE__))) die('You are not allowed to call this page directly.<p>You could try starting <a href="/">here</a>.</p>');

/*            ___
 *           /  /\     WEHEWEHE Main Plugin File
 *          /  /:/     @package WEHEWEHE
 *         /__/::\
 Copyright \__\/\:\__  © 2012-2014 Eli Scheetz (email: wordpress@ieonly.com)
 *            \  \:\/\
 *             \__\::/ This program is free software; you can redistribute it
 *     ___     /__/:/ and/or modify it under the terms of the GNU General Public
 *    /__/\   _\__\/ License as published by the Free Software Foundation;
 *    \  \:\ /  /\  either version 2 of the License, or (at your option) any
 *  ___\  \:\  /:/ later version.
 * /  /\\  \:\/:/
  /  /:/ \  \::/ This program is distributed in the hope that it will be useful,
 /  /:/_  \__\/ but WITHOUT ANY WARRANTY; without even the implied warranty
/__/:/ /\__    of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
\  \:\/:/ /\  See the GNU General Public License for more details.
 \  \::/ /:/
  \  \:\/:/ You should have received a copy of the GNU General Public License
 * \  \::/ with this program; if not, write to the Free Software Foundation,    
 *  \__\/ Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA        */

function WEHEWEHE_install() {
	global $wp_version;
	if (version_compare($wp_version, "2.6", "<"))
		die(__("This Plugin requires WordPress version 2.6 or higher"));
}

$encode = '/[\?\-a-z\: \.\=\/A-Z\&\_]/';
if (!function_exists('ur1encode')) {
	function ur1encode($url) {
		global $encode;
		return preg_replace($encode, '\'%\'.substr(\'00\'.strtoupper(dechex(ord(\'\0\'))),-2);', $url);
	}
}

function WEHEWEHE_display_header($pTitle, $optional_box = '') {
	global $WEHEWEHE_plugin_dir, $WEHEWEHE_Version;
	$WEHEWEHE_plugin_home = 'http://wordpress.ieonly.com/';
	$loading_img_URL = WEHEWEHE_images_path.'loading.gif';
	echo '<style>
.rounded-corners {margin: 10px; padding: 10px; -webkit-border-radius: 10px; -moz-border-radius: 10px; border: 1px solid #000000;}
.shadowed-box {box-shadow: -3px 3px 3px #666666; -moz-box-shadow: -3px 3px 3px #666666; -webkit-box-shadow: -3px 3px 3px #666666;}
.sidebar-box {background-color: #CCCCCC;}
.sidebar-links {padding: 0 15px; list-style: none;}
.shadowed-text {text-shadow: #0000FF -1px 1px 1px;}
.sub-option {float: left; margin: 3px 5px;}
.pp_left {height: 28px; float: left; background-position: top center;}
.pp_right {height: 18px; float: right; background-position: bottom center;}
.pp_donate {margin: 3px 5px; background-repeat: no-repeat; background-image: url(\'https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif\');}
.pp_left input {width: 100px; height: 28px;}
.pp_right input {width: 130px; height: 18px;}
#right-sidebar {float: right; margin-right: 10px; width: 290px;}
#main-section {margin-right: 310px;}
</style>
<script>
function showhide(id) {
	divx = document.getElementById(id);
	if (divx.style.display == "none")
		divx.style.display = "";
	else
		divx.style.display = "none";
}
</script>
<h1>WEHEWEHE '.$pTitle.'</h1>
<div id="right-sidebar" class="metabox-holder">
	<div id="pluginupdates" class="shadowed-box stuffbox"><h3 class="hndle"><span>Plugin Updates</span></h3>
		<div id="findUpdates"><center>Searching for updates ...<br /><img src="'.$loading_img_URL.'" alt="Loading..." /><br /><input type="button" value="Cancel" onclick="document.getElementById(\'findUpdates\').innerHTML = \'Could not find server!\';" /></center></div>
	<script type="text/javascript" src="'.$WEHEWEHE_plugin_home.WEHEWEHE_updated_images_path.'?js='.$WEHEWEHE_Version.'&p='.$WEHEWEHE_plugin_dir.'"></script>
	</div>
	<div id="pluginlinks" class="shadowed-box stuffbox"><h3 class="hndle"><span>Plugin Links</span></h3>
		<div class="inside">
		<form target="_blank" action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<table cellpadding=0 cellspacing=0><tr><td>
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="8VWNB5QEJ55TJ">
				<input type="image" src="http://wordpress.ieonly.com/wp-content/uploads/btn_donateCC_WIDE.gif" border="0" name="submit" alt="Make a Donation with PayPal">
			</td></tr><tr><td>
				<ul class="sidebar-links">
					<li><b>Included with this Plugin</b><ul class="sidebar-links">
						<li style="float: right;"><a href="javascript:showhide(\'div_License\');">License File</a></li>
						<li><a href="javascript:showhide(\'div_Readme\');">Readme File</a></li>
					</ul></li><br />
					<li style="float: right;"><b>on <a target="_blank" href="https://profiles.wordpress.org/scheeeli">WordPress.org</a></b><ul class="sidebar-links">
						<li><a target="_blank" href="https://wordpress.org/plugins/'.strtolower($WEHEWEHE_plugin_dir).'/faq/">Plugin FAQs</a></li>
						<li><a target="_blank" href="https://wordpress.org/support/plugin/'.strtolower($WEHEWEHE_plugin_dir).'">Forum Posts</a></li>
					</ul></li>
					<li><b>on <a target="_blank" href="'.$WEHEWEHE_plugin_home.'category/my-plugins/">Eli\'s Blog</a></b><ul class="sidebar-links">
						<li><a target="_blank" href="'.$WEHEWEHE_plugin_home.'category/my-plugins/wehewehe/">Plugin URI</a></li>
						<li><a target="_blank" href="mailto:wordpress@ieonly.com">E-Mail Me</a></li>
					</ul></li>
				</ul>
			</td></tr></table>
		</form>
		</div>
	</div>
	'.$optional_box.'
</div>
<div id="admin-page-container">
	<div id="main-section" class="metabox-holder">';
	WEHEWEHE_display_File('Readme');
	WEHEWEHE_display_File('License');
}
function WEHEWEHE_display_File($dFile) {
	if (file_exists(dirname(__FILE__).'/'.strtolower($dFile).'.txt')) {
		echo '<div id="div_'.$dFile.'" class="shadowed-box rounded-corners sidebar-box" style="display: none;"><a class="rounded-corners" style="float: right; padding: 0 4px; margin: 0 0 0 30px; text-decoration: none; color: #CC0000; background-color: #FFCCCC; border: solid #FF0000 1px;" href="javascript:showhide(\'div_'.$dFile.'\');">X</a><h1>'.$dFile.' File</h1><textarea disabled="yes" width="100%" style="width: 100%;" rows="20">';
		include(strtolower($dFile).'.txt');
		echo '</textarea></div>';
	}
}
function WEHEWEHE_mysql_report($MySQL) {
	if (false) {
		$SQL_Error = mysql_error();
		if (substr($SQL_Error, 0, 6) == "Table " && substr($SQL_Error, -14) == " doesn't exist")
			WEHEWEHE_install();
		else $echo .= '<li>ERROR: '.mysql_error().'<li>SQL:<br><textarea disabled="yes" cols="65" rows="15">'.$MySQL.'</textarea>';//only used for debugging.
	} else {
		if ($rs = mysql_fetch_assoc($result)) {
			$echo .= '	<div style="position: relative; background-color: #CCFFCC;" class="shadowed-box rounded-corners"><table border=1 cellspacing=0 cellpadding=1 style="padding: 1px;"><tr>';
			foreach ($rs as $field => $value)
				$echo .= '<td style="padding: 1px;"><div style="width: 100%; background-color: #000000;"><font color="#FFFFFF"><b>&nbsp;'.$field.'&nbsp;</b></font></div></td>';
			do {
				$echo .= '</tr><tr>';
				foreach ($rs as $field => $value)
					$echo .= '<td>'.$value.'</td>';
			} while ($rs = mysql_fetch_assoc($result));
			$echo .= '</tr></table></div>';
		} else
			$echo .= '<b>No Stats Info Available At This Time!</b><br />Make sure Safe Stats is set to Yes and the WEHEWEHE Widget has been placed on on your sidebar. Then go put enter some queries into the Widget and you should see some stats when you come back to this page.';
	}
	return $echo;
}
function WEHEWEHE_Settings() {
	global $WEHEWEHE_plugin_dir, $WEHEWEHE_source_array, $WEHEWEHE_menu, $WEHEWEHE_settings_array;
	$current_user = wp_get_current_user();
	$menu_groups = array('Main Menu Item placed below Comments and above Appearance','Main Menu Item placed below Settings','Sub-Menu under the Settings Menu Item');
	$menu_opts = '<div class="stuffbox shadowed-box">
		<h3 class="hndle"><span>Menu Item Placement Options</span></h3>
		<div class="inside">(Customize where to find this page in your admin menu)<form method="POST" name="WEHEWEHE_menu_Form">';
	foreach ($menu_groups as $mg => $menu_group)
		$menu_opts .= '<div class="sub-option" id="menu_group_div_'.$mg.'"><input type="radio" name="WEHEWEHE_menu_group" value="'.$mg.'"'.($WEHEWEHE_menu['group']==$mg?' checked':'').' onchange="document.WEHEWEHE_menu_Form.submit();" />'.$menu_group.'</div>';
	WEHEWEHE_display_header('Settings and Stats', $menu_opts.'</form><br style="clear: left;" /></div></div>');
	$WEHEWEHE_source_keys = array_keys($WEHEWEHE_source_array);
	if (!isset($WEHEWEHE_settings_array['web_source']))
		$WEHEWEHE_settings_array['web_source'] = $WEHEWEHE_source_keys[0];
	if (!isset($WEHEWEHE_settings_array['save_stats']))
		$WEHEWEHE_settings_array['save_stats'] = "yes";
	if (!isset($WEHEWEHE_settings_array['bgcolor']))
		$WEHEWEHE_settings_array['bgcolor'] = "transparent";
	if (isset($_POST['bgcolor']) && $_POST['bgcolor'] != $WEHEWEHE_settings_array['bgcolor'])
		$WEHEWEHE_settings_array['bgcolor'] = $_POST['bgcolor'];
	if (isset($_POST['save_stats']) && $_POST['save_stats'] != $WEHEWEHE_settings_array['save_stats'])
		$WEHEWEHE_settings_array['save_stats'] = $_POST['save_stats'];
	if (isset($_POST['web_source']) && $_POST['web_source'] != $WEHEWEHE_settings_array['web_source'] && in_array($_POST['web_source'], $WEHEWEHE_source_keys))
		$WEHEWEHE_settings_array['web_source'] = $_POST['web_source'];
	update_option($WEHEWEHE_plugin_dir.'_settings_array', $WEHEWEHE_settings_array);
	echo '<div id="WEHEWEHE_Form_container" class="shadowed-box stuffbox"><h3 class="hndle"><span>Global WEHEWEHE Widget Settings</span></h3>
	<div class="inside">
		<form method="POST" name="WEHEWEHE_Form"><div class="shadowed-box rounded-corners" style="float: left; background-color: '.$WEHEWEHE_settings_array['bgcolor'].';"><b>Web Source:</b>';
	foreach ($WEHEWEHE_source_array as $domain => $fullPath)
		echo '<br /><input type="radio" name="web_source" value="'.$domain.'"'.($domain==$WEHEWEHE_settings_array['web_source']?' checked':'').' />&nbsp;'.$fullPath;
	echo '</div><div class="shadowed-box rounded-corners" style="float: left; background-color: '.$WEHEWEHE_settings_array['bgcolor'].';"><b>Background Color:</b><br /><input type="text" name="bgcolor" value="'.$WEHEWEHE_settings_array['bgcolor'].'" /></div>';
//	echo '<br /><br /><b>Save Stats?</b><br /><input type="radio" name="save_stats" value="yes"'.($WEHEWEHE_settings_array['save_stats']=="yes"?" checked":"").' />Yes &nbsp; <input type="radio" name="save_stats" value="no"'.($WEHEWEHE_settings_array['save_stats']=="yes"?"":" checked").' />No';//coming soon<div style="float: left;"><h3 style="align: center;">Stats</h3>'.WEHEWEHE_mysql_report($MySQL).'</div>
	echo '<br style="clear: left;" /><input type="submit" value="Update" class="button-primary" style="float: right;" /><br /><br /></form></div></div></div></div>';
}
$WEHEWEHE_menu = array('group'=>0, 'url'=>basename(__FILE__));
function WEHEWEHE_menu() {
	global $WEHEWEHE_plugin_dir, $WEHEWEHE_Version, $wp_version, $WEHEWEHE_menu;
	$WEHEWEHE_menu = get_option('WEHEWEHE_menu', $WEHEWEHE_menu);
	if (isset($_POST['WEHEWEHE_menu_group']) && is_numeric($_POST['WEHEWEHE_menu_group']) && $_POST['WEHEWEHE_menu_group'] != $WEHEWEHE_menu['group']) {
		$WEHEWEHE_menu['group'] = $_POST['WEHEWEHE_menu_group'];
		update_option('WEHEWEHE_menu_group', $WEHEWEHE_menu['group']);
	}
	$Full_plugin_logo_URL = WEHEWEHE_images_path.'WEHEWEHE-16x16.gif';
	$base_page = $WEHEWEHE_plugin_dir.'-settings';
	if ($WEHEWEHE_menu['group'] == 2)
		add_submenu_page('options-general.php', __('WEHEWEHE Settings and Stats'), __('WEHEWEHE'), 'administrator', $base_page, $WEHEWEHE_plugin_dir.'_settings');
	elseif (!function_exists('add_object_page') || $WEHEWEHE_menu['group'] == 1)
		add_menu_page(__('WEHEWEHE Settings and Stats'), __('WEHEWEHE'), 'administrator', $base_page, $WEHEWEHE_plugin_dir.'_settings', $Full_plugin_logo_URL);
	else
		add_object_page(__('WEHEWEHE Settings and Stats'), __('WEHEWEHE'), 'administrator', $base_page, $WEHEWEHE_plugin_dir.'_settings', $Full_plugin_logo_URL);
}

function WEHEWEHE_init() {
	global $WEHEWEHE_plugin_dir, $WEHEWEHE_REFERER_Parts, $WEHEWEHE_source_array, $WEHEWEHE_settings_array;
	$YourTZ=get_option('timezone_string').'';
	if (function_exists('date_default_timezone_set') && strlen($YourTZ) > 0)
		date_default_timezone_set($YourTZ);
	$WEHEWEHE_source_array = array('wehewehe.org'=>'http://wehewehe.org/gsdl2.85/cgi-bin/hdict?a=q&q=', 'hilo.hawaii.edu'=>'http://hilo.hawaii.edu/wehe.php?q=');
	$WEHEWEHE_settings_array = get_option($WEHEWEHE_plugin_dir.'_settings_array');
	if (!isset($WEHEWEHE_settings_array['bgcolor']))
		$WEHEWEHE_settings_array['bgcolor'] = '#b5a894';
}
class WEHEWEHE_Widget_Class extends WP_Widget {
	function WEHEWEHE_Widget_Class() {
		global $WEHEWEHE_plugin_dir;
		$this->WP_Widget($WEHEWEHE_plugin_dir.'-Widget', __('WEHEWEHE'), array('classname' => 'widget_'.$WEHEWEHE_plugin_dir, 'description' => __('Translate words from Hawaiian to English or English to Hawaiian')));
		$this->alt_option_name = 'widget_'.$WEHEWEHE_plugin_dir;
	}
	function widget($args, $instance) {
		global $WEHEWEHE_plugin_dir, $WEHEWEHE_source_array, $WEHEWEHE_settings_array;
		extract($args);
		$widget_pre = str_replace('-','_',$widget_id);
		$widgeForm = '<div style="background-color: '.$WEHEWEHE_settings_array['bgcolor'].'; -webkit-border-radius: 3px; border-radius: 3px; -moz-border-radius: 3px;" id="'.$WEHEWEHE_plugin_dir.'_div" name="'.$WEHEWEHE_plugin_dir.'_div"><form method="post" target="'.$widget_pre.'_iframe" action="/wp-content/plugins/wehewehe/images/index.php" name="'.$widget_pre.'_form" id="'.$widget_pre.'_form">';//x action="'.WEHEWEHE_images_path.'index.php" 
		if ($instance['title'])
			$show_title = $before_title.$instance["title"].$after_title;
		else
			$show_title = "";
		if (!$instance['display_buttons'])
			$instance['display_buttons'] = "yes";
		if (isset($instance['display_buttons']) && $instance['display_buttons'] == "yes") {
//			$haw_chars = array('a'=>'228','e'=>'235','i'=>'239','o'=>'246','u'=>'252','okina'=>'39');
			$haw_chars = array('a'=>'257','e'=>'275','i'=>'299','o'=>'333','u'=>'363','okina'=>'699');
			$widgeForm .= '<input type="hidden" value="';
			foreach ($haw_chars as $char=>$code)
				$widgeForm .= '\' with kahako" /><img style="float: left; margin: 3px; -webkit-border-radius: 3px; border-radius: 3px; -moz-border-radius: 3px; border: 0px; box-shadow: 2px 2px 2px #000000; -moz-box-shadow: 2px 2px 2px #000000; -webkit-box-shadow: 2px 2px 2px #000000;" border="0" id="'.$WEHEWEHE_plugin_dir.$char.'_button" alt="'.$char.'" src="'.WEHEWEHE_images_path.$char.'.gif" onclick="document.'.$widget_pre.'_form.olelo_q.value += String.fromCharCode('.$code.');document.'.$widget_pre.'_form.olelo_q.focus();" title="insert letter \''.$char;
			$widgeForm .= '" />';
		}
		$widgeForm .= '<div style="float: left; width: 100%; margin: 0; padding: 0;"><input style="float: right; background-color: #8c7b6b; color: #ffffff; width: 60px; height: 22px; padding: 0; margin: 3px 6px; -webkit-border-radius: 3px; border-radius: 3px; -moz-border-radius: 3px; border: 0px; box-shadow: 2px 2px 2px #000000; -moz-box-shadow: 2px 2px 2px #000000; -webkit-box-shadow: 2px 2px 2px #000000;" type="submit" value="e huli" /><div style="margin: 0 80px 0 0;"><input style="line-height: 14px; vertical-align: middle; width: 100%; height: 16px; margin: 3px; padding: 2px; box-shadow: 2px 2px 2px #000000; -moz-box-shadow: 2px 2px 2px #000000; -webkit-box-shadow: 2px 2px 2px #000000;" id="'.$WEHEWEHE_plugin_dir.'_buttons" value="'.$_POST['olelo_q'].'" name="olelo_q" type="text" /></div></div><iframe style="margin: 4px 0 0 0; border: none; width: 100%; height: 150px;" src="'.WEHEWEHE_images_path.'index.php?get_url=ieonly.com/olelo.php" id="'.$widget_pre.'_iframe" name="'.$widget_pre.'_iframe"></iframe>
<script type="text/javascript">
var getFFVersion=navigator.userAgent.substring(navigator.userAgent.indexOf("Firefox")).split("/")[1];
var FFextraHeight=parseFloat(getFFVersion)>=0.1? 16 : 0 //extra height in px to add to iframe in FireFox 1.0+ browsers;
function '.$widget_pre.'_onLoad() {
	'.$widget_pre.'_resizeIframe("'.$widget_pre.'_iframe");
}
function '.$widget_pre.'_resizeIframe(frameid) {
	var ifr=document.getElementById(frameid);
	if (ifr && !window.opera) {
		ifr.style.height = "50px";
		if (ifr.contentDocument && ifr.contentDocument.body.offsetHeight) //ns6
			ifr.style.height = (ifr.contentDocument.body.offsetHeight+FFextraHeight)+"px";
		else if (ifr.Document && ifr.Document.body.scrollHeight) //ie5+
			ifr.style.height = (ifr.Document.body.scrollHeight)+"px";
		else
			ifr.style.height = "150px";
		if (ifr.addEventListener)
			ifr.addEventListener("load", '.$widget_pre.'_readjustIframe, false);
		else if (ifr.attachEvent) {
			ifr.detachEvent("onload", '.$widget_pre.'_readjustIframe);
			ifr.attachEvent("onload", '.$widget_pre.'_readjustIframe);
		}
	}
}
function '.$widget_pre.'_readjustIframe(e) {
	var evnt=(window.event)? event : e;
	var ifr=(evnt.currentTarget)? evnt.currentTarget : evnt.srcElement;
	if (ifr)
		'.$widget_pre.'_resizeIframe(ifr.id);
}
if (window.addEventListener)
	window.addEventListener("load", '.$widget_pre.'_onLoad, false);
else if (window.attachEvent)
	window.attachEvent("onload", '.$widget_pre.'_onLoad);
else
	window.onload='.$widget_pre.'_onLoad;
</script>';
		if (strlen($widgeForm) > 0)
			echo $before_widget.$show_title."\n".$widgeForm."</form></div>\n".$after_widget;
	}
	function flush_widget_cache() {
		global $WEHEWEHE_plugin_dir;
		wp_cache_delete('widget_'.$WEHEWEHE_plugin_dir, 'widget');
	}
	function update($new, $old) {
		$instance = $old;
		$instance['title'] = strip_tags($new['title']);
		$instance['display_buttons'] = strip_tags($new['display_buttons']);
		return $instance;
	}
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$display_buttons = isset($instance['display_buttons']) ? esc_attr($instance['display_buttons']) : 'yes';
		echo '<p><label for="'.$this->get_field_id('title').'">'.__('Widget Title').':</label>
		<input type="text" name="'.$this->get_field_name('title').'" id="'.$this->get_field_id('title').'" value="'.$title.'" /></p>
		<p><input type="checkbox" name="'.$this->get_field_name('display_buttons').'" id="'.$this->get_field_id('display_buttons').'" value="yes"'.($display_buttons=="yes"?" checked":"").' /><label for="'.$this->get_field_id('display_buttons').'">'.__('Show non-english letter buttons').'</label>
		</p>';
	}
}

$encode .= 'e';
function WEHEWEHE_set_plugin_action_links($links_array, $plugin_file) {
	if ($plugin_file == substr(__file__, (-1 * strlen($plugin_file))) && strlen($plugin_file) > 10)	
		$links_array = array_merge(array('<a href="admin.php?page=WEHEWEHE-settings">'.__( 'Settings' ).'</a>'), $links_array);
	return $links_array;
}

function WEHEWEHE_set_plugin_row_meta($links_array, $plugin_file) {
	if ($plugin_file == substr(__file__, (-1 * strlen($plugin_file))) && strlen($plugin_file) > 10)
		$links_array = array_merge($links_array, array('<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8VWNB5QEJ55TJ">'.__( 'Donate' ).'</a>'));
	return $links_array;
}

add_filter('plugin_row_meta', $WEHEWEHE_plugin_dir.'_set_plugin_row_meta', 1, 2);
add_filter('plugin_action_links', $WEHEWEHE_plugin_dir.'_set_plugin_action_links', 1, 2);
define("WEHEWEHE_images_path", plugins_url('/images/', __FILE__));
$WEHEWEHE_source_array=array();
$WEHEWEHE_settings_array=array();
define("WEHEWEHE_updated_images_path", 'wp-content/plugins/update/images/');
register_activation_hook(__FILE__,$WEHEWEHE_plugin_dir.'_install');
add_action('widgets_init', create_function('', 'return register_widget("WEHEWEHE_Widget_Class");'));
add_action('init', $WEHEWEHE_plugin_dir.'_init');
add_action('admin_menu', $WEHEWEHE_plugin_dir.'_menu');