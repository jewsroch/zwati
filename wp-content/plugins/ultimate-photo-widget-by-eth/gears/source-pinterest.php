<?php
/**
 * The PHP for retrieving content from Pinterest.
 *
 * @since Ultimate Photo Widget 1.0
 */
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////    Generate Image Content    ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Determine image size id
  switch ($pinterest_options['size-opt']) {
    case 75:
      $uftp_size_id = '_t.';
    break;
    case 192:
      $uftp_size_id = '_b.';
    break;
    case 554:
      $uftp_size_id = '_c.';
    break;
    case 600:
      $uftp_size_id = '_f.';
    break;
    case 930:
      $uftp_size_id = '.';
    break;
  }  

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

  include_once(ABSPATH . WPINC . '/feed.php');
  
  if($pinterest_options['specific-board']){
    $pinterest_rss_url = 'http://pinterest.com/'.$pinterest_options['uid'].'/'.$pinterest_options['specific-board'].'/rss';
    $rss = @fetch_feed( $pinterest_rss_url );
    /*
    if($rss == NULL){
      $pinterest_rss_url = 'http://pinterest.com/'.$pinterest_options['uid'].'/feed.rss';
      $rss = @fetch_feed( $pinterest_rss_url );
    }*/
  }else{
    $pinterest_rss_url = 'http://pinterest.com/'.$pinterest_options['uid'].'/feed.rss';
    $rss = @fetch_feed( $pinterest_rss_url );
  }
  

  if (!is_wp_error( $rss ) && $rss != NULL ){ // Check that the object is created correctly 
    // Bulldoze through the feed to find the items 
    $results = array();
    $uftp_title = @uftp_specialarraysearch($rss,'title');
    $uftp_title = $uftp_title['0']['data'];
    $rss_data = @uftp_specialarraysearch($rss,'item');
    //print_r($rss_data);
    
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
            // Next, strip away everything surrounding the source url.
              // . means any expression and + means repeat previous
            $uftp_photourl[$s] = @preg_replace(array('/(.+)src="/i','/"(.+)/') , '',$matches[ 0 ]);
            // Finally, change the size. 
              // [] specifies single character and \w is any word character
            $uftp_photourl[$s] = @preg_replace('/[_]\w[.]/', $uftp_size_id, $uftp_photourl[$s] );
            
            $uftp_photocap[$s] = $item['child']['']['title']['0']['data'];
            $s++;
          }
        }
        else{
          break;
        }
      }
    }
    if(!empty($uftp_linkurl) && !empty($uftp_photourl)){
      if( $pinterest_options['display-link'] ) {
          $uftp_linkStyle = $pinterest_options['link-style'];
					if ($uftp_linkStyle == 'large') { 
						$uftp_user_link .= '<a href="http://pinterest.com/'. $pinterest_options['uid'] .'/" target="_blank" title="Follow Me on Pinterest">';
            $uftp_user_link .= '<img src="http://passets-cdn.pinterest.com/images/follow-on-pinterest-button.png" alt="Follow Me on Pinterest" border="0" class="uftp-image-link"/>';
						$uftp_user_link .= '</a>';
					} elseif ($uftp_linkStyle == 'medium') { 
						$uftp_user_link .= '<a href="http://pinterest.com/'. $pinterest_options['uid'] .'/" target="_blank" title="Follow Me on Pinterest">';
						$uftp_user_link .= '<img src="http://passets-cdn.pinterest.com/images/pinterest-button.png" alt="Follow Me on Pinterest" border="0" class="uftp-image-link" />';
						$uftp_user_link .= '</a>';
					} elseif ($uftp_linkStyle == 'small') { 
						$uftp_user_link .= '<a href="http://pinterest.com/'. $pinterest_options['uid'] .'/" target="_blank" title="Follow Me on Pinterest">';
						$uftp_user_link .= '<img src="http://passets-cdn.pinterest.com/images/big-p-button.png" width="61" height="61" alt="Follow Me on Pinterest" border="0" class="uftp-image-link" />';
						$uftp_user_link .= '</a>';
					} elseif ($uftp_linkStyle == 'tiny') { 
						$uftp_user_link .= '<a href="http://pinterest.com/'. $pinterest_options['uid'] .'/" target="_blank" title="Follow Me on Pinterest" >';
						$uftp_user_link .= '<img src="http://passets-cdn.pinterest.com/images/small-p-button.png" width="16" height="16" alt="Follow Me on Pinterest" border="0" class="uftp-image-link"/>';
						$uftp_user_link .= '</a>';
					} elseif ($uftp_linkStyle == 'text') {
            $uftp_user_link .= '<div class="uftp-display-link" >';
            $uftp_user_link .= '<a href="http://pinterest.com/'.$pinterest_options['uid'].'/" target="_blank" >';
            $uftp_user_link .= $uftp_title;
            $uftp_user_link .= '</a></div>';
          } else {
            $uftp_user_link .= '<div class="uftp-display-link" >';
            $uftp_user_link .= '<a href="http://pinterest.com/'.$pinterest_options['uid'] .'/" target="_blank" >';
            $uftp_user_link .= $uftp_title;
            $uftp_user_link .= '</a></div>';
          } 
      }
      // If content successfully fetched, generate output...
      $uftp_continue = true;
      
    }else{
      $uftp_output .= 'No content found.';
      $uftp_continue = false;
    }

  }
  else{
    if($pinterest_options['specific-board']){
      $uftp_output .= '- No content found. <!-- @ '.$pinterest_rss_url.' --> <br /> - Check your ID and board name.';
    }else{
      $uftp_output .= '- No content found. <!-- @ '.$pinterest_rss_url.' --> <br /> - Check your ID.';
    }
    $uftp_continue = false;
  }
  
?>