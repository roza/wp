<?php
/*
Plugin Name: Clifton's Lightbox
Plugin URI: http://cliftonhatfield.com
Description: A Wordpress Plugin designed to display a lightbox upon a visitor's first entrance onto your blog. Display a photo, text, and an optin form to build your email list. Find Wordpress Video Tutorials @ <a href="http://cliftonhatfield.com" title="Wordpress Video Tutorials" target="_blank">CliftonHatfield.com</a>.
Author: Clifton Hatfield
Version: 2.3.1
Author URI: http://cliftonhatfield.com

Copyright 2012  Clifton Hatfield

/*  Copyright 2012  Clifton Hatfield  (email : clifton@cliftonhatfield.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*-----------------------------------------------------------------------------------*/
/* TABLE OF CONTENTS
/* 
- load_clp_styles
- admin_load_clp_styles
- load_clp_scripts
- admin_load_clp_scripts
- clp_load_lightbox_html
- clp_init_lightbox
- clp_menu_lightbox
- clp_lightbox_about
- clp_lightbox
- save_lightbox_settings
- clp_delete_cookie
- set_lightbox_cookie
- save_autoresponder
- clp_process_autoresponder
- clp_process_fields
- get_autoresponder
- get_script_src
- get_iframe_src
- clp_settings_saved
- clp_display_msg
- clp_lightbox_preview
- clp_is_mobile
*/
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
// Client side Stylesheets
/*-----------------------------------------------------------------------------------*/
add_action('wp_print_styles', 'load_clp_styles');
function load_clp_styles(){
	$row = get_autoresponder();
	//IS ENABLED?
	if($row['enabled'] == 1)
	{
		wp_register_style('clp_css', plugins_url('styles.min.css', __FILE__));
		wp_enqueue_style('clp_css');
		wp_register_style('clp_colorbox_css', plugins_url('colorbox.css', __FILE__));
		wp_enqueue_style('clp_colorbox_css');
	}
}

/*-----------------------------------------------------------------------------------*/
// Admin Stylesheet
/*-----------------------------------------------------------------------------------*/
add_action('admin_print_styles', 'admin_load_clp_styles');
function admin_load_clp_styles(){
	if($_GET['page'] == 'clp_lightbox')
	{
		wp_register_style('clp_style', plugins_url('styles.min.css', __FILE__));
		wp_enqueue_style('clp_style');
	}
}

/*-----------------------------------------------------------------------------------*/
// Load client side javascript
/*-----------------------------------------------------------------------------------*/
add_action('init', 'load_clp_scripts');
function load_clp_scripts(){
	$row = get_autoresponder();
	if($row['enabled'] == 1)
	{
		wp_register_script('clp_script', plugins_url('js/jquery.colorbox-min.js', __FILE__), array('jquery'));
		wp_enqueue_script('clp_script');
	}
}

/*-----------------------------------------------------------------------------------*/
// Load admin javascript
/*-----------------------------------------------------------------------------------*/
add_action('admin_init', 'admin_load_clp_scripts');
function admin_load_clp_scripts(){
	if($_GET['page'] == 'clp_lightbox')
	{
		wp_register_script('clp_script', plugins_url('js/js.js', __FILE__), array('jquery'));
		wp_register_script('load_clp_admin_js', plugins_url('js/admin.js', __FILE__), array('jquery'));
		wp_enqueue_script('clp_script');
		wp_enqueue_script('load_clp_admin_js');
	}
}

/*-----------------------------------------------------------------------------------*/
// Lightbox HTML
/*-----------------------------------------------------------------------------------*/
add_action('wp_footer', 'clp_load_lightbox_html');
function clp_load_lightbox_html(){
	$row = get_autoresponder();
	//IS ENABLED?
	if($row['enabled'] == 1)
	{
		echo "<div class=\"clp-display-none\">\n";
		include('lightbox.php');
		echo "</div>";
	}
}

/*-----------------------------------------------------------------------------------*/
// Init Colorbox
/*-----------------------------------------------------------------------------------*/
add_action('wp_head', 'clp_init_lightbox');
function clp_init_lightbox(){
	$row = get_autoresponder();
	//IS ENABLED AND NOT ON A MOBILE DEVICE?
	if($row['enabled'] == 1 && !clp_is_mobile())
	{
		if(!isset($_COOKIE['cliftons_lightbox_plugin']))
		{
			if($row['delay'] > 0)
			{
				$delay = $row['delay'] * 1000;
				echo '<script type="text/javascript">
				jQuery(function($){
						setTimeout("jQuery.colorbox({inline:true, href: \'#clp_wrapper\'});", '.$delay.');
				});
				</script>';
				echo "\n";
			}
		}
	}
}

