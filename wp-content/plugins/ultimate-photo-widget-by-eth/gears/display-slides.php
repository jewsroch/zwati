<?php
/**
 * The template for displaying Slideshow style.
 *
 * @since Ultimate Photo Widget 2.0
 */
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////       Check Content      /////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  // Check number of photos
  if($uftp_num != count($uftp_linkurl)){$uftp_num = count($uftp_linkurl);}

  for($i = 0;$i<count($uftp_photocap);$i++){
    $uftp_photocap[$i] = str_replace('"','',$uftp_photocap[$i]);
  }
  
  // Determine styling width
  if($uftp_reduced_width && $uftp_reduced_width<$uftp_size){
    $uftp_style_width = $uftp_reduced_width;   }
  else{   $uftp_style_width = $uftp_size;    }
  
  
  $uftp_output .= '<div id="'.$uftp_id.'_uftp_container" class="uftp_container_class" style="height:0px;opacity:0.0;">';     
  // Align photos
  $uftp_output .= '<div id="'.$uftp_id.'_float" style="width:'.$uftp_style_width.'px;overflow:hidden;';
  if($uftp_align == 'center'){                          //  Optional: Set text alignment (left/right) or center
    $uftp_output .= 'margin:0px auto;';
  }
  else{
    $uftp_output .= 'float:' . $uftp_align . ';';
  } 
  $uftp_output .= '">';
  
  $uftp_output .= '<div id="'.$uftp_id.'_slideshow_window" style="max-width:100%;"><div id="'.$uftp_id.'_slideshow_container" style="position:absolute;top:0px;width:100%;">';
  
  $uftp_output .= '<div class="active" style="opacity:0.0;">';
  $uftp_output .= '<a href="' . $uftp_linkurl[0] . '" target="_blank" >';
  $uftp_output .= '<img class="active" id="'.$uftp_id.'-tile-0" class="uftp-slideshow-img" src="' . $uftp_photourl[0] . '" ';
  $uftp_output .= 'title='."'". $uftp_photocap[0] ."'".' alt='."'". $uftp_photocap[0] ."' "; // Careful about caps with ""
  $uftp_output .= 'style="max-width:100%;"/>';
  $uftp_output .= '</a>';
  $uftp_output .= '</div>';
  
  for($i = 1;$i<$uftp_num;$i++){
    $uftp_output .= '<div class="" style="opacity:0.0;">';
    $uftp_output .= '<a href="' . $uftp_linkurl[$i] . '" target="_blank" title='."'". $uftp_photocap[$i] ."'".' >';
    $uftp_output .= '<img id="'.$uftp_id.'-tile-'.$i.'" class="uftp-slideshow-img" src="' . $uftp_photourl[$i] . '" ';
    $uftp_output .= 'title='."'". $uftp_photocap[$i] ."'".' alt='."'". $uftp_photocap[$i] ."' "; // Careful about caps with ""
    $uftp_output .= 'style="max-width:100%;"/>';
    $uftp_output .= '</a>';
    $uftp_output .= '</div>';
  }
  

  
  // Close slideshow
  $uftp_output .= '</div>';
  if(!$uftp_disable_by_link){
    $uftp_output .=  $uftp_by_link;    
  }      
  $uftp_output .= '</div>';

  // Link is inside float so additional styling unnecessary
  $uftp_output .= "<center>".$uftp_user_link."</center>";  

  // Close Container and Float
  $uftp_output .= '</div></div>';
  $uftp_output .= '<br clear="all" />';
  
  // TODO: default slide style
  $uftp_slide_style = ($slideshow_options['style'] ? $slideshow_options['style'] : 1);
  $uftp_fixed_height = ($slideshow_options['fixed-height'] ? $slideshow_options['fixed-height'] : NULL);  
  $uftp_remove_NextPrev = ($slideshow_options['remove-NextPrev'] ? $slideshow_options['remove-NextPrev'] : NULL); 
  
  $uftp_output .= '
  <script type="text/javascript">
  jQuery("#'.$uftp_id.'_uftp_container").css({"height":"auto"});
  jQuery(window).load(function() {
    uftpStartSlideshow("'.$uftp_id.'","'.$uftp_slide_style.'","'.$uftp_fixed_height.'","'.$uftp_remove_NextPrev.'");
    jQuery("#'.$uftp_id.'_uftp_container").css({"opacity":"1.0"});
  });
  </script>';
?>