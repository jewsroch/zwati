<?php
/*
Plugin Name: Flickr Set Slideshows
Plugin URI: http://majweb.co.uk/services/flickr-set-slideshows-for-wordpress
Description: Lets you easily embed slideshows of your flickr sets in your posts and pages.
Version: 0.5
Author: Marie Manandise, MAJWeb
Author URI: http://majweb.co.uk
License: GPL2
*/


/*  Copyright 2011  Marie Manandise  (email : marie@majweb.co.uk)

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


//include main processing file (actions other than options setting)
include_once ( 'flickr-set-slideshows-functions.php' );
include_once ( 'flickr-set-slideshows-listing.php' );
include_once ( 'flickr-set-slideshows-new.php' );
include_once ( 'flickr-set-slideshows-options.php' );


//setup on plugin activation
register_activation_hook(__FILE__ , 'fsg_install' );
//clear up on plugin deactivation
register_deactivation_hook(__FILE__ , 'fsg_uninstall' );

global $fsg_db_version;
$fsg_db_version = '1.0';

//add fsg_gallery shortcodes
add_shortcode( 'fsg_gallery' , 'fsg_shortcode_renderer' );


function fsg_install(){
    //plugin activation function; creates DB table
    global $wpdb;
    global $fsg_db_version;
    //name of DB table with user-defined prefix
    $table_name = $wpdb->prefix . "fsg_galleries";
    //table creation
    $query = "CREATE TABLE ".$table_name." (
	fsg_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	set_name TEXT NOT NULL,
	set_id TINYTEXT NOT NULL,
	size_code ENUM('sm','me','la','su')
    )";
    require_once ( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $query );
    add_option( "fsg_db_version" , $fsg_db_version );
}

function fsg_uninstall(){
    /*Better to leave everything in place in case the user deactivated by mistake
    * No hook on plugin deletion to do that...
    */
    //clean up options
    //delete_option('fsg_options');
    //delete_option('fsg_db_version');
    //clean up db
    //global $wpdb;
    //1.check table exists
    //$query = 'SELECT COUNT(*) FROM information_schema.tables WHERE table_schema =\''.DB_NAME.'\' AND table_name=\''.$wpdb->prefix.'fsg_galleries\'';
    //$exists = $wpdb->query($query);
    //if($exists){
	//2.drop table
	//$query = 'DROP TABLE '.$wpdb->prefix.'fsg_galleries';
	//$wpdb->query($query);
    //} //end of if table exists
}


//add Flickr set galleries menu pages to admin menu
add_action( 'admin_menu' , 'my_plugin_menu' );
//add css to style admin pages
add_action( 'admin_print_styles' , 'fsg_load_css' );
//add plugin js
add_action( 'admin_print_scripts' , 'fsg_load_js' );


function my_plugin_menu() {
    //adds flickr set galleries menu pages to admin menu
        $icon_path = plugin_dir_url( __FILE__ ).'icon.png';
	//add menu section
	add_menu_page( 'Flickr Set Slideshows' , //page title (browser's tab)
		       'Flickr Set Slideshows' , //name as visible in menu 
		       'edit_posts' ,	      //user capability	
		       'flickr_set_galleries_manager' , //menu slug or 'handle'
		       'display_flicker_set_galleries' , //function that outputs HTML
		       $icon_path );
	//add add_new page
	add_submenu_page( 'flickr_set_galleries_manager' ,//parent page handler
			 'New Flickr Set Slideshow' , //page title (browser's tab)
			 'Add new' , //name as visible in menu 
			 'edit_posts' ,	      //user capability	
			 'flickr_set_galleries_new' , //menu slug or 'handle'
			 'display_flicker_set_new_gallery' //function that outputs HTML
			);
	//add setup page
	add_options_page(
			 'Flickr set slideshows options' , //page title (browser's tab)
			 'Flickr set slideshows' , //name as visible in menu
			 'edit_posts' , // user capability
			 'flickr_set_galleries_options' , //slug or 'handle'
			 'display_flickr_set_galleries_options' //function that outputs the page HTML
			 );
}


function fsg_load_css() {
    global $pagenow;
    if( ! ( ( $pagenow == 'admin.php' AND ( $_GET['page'] == ( 'flickr_set_galleries_manager' OR 'flickr_set_galleries_new' ) ) ) OR ( $pagenow == 'options-general.php' AND $_GET['page'] == 'flickr_set_galleries_options') ) ){
	return;
    }
    //loads admin css file
	$path_to_css = plugin_dir_url(__FILE__).'flickr-set-slideshows.css';
	wp_enqueue_style( 'fsg_admin_style' , $path_to_css );
}

function fsg_load_js(){
    global $pagenow;
    if ( ! ( $pagenow == 'admin.php' AND ( $_GET['page'] == ( 'flickr_set_galleries_manager' OR 'flickr_set_galleries_new' ) ) ) ) {
	return;
    }
    //loads js file
    $path_to_js = plugin_dir_url(__FILE__).'flickr-set-slideshows.js';
    wp_enqueue_script( 'fsg_admin_js' , $path_to_js );
    $data = array(
		  'ajaxUrl' => site_url().'/wp-admin/admin-ajax.php' ,
		  'homeUrl' => site_url()
		  );
    wp_localize_script( 'fsg_admin_js' , 'absolutePaths' , $data );
}

function fsg_shortcode_renderer( $attr , $content ) {
    //get gallery from db
    $html = '';
    $html .= make_gallery_html( $attr['id'] );
    //render
    return $html;
}

?>