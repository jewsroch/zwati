<?php
add_action( 'admin_notices' , 'user_new_gallery_validation' );

function display_flicker_set_new_gallery() {
	$fsg_options = get_option( 'fsg_options' );
	//check for settings
	$is_ready = ( $fsg_options['flickr_id'] AND $fsg_options['flickr_api_key'] )? true : false;
	$save_value = __( 'Save Changes' );
	$icon_big_path = plugin_dir_url(__FILE__).'icon_big.png';
	/*get lists of user photosets from Flickr
	*var set_list is an array [0] = error message of false if no error
	*			   [1] = Flickr response as object
	*/			   
	$set_list = ( $is_ready ) ? get_photosets() : false;
	//builds gallery creation form
	$page_html = <<<EOD
<div class="wrap">
<div id="fsg_header"><img src="$icon_big_path" width="32" height="32" alt="Flick set slideshows icon" /><h2>Create a new Flickr set slideshow</h2></div>
<div id="fsg_body">
EOD;
	if ( ! $is_ready ) {
	    //the user has not registered settings yet
	    $page_html .= '<p>Please setup a link with your Flickr account first here: <a href="'.site_url('wp-admin/options-general.php?page=flickr_set_galleries_options').'">Flickr set slideshows settings</a></p>';
	} else {
	    if ( $set_list[0] ) {
		//error message
		$page_html .= '<p>'.$set_list[0].'</p>';
	    } else {
		//no error
		$set_options = get_options_html( $set_list[1] );
		//from action url
		$link = site_url().'/wp-admin/admin.php?page=flickr_set_galleries_new';
		$page_html .= <<<EOD
<form method="post" action="$link">
<input type="hidden" name="flickr_id" value="$fsg_options[flickr_id]" />
EOD;
		$page_html .= wp_nonce_field( 'submit_new_gallery' , 'new_gallery_nonce' );
		$page_html .= <<<EOD
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><label for="photoset">Choose a Flickr photo set:</label></th>
<td>$set_options</td>
</tr>
<tr valign="top">
<th scope="row"><label for="size">Choose a size for your slideshow:</label></th>
<td><select name="size">
<option value="">--Select size--</option>
<option value="sm">Small (400x300)</option>
<option value="me">Medium (500x375)</option>
<option value="la">Large (700x525)</option>
<option value="su">Super-sized (800x600)</option></td>
</select>
</tr>
</tbody>
</table>
<p class="submit">
<input type="submit" id="new-gallery-submit" class="button-primary" value="$save_value" />
</p>
</form>
EOD;
	    }
	}
        $page_html.= <<<EOD
<div id="fsg-preview-wrap">
<div id="fsg-preview-title"></div>
<div id="fsg-new-preview"></div>
</div>
</div>
</div>
EOD;
	echo $page_html;

}

function get_photosets(){
    /*gets user's list of Flickr photosets
    *returns array [0] = error response or false if went OK
    *		    [1] = Flickr response as object
    */
    $fsg_options = get_option( 'fsg_options' );
    $result = array();
    $url =  'http://api.flickr.com/services/rest/?';
    $params = array(
		    'method' => 'flickr.photosets.getList' ,
		    'api_key' => $fsg_options['flickr_api_key'] ,
		    'user_id' => $fsg_options['flickr_id'] ,
		    'format' => 'json' ,
		    'nojsoncallback' => 1
		    );
    $query = '';
    foreach ( $params as $key => $v ) {
	$query .= urlencode( $key ).'='.urlencode( $v ).'&';
    }
    $query = substr( $query , 0 , -1 );
    $request_url = $url.$query;
    //$response = json_decode( file_get_contents( $request_url ) );
    $response = wp_remote_get( $request_url );
    $response = json_decode( $response[ 'body' ] );
    if ( $response->stat == 'fail' ) {
	switch ( $response->code ) {
	    case 1:
		$result[0] = 'User not found. Please try again later or check your flickr username in the settings.';
	    break;
	    case 100:
		$result[0] = 'Ivalid API key. Please check your API key in the settings.';
	    break;
	    case 105:
		$result[0] = 'The Flickr request service is currently unavailable. Please try again later.';
	    break;
	    default:
		 $result[0] = 'An error occurred. Please get in touch with Marie (marie@majweb.co.uk) quoting error '.$response->code; 
	}
    } else {
	$result[0] = false;
        $result[1] = $response;
    }
    return $result;
}

