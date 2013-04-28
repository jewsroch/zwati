<?php
/**
 * The template for displaying Gallery style.
 *
 * @since Ultimate Photo Widget 2.0
 */
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////       Check Content      /////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
                    
  $uftp_output .= '<div id="uftp_container" style="position:relative;width:100%;">';  

  
  $uftp_output .= '<div id="'.$uftp_id.'-gallery" style="position:relative;height:300px;width:100%;background:#3f3;overflow:hidden;"><img id="big-image" src="' . $uftp_photourl[0] . '" /><br clear="all"/></div>';  
  
  // Align photos
  $uftp_output .= '<div id="'.$uftp_id.'-gallery-parent" style="position:relative;width:'.$uftp_style_width.';max-width:100%;';     

  if($uftp_align == 'center'){                          //  Optional: Set text alignment (left/right) or center
    $uftp_output .= 'margin:0px auto;text-align:center;';
  }
  else{
    $uftp_output .= 'float:' . $uftp_align . ';text-align:' . $uftp_align . ';';
  } 
  $uftp_output .= '">';

  
  
  for($i = 0;$i<$uftp_num;$i++){
    $uftp_output .= '<a href="' . $uftp_linkurl[$i] . '" target="_blank" title='."'". $uftp_photocap[$i] ."'".'>';
    $uftp_output .= '<img class="gallery-image" id="'.$uftp_id.'-tile-'.$i.'" src="' . $uftp_photourl[$i] . '" ';
    $uftp_output .= 'title='."'". $uftp_photocap[$i] ."'".' alt='."'". $uftp_photocap[$i] ."' "; // Careful about caps with ""
    $uftp_output .= 'border="0" hspace="5" vspace="0" style="position:relative;max-width:80px;margin-top:2px;" />';
    $uftp_output .= '</a>';
  }
  
  $uftp_by_link  =  '<div id="'.$uftp_id.'-by-link" style="position:absolute;bottom:0px;left:0px;height:auto;width:inherit;color:#C0C0C0;padding-bottom:8px;padding-left:5px;font-size:8px;line-height:8px;opacity:0.9;filter:alpha(opacity=90);text-align:left;"><a href="http://electrictreehouse.com/" style="color:#C0C0C0;text-decoration:none;" title="Widget by ElectricTreeHouse and KylinUntitled">ETH </a>& <a href="http://kylinuntitled.com/" style="color:#C0C0C0;text-decoration:none;" title="Widget by ElectricTreeHouse and KylinUntitled">KU</a></div>';      
  if(!$uftp_disable_by_link){
    $uftp_output .=  $uftp_by_link;    
  }          
  // Close gallery-parent
  $uftp_output .= '</div>';    

  $uftp_output .= $uftp_user_link; // Already checked if should be displayed

  // Close container
  $uftp_output .= '</div>';
  $uftp_output .= '<br clear="all" />';

  
  $uftp_output .= '
  <script type="text/javascript">
    jQuery(".gallery-image").mouseenter(function(){
      jQuery("#big-image").attr("src", jQuery(this).attr("src"));
    }); 
  
  jQuery("#'.$uftp_id.'_uftp_container").css({"height":"auto"});
  jQuery(window).load(function() {
    uftpGallery();
    jQuery("#'.$uftp_id.'_uftp_container").css({"opacity":"1.0"});
  });
  </script>';

?>