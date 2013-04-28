<?php
/**
 * The template for displaying Tiles style.
 *
 * @since Ultimate Photo Widget 1.0
 */
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////       Check Content      /////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  if($uftp_num != count($uftp_linkurl)){$uftp_num=count($uftp_linkurl);}
  
  for($i = 0;$i<count($uftp_photocap);$i++){
    $uftp_photocap[$i] = str_replace('"','',$uftp_photocap[$i]);
  }
  
  if($uftp_reduced_width && $uftp_reduced_width<$uftp_size){
    $uftp_style_width = $uftp_reduced_width;   }
  else{   $uftp_style_width = $uftp_size;    }
  
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////   Begin the Content   /////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  $uftp_output .= '<div id="'.$uftp_id.'_uftp_container" class="uftp_container_class" style="height:0px;">';     
  // Align photos
  $uftp_output .= '<div id="'.$uftp_id.'-tile-parent" class="uftp_parent_class" style="width:'.$uftp_style_width.'px;overflow:hidden;opacity:0.0;';     
  if($uftp_align == 'center'){                          //  Optional: Set text alignment (left/right) or center
    $uftp_output .= 'margin:0px auto;';
  }
  else{
    $uftp_output .= 'float:' . $uftp_align . ';';
  } 
  $uftp_output .= '">';

  for($i = 0;$i<$uftp_num;$i++){
    if($i%3){
      if($i%3 == 1){
      $uftp_output .= '<div id="'.$uftp_id.'-tile-div-'.$i.'" style="overflow:hidden;">';
      $uftp_output .= '<div id="'.$uftp_id.'-tile-image-div-'.$i.'" style="float:left;overflow:hidden;width:50%;">';
      $uftp_output .= '<a  href="' . $uftp_linkurl[$i] . '" target="_blank" title='."'". $uftp_photocap[$i] ."'".'>';
      $uftp_output .= '<img id="'.$uftp_id.'-tile-'.$i.'" src="' . $uftp_photourl[$i] . '" class="uftp-tile-img"';
      $uftp_output .= 'title='."'". $uftp_photocap[$i] ."'".' alt='."'". $uftp_photocap[$i] ."' "; // Careful about caps with ""
      $uftp_output .= 'border="0" vspace="0" hspace="0" ';
      $uftp_output .= 'style="float:left;max-width:'.($uftp_style_width).'px;"/>'; // max-width encourages space to be filled (100% is too small)
      $uftp_output .= '</a></div>';
      }
      if($i%3 == 2){
      $uftp_output .= '<div id="'.$uftp_id.'-tile-image-div-'.$i.'" style="float:right;overflow:hidden;width:50%;">';
      $uftp_output .= '<a  href="' . $uftp_linkurl[$i] . '" target="_blank" title='."'". $uftp_photocap[$i] ."'".'>';
      $uftp_output .= '<img id="'.$uftp_id.'-tile-'.$i.'" src="' . $uftp_photourl[$i] . '" class="uftp-tile-img"';
      $uftp_output .= 'title='."'". $uftp_photocap[$i] ."'".' alt='."'". $uftp_photocap[$i] ."' ";
      $uftp_output .= 'border="0" vspace="0" hspace="0" ';
      $uftp_output .= 'style="float:right;max-width:'.($uftp_style_width).'px;"/>';
      $uftp_output .= '</a></div>';
      $uftp_output .= '</div>';
      }
    }else{
      $uftp_output .= '<div id="'.$uftp_id.'-tile-div-'.$i.'" style="overflow:hidden;position:relative;width:100%;">';
      $uftp_output .= '<a  href="' . $uftp_linkurl[$i] . '"  target="_blank" title='."'". $uftp_photocap[$i] ."'".'>';
      $uftp_output .= '<img id="'.$uftp_id.'-tile-'.$i.'" src="' . $uftp_photourl[$i] . '" class="uftp-tile-img"';
      $uftp_output .= 'title='."'". $uftp_photocap[$i] ."'".' alt='."'". $uftp_photocap[$i] ."' "; // Careful about caps with ""
      $uftp_output .= 'border="0" vspace="0" hspace="0" ';
      $uftp_output .= 'style="max-width:100%;"/>'; // max-width encourages space to be filled and overrides default
      $uftp_output .= '</a>';
      $uftp_output .= '</div>';
    }
  }
         
  if(!$uftp_disable_by_link){
    $uftp_output .=  $uftp_by_link;    
  }        
  // Close tile-parent
  $uftp_output .= '</div>';    
  if($uftp_user_link){ 
    if($uftp_align == 'center'){                          //  Optional: Set text alignment (left/right) or center
      $uftp_output .= '<div id="'.$uftp_id.'-display-link" class="uftp-display-link-container" ';
      $uftp_output .= 'style="width:'.$uftp_style_width.';margin:0px auto;"><center>'.$uftp_user_link.'</center></div>';
    }
    else{
      $uftp_output .= '<br clear="all" />';
      $uftp_output .= '<div id="'.$uftp_id.'-display-link" class="uftp-display-link-container" ';
      $uftp_output .= 'style="float:' . $uftp_align . ';width:'.$uftp_style_width.';"><center>'.$uftp_user_link.'</center></div>'; // Only breakline if floating
    } 
  }
  
  // Close container
  $uftp_output .= '</div>';
  $uftp_output .= '<br clear="all" />';
  

  if($tiles_options['shape'] == "square"){                
  $uftp_output .= '<script type="text/javascript">
                    jQuery("#'.$uftp_id.'_uftp_container").css({"height":"auto"});
                    jQuery(window).load(function() {
                      uftp_square_tiles_resize('.$uftp_num.', "'.$uftp_id.'");
                    });
                  </script>';     
  }else{              
  $uftp_output .= '<script type="text/javascript">
                    jQuery("#'.$uftp_id.'_uftp_container").css({"height":"auto"});
                    jQuery(window).load(function() {
                      uftp_tiles_resize('.$uftp_num.', "'.$uftp_id.'");
                    });
                  </script>';     
  }
?>