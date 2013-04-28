<?php
/**
 * The PHP for widget update function
 *
 * @since Ultimate Photo Widget 2.0.3
 *
 */

  // The plethera of option parameters is intended to allow the user to save 
  // different settings in the same widget, reverting between sources and 
  // styles without reentering all the info.
  
  $options = $oldoptions;
  $options['title'] = strip_tags($newoptions['title']);
  
  // Source and source specific parameters
  $options['source-opt'] = $newoptions['source-opt'];   
  
  $options['flickr']['uid'] = str_replace(" ","",strip_tags($newoptions['flickr-uid']));
  $options['flickr']['display-link'] = isset($newoptions['flickr-display-link']);
  $options['flickr']['size-opt'] = $newoptions['flickr-size-opt'];
  $options['flickr']['uid-type'] = $newoptions['flickr-uid-type'];
  $options['flickr']['set-id'] = str_replace(' ','',strip_tags($newoptions['flickr-set-id'])); // Remove Spaces
  $options['flickr']['tags'] = str_replace(' ','',strip_tags($newoptions['flickr-tags'])); // Remove Spaces
  
  $options['tumblr']['uid'] = str_replace(" ","",strip_tags($newoptions['tumblr-uid']));
  $options['tumblr']['custom-link'] = isset($newoptions['tumblr-custom-link']);
  if($options['tumblr']['custom-link']){
    $options['tumblr']['uid'] = str_replace('http://','',$options['tumblr']['uid']); // Filter custom url
    $options['tumblr']['uid']= str_replace(array('/',' '),'',$options['tumblr']['uid']);
  }
  $options['tumblr']['display-link'] = isset($newoptions['tumblr-display-link']);
  $options['tumblr']['size-opt'] = $newoptions['tumblr-size-opt'];    
  
  $options['pinterest']['uid'] = str_replace(' ','',strip_tags($newoptions['pinterest-uid']));  
  $options['pinterest']['specific-board'] = str_replace(' ','-',strip_tags($newoptions['pinterest-specific-board']));  
  $options['pinterest']['display-link'] = isset($newoptions['pinterest-display-link']);
  $options['pinterest']['link-style'] = $newoptions['pinterest-link-style'];    
  $options['pinterest']['size-opt'] = $newoptions['pinterest-size-opt'];  
  
  // Style and style specific parameters
  $options['style-opt'] = $newoptions['style-opt'];
  
  $options['vertical']['num-items'] = $newoptions['vertical-num-items'];
  
  $options['tiles']['num-items'] = $newoptions['tiles-num-items'];
  $options['tiles']['shape'] = $newoptions['tiles-shape'];
  
  $options['slideshow']['num-items'] = $newoptions['slideshow-num-items'];
  $options['slideshow']['style'] = $newoptions['slideshow-style'];
  $options['slideshow']['fixed-height'] = isset($newoptions['slideshow-fixed-height']);
  $options['slideshow']['remove-NextPrev'] = isset($newoptions['slideshow-remove-NextPrev']);   
  
  $options['gallery']['num-items'] = $newoptions['gallery-num-items'];
  
  // Other    
  $options['align-opt'] = $newoptions['align-opt'];
  $options['reduced-width'] = strip_tags($newoptions['reduced-width']);
  $options['remove-myLink'] = isset($newoptions['remove-myLink']);
  
  // Since the number of items is important to source and style, 
  // save it as it's own setting. Default to vertical settings.
  $options['num-items'] = $newoptions['vertical-num-items'];
  switch ($options['style-opt']) {
    case "vertical":
      $options['num-items'] = $newoptions['vertical-num-items'];
    break;
    case "tiles":
      $options['num-items'] = $newoptions['tiles-num-items'];
    break;
    case "slideshow":
      $options['num-items'] = $newoptions['slideshow-num-items'];       
    break;
    case "gallery":
      $options['num-items'] = $newoptions['gallery-num-items'];
    break;   
  }

  // End update function
  ?>
