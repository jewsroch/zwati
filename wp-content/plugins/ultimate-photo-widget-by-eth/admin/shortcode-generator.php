<?php
/**
 * The PHP for shortcode generator feature
 *
 * @since Ultimate Photo Widget 2.1.0
 */

  // variables for the field and option names 
  $opt_name = 'ultime_photo_recent_shortcode';
  $hidden_field_name = 'ultime_photo_hidden';
  $uftp_setting_id = 'uftp_';

  // See if the user has posted and saved some information
  // If they did, the hidden field will be set to 'Y'
  if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
    // Read their posted value
    $record = '';
    $record .= 'source='.$_POST[ $uftp_setting_id."_source_opt" ].';';
    $record .= 'flickr-uid='.str_replace(' ','',strip_tags($_POST[ $uftp_setting_id."_flickr_uid" ])).';';       
    $record .= 'flickr-uid-type='.$_POST[ $uftp_setting_id."_flickr_uid_type" ].';';
    $record .= 'flickr-set='.str_replace(' ','',strip_tags($_POST[ $uftp_setting_id."_flickr_set" ])).';';
    $record .= 'flickr-tags='.str_replace(' ','',strip_tags($_POST[ $uftp_setting_id."_flickr_tags" ])).';';
    $record .= 'flickr-display-link='.isset($_POST[ $uftp_setting_id."_flickr_display_link" ]).';';
    $record .= 'flickr-size='.$_POST[ $uftp_setting_id."_flickr_size_opt" ].';';
    $record .= 'tumblr-custom-link='.isset($_POST[ $uftp_setting_id."_tumblr_custom_link" ]).';';
    $tumblr_uid = strip_tags($_POST[ $uftp_setting_id."_tumblr_uid" ]);
    if(isset($_POST[ $uftp_setting_id."_tumblr_custom_link" ])){
      $tumblr_uid = str_replace('http://','',$tumblr_uid); // Filter custom Tumbrl url
      $tumblr_uid = str_replace(array('/',' '),'',$tumblr_uid);
    }
    $record .= 'tumblr-uid='.$tumblr_uid.';';
    $record .= 'tumblr-display-link='.isset($_POST[ $uftp_setting_id."_tumblr_display_link" ]).';';        
    $record .= 'tumblr-size='.$_POST[ $uftp_setting_id."_tumblr_size_opt" ].';'; 
    $record .= 'pinterest-uid='.str_replace(' ','',strip_tags($_POST[ $uftp_setting_id."_pinterest_uid" ])).';'; 
    $record .= 'pinterest-display-link='.isset($_POST[ $uftp_setting_id."_pinterest_display_link" ]).';'; 
    $record .= 'pinterest-link-style='.$_POST[ $uftp_setting_id."_pinterest_linl_style" ].';';
    $record .= 'pinterest-size='.$_POST[ $uftp_setting_id."_pinterest_size_opt" ].';'; 
    $record .= 'style='.$_POST[ $uftp_setting_id."_style_opt" ].';'; 
    $record .= 'vertical-num='.$_POST[ $uftp_setting_id."_vertical_num" ].';'; 
    $record .= 'tile-shape='.$_POST[ $uftp_setting_id."_tile_shape" ].';'; 
    $record .= 'tile-num='.$_POST[ $uftp_setting_id."_tile_num" ].';'; 
    $record .= 'slideshow-style='.$_POST[ $uftp_setting_id."_slideshow_style" ].';'; 
    $record .= 'slideshow-num='.$_POST[ $uftp_setting_id."_slideshow_num" ].';'; 
    $record .= 'slideshow-fixed-height='.isset($_POST[ $uftp_setting_id."_slideshow_fixed_height" ]).';';  
    $record .= 'slideshow-remove-NextPrev='.isset($_POST[ $uftp_setting_id."_slideshow_remove_NextPrev" ]).';';        
    $record .= 'align='.$_POST[ $uftp_setting_id."_align" ].';';   
    $record .= 'reduced-width='.strip_tags($_POST[ $uftp_setting_id."_reduced_width" ]).';';   
    $record .= 'disable-eth-link='.isset($_POST[ $uftp_setting_id."_disable_eth_link" ]).';';   
    $raw_opt_val = $record;

    // Save the posted value in the database
    update_option( $opt_name, $raw_opt_val );
    
    $show_shortcode = true;
    /*
    // Put an settings updated message on the screen
    ?><div class="updated"><p><strong><?php _e('settings saved.', 'uftp-photo' ); ?></strong></p></div><?php
    */

  }
    
  // Read in the existing (i.e. new) option value from database
  $options = array();
  $raw_opt_val = get_option( $opt_name );
  $raw_opt_val = explode(";", $raw_opt_val);
  foreach($raw_opt_val as $opt){
    $opt = explode("=", $opt);
    $options[$opt[0]] = $opt[1];
  }

  // Now display the settings editing screen

  echo '<div class="wrap">';

  // header

  echo "<h2>" . __( 'Ultimate Photo Shortcode Generator', 'uftp-photo' ) . "</h2>";

  // settings form
  
  ?>
  <p><?php _e('This page will create shortcodes allowing you to insert the Ultimate Photo Widget into any post or page.'); ?></p>
  <form name="form1" method="post" action="">
  <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
  
  <div id="big-right-left-container">
    <div id="big-left" style="float:left;">
      <div id="uftp-right-left-container">
        <?php ////////////////////////////////////////// Left Options ///////////////////////////////////////////////////?>
        <div id="uftp-left-options">

          <p><label for="<?php echo $uftp_setting_id; ?>_source_opt" ><?php _e('Select Image Source: ');?>
          <select onchange="javascript: uftpToggleSourceMenu('<?php echo $uftp_setting_id; ?>_source_opt');" id="<?php echo $uftp_setting_id; ?>_source_opt" name="<?php echo $uftp_setting_id; ?>_source_opt"  >
            <option label="{ Flickr }" value="flickr" <?php if($options['source'] == 'flickr') { echo 'selected'; } ?>>{ Flickr }</option>
            <option label="{ Tumblr }" value="tumblr" <?php if($options['source'] == 'tumblr') { echo 'selected'; } ?>>{ Tumblr }</option>
            <option label="{ Pinterest }" value="pinterest" <?php if($options['source'] == 'pinterest') { echo 'selected'; } ?>>{ Pinterest }</option>
          </select></label> </p>
          
          <?php//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
          
          <div id="uftp-source-opt-containter">
          <?php /////////////////////////////////////////////////////////////////////////////////////////////////
                ////////////////////////////////////       FLICKR        ////////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
                
            <div id="<?php echo $uftp_setting_id; ?>_source_opt_flickr_opt">
            
              <p><label for="<?php echo $uftp_setting_id; ?>_flickr_uid_type" ><?php _e('Retrieve Photos From: ');?></label>       
              <select id="<?php echo $uftp_setting_id; ?>_flickr_uid_type" name="<?php echo $uftp_setting_id; ?>_flickr_uid_type" onchange="javascript: uftpToggleFlickrMenu('<?php echo $uftp_setting_id; ?>_flickr_uid_type');">
                <?php foreach (array("user","favorites","group","set","community") as $i) { ?>
                  <option <?php if ($options['flickr-uid-type'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>         
              </select></p>
            
              <?php ///// User and Group ID ////// ?>
              <div id="<?php echo $uftp_setting_id; ?>_flickr_uid_type_id">
                <label for="<?php echo $uftp_setting_id; ?>_flickr_uid">
                <span id="<?php echo $uftp_setting_id; ?>_flickr_uid_type_user"><?php _e('Flickr User ID: '); ?></span>
                <span id="<?php echo $uftp_setting_id; ?>_flickr_uid_type_group"><?php _e('Flickr Group ID: '); ?></span>
                <input id="<?php echo $uftp_setting_id; ?>_flickr_uid" name="<?php echo $uftp_setting_id; ?>_flickr_uid" type="text" style="width: 150px" value="<?php echo esc_attr($options['flickr-uid']); ?>" /></label>

                <div id="<?php echo $uftp_setting_id; ?>_flickr_uid_type_get_ID"><small><em>Don't know the ID? Use <a href="http://idgettr.com/" target="_blank">http://idgettr.com/</a> to find it.<br /><br /></em></small></div>
                
                <label id="<?php echo $uftp_setting_id; ?>_flickr_uid_type_set" for="<?php echo $uftp_setting_id; ?>_flickr_uid_type_set">
                <p><?php _e('Set ID: '); ?>
                <input id="<?php echo $uftp_setting_id; ?>_flickr_set" name="<?php echo $uftp_setting_id; ?>_flickr_set" type="text" style="width: 190px" value="<?php echo esc_attr($options['flickr-set']); ?>" />
                <small><em><br \>The Set ID is the number in the set url.</em></small></p>
                </label>
              </div>
              
              <div id="<?php echo $uftp_setting_id; ?>_flickr_uid_type_community"  >
                <p>
                <label for="<?php echo $uftp_setting_id; ?>_flickr_tags"><?php _e('Tag(s): '); ?>
                <input id="<?php echo $uftp_setting_id; ?>_flickr_tags" name="<?php echo $uftp_setting_id; ?>_flickr_tags" type="text" style="width: 200px" value="<?php echo esc_attr($options['flickr-tags']); ?>" /></label><br \>
                <small style="padding-left:70px;"><em>Comma seperated, no spaces</em></small>
                </p>
              </div>
              
              <script type="text/javascript">
              jQuery(window).load(function() {
                uftpLoadFlickrMenu('<?php echo $uftp_setting_id; ?>_flickr_uid_type');
              });
              uftpLoadFlickrMenu('<?php echo $uftp_setting_id; ?>_flickr_uid_type');
              </script>
              
              <p><label for="<?php echo $uftp_setting_id; ?>_flickr_display_link" style="line-height:15px;"><input id="<?php echo $uftp_setting_id; ?>_flickr_display_link" name="<?php echo $uftp_setting_id; ?>_flickr_display_link" type="checkbox" value="1" <?php checked(isset($options['flickr-display-link']) ? $options['flickr-display-link'] : 0); ?> /><?php _e(' Display Link to Flickr Page'); ?></label></p>
                        
              <label for="<?php echo $uftp_setting_id; ?>_flickr_size_opt">
              <?php _e('Select Photo Size: ');?>        
              <select name="<?php echo $uftp_setting_id; ?>_flickr_size_opt" id="<?php echo $uftp_setting_id; ?>_flickr_size_opt">
                <?php foreach (array(75,100,240,500,640) as $i) { ?>
                  <option <?php if ($options['flickr-size'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i."px"; ?></option>
                <?php } ?>         
              </select></label>

              <br \><small style="padding-left:10px;"><em>Size is length of longest side<br /><br /></em></small>
            </div>
            
          <?php /////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////       TUMBLR         ////////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
                
            <div id="<?php echo $uftp_setting_id; ?>_source_opt_tumblr_opt" >
            
              <p><label for="<?php echo $uftp_setting_id; ?>_tumblr_uid"><?php _e('Tumblr ID: '); ?>
              <input class="widefat" id="<?php echo $uftp_setting_id; ?>_tumblr_uid" name="<?php echo $uftp_setting_id; ?>_tumblr_uid" type="text" style="width: 100px" value="<?php echo esc_attr($options['tumblr-uid']); ?>" />
              <span id="<?php echo $uftp_setting_id; ?>_tumblr_uid_label"><?php _e('.tumblr.com');?></span></label></p>
              
              <p><label for="<?php echo $uftp_setting_id; ?>_tumblr_custom_link">
              <input onchange="javascript: uftpToggleCustomTubmlrURL('<?php echo $uftp_setting_id; ?>_tumblr_custom_link','<?php echo $uftp_setting_id; ?>_tumblr_uid');" id="<?php echo $uftp_setting_id; ?>_tumblr_custom_link" name="<?php echo $uftp_setting_id; ?>_tumblr_custom_link" type="checkbox" value="1" <?php checked(isset($options['tumblr-custom-link']) ? $options['tumblr-custom-link'] : 0); ?> /><?php _e(' Use Custom Tumblr URL <br />(e.g. www.your-name.com)'); ?></label></p>

              <p><label for="<?php echo $uftp_setting_id; ?>_tumblr_display_link">
              <input id="<?php echo $uftp_setting_id; ?>_tumblr_display_link" name="<?php echo $uftp_setting_id; ?>_tumblr_display_link" type="checkbox" value="1" <?php checked(isset($options['tumblr-display-link']) ? $options['tumblr-display-link'] : 0); ?> /><?php _e(' Display Link to Tumblr Page'); ?></label></p>
               
              <p><label for="<?php echo $uftp_setting_id; ?>_tumblr_size_opt"><?php _e('Select Photo Width: ');?>        
              <select name="<?php echo $uftp_setting_id; ?>_tumblr_size_opt" id="<?php echo $uftp_setting_id; ?>_tumblr_size_opt">
                <?php foreach (array(75,100,250,400,500) as $i) { ?>
                  <option <?php if ($options['tumblr-size'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i."px"; ?></option>
                <?php } ?>    
              </select></label></p>
              
              <script type="text/javascript">
              jQuery(window).load(function() {
                uftpLoadCustomTubmlrURL('<?php echo $uftp_setting_id; ?>_tumblr_custom_link','<?php echo $uftp_setting_id; ?>_tumblr_uid');
              });
              uftpLoadCustomTubmlrURL('<?php echo $uftp_setting_id; ?>_tumblr_custom_link','<?php echo $uftp_setting_id; ?>_tumblr_uid');
              </script>

            </div>
            
          <?php /////////////////////////////////////////////////////////////////////////////////////////////////
                ////////////////////////////////////     PINTEREST        ///////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
                
            <div id="<?php echo $uftp_setting_id; ?>_source_opt_pinterest_opt" >
            
              <p><label for="<?php echo $uftp_setting_id; ?>_pinterest_uid"><?php _e('Pinterest ID: '); ?>
              <input class="widefat" id="<?php echo $uftp_setting_id; ?>_pinterest_uid" name="<?php echo $uftp_setting_id; ?>_pinterest_uid" type="text" style="width: 100px" value="<?php echo esc_attr($options['pinterest-uid']); ?>" />
              </label></p>

              <p><label for="<?php echo $uftp_setting_id; ?>_pinterest_display_link">
              <input id="<?php echo $uftp_setting_id; ?>_pinterest_display_link" name="<?php echo $uftp_setting_id; ?>_pinterest_display_link" type="checkbox" value="1" <?php checked(isset($options['pinterest-display-link']) ? $options['pinterest-display-link'] : 0); ?> />
              <?php _e(' Display Link to Pinterest Page'); ?></label></p>
              
              <p><label for="<?php echo $uftp_setting_id; ?>_pinterest_linl_style" ><?php _e('Link Style: '); ?>
              <select id="<?php echo $uftp_setting_id; ?>_pinterest_linl_style" name="<?php echo $uftp_setting_id; ?>_pinterest_linl_style"  >
                <option label="Text Link" value="text" <?php if($options['pinterest-link-style'] == 'text') { echo 'selected'; } ?>>Text</option>
                <option label="Large Button" value="large" <?php if($options['pinterest-link-style'] == 'large') { echo 'selected'; } ?>>Large</option>
                <option label="Medium Button" value="medium" <?php if($options['pinterest-link-style'] == 'medium') { echo 'selected'; } ?>>Medium</option>
                <option label="Small Button" value="small" <?php if($options['pinterest-link-style'] == 'small') { echo 'selected'; } ?>>Small</option>
                <option label="Tiny Button" value="tiny" <?php if($options['pinterest-link-style'] == 'tiny') { echo 'selected'; } ?>>Tiny</option>
              </select></label></p>
               
              <p><label for="<?php echo $uftp_setting_id; ?>_pinterest_size_opt"><?php _e('Select Photo Width (approx): ');?>        
              <select name="<?php echo $uftp_setting_id; ?>_pinterest_size_opt" id="<?php echo $uftp_setting_id; ?>_pinterest_size_opt">
                <?php foreach (array(75,192,554,600,930) as $i) { ?>
                  <option <?php if ($options['pinterest-size'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>">
                  <?php if($i==930){echo 'original';}else{echo $i."px";} ?></option>
                <?php } ?>          
              </select></label></p>         
            </div>
          </div><!-- close source-opt-containter -->
          
          <script type="text/javascript">
          // Make sure toggle is done corrently when page first loads
          jQuery(window).load(function() {
            uftpLoadSourceMenu('<?php echo $uftp_setting_id; ?>_source_opt');
          });
          // and toggle again upon saving
          uftpLoadSourceMenu('<?php echo $uftp_setting_id; ?>_source_opt');
          </script>         
        </div>   
        
          <?php ////////////////////////////////////////// Right Options ///////////////////////////////////////////////////?>    
          <?php//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?> 
        <div id="uftp-right-options">
          <p><label for="<?php echo $uftp_setting_id; ?>_style_opt"  title="" ><?php _e('Select Display Style: ');?>
          <select onchange="javascript: uftpToggleStyleMenu('<?php echo $uftp_setting_id; ?>_style_opt');" name="<?php echo $uftp_setting_id; ?>_style_opt" id="<?php echo $uftp_setting_id; ?>_style_opt" >
            <option label="{ Vertical }" value="vertical" <?php if($options['style'] == 'vertical') { echo 'selected'; } ?>>{ Vertical }</option>
            <option label="{ Tiles }" value="tiles" <?php if($options['style'] == 'tiles') { echo 'selected'; } ?>>{ Tiles }</option>
            <option label="{ Slideshow }" value="slideshow" <?php if($options['style'] == 'slideshow') { echo 'selected'; } ?>>{ Slideshow }</option>
          </select></label></p>
          
          <?php//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
          
          <div id="uftp-style-opt-containter">
          
          <?php /////////////////////////////////////////////////////////////////////////////////////////////////
                ////////////////////////////////////      Vertical       ////////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
            <div id="<?php echo $uftp_setting_id; ?>_style_opt_vertical" >
              <p><label for="<?php echo $uftp_setting_id; ?>_vertical_num"><?php _e('Select Number of Photos: ');?>        
              <select id="<?php echo $uftp_setting_id; ?>_vertical_num" name="<?php echo $uftp_setting_id; ?>_vertical_num" >
                <?php for ($i=1; $i<=20; $i++) { ?>
                  <option <?php if ($options['vertical-num'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>        
              </select></label></p>
            </div>
            
          <?php /////////////////////////////////////////////////////////////////////////////////////////////////
                //////////////////////////////////        Tiles          ////////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
            <div id="<?php echo $uftp_setting_id; ?>_style_opt_tiles" >
              <p><label for="<?php echo $uftp_setting_id; ?>_tile_shape"> <?php _e('Select Tile Shape: ');?>
              <select id="<?php echo $uftp_setting_id; ?>_tile_shape" name="<?php echo $uftp_setting_id; ?>_tile_shape" >
                <option label="Square" value="square" <?php if($options['tile-shape'] == 'square') { echo 'selected'; } ?>>Square</option>
                <option label="Rectangle" value="rectangle" <?php if($options['tile-shape'] == 'rectangle') { echo 'selected'; } ?>>Rectangle</option>        
              </select></label></p>
              <p><label for="<?php echo $uftp_setting_id; ?>_tile_num"> <?php _e('Select Number of Photos: ');?>
              <select id="<?php echo $uftp_setting_id; ?>_tile_num" name="<?php echo $uftp_setting_id; ?>_tile_num" >
                <?php foreach (array(1,3,4,6,7,9,10,12,13,15,16,18,19) as $i) { ?>
                  <option <?php if ($options['tile-num'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>        
              </select></label></p>
              <p><?php _e('- Photos will be cropped to fit.'); ?><br \>  
              <?php _e('- Might require Reduced Photo Width.'); ?></p>  
            </div>
            
          <?php /////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////      Slideshow        ///////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
            <div id="<?php echo $uftp_setting_id; ?>_style_opt_slideshow" >
              <label for="<?php echo $uftp_setting_id; ?>_slideshow_style"><?php _e('Slideshow Style: ');?>	
              <select id="<?php echo $uftp_setting_id; ?>_slideshow_style" name="<?php echo $uftp_setting_id; ?>_slideshow_style" >
                <option label="Rotate" value="1" <?php if($options['slideshow-style'] == '1') { echo 'selected'; } ?>>Rotate</option>
                <option label="Fade" value="2" <?php if($options['slideshow-style'] == '2') { echo 'selected'; } ?>>Fade</option>
                <option label="Shutter" value="3" <?php if($options['slideshow-style'] == '3') { echo 'selected'; } ?>>Shutter</option>   
              </select></label><br \>
            
              <label for="<?php echo $uftp_setting_id; ?>_slideshow_num"><?php _e('Select Number of Photos: ');?>	
              <select id="<?php echo $uftp_setting_id; ?>_slideshow_num" name="<?php echo $uftp_setting_id; ?>_slideshow_num" >
                <?php for ($i=2; $i<=20; $i++) { ?>
                  <option <?php if ($options['slideshow-num'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>        
              </select></label><br \>
              
              <p><label for="<?php echo $uftp_setting_id; ?>_slideshow_fixed_height" >
              <input id="<?php echo $uftp_setting_id; ?>_slideshow_fixed_height" name="<?php echo $uftp_setting_id; ?>_slideshow_fixed_height" type="checkbox" value="1" <?php checked(isset($options['slideshow-fixed-height']) ? $options['slideshow-fixed-height'] : 0); ?> />
              <?php _e(' Maintain Fixed Height'); ?></label></p>
              
              <p><label for="<?php echo $uftp_setting_id; ?>_slideshow_remove_NextPrev" >
              <input id="<?php echo $uftp_setting_id; ?>_slideshow_remove_NextPrev" name="<?php echo $uftp_setting_id; ?>_slideshow_remove_NextPrev" type="checkbox" value="1" <?php checked(isset($options['slideshow-remove-NextPrev']) ? $options['slideshow-remove-NextPrev'] : 0); ?> />
              <?php _e(' Remove "Next" and "Prev"'); ?></label></p>
        
              <p> <?php _e('- Might require Reduced Photo Width.'); ?></p>  
            </div> 
          </div><!-- close style-opt-containter -->
          
          <script type="text/javascript">
          jQuery(window).load(function() {
            uftpLoadStyleMenu('<?php echo $uftp_setting_id; ?>_style_opt');
          });
          uftpLoadStyleMenu('<?php echo $uftp_setting_id; ?>_style_opt');
          </script>
        </div><!-- close right-options -->
        
        <br clear="all"/>
        
        <?php//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
        <div id="<?php echo $uftp_setting_id; ?>_additional_options" style="width:550px">
          <p><label for="<?php echo $uftp_setting_id; ?>_align" ><?php _e('Photo Alignment: ');?>  
          <select id="<?php echo $uftp_setting_id; ?>_align" name="<?php echo $uftp_setting_id; ?>_align" >
            <?php foreach (array('left','center','right') as $i) { ?>
              <option <?php if ($options['align'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>       
          </select></label>   

          <label for="<?php echo $uftp_setting_id; ?>_reduced_width" style="padding-left:25px;">
          <?php _e('Reduced Photo Width (<a href="#" class="reduced-width-link">What is this?</a>):  '); ?>
          <input class="widefat" id="<?php echo $uftp_setting_id; ?>_reduced_width" name="<?php echo $uftp_setting_id; ?>_reduced_width" type="text" style="width: 40px" value="<?php echo esc_attr($options['reduced-width']); ?>" />
          <?php _e('px'); ?></label></p>
            
          <p><label for="<?php echo $uftp_setting_id; ?>_disable_eth_link" >
          <input id="<?php echo $uftp_setting_id; ?>_disable_eth_link" name="<?php echo $uftp_setting_id; ?>_disable_eth_link" type="checkbox" value="1" <?php checked(isset($options['disable-eth-link']) ? $options['disable-eth-link'] : 0); ?> />
          <?php _e(' Disable the tiny white link I have placed in the bottom left corner, though I have spent months developing this plugin and would appreciate the link.'); ?></label></p>
        </div><!-- close additional-options -->    
      </div><!-- close uftp-right-left-container -->
    </div><!-- close big-left-container -->
    
    <div id="big-right-container" style="float:left;width:500px;margin:20px;">
      <div id="<?php echo $uftp_setting_id; ?>_description" style="position:relative;width:500px;overflow:hidden;">
        <div id="<?php echo $uftp_setting_id; ?>_description_text">
          <b>Reduced Photo Width Explanation:</b> <br \>
          If photos are not being resized, cropped, or positioned correctly, (or if you would like a smaller photo size) 
          use the Reduced Photo Width option. Otherwise, leave the option blank. <br \>
          - The Reduced Photo Width should be less than the Selected Photo Width/Size. <br \>
          - For sidebars, between 200 and 250px is usually good. <br \>
          - Decrease Reduced Photo Width until issue is resolved. <br \>
          <br clear="all"/>
        </div>
      </div><!-- close text -->
      <div id="<?php echo $uftp_setting_id; ?>_links">
        <b>Useful Links:</b><br \>
        To see examples of each display type, visit <a href="http://kylinuntitled.com/ultimate-photo-widget/" target="_blank">Kylin Untitled. </a><br \>
        For the full description and explanation of functionality, visit <a href="http://electrictreehouse.com/ultimate-photo-widget/" target="_blank">Electric Tree House.</a><br \>
        Please continue to inform me of errors at <a href="http://electrictreehouse.com/ultimate-photo-widget/" target="_blank">Electric Tree House.</a><br \><br \>
        <b>Thank you for the donations:</b><br \>
        <p style="text-align: left;"><a title="Donate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=electrictreehouse%40gmail%2ecom&lc=US&item_name=Electric%20Tree%20House&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted" target="_blank"><button><img class="size-full wp-image-1537 aligncenter" title="Donate" src="<?php echo $donate_button ?>" alt="" width="147" height="47" /></button></a></p>
      </div>       
    </div><!-- close big-right-container -->
  </div><!-- close big-right-left-container -->
  <br clear="all"/>
  
    <script type="text/javascript">
    jQuery("#<?php echo $uftp_setting_id; ?>_description").height(0);
    jQuery(".reduced-width-link").click(function(event) {
      event.preventDefault();
      var h = jQuery("#<?php echo $uftp_setting_id; ?>_description_text").height();
      jQuery("#<?php echo $uftp_setting_id; ?>_description").animate({height:h}, 1000);
    });      
    </script>
      
    <p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes and Generate Shortcode') ?>" />
    </p>

  </form>

  <?php 
  if($show_shortcode){
    $short = '[ultimate-photo source="'.$options['source'].'" ';
    switch($options['source']){
      case "flickr":
        $short .= 'type="'.$options['flickr-uid-type'].'" ';
        if($options['flickr-uid-type']=='set'){
          $short .= 'set="'.$options['flickr-set'].'" ';
          $short .= 'uid="'.$options['flickr-uid'].'" ';
        }
        elseif($options['flickr-uid-type']=='community'){
          $short .= 'tags="'.$options['flickr-tags'].'" ';      
        }else{
          $short .= 'uid="'.$options['flickr-uid'].'" ';
        }
        if($options['flickr-display-link']){
          $short .= 'display_link="'.$options['flickr-display-link'].'" ';  
        }
        $short .= 'size="'.$options['flickr-size'].'" ';        
      break;
      case "tumblr":    
        $short .= 'uid="'.$options['tumblr-uid'].'" '; 
        if($options['tumblr-custom-link']){
          $short .= 'custom="'.$options['tumblr-custom-link'].'" ';  
        }      
        if($options['tumblr-display-link']){
          $short .= 'display_link="'.$options['tumblr-display-link'].'" ';  
        }
        $short .= 'size="'.$options['tumblr-size'].'" ';  
      break;
      case "pinterest":
        $short .= 'uid="'.$options['pinterest-uid'].'" ';      
        if($options['pinterest-display-link']){
          $short .= 'display_link="'.$options['pinterest-display-link'].'" ';  
          $short .= 'link_style="'.$options['pinterest-link-style'].'" ';  
        }
        $short .= 'size="'.$options['pinterest-size'].'" ';  
      break;
    }
    $short .= 'style="'.$options['style'].'" '; 
    switch ($options['style']) {
      case "vertical":
        $short .= 'num="'.$options['vertical-num'].'" ';   
      break;
      case "tiles":
        $short .= 'num="'.$options['tile-num'].'" ';   
        $short .= 'shape="'.$options['tile-shape'].'" ';   
      break;
      case "slideshow":
        $short .= 'num="'.$options['slideshow-num'].'" ';   
        $short .= 'slideshow_style="'.$options['slideshow-style'].'" ';  
        if($options['slideshow-fixed-height']){
          $short .= 'fixed_height="'.$options['slideshow-fixed-height'].'" '; 
        }
        if($options['slideshow-remove-NextPrev']){
          $short .= 'remove_np="'.$options['slideshow-remove-NextPrev'].'" ';    
        }
      break;
    }
    $short .= 'align="'.$options['align'].'" ';  
    
    $reduced_width = apply_filters( 'uftp_photo', is_numeric($options['reduced-width']) ? $options['reduced-width'] : NULL, $options );   
    if($reduced_width){
      $short .= 'reduced_width="'.$options['reduced-width'].'" ';    
    }
    if($options['disable-eth-link']){
      $short .= 'disable_link="'.$options['disable-eth-link'].'" ';      
    }
    $short .= ']';
    
    echo '<p style="padding:5px;"> Now, copy (Crtl+C) and paste (Crtl+P) the following shortcode into a page or post. </p>';
    
    echo '<textarea class="auto_select" style="height:auto;width:90%;background:#E0E0E0;padding:10px;">'.$short.'</textarea><br clear="all"/>';

    echo '    
    <script type="text/javascript">
    jQuery(".auto_select").mouseenter(function(){
      jQuery(this).select();
    }); 
    </script>';

  }


  ?>

  </div>

