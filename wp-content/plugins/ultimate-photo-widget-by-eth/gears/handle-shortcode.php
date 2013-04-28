<?php
/**
 * The PHP for handling shortcodes
 *
 * @since Ultimate Photo Widget 2.0.3
 */
 
    $uftp_id = rand();
    // Source, Style, and Display Options
    $uftp_source = $source;
    $uftp_num = $num; 
    $uftp_disable_by_link = $disable_link;   
    $uftp_style = $style;
    $uftp_size = $size;
    $uftp_align = $align;
    $uftp_reduced_width = $reduced_width;

    $uftp_by_link  =  '<div id="'.$uftp_id.'-by-link" class="uftp-by-link"><a href="http://electrictreehouse.com/" style="COLOR:#C0C0C0;text-decoration:none;" title="Widget by ElectricTreeHouse and KylinUntitled">ETH </a>& <a href="http://kylinuntitled.com/" style="COLOR:#C0C0C0;text-decoration:none;" title="Widget by ElectricTreeHouse and KylinUntitled">KU</a></div>';
    
    // Only try to display content if successfully retrieved from source.
    $uftp_continue = false;
    // Initiat output
    //$uftp_output = '<!-- '.print_r($atts,true).' -->';
    $uftp_safe_output = '';
    // Get content from source.
    switch ($uftp_source) {
			case "flickr":
        $flickr_options = array('uid' => $uid, 'display-link' => $display_link, 'size-opt' => $size, 'uid-type' => $type, 'set-id' => $set, 'tags' => $tags);
        include( UPWbyETH_DIR.'/gears/source-flickr.php');
			break;
			case "tumblr":    
        $tumblr_options = array('uid' => $uid, 'display-link' => $display_link, 'custom-link' => $custom, 'size-opt' => $size);
        include( UPWbyETH_DIR.'/gears/source-tumblr.php');
			break;
			case "pinterest":
        $pinterest_options = array('uid' => $uid, 'specific-board'=> $specific_board, 'display-link' => $display_link, 'link-style' => $link_style, 'size-opt' => $size);
        include( UPWbyETH_DIR.'/gears/source-pinterest.php');
			break;
		}
     
    
    // If content found, generate output
    if($uftp_continue){
      switch ($style) {
        case "vertical":
          $vertical_options = '';
          include( UPWbyETH_DIR.'/gears/display-vertical.php');
        break;
        case "tiles":
          $tiles_options = array('shape' => $shape); 
          include( UPWbyETH_DIR.'/gears/display-tiles.php');
          include( UPWbyETH_DIR.'/gears/display-safe-output.php');
        break;
        case "slideshow":
          $slideshow_options = array('style' => $slideshow_style, 'fixed-height'=>$fixed_height, 'remove-NextPrev'=>$remove_np );
          include( UPWbyETH_DIR.'/gears/display-slides.php');  
          include( UPWbyETH_DIR.'/gears/display-safe-output.php');          
        break;
        case "gallery":
          include( UPWbyETH_DIR.'/gears/display-gallery.php');
        break;

      }
    }
?>