function get_options_html( $set_array ) {
    //creates HTML select form element with Flickr photosets
    $html = '';
    if ( ! empty ( $set_array->photosets->photoset ) ) {
	$html .= '<select name="photoset"><option value="">--Select photoset--</option>';
	foreach ( $set_array->photosets->photoset as $photoset ) {
	    $html .= '<option value="'.$photoset->id.'">'.ucfirst( $photoset->title->_content ).'</option>';
	}//en of foreach
	$html .= '</select>';
    } else {
	$html .= '<span>You haven\'t created any set yet. Remind me <a target="_blank" href="http://www.ehow.com/how_4450827_create-photo-set-flickr.html">how to create a set</a> again?</span>';
    }
    return $html;
}

function user_new_gallery_validation(){
    //process request for new gallery
    global $parent_file;
    global $wpdb;
    $flickr_sizes = array( 'sm' , 'me' , 'la' , 'su' );
    if ( $parent_file == 'flickr_set_galleries_manager' && $_GET['page'] == 'flickr_set_galleries_new' ) {
	if ( ! empty( $_POST ) && check_admin_referer( 'submit_new_gallery' , 'new_gallery_nonce' ) ) {
	    //check referrer and nonce
	    //validate
	    if ( ! ( is_numeric( $_POST['photoset'] ) AND $_POST['photoset']!== 0 AND in_array( $_POST['size'] , $flickr_sizes ) ) ) {
		echo '<div id="message" class="error fade"><p><strong>Sorry, something\'s wrong with your input...</strong></p></div>';
		return;
	    }
	    //deal with input
	    //get set name from id
	    $fsg_options = get_option( 'fsg_options' );
	    $url =  'http://api.flickr.com/services/rest/?';
	    $params = array(
			    'method' => 'flickr.photosets.getInfo' ,
			    'api_key' => $fsg_options['flickr_api_key'] ,
			    'photoset_id' => $_POST['photoset'] ,
			    'format' => 'json' ,
			    'nojsoncallback' => 1
		    );
	    $query = '';
	    foreach ( $params as $key => $v ) {
		    $query .= urlencode( $key ).'='.urlencode( $v ).'&';
	    }
	    $query = substr( $query , 0 , -1 );
	    $request_url = $url.$query;
	    //$response = json_decode( file_get_contents( $request_url ) );
	    $response = wp_remote_get( $request_url ) ;
	    $response = json_decode( $response[ 'body' ] );
	    if ( $response->stat == 'fail' ) {
		switch ( $response->code ) {
		    case 1:
		        echo '<div id="message" class="error fade"><p><strong>Sorry, your photoset was not found, which doesn\'t make sense. Please try again later.</strong></p></div>';
		    break;
		    case 105:
		        echo '<div id="message" class="error fade"><p><strong>Sorry, the Flickr request service is not available right now. Please try again later.</strong></p></div>';
		    break;
		    default:
		        echo '<div id="message" class="error fade"><p><strong>Sorry, something\'s wrong. Please tell Marie (marie@majweb.co.uk) quoting error: '.$response->code.'</strong></p></div>';
		    }
		    return;
		}
		$gal_name = $response->photoset->title->_content;
		$data = array(
			      'set_name' => $gal_name ,
			      'set_id' => $_POST['photoset'] ,
			      'size_code' => $_POST['size']
			      );
	    //save data to DB
	    if ( ! $wpdb->insert( $wpdb->prefix.'fsg_galleries' , $data ) ) {
		echo '<div id="message" class="error fade"><p><strong>Couldn\'t save the slideshow in the database.</strong></p></div>';
	    }
	    //get id of new gallery
	    $gallery_id = $wpdb->insert_id;
	    //feedback to user
	    echo '<div id="message" class="updated"><p style="text-align:center;">Your new slideshow <strong>\''.$gal_name.'\'</strong> has been created, <strong>copy and paste the following shortcode</strong> to insert it in your posts or pages:</p>
	    <p style="text-align:center;"><input type="text" readonly="readonly" value="[fsg_gallery id=&#34;'.$gallery_id.'&#34;]" /></p>
	    <p style="text-align:center;">You can find this information later again in your <a href="'.site_url().'/wp-admin/admin.php?page=flickr_set_galleries_manager">slideshow listing</a>.</p>
	    </div>';
	}
    }
}

?>