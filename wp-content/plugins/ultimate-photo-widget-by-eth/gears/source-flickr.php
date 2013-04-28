<?php
/**
 * The PHP for retrieving content from Flickr.
 *
 * @since Ultimate Photo Widget 1.0
 */
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////    Generate Image Content    ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // For Reference:
  // http://www.flickr.com/services/api/response.json.html
  // s = small square 75x75
  // t = thumbnail, 100 on longest side
  // m = small, 240 on longest side
  // - = medium, 500 on longest side
  // z = medium, 640 on longest side
  // b = large, 1024 on longest side*
  // o = original image, either a jpg, gif or png, depending on source format**
  // *Before May 25th 2010 large photos only exist for very large original images.
  // **Original photos behave a little differently. They have their own secret (called originalsecret in responses) and a variable file extension (called originalformat in responses). These values are returned via the API only when the caller has permission to view the original size (based on a user preference and various other criteria). The values are returned by the flickr.photos.getInfo method and by any method that returns a list of photos and allows an extras parameter (with a value of original_format), such as flickr.photos.search. The flickr.photos.getSizes method, as always, will return the full original URL where permissions allow.
    
  // Determine image size id
  $uftp_size_id = '.'; // Default is 500
  switch ($flickr_options['size-opt']) {
    case 75:
      $uftp_size_id = '_s.';
    break;
    case 100:
      $uftp_size_id = '_t.';
    break;
    case 240:
      $uftp_size_id = '_m.';
    break;
    case 500:
      $uftp_size_id = '.';
    break;
    case 640:
      $uftp_size_id = '_z.';
    break;
  }  
  
  // Retrieve content using curl_init and PHP_serial
 if ( curl_init() ) {
    // @ is shut-up operator
    // For reference: http://www.flickr.com/services/feeds/
    $flickr_uid = apply_filters( 'uftp_photo', empty($flickr_options['uid']) ? '' : $flickr_options['uid'], $flickr_options );
    switch ($flickr_options['uid-type']) {
    case 'user':
      $request = 'http://api.flickr.com/services/feeds/photos_public.gne?id='. $flickr_uid .'&lang=en-us&format=php_serial';
    break;
    case 'favorites':
      $request = 'http://api.flickr.com/services/feeds/photos_faves.gne?nsid='. $flickr_uid .'&lang=en-us&format=php_serial';
    break;
    case 'group':
      $request = 'http://api.flickr.com/services/feeds/groups_pool.gne?id='. $flickr_uid .'&lang=en-us&format=php_serial';
    break;
    case 'set':
      $uftp_flickr_set = apply_filters( 'uftp_photo', empty($flickr_options['set-id']) ? '' : $flickr_options['set-id'], $flickr_options );
      $request = 'http://api.flickr.com/services/feeds/photoset.gne?set=' . $uftp_flickr_set . '&nsid='. $flickr_uid .'&lang=en-us&format=php_serial';
    break;
    case 'community':
      $uftp_flickr_tags = apply_filters( 'uftp_photo', empty($flickr_options['tags']) ? '' : $flickr_options['tags'], $flickr_options );
      $request = 'http://api.flickr.com/services/feeds/photos_public.gne?tags='. $uftp_flickr_tags .'&lang=en-us&format=php_serial';
    break;
    } 

    $ci = @curl_init();
    @curl_setopt($ci, CURLOPT_URL, $request);
    @curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
    $_flickrurl = @curl_exec($ci);
    @curl_close($ci);
    
    $_flickr_php = @unserialize($_flickrurl);

    if(empty($_flickr_php)){
      $uftp_output .= '<!-- Failed using PHP_Serial @ '.$request.' -->';
      $uftp_continue = false;
    }else{
      
      $uftp_title = $_flickr_php['title'];
      $uftp_link = $_flickr_php['url'];
      $uftp_content =  $_flickr_php['items'];

      for ($i=0;$i<$uftp_num;$i++) {
        if($uftp_content[$i]['url']){ // Check if anything is there
          $uftp_linkurl[$i] = $uftp_content[$i]['url'];
          $uftp_photocap[$i] = $uftp_content[$i]['title']; // retrieve image title
           // retrieve image url from feed and set new image size
          $uftp_photourl[$i] = @str_replace('_m.', $uftp_size_id, $uftp_content[$i]['m_url'] );
        }
      }
      if(!empty($uftp_linkurl) && !empty($uftp_photourl)){
        if( $flickr_options['display-link'] ) {
          $uftp_user_link = '<div class="uftp-display-link" >';
          $uftp_user_link .='<a href="'.$uftp_link.'" target="_blank" >';
          $uftp_user_link .= $uftp_title;
          $uftp_user_link .= '</a></div>';
        }
        // If content successfully fetched, generate output...
        $uftp_continue = true;
        $uftp_output .= '<!-- Success using PHP_Serial -->';
      }else{
        $uftp_output .= '<!-- No photos found using PHP_Serial @ '.$request.' -->';  
        $uftp_continue = false;
      }
    }
  }
  ///////////////////////////////////////////////////
  /// If nothing found, try using xml and rss_200 ///
  ///////////////////////////////////////////////////

  if ( $uftp_continue == false && function_exists('simplexml_load_file') ) {
    $flickr_uid = apply_filters( 'uftp_photo', empty($flickr_options['uid']) ? '' : $flickr_options['uid'], $flickr_options );
    switch ($flickr_options['uid-type']) {
    case 'user':
      $request = 'http://api.flickr.com/services/feeds/photos_public.gne?id='. $flickr_uid  .'&lang=en-us&format=rss_200';
    break;
    case 'favorites':
      $request = 'http://api.flickr.com/services/feeds/photos_faves.gne?nsid='. $flickr_uid  .'&lang=en-us&format=rss_200';
    break;
    case 'group':
      $request = 'http://api.flickr.com/services/feeds/groups_pool.gne?id='. $flickr_uid  .'&lang=en-us&format=rss_200';
    break;
    case 'set':
      $uftp_flickr_set = apply_filters( 'uftp_photo', empty($flickr_options['set-id']) ? '' : $flickr_options['set-id'], $flickr_options );
      $request = 'http://api.flickr.com/services/feeds/photoset.gne?set=' . $uftp_flickr_set . '&nsid='. $flickr_uid  .'&lang=en-us&format=rss_200';
    break;
    case 'community':
      $uftp_flickr_tags = apply_filters( 'uftp_photo', empty($flickr_options['tags']) ? '' : $flickr_options['tags'], $flickr_options );
      $request = 'http://api.flickr.com/services/feeds/photos_public.gne?tags='. $uftp_flickr_tags .'&lang=en-us&format=rss_200';
    break;
    } 

    $_flickrurl  = @urlencode( $request );	// just for compatibility
    $_flickr_xml = @simplexml_load_file( $_flickrurl,"SimpleXMLElement",LIBXML_NOCDATA); // @ is shut-up operator
    if($_flickr_xml===false){ 
      $uftp_output .= '<!-- Failed using XML @ '.$request.' -->';
      $uftp_continue = false;
    }else{
      $uftp_title = $_flickr_xml->channel->title;
      $uftp_link = $_flickr_xml->channel->link;
      
      if(!$_flickr_xml && !$_flickr_xml->channel){
        $uftp_output .= '<!-- No photos found using XML @ '.$request.' -->';
        $uftp_continue = false;
      }else{
        $s = 0; // simple counter
        foreach( $_flickr_xml->channel->item as $p ) { // This will prevent empty images from being added to uftp_linkurl.
          if($s<$uftp_num){
            // list of link urls
            $uftp_linkurl[$s] = $p->link; // ->i is equivalent of ['i'] for objects
            if($uftp_linkurl[$s]){
              // For Reference: regex references and http://php.net/manual/en/function.preg-match.php
              // Using the RSS feed will require some manipulation to get the image url from flickr;
              // preg_replace is bad at skipping lines so we'll start with preg_match
                // i sets letters in upper or lower case,
              @preg_match( "/<img(.+)\/>/i", $p->description, $matches ); // First, get image from feed.
              // Next, strip away everything surrounding the source url.
                // . means any expression, and + means repeat previous
              $uftp_photourl[$s] = @preg_replace(array('/(.+)src="/i','/"(.+)/') , '',$matches[ 0 ]);
              // Finally, change the size. [] specifies single character and \w is any word character
              $uftp_photourl[$s] = @preg_replace('/[_]\w[.]/', $uftp_size_id, $uftp_photourl[$s] );

              $uftp_photocap[$s] = $p->title;
            }
            $s++;
          }
          else{
            break;
          }
        }
        if(!empty($uftp_linkurl) && !empty($uftp_photourl)){
          if( $flickr_options['display-link'] ) {
            $uftp_user_link = '<div class="uftp-display-link" >';
            $uftp_user_link .='<a href="'.$uftp_link.'" target="_blank" >';
            $uftp_user_link .= $uftp_title;
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
    
    $flickr_uid = apply_filters( 'uftp_photo', empty($flickr_options['uid']) ? '' : $flickr_options['uid'], $flickr_options );
    switch ($flickr_options['uid-type']) {
    case 'user':
      $request = 'http://api.flickr.com/services/feeds/photos_public.gne?id='. $flickr_uid  .'&lang=en-us&format=rss_200';
    break;
    case 'favorites':
      $request = 'http://api.flickr.com/services/feeds/photos_faves.gne?nsid='. $flickr_uid  .'&lang=en-us&format=rss_200';
    break;
    case 'group':
      $request = 'http://api.flickr.com/services/feeds/groups_pool.gne?id='. $flickr_uid  .'&lang=en-us&format=rss_200';
    break;
    case 'set':
      $uftp_flickr_set = apply_filters( 'uftp_photo', empty($flickr_options['set-id']) ? '' : $flickr_options['set-id'], $flickr_options );
      $request = 'http://api.flickr.com/services/feeds/photoset.gne?set=' . $uftp_flickr_set . '&nsid='. $flickr_uid  .'&lang=en-us&format=rss_200';
    break;
    case 'community':
      $uftp_flickr_tags = apply_filters( 'uftp_photo', empty($flickr_options['tags']) ? '' : $flickr_options['tags'], $flickr_options );
      $request = 'http://api.flickr.com/services/feeds/photos_public.gne?tags='. $uftp_flickr_tags .'&lang=en-us&format=rss_200';
    break;
    } 
    include_once(ABSPATH . WPINC . '/feed.php');
    $rss = @fetch_feed( $request );

    if (!is_wp_error( $rss ) && $rss != NULL ){ // Check that the object is created correctly 
      // Bulldoze through the feed to find the items 
      $results = array();
      $uftp_title = @uftp_specialarraysearch($rss,'title');
      $uftp_title = $uftp_title['0']['data'];
      $uftp_link = @uftp_specialarraysearch($rss,'link');
      $uftp_link = $uftp_link['0']['data'];
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
        if( $flickr_options['display-link'] ) {
          $uftp_user_link = '<div class="uftp-display-link" >';
          $uftp_user_link .='<a href="'.$uftp_link.'" target="_blank" >';
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
  //// If STILL!!! nothing found, report that Flickr ID must be wrong ///
  ///////////////////////////////////////////////////////////////////////
  if( $uftp_continue == false ) {
    $uftp_output .= '- No photos found. Check your ID.';
  } 

?>