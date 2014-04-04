<?php
add_action( 'admin_notices' , 'user_change_del_gallery_validation' );
add_action( 'wp_ajax_admin_del_fsg' , 'admin_del_fsg' );
add_action( 'wp_ajax_admin_edit_fsg' , 'admin_edit_fsg' );

function display_flicker_set_galleries() {
	$save_value = __( 'Save Changes' );
	$icon_big_path = plugin_dir_url(__FILE__).'icon_big.png';
	$galleries = get_galleries();
	$listing = '';
	if( ! empty( $galleries ) ) {
	    $listing .= make_gallery_table( $galleries );
	} else {
	    $listing .= '<p style="text-align:center;">There are no slideshows right now. Create slideshows from <a href="'.site_url().'/wp-admin/admin.php?page=flickr_set_galleries_new">Flick Set gallery &#62; Add new page</a>.</p>';
	} 
	$page_html = <<<EOD
<div class="wrap">
<div id="fsg_header"><img src="$icon_big_path" width="32" height="32" alt="Flick set slideshows icon" /><h2>Your Flickr set slideshows</h2></div>
<div id="fsg_body">
$listing
</div>
</div>
EOD;
	echo $page_html;
}


function make_gallery_table( $gal_array )  {
    $html = '<table id="fsgListing" class="widefat"><thead><tr><th scope="col">ID</th><th scope="col">Photoset</th><th class="size" scope="col">Size</th>
    <th scope="col">Shortcode</th><th scope="col"></th><th scope="col"></th></tr></thead><tbody id="the-list">';
    foreach ( $gal_array as $gal ) {
	$size = '';
	switch ( $gal->size_code ) {
	    case 'sm':
		$size = 'Small (400x300)';
	    break;
	    case 'me':
		$size = 'Medium (500x375)';
	    break;
	    case 'la':
		$size = 'Large (700x525)';
	    break;
	    case 'su':
		$size = 'Super-sized (800x600)';
	    break;
	}
	//preview gallery
	$gal_html = make_gallery_html( $gal->fsg_id );
	//delete gallery URL
	$del_url = wp_nonce_url( site_url().'/wp-admin/admin.php?page=flickr_set_galleries_manager&fsg_action=delete&fsg_gal_id='.$gal->fsg_id , 'delete_fsg_gallery' );
	//change size table cell
	$edit_url = wp_nonce_url( site_url().'/wp-admin/admin.php?page=flickr_set_galleries_manager&fsg_action=edit&fsg_gal_id='.$gal->fsg_id , 'edit_fsg_gallery' );
	$edit_td = $size.'<br /><span class="fsg_edit"><a class="editFsgLink" href="'.$edit_url.'">change size</a></span>';
	if ( isset ( $_GET['fsg_action'] ) && isset ( $_GET['fsg_gal_id'] ) ) {
	    if ( $_GET['fsg_action'] == 'edit' && $_GET['fsg_gal_id'] == $gal->fsg_id ) {
		$link = site_url().'/wp-admin/admin.php?page=flickr_set_galleries_manager';
		$edit_td = '<form action="'.$link.'" method="post">
			    <select name="size">
			    <option value="">--Select size--</option>
			    <option value="sm">Small (400x300)</option>
			    <option value="me">Medium (500x375)</option>
			    <option value="la">Large (700x525)</option>
			    <option value="su">Super-sized (800x600)</option>
			    </select></td>
			    <input type="hidden" name="gal_id" value="'.$gal->fsg_id.'" />
			    <p class="submit">
				<input type="submit" name="new_fsg_size" id="new-size-submit" class="button-primary" value="OK" />
			    </p>
			    </form>';
	    }
	}
	$html .= '<tr>
		    <td>'.$gal->fsg_id.'</td>
		    <td>'.ucfirst($gal->set_name).'</td>
		    <td class="size" id="fsgEdit'.$gal->fsg_id.'">'.$edit_td.'</td>
		    <td><input type="text" readonly="readonly" value="[fsg_gallery id=&#34;'.$gal->fsg_id.'&#34;]" /></td>
		    <td><a class="fsg-preview-link" id="'.$gal->fsg_id.'" href="#">Preview</a></td>
		    <td><a class="fsgDelete" id="fsgDel'.$gal->fsg_id.'" href="'.$del_url.'">delete</a></td>
		</tr>
		<tr id="fsg-'.$gal->fsg_id.'" class="fsg-preview">
		    <td colspan="6"><span class="fsg-close"><a href="#">Close</a></span><p style="text-align:center;">'.$gal_html.'</p></td>
		</tr>';
    }
    $html .= '</tbody></table>';
    return $html;
}

