<?php
  /**
   * The PHP for retrieving content from Tumblr.
   *
   * @since Ultimate Photo Widget 1.0
   *
   * Try three retrueval methods ( simplexml_load_file with XML, curl_init with JSON, and fetch_feed with RSS)
   * @since Ultimate Photo Widget 2.0.3.1
   *
   **/
 
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  ///////////////////////////////////////////    Generate Image Content    ////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /////////////////////////////////////////////////////////
  // Use XML (seems to be less temperamental than JSON)  //
  /////////////////////////////////////////////////////////
  if ( function_exists('simplexml_load_file') ) {
    // Determine image size id
    switch ($tumblr_options['size-opt']) {
      case 500:
        $uftp_size_id = 1;
      break;
      case 400:
        $uftp_size_id = 2;
      break;
      case 250:
        $uftp_size_id = 3;
      break;
      case 100:
        $uftp_size_id = 4;
      break;
      case 75:
        $uftp_size_id = 5;
      break;
    }
    
    $pagecounter = 0;		// to change starting position (for future use and not yet implemented)
    $tumblr_uid = apply_filters( 'uftp_photo', empty($tumblr_options['uid']) ? '' : $tumblr_options['uid'], $tumblr_options );
    if($tumblr_options['custom-link']){
      // No reason not to filter ID again.
      $tumblr_uid = str_replace('http://','',$tumblr_uid);
      $tumblr_uid = str_replace(array('/',' '),'',$tumblr_uid);
      $request = 'http://' . $tumblr_uid . '/api/read?start=' . $pagecounter . '&number=' .$uftp_num. '&type=photo';
    }
    else{
      $request = 'http://' . $tumblr_uid . '.tumblr.com/api/read?start=' . $pagecounter . '&number=' .$uftp_num. '&type=photo';
    }
    // XML doesn't seem to care if "www" is present or not
    $_tumblr_request  = @urlencode( $request );	// just for compatibility
    $_tumblr_xml = @simplexml_load_file( $_tumblr_request); // @ is shut-up operator

    if($_tumblr_xml===false){ 
      $uftp_output .= '<!-- Failed using XML @ '.$request.' -->';
      $uftp_continue = false;
    }else{
      $s = 0; // simple counter
      if( $_tumblr_xml && $_tumblr_xml->posts[0] ) {
        foreach( $_tumblr_xml->posts[0]->post as $p ) {
          if($s<$uftp_num){
            // list of link urls
            $uftp_linkurl[$s] = $p['url'];
            // list of photo urls
            $uftp_photourl[$s] = $p->{"photo-url"}[$uftp_size_id];
            $uftp_photocap[$s] = $p["slug"];
            $s++;
          }
        }
      }
      if(!empty($uftp_linkurl) && !empty($uftp_photourl)){
        // If set, generate tumblr link
        if( $tumblr_options['display-link'] ) {
          $uftp_user_link = '<div class="uftp-display-link">';
          if($tumblr_options['custom-link'] ){
            $uftp_user_link .='<a href="http://' . $tumblr_uid . '/" target="_blank" >';          
          }else{
            $uftp_user_link .='<a href="http://' . $tumblr_uid . '.tumblr.com/" target="_blank" >';
          }
          $uftp_user_link .= $_tumblr_xml->tumblelog[title];
          $uftp_user_link .= '</a></div>';
        }
        // If content successfully fetched, generate output...
        $uftp_continue = true;    
        $uftp_output .= '<!-- Success using XML -->';
      }else{
        $uftp_output .= '<!-- No photos found using XML @ '.$request.' -->';  
        $uftp_continue = false;
      }
    }
  }
  
  ////////////////////////////////////////////////////////
  /// If nothing found, try using curl_init() and JSON ///
  ////////////////////////////////////////////////////////
  if ( curl_init() && $uftp_continue == false) {
    $tumblr_uid = apply_filters( 'uftp_photo', empty($tumblr_options['uid']) ? '' : $tumblr_options['uid'], $tumblr_options );
    if($tumblr_options['custom-link']){
      $tumblr_uid = str_replace('http://','',$tumblr_uid );
      $tumblr_uid = str_replace(array('/',' '),'',$tumblr_uid);
      $request = 'http://' . $tumblr_uid . '/api/read/json?number=' .$uftp_num. '&type=photo';      
    }
    else{
      $request = 'http://' .$tumblr_uid. '.tumblr.com/api/read/json?number=' .$uftp_num. '&type=photo';
    }

    $ci = curl_init($request);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
    $_tumblrurl = curl_exec($ci);
    
    // In case the custom link should/should not have "www"
    if(empty($_tumblrurl) && $tumblr_options['custom-link']){
      if(stristr($tumblr_uid,'www.')){
        $tumblr_uid = str_replace('www.','',$tumblr_uid );
      }else{
        $tumblr_uid = "www.".$tumblr_uid;
      }
      $request = 'http://' . $tumblr_uid . '/api/read/json?number=' .$uftp_num. '&type=photo';
      $ci = curl_init($request);
      curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
      $_tumblrurl = curl_exec($ci);
    }

    // Tumblr JSON doesn't come in standard form, some str replace needed
    $_tumblrurl = str_replace('var tumblr_api_read = ','',$_tumblrurl);
    $_tumblrurl = str_replace(';','',$_tumblrurl);

    // parameter 'true' is necessary for output as PHP array
    $_tumblr_json = json_decode($_tumblrurl, true);

    if(empty($_tumblr_json)){
      $uftp_output .= '<!-- Failed using JSON @ '.$request.' -->';
      $uftp_continue = false;
    }else{
      //print_r ($_tumblr_json);
      $uftp_temp = $_tumblr_json['tumblelog'];
      $uftp_content =  $_tumblr_json['posts'];

      // Using the JSON API, the actual image size will be requested rather than the size id
      $type = 'photo-url-'.$tumblr_options['size-opt'].'';
      for ($i=0;$i<$uftp_num;$i++) {
        if ($uftp_content[$i]['type'] == 'photo') {
          $uftp_linkurl[$i] = $uftp_content[$i]['url'];
          $uftp_photourl[$i] = $uftp_content[$i][$type];
          $uftp_photocap[$i] = $uftp_content[$i]['slug'];
        }
      }
      if(!empty($uftp_linkurl) && !empty($uftp_photourl)){
        if( $tumblr_options['display-link'] ) {
          $uftp_user_link = '<div class="uftp-display-link" >';
          if($tumblr_options['custom-link']){
            $uftp_user_link .='<a href="http://' . $tumblr_uid . '/" target="_blank" >';          
          }else{
            $uftp_user_link .='<a href="http://' . $tumblr_uid . '.tumblr.com/" target="_blank" >';
          }
          $uftp_user_link .= $uftp_temp['title'];
          $uftp_user_link .= '</a></div>';
        }
        // If content successfully fetched, generate output...
        $uftp_continue = true;
        $uftp_output .= '<!-- Success using JSON -->';
      }else{
        $uftp_output .= '<!-- No photos found using JSON @ '.$request.' -->';      
        $uftp_continue = false;
      }
    }
  }
  
  ////////////////////////////////////////////////////////
  ////      If still nothing found, try using RSS      ///
  ////////////////////////////////////////////////////////
  if( $uftp_continue == false ) {
    // RSS may actually be safest approach since it does not require PHP server extensions,
    // but I had to build my own method for parsing SimplePie Object so I will keep it as the last option.
    
    if(!function_exists(uftp_specialarraysearch)){
      function uftp_specialarraysearch($array, $find){
        foreach ($array as $key=>$value){
          if( is_string($key) && $key==$find){
            return $value;
          }
          elseif(is_array($value)){
            $results = uftp_specialarraysearch($value, $find);
          }
          elseif(is_object($value)){
            $sub = $array->$key;
            $results = uftp_specialarraysearch($sub, $find);
          }
          // If found, return
          if(!empty($results)){return $results;}
        }
        return $results;
      }
    }
    
    $tumblr_uid = apply_filters( 'uftp_photo', empty($tumblr_options['uid']) ? '' : $tumblr_options['uid'], $tumblr_options );
    if($tumblr_options['custom-link']){
      // No reason not to filter ID again.
      $tumblr_uid = str_replace('http://','',$tumblr_uid);
      $tumblr_uid = str_replace(array('/',' '),'',$tumblr_uid);
      $request = 'http://' . $tumblr_uid . '/rss';
    }
    else{
      $request = 'http://' . $tumblr_uid . '.tumblr.com/rss';
    }

    include_once(ABSPATH . WPINC . '/feed.php');
    $rss = @fetch_feed( $request );

    if (!is_wp_error( $rss ) && $rss != NULL ){ // Check that the object is created correctly 
      // Bulldoze through the feed to find the items 
      $results = array();
      $uftp_title = @uftp_specialarraysearch($rss,'title');
      $uftp_title = $uftp_title['0']['data'];
      $rss_data = @uftp_specialarraysearch($rss,'item');

      $s = 0; // simple counter
      if ($rss_data != NULL ){ // Check again
        foreach ( $rss_data as $item ) {
          if($s<$uftp_num){
            $uftp_linkurl[$s] = $item['child']['']['link']['0']['data'];    
            $content = $item['child']['']['description']['0']['data'];     
            if($content){
              // For Reference: regex references and http://php.net/manual/en/function.preg-match.php
              // Using the RSS feed will require some manipulation to get the image url from flickr;
              // preg_replace is bad at skipping lines so we'll start with preg_match
              // i sets letters in upper or lower case, s sets . to anything
              @preg_match("/<IMG.+?SRC=[\"']([^\"']+)/si",$content,$matches); // First, get image from feed.
              if($matches[ 0 ]){
                // Next, strip away everything surrounding the source url.
                // . means any expression and + means repeat previous
                $uftp_photourl[$s] = @preg_replace(array('/(.+)src="/i','/"(.+)/') , '',$matches[ 0 ]);
                // Finally, change the size. 
                  // [] specifies single character and \w is any word character
                $uftp_photourl[$s] = @preg_replace('/[_]500[.]/', '_'.$tumblr_options['size-opt'].'.', $uftp_photourl[$s] );
                
                // Could set the caption as blank instead of default "Photo", but currently not doing so.
                $uftp_photocap[$s] = $item['child']['']['title']['0']['data'];
                $s++;
              }
            }
          }
          else{
            break;
          }
        }
      }
      if(!empty($uftp_linkurl) && !empty($uftp_photourl)){
        if( $tumblr_options['display-link'] ) {
          $uftp_user_link = '<div class="uftp-display-link" >';
          if($tumblr_options['custom-link']){
            $uftp_user_link .='<a href="http://' . $tumblr_uid . '/" target="_blank" >';          
          }else{
            $uftp_user_link .='<a href="http://' . $tumblr_uid . '.tumblr.com/" target="_blank" >';
          }
          $uftp_user_link .= $uftp_title;
          $uftp_user_link .= '</a></div>';
        }
        // If content successfully fetched, generate output...
        $uftp_continue = true;
        $uftp_output .= '<!-- Success using RSS -->';
      }else{
        $uftp_output .= '<!-- No photos found using RSS @ '.$request.' -->';
        $uftp_continue = false;
      }
    }
    else{
      $uftp_output .= '<!-- Failed RSS @ '.$request.' -->';
      $uftp_continue = false;
    }      
  }
    
  ///////////////////////////////////////////////////////////////////////
  //// If STILL!!! nothing found, report that Tumblr ID must be wrong ///
  ///////////////////////////////////////////////////////////////////////
  if( $uftp_continue == false ) {
    $uftp_output .= '- No photos found. Check your ID.';
  } 

?>