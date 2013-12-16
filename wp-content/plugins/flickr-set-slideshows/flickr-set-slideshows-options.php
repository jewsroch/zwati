<?php
//registers plugin options
add_action( 'admin_init' , 'register_fsg_options' );
add_action( 'admin_notices' , 'fsg_validation_notice' );

function display_flickr_set_galleries_options() {
    //display content of 'Setup' page
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}	
	$icon_big_path = plugin_dir_url(__FILE__).'icon_big.png';
	$save_value = __( 'Save Changes' );
	
	$page_html = <<<EOD
<div class="wrap">
<div id="fsg_header"><img src="$icon_big_path" width="32" height="32" alt="Flickr set slideshows icon" /><h2>Flickr set slideshows setup</h2></div>
<div id="fsg_body">
<form method="post" action="options.php">
EOD;
	echo $page_html;
settings_fields( 'fsg_plugin_options' );
do_settings_sections( 'flickr_set_galleries_options' );
	$page_html = <<<EOD
<p class="submit">
<input type="submit" class="button-primary" value="$save_value" />
</p>
</form>
</div>
</div>
EOD;
	echo $page_html;
}


//options registration
function register_fsg_options(){
    //register Flickr set galleries option, i.e. Flicker username
    register_setting( 'fsg_plugin_options' , //options group
		      'fsg_options' , //name of the option (all options are lumped into one array)
		      'fsg_options_validate'
		    );
    add_settings_section( 'fsg_option_main' , //settings section id
			  'Flickr credentials' , //title of the section
			  'flickr_cred_section_text' , //
			  'flickr_set_galleries_options' //options page name
			 );
    add_settings_field( 'flickr_username_field' , //field id
		        'Flickr screen name:' , //options label
		        'flickr_username_field_html' , //function to output HTML
		        'flickr_set_galleries_options' , //options page name
		        'fsg_option_main' //settings section handler
		       );
    add_settings_field( 'flickr_id_field' , //field id
		        '' , //options label
		        'flickr_id_field_html' , //function to output HTML
		        'flickr_set_galleries_options' , //options page name
		        'fsg_option_main' //settings section handler
		       );
    add_settings_field( 'flickr_api_key_field' , //field id
		        'Flickr API key:' , //options label
		        'flickr_api_key_field_html' , //function to output HTML
		        'flickr_set_galleries_options' , //options page name
		        'fsg_option_main' //settings section handler
		       );
    add_settings_field( 'fsg_error_field' , //error code
		        '' , //options label
		        'flickr_error_field_html' , //function to output HTML
		        'flickr_set_galleries_options' , //options page name
		        'fsg_option_main' //settings section handler
		       );
}

function flickr_cred_section_text(){
    echo '<p>Link to your Flickr account.</p>';
}

function flickr_username_field_html(){
    $options = get_option( 'fsg_options' );
    echo "<input id='flickr_username_field' name='fsg_options[username]' size='40' type='text' value='{$options['username']}' />";
}

function flickr_id_field_html(){
    $options = get_option( 'fsg_options' );
    echo "<input id='flickr_id_field' name='fsg_options[flickr_id]' size='40' type='hidden' value='{$options['flickr_id']}' />";
    if ( $options['flickr_id'] ) {
	echo '<p>By the way, your flickr ID is <b>'.$options['flickr_id'].'</b></p>';
    }
}

function flickr_api_key_field_html(){
    $options = get_option( 'fsg_options' );
    echo "<input id='flickr_api_key_field' name='fsg_options[flickr_api_key]' size='40' type='text' value='{$options['flickr_api_key']}' />";
}


function flickr_error_field_html(){
    //
}

function fsg_options_validate( $input ){
    //check username validity
    $input['username'] = trim( $input['username'] );
    $input['flickr_api_key'] = trim( $input['flickr_api_key'] );
    if ( $input['username'] == '' ) {
	//flickr is pretty lenient, just checking it's not empty
	$input['fsg_error'] = 'inv_username';
	$input['username'] = '';
	$input['flickr_api_key'] = '';
	$input['flickr_id'] = '';
	return $input;
    }
    //check API key is valid
    if ( ! ( preg_match( '/^\w+$/' , $input['flickr_api_key'] ) ) ) {
	$input['fsg_error'] = 'inv_api_key';
	$input['flickr_api_key'] = '';
	$input['username'] = '';
	$input['flickr_id'] = '';
	return $input;
    }
    //gets Flickr id
    $url = 'http://api.flickr.com/services/rest/?';
    $params = array(
		    'method' => 'flickr.people.findByUsername' ,
		    'api_key' => $input['flickr_api_key'] ,
		    'username' => $input['username'] ,
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
    $response = json_decode($response[ 'body' ]);
    if ( $response->stat == 'fail' ) {
	switch ( $response->code ) {
	    case 1:
		$input['fsg_error'] = 'not_found';
	    break;
	    case 100:
		$input['fsg_error'] = 'inv_api_key';
	    break;
	    case 105:
		$input['fsg_error'] = 'not_available';
	    break;
	    default:
		 $input['fsg_error'] = $response->code; 
	}
	$input['flickr_id'] = '';
    } else {
        $input['flickr_id'] = $response->user->id;
    }
    return $input;
}


function fsg_validation_notice(){
    //customises error messages
    global $parent_file;
    if ( $parent_file == 'options-general.php' && $_GET['page'] == 'flickr_set_galleries_options' ) {
        $fsg_options = get_option( 'fsg_options' );
	if ( $fsg_options['fsg_error'] ) {
        	switch ( $fsg_options['fsg_error'] ) {
		    case 'inv_username':
			echo '<div id="message" class="error fade"><p><strong>Sorry, this is not a valid Flickr screen name.</strong></p></div>';
		    break;
		    case 'not_found':
			echo '<div id="message" class="error fade"><p><strong>This screen name was not found on flickr. Please check you typed it correctly.</strong></p>
			<p>If you have just created your flickr account, please wait for a while, it might not be fully registered yet.</p>
			<p>Remind me <a href="http://majweb.co.uk/services/flickr-set-slideshows-for-wordpress#FAQ" target="_blank">what a flickr screen name is</a> again?</p></div>';
		    break;
		    case 'inv_api_key':
			echo '<div id="message" class="error fade"><p><strong>This API key is not valid. Please check you typed it correctly.</strong></p>
			<p>Remind me <a href="http://majweb.co.uk/services/flickr-set-slideshows-for-wordpress#FAQ" target="_blank">what a flickr API key is</a> again?</p></div>';
		    break;
		    case 'not_available':
			echo '<div id="message" class="error fade"><p><strong>Sorry,the flickr service is temporarily unavailable. Please try again later.</strong></p></div>';
		    break;
		    case 'coding':
			echo '<div id="message" class="error fade"><p><strong>Oops, something went wrong. Please, get in touch with Marie (marie@majweb.co.uk) and explain the problem, giving the error code: '.$fsg_options['fsg_error'].'.</strong></p></div>';
		    break;
		}//end of switch
		unset ( $_GET['settings-updated'] );
	} //end of if error
    } //end of if right page
}

?>