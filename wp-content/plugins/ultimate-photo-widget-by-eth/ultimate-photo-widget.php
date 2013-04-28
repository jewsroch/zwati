<?php
/*
Plugin Name: Ultimate Photo Widget for Flickr, Tumblr, and Pinterest
Plugin URI: http://kylinuntitled.com/ultimate-photo-widget/
Description: The Ultimate Photo Widget for Flickr, Tumblr, and Pinterest is intended to create a means of retrieving photos from various popular sites and displaying them in a stylish and uniform way. The Ulimate Photo Widget is currently capable of retrieving photos from Flickr, Tumblr, and Pinterest and displaying them in three styles styles: vertical, tiles, and slideshow. This lightweight but powerful widget takes advantage of WordPress's built in JQuery scripts to create a sleek presentation that I hope you will like.
Version: 2.0.2.3
Author: Eric Burger
Author URI: http://electrictreehouse.com/

*/

/* ******************** DO NOT edit below this line! ******************** */
/* Prevent direct access to the plugin */
if (!defined('ABSPATH')) {
	exit(__( "Sorry, you are not allowed to access this page directly.", UPWbyETH_DOMAIN ));
}

/* Pre-2.6 compatibility to find directories */
if ( ! defined( 'WP_CONTENT_URL' ) )
	define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );


/* Set constants for plugin */
define( 'UPWbyETH_URL', WP_PLUGIN_URL.'/'. basename(dirname(__FILE__)) . '' );
define( 'UPWbyETH_DIR', WP_PLUGIN_DIR.'/'. basename(dirname(__FILE__)) . '' );
define( 'UPWbyETH_VER', '2.0.2.3' );
define( 'UPWbyETH_DOMAIN', 'Ultimate_Photo_Widget' );
//define( 'UPWbyETH_WP_VERSION_REQ', '3.0' );
define( 'UPWbyETH_FILE_HOOK', 'ultimate_photo_widget' );
define( 'UPWbyETH_ID', 'upw_by_eth' );
//define( 'UPWbyETH_PAGEHOOK', 'settings_page_'.UPWbyETH_FILE_HOOK );
//define( 'UPWbyETH_ERRORIMGURL', UPWbyETH_URL . '/error-img/error.jpg' );

/* ******************** DO NOT edit above this line! ******************** */

add_action('init','uftp_photo_update');

function uftp_photo_update(){

  $current_version = get_option("uftp_photo_version", 1.0);

  if($current_version == 1.0){
    $current_opt = get_option('widget_uftp_photo');
    if($current_opt){
      include_once('gears/old-settings-updater.php'); 
    }
  }else{
    update_option("uftp_photo_version",UPWbyETH_VER);
  }
}

class UFTP_Photo_Widget extends WP_Widget {

	function UFTP_Photo_Widget() {
		$widget_ops = array('classname' => 'widget_uftp', 'description' => __('Add images from Flickr, Tumblr, or Pinterest to your sidebar'));
		$control_ops = array('width' => 550, 'height' => 350);
		$this->WP_Widget('uftp_photo', __('Ultimate Photo Widget'), $widget_ops, $control_ops);
	}
  
	function widget( $args, $options ) {
		extract($args);

		$title = apply_filters( 'widget_title', empty($options['title']) ? '' : $options['title'], $options );
        
    // Set Important Widget Options    
    $uftp_id = $args["widget_id"];
    $uftp_align = $options['align-opt'];
    $uftp_num = $options['num-items'];
    $uftp_reduced_width = apply_filters( 'uftp_photo', is_numeric($options['reduced-width']) ? $options['reduced-width'] : NULL, $options );
    $uftp_disable_by_link = $options['remove-myLink'];
    $uftp_by_link  =  '<div id="'.$uftp_id.'-by-link" class="uftp-by-link"><a href="http://electrictreehouse.com/" style="COLOR:#C0C0C0;text-decoration:none;" title="Widget by ElectricTreeHouse and KylinUntitled">ETH </a>& <a href="http://kylinuntitled.com/" style="COLOR:#C0C0C0;text-decoration:none;" title="Widget by ElectricTreeHouse and KylinUntitled">KU</a></div>'; 
    
    // Only try to display content if successfully retrieved from source.
    $uftp_continue = false;
    // Initiat output
    //$uftp_output = '<!-- '.print_r($options,true).' -->'; // Show settings as comment
    $uftp_safe_output = '';
    $uftp_user_link = '';
    // Get content from source.
    switch ($options['source-opt']) {
			case "flickr":
        $flickr_options = $options['flickr'];
        $uftp_size = $flickr_options['size-opt'];
        include( 'gears/source-flickr.php');
			break;
			case "tumblr":  
        $tumblr_options = $options['tumblr'];   
        $uftp_size = $tumblr_options['size-opt'];        
        include( 'gears/source-tumblr.php');
			break;
			case "pinterest":
        $pinterest_options = $options['pinterest'];   
        $uftp_size = $pinterest_options['size-opt'];
        include( 'gears/source-pinterest.php');
			break;
		}
    
    // If content found, generate output
    if($uftp_continue){  
      switch ($options['style-opt']) {
        case "vertical":
          $vertical_options = $options['vertical']; 
          include( 'gears/display-vertical.php');
        break;
        case "tiles":
          $tiles_options = $options['tiles']; 
          include( 'gears/display-tiles.php');
          include( 'gears/display-safe-output.php');
        break;
        case "slideshow":
          $slideshow_options = $options['slideshow']; 
          include( 'gears/display-slides.php');   
          include( 'gears/display-safe-output.php');          
        break;
        case "gallery":
          include( 'gears/display-gallery.php');
        break;
      }
    }
    // If user does not have necessary extensions 
    // or error occured before content complete, report such...
    else{
      $uftp_output = 'Sorry:<br>'.$uftp_output;
    }
    // These lines display the output.
    echo $before_widget . $before_title . $title . $after_title;
    echo $uftp_output . $uftp_safe_output;
    echo $after_widget;
  }
    
