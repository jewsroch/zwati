<?php
function get_galleries() {
    ////retrieves all galleries info from DB
    global $wpdb;
    $galleries = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'fsg_galleries ORDER BY fsg_id DESC' , OBJECT );
    return $galleries;
}

function get_gallery( $id ) {
    global $wpdb;
    $result = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'fsg_galleries WHERE fsg_id='.$id , OBJECT );
    return $result;
}

function make_gallery_html( $gal_id ) {
    //creates flickr gallery html object from gallery id
    $html = '';
    global $wpdb;
    $gallery = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'fsg_galleries WHERE fsg_id='.$gal_id , OBJECT );
    if( !$gallery ) {
	return;
    }
    $w = '';
    $h = '';
    switch ( $gallery->size_code ) {
	case 'sm':
	    $w = 400;
	    $h = 300;
	break;
	case 'me':
	    $w = 500;
	    $h = 375;
	break;
	case 'la':
	    $w = 700;
	    $h = 525;
	break;
	case 'su':
	    $w = 800;
	    $h = 600;
	break;
    }
    //get user_id from options
    $fsg_options = get_option( 'fsg_options' );
    $user_id = $fsg_options['flickr_id'];
    //create html
    $html = '<object width="'.$w.'" height="'.$h.'"> <param name="flashvars"value="offsite=true&lang=en-us&page_show_url=%2Fphotos%2F'.$user_id.'%2Fsets%2F'.$gallery->set_id.'%2Fshow%2F&page_show_back_url=%2Fphotos%2F'.$user_id.'%2Fsets%2F'.$gallery->set_id.'%2F&set_id='.$gallery->set_id.'&jump_to="></param><param name="movie" value="http://www.flickr.com/apps/slideshow/show.swf?v=109615"></param><param name="allowFullScreen" value="true"></param><embed type="application/x-shockwave-flash" src="http://www.flickr.com/apps/slideshow/show.swf?v=109615" allowFullScreen="true" flashvars="offsite=true&lang=en-us&page_show_url=%2Fphotos%2F'.$user_id.'%2Fsets%2F'.$gallery->set_id.'%2Fshow%2F&page_show_back_url=%2Fphotos%2F'.$user_id.'%2Fsets%2F'.$gallery->set_id.'%2F&set_id='.$gallery->set_id.'&jump_to=" width="'.$w.'" height="'.$h.'"></embed></object>';
    return $html;
}

function check_fsg_gallery( $id ) {
    //determines whether gallery exists based on id
    global $wpdb;
    $exists = $wpdb->get_var( 'SELECT COUNT(*) FROM '.$wpdb->prefix.'fsg_galleries WHERE fsg_id='.$id );
    return $exists;  
}

function delete_fsg_gallery( $id ) {
    //delete gallery whose id is given
    global $wpdb;
    $result = $wpdb->query('DELETE FROM '.$wpdb->prefix.'fsg_galleries WHERE fsg_id='.$id);
    return $result;
}

function edit_fsg_gallery( $size , $id ) {
    global $wpdb;
    $result = $wpdb->update($wpdb->prefix.'fsg_galleries',array('size_code'=>$size),array('fsg_id'=>$id));
    return $result;
}

?>