function user_change_del_gallery_validation() {

	if ( isset( $_REQUEST[ 'fsg_action' ] ) ) {
		//treats del and change size requests (if JS disabled)
		if ( $_REQUEST['fsg_action'] == 'delete' && ! wp_verify_nonce( $_REQUEST['_wpnonce'] , 'delete_fsg_gallery' ) && $_REQUEST['fsg_gal_id'] ) {
			//check delete action nonce
			echo '<div id="message" class="error fade"><p><strong>Request not valid.</strong></p></div>';
			return;
		}
		if ( $_REQUEST['fsg_action'] == 'edit' && ! wp_verify_nonce( $_REQUEST['_wpnonce'] , 'edit_fsg_gallery' ) && $_REQUEST['fsg_gal_id'] ) {
			//check delete action nonce
			echo '<div id="message" class="error fade"><p><strong>Request not valid.</strong></p></div>';
			return;
		}
		//check gallery exists
		if ( $_REQUEST['fsg_action'] == 'delete' ) {
			$gal_id = $_REQUEST['fsg_gal_id'];
			if ( ! check_fsg_gallery( $gal_id ) ) {
				echo '<div id="message" class="error fade"><p><strong>Sorry this slideshow doesn\'t seem to exist...</strong></p></div>';
				return;
			}
			if ( ! delete_fsg_gallery( $gal_id ) ) {
				echo '<div id="message" class="error fade"><p><strong>Problem deleting the slideshow</strong></p></div>';
			}else{
				echo '<div id="message" class="updated"><p><strong>Slideshow deleted</strong></p></div>';
			}
		}
		//check gallery exists
		if ( $_REQUEST['fsg_action'] == 'edit' ) {
			$gal_id = $_REQUEST['fsg_gal_id'];
			if ( ! check_fsg_gallery( $gal_id ) ) {
			    echo '<div id="message" class="error fade"><p><strong>Sorry this slideshow doesn\'t seem to exist...</strong></p></div>';
			    return;
			}
		}	
	}
	
	
    //actually registers new size of gallery
    if ( ! empty( $_POST ) && isset( $_POST['new_fsg_size'] ) ) {
	if ( ! isset ( $_POST['size'] ) OR ! isset ( $_POST['gal_id'] ) ) {
	    echo '<div id="message" class="error fade"><p>Sorry, something went wrong...</p></div>';
	    return;
	}
	$gal_id = $_POST['gal_id'];
	$size = $_POST['size'];
	//check not same size
	$gal_details = get_gallery( $gal_id );
	if ( $gal_details->size_code == $size ) { return; }
	if ( ! in_array( $size , array( 'sm' , 'me' , 'la' , 'su' ) ) ) {
	    echo '<div id="message" class="error fade"><p><strong>Sorry this size is not valid...</strong></p></div>';
	    return;
	}
	if ( ! check_fsg_gallery( $gal_id ) ) {
	    echo '<div id="message" class="error fade"><p><strong>Sorry this slideshow doesn\'t seem to exist...</strong></p></div>';
	    return;
	}
	if ( ! edit_fsg_gallery( $size , $gal_id ) ) {
	    echo '<div id="message" class="error fade"><p><strong>Problem updating the slideshow</strong></p></div>';
	} else {
	    echo '<div id="message" class="updated"><p><strong>Slideshow updated</strong></p></div>';
	}
    }
}

function admin_del_fsg(){
    //AJAX called function to remove gallery from DB
    $gal_id = $_REQUEST['gal_id'];
    $response = array( 'success'=>true );
    if ( ! $gal_id ) {
	$response['success'] = false;
	echo json_encode( $response );
	die;
    }
    $deletion = delete_fsg_gallery( $gal_id );
    if ( ! $deletion ) {
	$response['success'] = false;
	echo json_encode( $response );
	die;
    }
    $response['gallery'] = $gal_id;
    echo json_encode( $response );
    die;
}

function admin_edit_fsg(){
    //AJAX called function to update gallery size
    $gal_id = $_REQUEST['gal_id'];
    $gal_size = $_REQUEST['gal_size'];
    $response = array( 'success'=>true );
    $response['gallery'] = $gal_id;
    $response['gal_size'] = $gal_size;
    $gal_details = get_gallery( $gal_id );
    if ( ! $gal_id ) {
	$response['success'] = false;
	$response['gal_size'] = $gal_details->size_code;
	echo json_encode( $response );
	die;
    }
    if ( $gal_details->size_code == $gal_size ) {
	$response['gallery'] = $gal_id;
	$response['gal_size'] = $gal_size;
	echo json_encode( $response );
	die;	
    }
    $update = edit_fsg_gallery( $gal_size , $gal_id );
    if ( ! $update ) {
	$response['success'] = false;
	$response['gal_size'] = $gal_details->size_code;
	echo json_encode( $response );
	die;
    }
    echo json_encode( $response );
    die;
}

?>