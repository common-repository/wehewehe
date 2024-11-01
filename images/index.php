<?php
function get_file_contents_from_web($web_source) {
	$ReadFile = '';
	if (function_exists('curl_init')) {
		if (isset($_SERVER['HTTP_REFERER']))
			$SERVER_HTTP_REFERER = $_SERVER['HTTP_REFERER'];
		elseif (isset($_SERVER['HTTP_HOST']))
			$SERVER_HTTP_REFERER = 'HOST://'.$_SERVER['HTTP_HOST'];
		elseif (isset($_SERVER['SERVER_NAME']))
			$SERVER_HTTP_REFERER = 'NAME://'.$_SERVER['SERVER_NAME'];
		elseif (isset($_SERVER['SERVER_ADDR']))
			$SERVER_HTTP_REFERER = 'ADDR://'.$_SERVER['SERVER_ADDR'];
		else
			$SERVER_HTTP_REFERER = 'NULL://not.anything.com';
		$curl_hndl = curl_init();
		curl_setopt($curl_hndl, CURLOPT_URL, $web_source);
		curl_setopt($curl_hndl, CURLOPT_TIMEOUT, 30);
	    curl_setopt($curl_hndl, CURLOPT_REFERER, $SERVER_HTTP_REFERER);
	    if (isset($_SERVER['HTTP_USER_AGENT']))
	    	curl_setopt($curl_hndl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($curl_hndl, CURLOPT_HEADER, 0);
		curl_setopt($curl_hndl, CURLOPT_RETURNTRANSFER, TRUE);
		$ReadFile = curl_exec($curl_hndl);
		curl_close($curl_hndl);
	} else echo ("else");
	if ((strlen($ReadFile) == 0) && function_exists('file_get_contents'))
		$ReadFile = @file_get_contents($web_source).'';
	if (strlen($ReadFile) > 0) {
		$ReadFile = str_replace(' width="800"', '', $ReadFile);
		$table_array = array('<table class="results"','<table class="text6"','<div id="footer" class="footer"');
		if (strpos($ReadFile, $table_array[0])) {
			$temp_array = explode($table_array[0], $table_array[0].$ReadFile);
			$ReadFile = $temp_array[count($temp_array) - 1];
			$temp_array = explode($table_array[1], $ReadFile.$table_array[1]);
			$temp_array = explode($table_array[2], $temp_array[0].$table_array[2]);
			$ReadFile = '<style>.results {background-color: #cccccc;}</style><table class="results" border=1 cellspacing=0 style="width: 100%; height: 100%;"'.$temp_array[0];//.'</table>';
		}
	}
	return $ReadFile;
}
$img_src = 'WEHEWEHE-16x16.gif';
import_request_variables("gP", "img_");
if (isset($_POST['olelo_q'])) {
	$conf_path = 'wp-load.php';
	while (!file_exists($conf_path) && strlen($conf_path) < 30)
		$conf_path = '../'.$conf_path;
	if (file_exists($conf_path))
		include($conf_path);
//	$WEHEWEHE_settings_array = get_option('WEHEWEHE_settings_array');
	if (isset($WEHEWEHE_source_array) && is_array($WEHEWEHE_source_array)) {
		if (isset($WEHEWEHE_settings_array) && is_array($WEHEWEHE_settings_array) && isset($WEHEWEHE_settings_array['web_source']) && isset($WEHEWEHE_source_array[$WEHEWEHE_settings_array['web_source']])) {
			$_GET_URL = $WEHEWEHE_settings_array['web_source'];
		} else {
			$WEHEWEHE_source_keys = array_keys($WEHEWEHE_source_array);
			$_GET_URL = print_r($WEHEWEHE_settings_array, true).$WEHEWEHE_source_keys[0];
		}
		$web_source = $WEHEWEHE_source_array[$_GET_URL].str_replace('%27', 'ʻ', urlencode(str_replace("\\", '', $_POST['olelo_q'])));
		$mt = microtime(true);
		$ReadFile = get_file_contents_from_web($web_source);
		$sec = microtime(true) - $mt;
		if (strlen($ReadFile) > 0) {
			$ReadFile = str_replace('?', '&', $ReadFile);
			//$WEHEWEHE_settings_array['save_stats'] = "yes";
			$ReadFile = str_replace('href="', 'url="'.$web_source.'" href="index.php?get_url='.urlencode($_GET_URL).'/', $ReadFile);
			echo str_replace('found for <b>'.$_POST['olelo_q'].'</b>. To select an entry, click it', 'for <b><i>'.$_POST['olelo_q'].'</i></b> returned in '.substr($sec, 0, 4).' seconds. Click an entry to view it', $ReadFile);
		} else
			echo 'No Function to Fetch Results!<br />The server must have file_get_contents or cURL installed for this plugin to work.';
	} else
		echo 'No Sources Found!';
} elseif (isset($_GET['get_url'])) {
	$web_source = 'http://'.$_GET['get_url'].'?'.str_replace('get_url='.$_GET['get_url'].'&', '', $_SERVER['QUERY_STRING']);
//		echo ("test7:$web_source");
	$ReadFile = get_file_contents_from_web($web_source);
//		echo ("<textarea>".($ReadFile)."</textarea>");
	if ($ReadFile == '') $ReadFile = 'Could not connect to <a href="'.$web_source.'" target="_blank">'.$_GET['get_url'].'</a>';
	echo $ReadFile;//'get_url='.$_GET['get_url'].'<li>other gets:'.print_r($_GET, true);
} elseif (file_exists($img_src)) {
	$imageInfo = getimagesize($img_src);
	header("Content-type: ".$imageInfo['mime']);
	$img = @imagecreatefromgif($img_src);
	imagegif($img);
	imagedestroy($img);
} else echo $img_src.' not found!';
?>
