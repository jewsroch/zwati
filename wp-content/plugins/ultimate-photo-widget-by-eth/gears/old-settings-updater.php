<?php
/**
 * PHP for updating settings from old ( pre-2.0.1) to new
 *
 * @since Ultimate Photo Widget 2.0.3
 */

  $new_opt = array();
  foreach($current_opt as $id => $opt){
    if(is_numeric ($id)){
      $new_opt[$id] = array(
        'title'=>$opt['title'],
        'source-opt'=>$opt['source-opt'],
        'size-opt'=>$opt['size-opt'],
        'style-opt'=>$opt['style-opt'],
        'align-opt'=>$opt['align-opt'],
        'num-items'=>$opt['num-items'],
        'reduced-width'=>$opt['reduced-width'],
        'remove-myLink'=>$opt['remove-myLink']
      );
      $new_opt[$id]['flickr'] = array(
        'uid'=>$opt['uftp-flickr-uid'],
        'display-link'=>$opt['display-Flink'],
        'size-opt'=>$opt['size-Fopt'],
        'uid-type'=>$opt['uftp-flickr-uid-type'],
        'set-id'=>$opt['uftp-flickr-type-set'],
        'tags'=>$opt['uftp-flickr-tags']
      );
      $new_opt[$id]['tumblr'] = array(
        'uid'=>$opt['uftp-tumblr-uid'],
        'display-link'=>$opt['display-Tlink'],
        'size-opt'=>$opt['size-Topt'],
        'custom-link'=>$opt['custom-Tlink']
      );
      $new_opt[$id]['pinterest'] = array(
        'uid'=>$opt['uftp-pinterest-uid'],
        'display-link'=>$opt['display-Plink'],
        'size-opt'=>$opt['size-Popt'],
        'link-style'=>'text'
      );
      $new_opt[$id]['vertical'] = array(
        'num-items'=>$opt['num-Vitems']
      );   
      if($opt['style-opt']=='square-tiles'){
        $new_opt[$id]['tiles'] = array(
          'num-items'=>$opt['num-STitems'],
          'shape'=>'square'
        );   
        $new_opt[$id]['style-opt'] = 'tiles'; // Change style to tiles
      }else{
        $new_opt[$id]['tiles'] = array(
          'num-items'=>$opt['num-Titems'],
          'shape'=>'rectangle'
        );
      }
      $new_opt[$id]['slideshow'] = array(
        'num-items'=>$opt['num-Sitems'],
        'style'=>($opt['slide-style'] ? $opt['slide-style'] : 1), // If no style set, use rotate (1)
        'fixed-height'=>$opt['fixed-height'],
        'remove-NextPrev'=>$opt['remove-NextPrev']
      );   
    }
    else{
      $new_opt[$id] = $opt;
    }
  }
  update_option("uftp_photo_version",$new_version);
  update_option("widget_uftp_photo",$new_opt);
 
?>