/*-----------------------------------------------------------------------------------*/
// Admin menu
/*-----------------------------------------------------------------------------------*/
add_action('admin_menu', 'clp_menu_lightbox');
function clp_menu_lightbox(){
	add_options_page('Clifton\'s Lightbox Plugin', 'Lightbox', 8, 'clp_lightbox', 'clp_lightbox');
	add_submenu_page('clp_lightbox', 'Settings - Clifton\'s Lightbox Plugin', 'Settings', 8, 'clp_lightbox', 'clp_lightbox');
	add_submenu_page('clp_lightbox', 'About - Clifton\'s Lightbox Plugin', 'About', 8, 'clp_lightbox_about', 'clp_lightbox_about');
}

/*-----------------------------------------------------------------------------------*/
// About page
/*-----------------------------------------------------------------------------------*/
function clp_lightbox_about(){
	include('about.php');
}

/*-----------------------------------------------------------------------------------*/
// Settings page
/*-----------------------------------------------------------------------------------*/
function clp_lightbox()
{
	$row = get_autoresponder();
	$title = htmlentities($row['title']);
	$button = htmlentities($row['button']);
	include('settings.php');
}

/*-----------------------------------------------------------------------------------*/
// Save changes
/*-----------------------------------------------------------------------------------*/
add_action('admin_init', 'save_lightbox_settings');
function save_lightbox_settings(){
	if(isset($_POST['lightbox_submit']))	
	{
		save_autoresponder();
	}
} 

/*-----------------------------------------------------------------------------------*/
// Delete cookie
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_clp_delete_cookie', 'clp_delete_cookie');
function clp_delete_cookie(){
	$url = parse_url(get_option('home'));
	setcookie('cliftons_lightbox_plugin', 1, time()-3600, $url['path'] . '/');
	echo 'You just deleted one delicious cookie! Share with me next time :)';
	die();
}

/*-----------------------------------------------------------------------------------*/
// Set cookie
/*-----------------------------------------------------------------------------------*/
add_action('send_headers', 'set_lightbox_cookie');
function set_lightbox_cookie(){
	if(!isset($_COOKIE['cliftons_lightbox_plugin']))
	{
		$clp = get_autoresponder();
		$url = parse_url(get_option('home'));
		if($clp['cookie_life'] == 'minute')
			setcookie('cliftons_lightbox_plugin', 1, time()+60, $url['path'] . '/');
		elseif($clp['cookie_life'] == 'hour')
			setcookie('cliftons_lightbox_plugin', 1, time()+60*60, $url['path'] . '/');
		elseif($clp['cookie_life'] == 'five_hours')
			setcookie('cliftons_lightbox_plugin', 1, time()+60*300, $url['path'] . '/');
		elseif($clp['cookie_life'] == 'twentyfour_hours')
			setcookie('cliftons_lightbox_plugin', 1, time()+60*60*24, $url['path'] . '/');
		elseif($clp['cookie_life'] == 'thirty_days')
			setcookie('cliftons_lightbox_plugin', 1, time()+60*60*24*30, $url['path'] . '/');
		elseif($clp['cookie_life'] == 'six_months')
			setcookie('cliftons_lightbox_plugin', 1, time()+60*60*24*180, $url['path'] . '/');
		elseif($clp['cookie_life'] == 'until_deleted')
			setcookie('cliftons_lightbox_plugin', 1, time()+60*60*24*365, $url['path'] . '/');
	}
}

