<?php
/*
Plugin Name: Embed Facebook Albums
Plugin URI: http://wordpress.org/plugins/embed-facebook/
Description: Lets you embed facebook photo albums in a WordPress post or page.
Author: Sohail Abid
Version: 2.0
Author URI: http://sohailabid.com/
*/

include_once('json.php');
define('SOHAIL_EMBED_FACEBOOK_URL', get_option( 'siteurl' ). '/wp-content/plugins/embed-facebook');

add_action('wp_head', 'sohail_embed_facebook_head');
function sohail_embed_facebook_head()
{
	echo '<script type="text/javascript" src="'.SOHAIL_EMBED_FACEBOOK_URL.'/slidewindow/slidewindow_min.js"></script>' . "\n";
	echo '<script type="text/javascript">currPath = "'.SOHAIL_EMBED_FACEBOOK_URL.'/slidewindow/"; strImgOf="";</script>' . "\n";
}    

add_filter('the_content', 'sohail_embed_facebook');
function sohail_embed_facebook($the_content)
{
	return preg_replace_callback("/<p>(http|https):\/\/www\.facebook\.com\/media\/set\/([^<\s]*)<\/p>/", "sohail_do_embed", $the_content);
}

function sohail_do_embed($query)
{
	$query = explode('=', $query[2]);
	$query = explode('.', $query[1]);
	$album_id = $query[1];

	$album = sohail_get_json('http://graph.facebook.com/'.$album_id);
	$photos = sohail_get_json('http://graph.facebook.com/'.$album_id.'/photos');

	$return  = '<div style="margin-bottom:1em;border:1px solid #C6CEDD;padding:3px;">';
	$return .= '<div style="background:#EDEFF4;padding:10px;margin-bottom:3px;font-weight:bold"><a style="text-decoration:none" href="'.$album->link.'">'.$album->name.'</a></div>';
	$return .= '<div style="line-height:0">';
	foreach($photos->data as $photo)
	{
		$return .= '<a href="'.$photo->source.'" onclick="return showSlideWindow(this, 600, 400);" class="viewable" style="width:33.33333%;height:150px;display:inline-block;background:#eee url('.$photo->source.') center center;background-size:cover"></a>';		
	}
	$return .= '</div>';
	$return .= '</div>';

	return $return;
}

function sohail_get_json($url)
{
	if (function_exists("curl_init"))
		$json = @curl_get_content($url);
	else
		$json = @file_get_contents($url);
	
	if(function_exists("json_decode"))
		return json_decode($json);
	else
		return sohail_json_decode($json);
}

function curl_get_content($url)
{
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, "Firefox (WindowsXP) - Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    ob_start();
    curl_exec ($ch);
    curl_close ($ch);
    $return = ob_get_contents();
    ob_end_clean();
    return $return;    
}

function sohail_json_encode($value) {
	$json = new Services_JSON();
	return $json->encode($value);
}

function sohail_json_decode($value) {
	$json = new Services_JSON();
	return $json->decode($value);
}
