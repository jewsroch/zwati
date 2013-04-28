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
  else{   $uftp_style_width = "100%";    }
  
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////   Begin the Content   /////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  $uftp_safe_output = '<noscript>';
                    
  $uftp_safe_output .= '<div id="uftp_container" style="position:relative;width:100%;">';     
  
  // Align photos
  $uftp_safe_output .= '<div id="'.$uftp_id.'-vertical-parent" style="position:relative;width:'.$uftp_style_width.';max-width:100%;';     

  if($uftp_align == 'center'){                          //  Optional: Set text alignment (left/right) or center
    $uftp_safe_output .= 'margin:0px auto;text-align:center;';
  }
  else{
    $uftp_safe_output .= 'float:' . $uftp_align . ';text-align:' . $uftp_align . ';';
  } 
  $uftp_safe_output .= '">';
  
  for($i = 0;$i<$uftp_num;$i++){
    $uftp_safe_output .= '<a href="' . $uftp_linkurl[$i] . '" target="_blank" title='."'". $uftp_photocap[$i] ."'".'>';
    $uftp_safe_output .= '<img id="'.$uftp_id.'-tile-'.$i.'" src="' . $uftp_photourl[$i] . '" ';
    $uftp_safe_output .= 'title='."'". $uftp_photocap[$i] ."'".' alt='."'". $uftp_photocap[$i] ."' "; // Careful about caps with ""
    $uftp_safe_output .= 'border="0" hspace="0" vspace="0" style="position:relative;max-width:100%;margin-top:2px;" />';
    $uftp_safe_output .= '</a>';
  }
  
  $uftp_by_link  =  '<div id="'.$uftp_id.'-by-link" style="position:absolute;bottom:0px;left:0px;height:auto;width:inherit;color:#C0C0C0;padding-bottom:8px;padding-left:5px;font-size:8px;line-height:8px;opacity:0.9;filter:alpha(opacity=90);text-align:left;"><a href="http://electrictreehouse.com/" style="color:#C0C0C0;text-decoration:none;" title="Widget by ElectricTreeHouse and KylinUntitled">ETH </a>& <a href="http://kylinuntitled.com/" style="color:#C0C0C0;text-decoration:none;" title="Widget by ElectricTreeHouse and KylinUntitled">KU</a></div>';      
  if(!$uftp_disable_by_link){
    $uftp_safe_output .=  $uftp_by_link;    
  }          
  // Close tile-parent
  $uftp_safe_output .= '</div>';    

  if( $uftp_display_link ) {
    $uftp_safe_output .= $uftp_user_link;
  }
  // Close container
  $uftp_safe_output .= '</div>';
  $uftp_safe_output .= '<br clear="all" />';
  $uftp_safe_output .= '</noscript>';

?>