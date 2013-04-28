<?php
/**
 * The template for displaying Vertical style.
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
  
  if($uftp_reduced_width && $uftp_reduced_width<$uftp_size ){
    $uftp_style_width = $uftp_reduced_width."px";   }
  else{   $uftp_style_width = $uftp_size."px";    }
  
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////   Begin the Content   /////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    
  $uftp_output .= '<div id="uftp_container" class="uftp_container_class">';     
  
  // Align photos
  $uftp_output .= '<div id="'.$uftp_id.'-vertical-parent" class="uftp_parent_class" style="width:'.$uftp_style_width.';padding:0px;';
  if($uftp_align == 'center'){                          //  Optional: Set text alignment (left/right) or center
    $uftp_output .= 'margin:0px auto;text-align:center;';
  }
  else{
    $uftp_output .= 'float:' . $uftp_align . ';text-align:' . $uftp_align . ';';
  } 
  $uftp_output .= '">';
  
  for($i = 0;$i<$uftp_num;$i++){
    $uftp_output .= '<a href="' . $uftp_linkurl[$i] . '" class="uftp-vertical-link" target="_blank" title='."'". $uftp_photocap[$i] ."'".'>';
    $uftp_output .= '<img id="'.$uftp_id.'-tile-'.$i.'" class="uftp-vertical-img" src="' . $uftp_photourl[$i] . '" ';
    $uftp_output .= 'title='."'". $uftp_photocap[$i] ."'".' alt='."'". $uftp_photocap[$i] ."' "; // Careful about caps with ""
    $uftp_output .= 'border="0" hspace="0" vspace="0" style="max-width:'.$uftp_style_width.'" />'; // Override the max-width set by theme
    $uftp_output .= '</a>';
  }
  
  $uftp_by_link  =  '<div id="'.$uftp_id.'-by-link" class="uftp-by-link"><a href="http://electrictreehouse.com/" style="COLOR:#C0C0C0;text-decoration:none;" title="Widget by ElectricTreeHouse and KylinUntitled">ETH </a>& <a href="http://kylinuntitled.com/" style="COLOR:#C0C0C0;text-decoration:none;" title="Widget by ElectricTreeHouse and KylinUntitled">KU</a></div>';      
  if(!$uftp_disable_by_link){
    $uftp_output .=  $uftp_by_link;    
  }          
  // Close vertical-parent
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

?>