/*-----------------------------------------------------------------------------------*/
// Save autoresponder
/*-----------------------------------------------------------------------------------*/
function save_autoresponder(){
	$html = trim(utf8_encode($_POST['autoresponder']));
	$first = substr($html, 0, 7);
	$last = substr($html, -7);
	if($first == '<script' && $last == 'script>')
	{
		$src = get_script_src($html);
		$html = file_get_contents(stripslashes(str_replace('"', '', $src)));
		if(preg_match('/iframe/', $html))
		{
			$src = get_iframe_src($html);
			$html = file_get_contents(stripslashes(str_replace('"', '', $src)));
		}
		else		  
		{
			$search[] = 'document.write(\'';
			$search[] = '\');';
			$search[] = '\\';
			$replace[] = '';
			$file = str_replace($search, $replace, $html);
			$form1 = explode('<form', $file);
			$form2 = explode('</form>', $form1[1]);
			$form = $form2[0];
			$html = '<form'.$form.'</form>';
		}
	}
	
	$doc = new DOMDocument();
	if(!empty($html))
	{
		if(!@$doc->loadHTML($html)){
			//echo 'something went wrong';
		}
		else
		{
			$xpath = new DOMXpath($doc);
			foreach($xpath->query('//form//input') as $eInput)
			{
				$fields[str_replace(array('"', '\''), '', $eInput->getAttribute('name'))] = str_replace(array('"', '\''), '', str_replace('"/', '"', $eInput->getAttribute('value')));
			}
			
			foreach($xpath->query('//form') as $form)
			{
				$clp['form_url'] = str_replace('"', '', $form->getAttribute('action'));
			}
		}
	}
	
	$clp['fields'] = $fields;
	$clp['html'] = trim($_POST['autoresponder']);
	$clp['selected_name'] = $_POST['name_field'];
	$clp['selected_email'] = $_POST['email_field'];
	$clp['enabled'] = (is_numeric($_POST['enabled'])) ? $_POST['enabled'] : 0;
	$clp['title'] = strip_tags(trim($_POST['title']));
	$video = ($_POST['video'] != '') ? end(explode('v=', $_POST['video'])) : '';
	$video = explode('&', $video);
	$clp['video'] = trim($video[0]);
	$clp['image'] = strip_tags(trim($_POST['image']));
	$clp['list'] = $_POST['list'];
	$clp['description'] = trim($_POST['description']);
	$clp['button'] = strip_tags(trim($_POST['button']));
	$clp['privacy'] = strip_tags(trim($_POST['privacy']));
	$clp['delay'] = $_POST['delay'];
	$clp['cookie_life'] = $_POST['cookie_life'];
	$clp['poweredby'] = $_POST['poweredby'];
	update_option('cliftons_lightbox_plugin', $clp);
	clp_settings_saved();
}

/*-----------------------------------------------------------------------------------*/
// Ajax find autoresponder HTML
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_clp_process_autoresponder', 'clp_process_autoresponder');
function clp_process_autoresponder(){
	global $wpdb;
	$html = $_POST['html'];
	$html = trim(utf8_encode($html));
	$first = substr($html, 0, 7);
	$last = substr($html, -7);
	if($first == '<script' && $last == 'script>')
	{
		$src = get_script_src($html);
		$html = file_get_contents(stripslashes(str_replace('"', '', $src)));
		if(preg_match('/iframe/', $html))
		{
			$src = get_iframe_src($html);
			$html = file_get_contents(stripslashes(str_replace('"', '', $src)));
		}
		else		  
		{
			$search[] = 'document.write(\'';
			$search[] = '\');';
			$search[] = '\\';
			$replace[] = '';
			$file = str_replace($search, $replace, $html);
			$form1 = explode('<form', $file);
			$form2 = explode('</form>', $form1[1]);
			$form = $form2[0];
			$html = '<form'.$form.'</form>';
		}
	}
	
	$doc = new DOMDocument();
	if(!empty($html))
	{
		if(!@$doc->loadHTML($html)){
			//echo 'something went wrong';
		}
		else
		{
			$xpath = new DOMXpath($doc);
			foreach($xpath->query('//form//input') as $eInput)
			{
				$fields[str_replace(array('"', '\''), '', $eInput->getAttribute('name'))] = str_replace(array('"', '\''), '', str_replace('"/', '"', $eInput->getAttribute('value')));
			}
		}
	}
	
	$array['html'] = stripslashes($html);
	
	echo json_encode($array);
	
	die();
}

