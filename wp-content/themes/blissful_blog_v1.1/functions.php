<?php
//  Turn a category ID to a Name
function cat_id_to_name($id) {
	foreach((array)(get_categories()) as $category) {
    	if ($id == $category->cat_ID) { return $category->cat_name; break; }
	}
}

// Add ID and CLASS attributes to the first <ul> occurence in wp_page_menu
function add_menuclass($ulclass) {
return preg_replace('/<ul>/', '<ul class="menu">', $ulclass, 1);
}
add_filter('wp_page_menu','add_menuclass');
add_filter('wp_nav_menu','add_menuclass');

function add_sub_menuclass($ulchildclass) {
return preg_replace('/<ul>/', '<ul class="sub-menu">', $ulchildclass, 1);
}
add_filter('wp_page_menu','add_sub_menuclass');
add_filter('wp_nav_menu','add_sub_menuclass');

//	Include the Custom Header code
define( 'HEADER_IMAGE', '%s/images/logo.png' ); // The default logo located in themes folder
define( 'HEADER_IMAGE_WIDTH', apply_filters( '', 920 ) ); // Width of Logo
define( 'HEADER_IMAGE_HEIGHT', apply_filters( '', 180 ) ); // Height of Logo
define( 'NO_HEADER_TEXT', true );
add_custom_image_header( 'header_style', 'admin_header_style' ); // This Enables the Appearance > Header
function header_style() { ?>
<style type="text/css">
#header #title a {
background: url(<?php header_image(); ?>) no-repeat;
}
</style>
<?php }
// Following Code is for Styling the Admin Side
if ( ! function_exists( 'admin_header_style' ) ) :
function admin_header_style() {
?>
<style type="text/css">
#headimg {
height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}
#headimg h1, #headimg #desc {
display: none;
}
</style>
<?php
}
endif;

// Register Sidebars
if ( function_exists('register_sidebars') )
	register_sidebar(array('name'=>'Sidebar','before_title'=>'<h4>','after_title'=>'</h4>'));
	register_sidebar(array('name'=>'Footer Left','before_title'=>'<h4>','after_title'=>'</h4>'));
	register_sidebar(array('name'=>'Footer Mid','before_title'=>'<h4>','after_title'=>'</h4>'));
	register_sidebar(array('name'=>'Footer Right','before_title'=>'<h4>','after_title'=>'</h4>'));
	register_sidebar(array('name'=>'Sponsor Widget','before_title'=>'<h4>','after_title'=>'</h4>'));
	
//	Load local Gravity Forms styles if the plugin is installed
if(class_exists("RGForms") && !is_admin()){
    wp_enqueue_style("local_gf_styles", get_bloginfo('template_url') . "/includes/organic_gforms.css");
    if(!get_option('rg_gforms_disable_css'))
        update_option('rg_gforms_disable_css', true);
}

// Add custom background
if ( function_exists('add_custom_background') )
	add_custom_background();

// Add navigation support
add_theme_support( 'menus' );

// Ondemand function to generate tinyurl
function getTinyUrl($url) {  
     $tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url);  
     return $tinyurl;  
}

//	Add thumbnail support
if ( function_exists('add_theme_support') )
	add_theme_support('post-thumbnails');
	add_image_size( 'gallery-img', 370, 700, true ); // Portfolio Page Thumbnails
?>