	function update( $newoptions, $oldoptions ) {
    include( 'admin/widget-menu-update.php'); 
    return $options;
	}

	function form( $options ) {
    include( 'admin/widget-menu-form.php'); 
	}
}

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////  Safely Enqueue Scripts  and Register Widget  ////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  // Load Admin JS and CSS
	function uftp_admin_head_script(){ 
    // TODO - CREATE SEPERATE FUNCTIONS TO LOAD ADMIN PAGE AND WIDGET PAGE SCRIPTS
    wp_enqueue_script( 'jquery');
    // Replication Error caused by not loading new version of JS and CSS
    // Fix by always changing version number if changes were made
    // I now believe deregistering will also fix the problem, but have not tested
    wp_deregister_script('uftp_admin_menu');
    wp_register_script('uftp_admin_menu',UPWbyETH_URL.'/js/uftp-admin-menu.js','',UPWbyETH_VER);
    wp_enqueue_script('uftp_admin_menu');
    
    wp_deregister_style('upwbyeth_tabs_ui');     
    wp_register_style('upwbyeth_tabs_ui',UPWbyETH_URL.'/css/upwbyeth_tabs_ui.css','',UPWbyETH_VER);
    // upwbyeth_tabs_ui.css is registered by after options page is created
    
    wp_deregister_style('uftp_admin_css');   
    wp_register_style('uftp_admin_css',UPWbyETH_URL.'/css/admin_style.css','',UPWbyETH_VER);
    wp_enqueue_style('uftp_admin_css');
	}
  add_action('admin_init', 'uftp_admin_head_script'); // admin_init so that it is ready when page loads
  
  // Load Display JS and CSS
  function UPWbyETH_enqueue_display_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script('UPWbyETH_tiles_and_slideshow',UPWbyETH_URL.'/js/upwbyeth_tiles_and_slideshow.js','',UPWbyETH_VER);
    wp_deregister_style('UPWbyETH_widget_css'); // Since I wrote the scripts, deregistering and updating version are redundant in this case
    wp_register_style('UPWbyETH_widget_css',UPWbyETH_URL.'/css/upwbyeth_widget_style.css','',UPWbyETH_VER);
    wp_enqueue_style('UPWbyETH_widget_css');
  }
  add_action('wp_enqueue_scripts', 'UPWbyETH_enqueue_display_scripts');
  
   // Register Widget
	function uftp_widget_register() {register_widget( 'UFTP_Photo_Widget' );}
  add_action('widgets_init','uftp_widget_register');

  
  
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  // Shortcode
  function uftp_short_func( $atts ) {
    extract( shortcode_atts( array(
      'source' => '',
      'uid' => '',
      'size' => '',      
      'type' => 'user',
      'set' => '',
      'tags' => '',
      'custom' => false,
      'specific_board' => NULL,
      'link_style' => '',
      'display_link' => false,
      'style' => 'vertical',
      'num' => '',      
      'shape' => 'rectangle',
      'slideshow_style' => '1',
      'fixed_height' => false,      
      'remove_np' => false,      
      'align' => 'center',      
      'reduced_width' => NULL,
      'disable_link' => false,

    ), $atts ) );

    include( 'gears/handle-shortcode.php');  
    return $uftp_output . $uftp_safe_output;
  }
  add_shortcode( 'ultimate-photo', 'uftp_short_func' );
  
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////     Admin Menu    /////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Create custom plugin settings page
  add_action('admin_menu', 'uftp_photo_menu');

  function uftp_photo_menu() {
    //  Create page in Plugins directory
    $page = add_options_page(__('Ultimate Photo','uftp-photo'), __('Ultimate Photo Widget','uftp-photo'), 'manage_options', 'uftp-photo-settings', 'uftp_photo_settings_page');
     
     add_action( 'admin_print_styles-'.$page, 'my_plugin_admin_styles' );  
  }

   function my_plugin_admin_styles() {
     wp_enqueue_script('jquery-ui-core');
     wp_enqueue_script('jquery-ui-tabs');
     wp_enqueue_style( 'upwbyeth_tabs_ui' );
   }
 
  function uftp_photo_settings_page() {
    // Check that the user has the required capability 
    if (!current_user_can('manage_options')) {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    $donate_button = UPWbyETH_URL.'/img/donate.gif';
    include( 'admin/admin-menu.php');  
  } 


  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  
?>