/*-----------------------------------------------------------------------------------*/
// Ajax find name & email fields
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_clp_process_fields', 'clp_process_fields');
function clp_process_fields(){
	global $wpdb;
	$html = $_POST['html'];
	$html = trim(utf8_encode($html));
	$first = substr($html, 0, 7);
	$last = substr($html, -7);
	if($first == '<script' && $last == 'script>')
	{
		$src = get_script_src($html);
		$html = file_get_contents(stripslashes(str_replace('"', '', $src)));
		if(preg_match('/iframe/', $html))
		{
			$src = get_iframe_src($html);
			$html = file_get_contents(stripslashes(str_replace('"', '', $src)));
		}
		else		  
		{
			$search[] = 'document.write(\'';
			$search[] = '\');';
			$search[] = '\\';
			$replace[] = '';
			$file = str_replace($search, $replace, $html);
			$form1 = explode('<form', $file);
			$form2 = explode('</form>', $form1[1]);
			$form = $form2[0];
			$html = '<form'.$form.'</form>';
		}
	}
	
	$doc = new DOMDocument();
	if(!empty($html))
	{
		if(!@$doc->loadHTML($html)){
			//echo 'something went wrong';
		}
		else
		{
			$xpath = new DOMXpath($doc);
			foreach($xpath->query('//form//input') as $eInput)
			{
				$fields[] = str_replace(array('"', '\''), '', $eInput->getAttribute('name'));
			}
		}
	}
	
	foreach($fields as $field)
	{
		if(!empty($field))
			$str .= '<option value="'.stripslashes($field).'">'.stripslashes($field).'</option>';	
	}
	
	echo $str;
	
	die();
}

/*-----------------------------------------------------------------------------------*/
// Get options
/*-----------------------------------------------------------------------------------*/
function get_autoresponder(){
	$array = get_option('cliftons_lightbox_plugin');
	if(!empty($array['fields']))
	{
		foreach($array['fields'] as $key => $value)
		{
			$clp['fields'][stripslashes($key)] = stripslashes($value);	
		}
	}
	$clp['enabled'] = $array['enabled'];
	$clp['form_url'] = stripslashes($array['form_url']);
	$clp['html'] = stripslashes($array['html']);
	$clp['selected_name'] = stripslashes($array['selected_name']);
	$clp['selected_email'] = stripslashes($array['selected_email']);	
	$clp['selected_form_url'] = stripslashes($array['form_url']);
	$clp['title'] = stripslashes($array['title']);
	$clp['description'] = stripslashes($array['description']);
	$clp['video'] = stripslashes($array['video']);
	$clp['video_player'] = '<iframe title="YouTube video player" width="320" height="270" src="http://www.youtube.com/embed/'.$clp['video'].'?rel=0" frameborder="0" allowfullscreen></iframe>';
	$clp['image'] = stripslashes($array['image']);
	$clp['list'] = $array['list'];
	$clp['button'] = stripslashes(trim($array['button']));
	$clp['privacy'] = stripslashes(trim($array['privacy']));
	$clp['delay'] = $array['delay'];
	$clp['cookie_life'] = $array['cookie_life'];
	$clp['poweredby'] = $array['poweredby'];
	return $clp;
}

/*-----------------------------------------------------------------------------------*/
// Get javascript source
/*-----------------------------------------------------------------------------------*/
function get_script_src($html){
	$doc = new DOMDocument();
	if(!empty($html))
	{
		if(!@$doc->loadHTML($html)){
			//echo 'something went wrong';
		}
		else
		{
			$xpath = new DOMXpath($doc);
			foreach($xpath->query('//script') as $eInput)
			{
				$src = $eInput->getAttribute('src');
			}
			return $src;
		}
	}
}

/*-----------------------------------------------------------------------------------*/
// Get iframe source
/*-----------------------------------------------------------------------------------*/
function get_iframe_src($html){
	$doc = new DOMDocument();
	if(!empty($html))
	{
		if(!@$doc->loadHTML($html)){
			//echo 'something went wrong';
		}
		else
		{
			$xpath = new DOMXpath($doc);
			foreach($xpath->query('//iframe') as $eInput)
			{
				$src = $eInput->getAttribute('src');
			}
			return $src;
		}
	}
}

/*-----------------------------------------------------------------------------------*/
// Save message
/*-----------------------------------------------------------------------------------*/
function clp_settings_saved(){
	$_SESSION['clp_msg'] = 'Settings have been saved';	
}

/*-----------------------------------------------------------------------------------*/
// Display message
/*-----------------------------------------------------------------------------------*/
function clp_display_msg(){
	if(!empty($_SESSION['clp_msg']))
	{
		$msg = stripslashes($_SESSION['clp_msg']);
		echo '<div class="updated" id="message"><p>'.$msg.'</p></div>';	
	}
}

/*-----------------------------------------------------------------------------------*/
// Lightbox preview
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_clp_lightbox', 'clp_lightbox_preview');
function clp_lightbox_preview(){
	global $wpdb;
	if($_GET['action'] == 'clp_lightbox')
	{
		$row = get_autoresponder();
		$html .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
		$html .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
		$html .= "<head>
		<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-latest.js\"></script>
		<link rel=\"stylesheet\" id=\"clp_style-css\"  href=\"".plugins_url('styles.min.css', __FILE__)."\" type=\"text/css\" media=\"all\" />
		<link rel=\"stylesheet\" id=\"clp_style-css\"  href=\"".plugins_url('colorbox.css', __FILE__)."\" type=\"text/css\" media=\"all\" />
        <script type=\"text/javascript\" src=\"".plugins_url('js/js.js', __FILE__)."\"></script>
        <script type=\"text/javascript\" src=\"".plugins_url('js/jquery.colorbox-min.js', __FILE__)."\"></script>
		<script type=\"text/javascript\">jQuery(function($){jQuery.colorbox({inline:true, href: '#clp_wrapper'});});</script>		
		</head>\n";
		echo $html;
		echo "\n";
		echo '<body>';
		echo "\n";
		echo "<div style=\"display:none;\">\n";
		include('lightbox.php');
		echo "</div>\n";
		echo "</body>\n";
		echo "</html>\n";
	}
	die();
}

/*-----------------------------------------------------------------------------------*/
// Check if mobile
/*-----------------------------------------------------------------------------------*/
function clp_is_mobile(){
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$mobile_agents = array(
		"240x320",
		"acer",
		"acoon",
		"acs-",
		"abacho",
		"ahong",
		"airness",
		"alcatel",
		"amoi",	
		"android",
		"anywhereyougo.com",
		"applewebkit/525",
		"applewebkit/532",
		"asus",
		"audio",
		"au-mic",
		"avantogo",
		"becker",
		"benq",
		"bilbo",
		"bird",
		"blackberry",
		"blazer",
		"bleu",
		"cdm-",
		"compal",
		"coolpad",
		"danger",
		"dbtel",
		"dopod",
		"elaine",
		"eric",
		"etouch",
		"fly " ,
		"fly_",
		"fly-",
		"go.web",
		"goodaccess",
		"gradiente",
		"grundig",
		"haier",
		"hedy",
		"hitachi",
		"htc",
		"huawei",
		"hutchison",
		"inno",
		"ipad",
		"ipaq",
		"ipod",
		"jbrowser",
		"kddi",
		"kgt",
		"kwc",
		"lenovo",
		"lg ",
		"lg2",
		"lg3",
		"lg4",
		"lg5",
		"lg7",
		"lg8",
		"lg9",
		"lg-",
		"lge-",
		"lge9",
		"longcos",
		"maemo",
		"mercator",
		"meridian",
		"micromax",
		"midp",
		"mini",
		"mitsu",
		"mmm",
		"mmp",
		"mobi",
		"mot-",
		"moto",
		"nec-",
		"netfront",
		"newgen",
		"nexian",
		"nf-browser",
		"nintendo",
		"nitro",
		"nokia",
		"nook",
		"novarra",
		"obigo",
		"palm",
		"panasonic",
		"pantech",
		"philips",
		"phone",
		"pg-",
		"playstation",
		"pocket",
		"pt-",
		"qc-",
		"qtek",
		"rover",
		"sagem",
		"sama",
		"samu",
		"sanyo",
		"samsung",
		"sch-",
		"scooter",
		"sec-",
		"sendo",
		"sgh-",
		"sharp",
		"siemens",
		"sie-",
		"softbank",
		"sony",
		"spice",
		"sprint",
		"spv",
		"symbian",
		"tablet",
		"talkabout",
		"tcl-",
		"teleca",
		"telit",
		"tianyu",
		"tim-",
		"toshiba",
		"tsm",
		"up.browser",
		"utec",
		"utstar",
		"verykool",
		"virgin",
		"vk-",
		"voda",
		"voxtel",
		"vx",
		"wap",
		"wellco",
		"wig browser",
		"wii",
		"windows ce",
		"wireless",
		"xda",
		"xde",
		"zte"
	);

	$is_mobile = false;

	foreach ($mobile_agents as $device){
		if (stristr($user_agent, $device))
		{
			$is_mobile = true;
			break;
		}
	}

	return $is_mobile;
}
?>