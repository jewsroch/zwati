<?php
/**
 * The PHP for widget form function
 *
 * @since Ultimate Photo Widget 2.0.2
 *
 */

 ?>
 
 <?php
 
  $defaults = array( 'title' => '', 'source-opt'=>'flickr','style-opt'=>'vertical','align-opt'=>'center');
	$options = wp_parse_args( (array) $options, $defaults );
  $title = strip_tags($options['title']);
    
  ?>
    
  <div id="uftp-right-left-container">
  
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" style="width: 230px" value="<?php echo esc_attr($title); ?>" /></label>
    <br clear="all" /><br />

    <?php ////////////////////////////////////////// Left Options ///////////////////////////////////////////////////?>
    <div id="uftp-left-options">

      <p><label for="<?php echo $this->get_field_id('source-opt'); ?>" ><?php _e('Select Image Source: ');?>
      <select onchange="javascript: uftpToggleSourceMenu('<?php echo $this->get_field_id( 'source-opt' ); ?>');" id="<?php echo $this->get_field_id('source-opt'); ?>" name="<?php echo $this->get_field_name('source-opt'); ?>"  >
        <option label="[ Flickr ]" value="flickr" <?php if($options['source-opt'] == 'flickr') { echo 'selected'; } ?>>{ Flickr }</option>
        <option label="[ Tumblr ]" value="tumblr" <?php if($options['source-opt'] == 'tumblr') { echo 'selected'; } ?>>{ Tumblr }</option>
        <option label="[ Pinterest ]" value="pinterest" <?php if($options['source-opt'] == 'pinterest') { echo 'selected'; } ?>>{ Pinterest }</option>
      </select></label> </p>
      
      <?php//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
      
      <div id="uftp-source-opt-containter">
      <?php /////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////       FLICKR        ////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
            
        <div id="<?php echo $this->get_field_id('source-opt'); ?>_flickr_opt">
        
          <p><label for="<?php echo $this->get_field_id('flickr-uid-type'); ?>" ><?php _e('Retrieve Photos From: ');?></label>       
          <select id="<?php echo $this->get_field_id( 'flickr-uid-type' ); ?>" name="<?php echo $this->get_field_name( 'flickr-uid-type' ); ?>" onchange="javascript: uftpToggleFlickrMenu('<?php echo $this->get_field_id( 'flickr-uid-type' ); ?>');">
            <?php foreach (array("user","favorites","group","set","community") as $i) { ?>
              <option <?php if ($options['flickr']['uid-type'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>         
          </select></p>
        
          <?php ///// User and Group ID ////// ?>
          <div id="<?php echo $this->get_field_id( 'flickr-uid-type' ); ?>_id">
            <label for="<?php echo $this->get_field_id('flickr-uid'); ?>">
            <span id="<?php echo $this->get_field_id( 'flickr-uid-type' ); ?>_user"><?php _e('Flickr User ID: '); ?></span>
            <span id="<?php echo $this->get_field_id( 'flickr-uid-type' ); ?>_group"><?php _e('Flickr Group ID: '); ?></span>
            <input id="<?php echo $this->get_field_id('flickr-uid'); ?>" name="<?php echo $this->get_field_name('flickr-uid'); ?>" type="text" style="width: 150px" value="<?php echo esc_attr($options['flickr']['uid']); ?>" /></label>

            <div id="<?php echo $this->get_field_id( 'flickr-uid-type' ); ?>_get_ID"><small><em><?php _e("Don't know the ID? Use ", UPWbyETH_DOMAIN); ?><a href="http://idgettr.com/" target="_blank">idgettr.com</a><?php _e(" to find it.", UPWbyETH_DOMAIN); ?><br><br></em></small></div>
            
            <label id="<?php echo $this->get_field_id( 'flickr-uid-type' ); ?>_set" for="<?php echo $this->get_field_id('flickr-set-id'); ?>">
            <p><?php _e('Set ID: '); ?>
            <input id="<?php echo $this->get_field_id('flickr-set-id'); ?>" name="<?php echo $this->get_field_name('flickr-set-id'); ?>" type="text" style="width: 190px" value="<?php echo esc_attr($options['flickr']['set-id']); ?>" />
            <small><em><br><?php _e("The Set ID is the number in the set URL.", UPWbyETH_DOMAIN); ?></em></small></p>
            </label>
          </div>
          
          <div id="<?php echo $this->get_field_id( 'flickr-uid-type' ); ?>_community"  >
            <p>
            <label for="<?php echo $this->get_field_id('flickr-tags'); ?>"><?php _e('Tag(s): '); ?>
            <input id="<?php echo $this->get_field_id('flickr-tags'); ?>" name="<?php echo $this->get_field_name('flickr-tags'); ?>" type="text" style="width: 200px" value="<?php echo esc_attr($options['flickr']['tags']); ?>" /></label><br>
            <small style="padding-left:70px;"><em><?php _e("Comma seperated, no spaces", UPWbyETH_DOMAIN); ?></em></small>
            </p>
          </div>
          
          <script type="text/javascript">
          jQuery(window).load(function() {
            uftpLoadFlickrMenu('<?php echo $this->get_field_id( 'flickr-uid-type' ); ?>');
          });
          uftpLoadFlickrMenu('<?php echo $this->get_field_id( 'flickr-uid-type' ); ?>');
          </script>

          <p><label for="<?php echo $this->get_field_id('flickr-display-link'); ?>" style="line-height:15px;"><input id="<?php echo $this->get_field_id('flickr-display-link'); ?>" name="<?php echo $this->get_field_name('flickr-display-link'); ?>" type="checkbox" value="Yes" <?php checked(isset($options['flickr']['display-link']) ? $options['flickr']['display-link'] : 0); ?> /><?php _e(' Display Link to Flickr Page'); ?></label></p>
                    
          <label for="<?php echo $this->get_field_id('flickr-size-opt'); ?>">
          <?php _e('Select Photo Size: ');?>        
          <select name="<?php echo $this->get_field_name( 'flickr-size-opt' ); ?>" id="<?php echo $this->get_field_id( 'flickr-size-opt' ); ?>">
            <?php foreach (array(75,100,240,500,640) as $i) { ?>
              <option <?php if ($options['flickr']['size-opt'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i."px"; ?></option>
            <?php } ?>         
          </select></label>

          <br><small style="padding-left:10px;"><em><?php _e("Size is length of longest side", UPWbyETH_DOMAIN); ?><br><br></em></small>
        </div>
        
      <?php /////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////       TUMBLR         ////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
            
        <div id="<?php echo $this->get_field_id('source-opt'); ?>_tumblr_opt" >
        
          <p><label for="<?php echo $this->get_field_id('tumblr-uid'); ?>"><?php _e('Tumblr ID: '); ?>
          <input class="widefat" id="<?php echo $this->get_field_id('tumblr-uid'); ?>" name="<?php echo $this->get_field_name('tumblr-uid'); ?>" type="text" style="width: 100px" value="<?php echo esc_attr($options['tumblr']['uid']); ?>" />
          <span id="<?php echo $this->get_field_id('tumblr-uid'); ?>_label"><?php _e('.tumblr.com');?></span></label></p>
          
          <p><label for="<?php echo $this->get_field_id('tumblr-custom-link'); ?>">
          <input onchange="javascript: uftpToggleCustomTubmlrURL('<?php echo $this->get_field_id('tumblr-custom-link'); ?>','<?php echo $this->get_field_id( 'tumblr-uid' ); ?>');" id="<?php echo $this->get_field_id('tumblr-custom-link'); ?>" name="<?php echo $this->get_field_name('tumblr-custom-link'); ?>" type="checkbox" value="Yes" <?php checked(isset($options['tumblr']['custom-link']) ? $options['tumblr']['custom-link'] : 0); ?> /><?php _e(' Use Custom Tumblr URL <br />(e.g. google.com or www.google.com)'); ?></label></p>

          <p><label for="<?php echo $this->get_field_id('tumblr-display-link'); ?>">
          <input id="<?php echo $this->get_field_id('tumblr-display-link'); ?>" name="<?php echo $this->get_field_name('tumblr-display-link'); ?>" type="checkbox" value="Yes" <?php checked(isset($options['tumblr']['display-link']) ? $options['tumblr']['display-link']: 0); ?> /><?php _e(' Display Link to Tumblr Page'); ?></label></p>
           
          <p><label for="<?php echo $this->get_field_id('tumblr-size-opt'); ?>"><?php _e('Select Photo Width: ');?>        
          <select name="<?php echo $this->get_field_name( 'tumblr-size-opt' ); ?>" id="<?php echo $this->get_field_id( 'tumblr-size-opt' ); ?>">
            <?php foreach (array(75,100,250,400,500) as $i) { ?>
              <option <?php if ($options['tumblr']['size-opt'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i."px"; ?></option>
            <?php } ?>    
          </select></label></p>
          
          <script type="text/javascript">
          jQuery(window).load(function() {
            uftpLoadCustomTubmlrURL('<?php echo $this->get_field_id('tumblr-custom-link'); ?>','<?php echo $this->get_field_id( 'tumblr-uid' ); ?>');
          });
          uftpLoadCustomTubmlrURL('<?php echo $this->get_field_id('tumblr-custom-link'); ?>','<?php echo $this->get_field_id( 'tumblr-uid' ); ?>');
          </script>

        </div>
        
      <?php /////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////     PINTEREST        ///////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
            
        <div id="<?php echo $this->get_field_id('source-opt'); ?>_pinterest_opt" >
        
          <p><label for="<?php echo $this->get_field_id('pinterest-uid'); ?>"><?php _e('Pinterest ID: '); ?>
          <input class="widefat" id="<?php echo $this->get_field_id('pinterest-uid'); ?>" name="<?php echo $this->get_field_name('pinterest-uid'); ?>" type="text" style="width: 100px" value="<?php echo esc_attr($options['pinterest']['uid']); ?>" />
          </label></p>
          <p><label for="<?php echo $this->get_field_id('pinterest-specific-board'); ?>"><?php _e('Select Specific Board: '); ?>
          <input class="widefat" id="<?php echo $this->get_field_id('pinterest-specific-board'); ?>" name="<?php echo $this->get_field_name('pinterest-specific-board'); ?>" type="text" style="width: 120px" value="<?php echo esc_attr($options['pinterest']['specific-board']); ?>" />
          </label></p>
          
          <p><label for="<?php echo $this->get_field_id('pinterest-display-link'); ?>">
          <input id="<?php echo $this->get_field_id('pinterest-display-link'); ?>" name="<?php echo $this->get_field_name('pinterest-display-link'); ?>" type="checkbox" value="Yes" <?php checked(isset($options['pinterest']['display-link']) ? $options['pinterest']['display-link'] : 0); ?> />
          <?php _e(' Display Link to Pinterest Page'); ?></label></p>
          
          <p><label for="<?php echo $this->get_field_id('pinterest-link-style'); ?>" ><?php _e('Link Style: '); ?>
          <select id="<?php echo $this->get_field_id('pinterest-link-style'); ?>" name="<?php echo $this->get_field_name('pinterest-link-style'); ?>"  >
            <option label="Text Link" value="text" <?php if($options['pinterest']['link-style'] == 'text') { echo 'selected'; } ?>>Text</option>
            <option label="Large Button" value="large" <?php if($options['pinterest']['link-style'] == 'large') { echo 'selected'; } ?>>Large</option>
            <option label="Medium Button" value="medium" <?php if($options['pinterest']['link-style'] == 'medium') { echo 'selected'; } ?>>Medium</option>
            <?php /* <option label="Small Button" value="small" <?php if($options['pinterest']['link-style'] == 'small') { echo 'selected'; } ?>>Small</option> */?>
            <option label="Tiny Button" value="tiny" <?php if($options['pinterest']['link-style'] == 'tiny') { echo 'selected'; } ?>>Tiny</option>
          </select></label> </p>         
           
          <p><label for="<?php echo $this->get_field_id('pinterest-size-opt'); ?>"><?php _e('Select Photo Width (approx): ');?>        
          <select name="<?php echo $this->get_field_name( 'pinterest-size-opt' ); ?>" id="<?php echo $this->get_field_id( 'pinterest-size-opt' ); ?>">
            <?php foreach (array(75,192,554,600,930) as $i) { ?>
              <option <?php if ($options['pinterest']['size-opt'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>">
              <?php if($i==930){echo 'original';}else{echo $i."px";} ?></option>
            <?php } ?>          
          </select></label></p>         
        </div>
      </div><!-- close source-opt-containter -->
      
      <script type="text/javascript">
      // Make sure toggle is done corrently when page first loads
      jQuery(window).load(function() {
        uftpLoadSourceMenu('<?php echo $this->get_field_id( 'source-opt' ); ?>');
      });
      // and toggle again upon saving
      uftpLoadSourceMenu('<?php echo $this->get_field_id( 'source-opt' ); ?>');
      </script>         
    </div>   
      <?php/////////////////////////////////////////////////////////////////////////////////////////////////////////////?>     
      <?php ////////////////////////////////////////// Right Options ///////////////////////////////////////////////////?>    
      <?php/////////////////////////////////////////////////////////////////////////////////////////////////////////////?> 
     <div id="uftp-right-options">
      <p><label for="<?php echo $this->get_field_id('style-opt'); ?>"  title="" ><?php _e('Select Display Style: ');?>
      <select onchange="javascript: uftpToggleStyleMenu('<?php echo $this->get_field_id( 'style-opt' ); ?>');" name="<?php echo $this->get_field_name('style-opt'); ?>" id="<?php echo $this->get_field_id('style-opt'); ?>" >
        <option label="[ Vertical ]" value="vertical" <?php if($options['style-opt'] == 'vertical') { echo 'selected'; } ?>>{ Vertical }</option>
        <option label="[ Tiles ]" value="tiles" <?php if($options['style-opt'] == 'tiles') { echo 'selected'; } ?>>{ Tiles }</option>
        <option label="[ Slideshow ]" value="slideshow" <?php if($options['style-opt'] == 'slideshow') { echo 'selected'; } ?>>{ Slideshow }</option>
        <?php /* <option label="{ Gallery }" value="gallery" <?php if($options['style-opt'] == 'gallery') { echo 'selected'; } ?>>{ Gallery }</option> */ ?>
      </select></label></p>
      
      <?php//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
      
      <div id="uftp-style-opt-containter">
      
      <?php /////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////      Vertical       ////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
        <div id="<?php echo $this->get_field_id( 'style-opt' ); ?>_vertical" >
          <p><label for="<?php echo $this->get_field_id('vertical-num-items'); ?>"><?php _e('Select Number of Photos: ');?>        
          <select id="<?php echo $this->get_field_id( 'vertical-num-items' ); ?>" name="<?php echo $this->get_field_name( 'vertical-num-items' ); ?>" >
            <?php for ($i=1; $i<=20; $i++) { ?>
              <option <?php if ($options['vertical']['num-items'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>        
          </select></label></p>
        </div>
        
      <?php /////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////        Tiles          ////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
        <div id="<?php echo $this->get_field_id( 'style-opt' ); ?>_tiles" >
          <p><label for="<?php echo $this->get_field_id( 'tiles-shape' ); ?>"> <?php _e('Select Tile Shape: ');?>
          <select id="<?php echo $this->get_field_id( 'tiles-shape' ); ?>" name="<?php echo $this->get_field_name( 'tiles-shape' ); ?>" >
            <option label="Square" value="square" <?php if($options['tiles']['shape'] == 'square') { echo 'selected'; } ?>>Square</option>
            <option label="Rectangle" value="rectangle" <?php if($options['tiles']['shape'] == 'rectangle') { echo 'selected'; } ?>>Rectangle</option>   
          </select></label></p>
          <p><label for="<?php echo $this->get_field_id('tiles-num-items'); ?>"> <?php _e('Select Number of Photos: ');?>
          <select id="<?php echo $this->get_field_id( 'tiles-num-items' ); ?>" name="<?php echo $this->get_field_name( 'tiles-num-items' ); ?>" >
            <?php foreach (array(1,3,4,6,7,9,10,12,13,15,16,18,19) as $i) { ?>
              <option <?php if ($options['tiles']['num-items']  == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>        
          </select></label></p>
          <p><?php _e('- Photos will be cropped to fit.'); ?><br>  
          <?php _e('- Might require Reduced Photo Width.'); ?></p>  
        </div>
 
      <?php /////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////      Slideshow        ///////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
        <div id="<?php echo $this->get_field_id( 'style-opt' ); ?>_slideshow" >
          <p><label for="<?php echo $this->get_field_id('slideshow-style'); ?>"><?php _e('Slideshow Style: ');?>	
          <select id="<?php echo $this->get_field_id( 'slideshow-style' ); ?>" name="<?php echo $this->get_field_name( 'slideshow-style' ); ?>" >
            <option label="Rotate" value="1" <?php if($options['slideshow']['style'] == '1') { echo 'selected'; } ?>>Rotate</option>
            <option label="Fade" value="2" <?php if($options['slideshow']['style'] == '2') { echo 'selected'; } ?>>Fade</option>
            <option label="Shutter" value="3" <?php if($options['slideshow']['style'] == '3') { echo 'selected'; } ?>>Shutter</option>   
          </select></label></p>
        
          <p><label for="<?php echo $this->get_field_id('slideshow-num-items'); ?>"><?php _e('Select Number of Photos: ');?>	
          <select id="<?php echo $this->get_field_id( 'slideshow-num-items' ); ?>" name="<?php echo $this->get_field_name( 'slideshow-num-items' ); ?>" >
            <?php for ($i=2; $i<=20; $i++) { ?>
              <option <?php if ($options['slideshow']['num-items'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>        
          </select></label></p>

          <p><label for="<?php echo $this->get_field_id('slideshow-fixed-height'); ?>" >
          <input id="<?php echo $this->get_field_id('slideshow-fixed-height'); ?>" name="<?php echo $this->get_field_name('slideshow-fixed-height'); ?>" type="checkbox" value="Yes" <?php checked(isset($options['slideshow']['fixed-height']) ? $options['slideshow']['fixed-height'] : 0); ?> />
          <?php _e(' Maintain Fixed Height'); ?></label></p>  
          
          <p><label for="<?php echo $this->get_field_id('slideshow-remove-NextPrev'); ?>" >
          <input id="<?php echo $this->get_field_id('slideshow-remove-NextPrev'); ?>" name="<?php echo $this->get_field_name('slideshow-remove-NextPrev'); ?>" type="checkbox" value="Yes" <?php checked(isset($options['slideshow']['remove-NextPrev']) ? $options['slideshow']['remove-NextPrev'] : 0); ?> />
          <?php _e(' Remove "Next" and "Prev"'); ?></label></p>
    
          <p> <?php _e('- Might require Reduced Photo Width.'); ?></p>  
        </div> 
        
      <?php /////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////      Gallery        ////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////  ?>
        <div id="<?php echo $this->get_field_id( 'style-opt' ); ?>_gallery" >
          <p><label for="<?php echo $this->get_field_id('gallery-num-items'); ?>"><?php _e('Select Number of Photos: ');?>        
          <select id="<?php echo $this->get_field_id( 'gallery-num-items' ); ?>" name="<?php echo $this->get_field_name( 'gallery-num-items' ); ?>" >
            <?php for ($i=1; $i<=20; $i++) { ?>
              <option <?php if ($options['gallery']['num-items'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>        
          </select></label></p>
        </div>        
        
      </div><!-- close style-opt-containter -->
      
      <script type="text/javascript">
      jQuery(window).load(function() {
        uftpLoadStyleMenu('<?php echo $this->get_field_id( 'style-opt' ); ?>');
      });
      uftpLoadStyleMenu('<?php echo $this->get_field_id( 'style-opt' ); ?>');
      </script>
    </div>
  </div>
  <br clear="all" />
  
      <?php//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
  <div>
    <p><label for="<?php echo $this->get_field_id('align-opt'); ?>" ><?php _e('Photo Alignment: ');?>  
    <select id="<?php echo $this->get_field_id( 'align-opt' ); ?>" name="<?php echo $this->get_field_name( 'align-opt' ); ?>" >
      <?php foreach (array('left','center','right') as $i) { ?>
        <option <?php if ($options['align-opt'] == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
      <?php } ?>       
    </select></label>   

    <label for="<?php echo $this->get_field_id('reduced-width'); ?>" style="padding-left:25px;">
    <?php _e('Reduced Photo Width (<a href="#" class="reduced-width-link">What is this?</a>):  '); ?>
    <input class="widefat" id="<?php echo $this->get_field_id('reduced-width'); ?>" name="<?php echo $this->get_field_name('reduced-width'); ?>" type="text" style="width: 40px" value="<?php echo esc_attr($options['reduced-width']); ?>" />
    <?php _e('px'); ?></label></p>   
    

    
    <p><label for="<?php echo $this->get_field_id('remove-myLink'); ?>" >
    <input id="<?php echo $this->get_field_id('remove-myLink'); ?>" name="<?php echo $this->get_field_name('remove-myLink'); ?>" type="checkbox" value="Yes" <?php checked(isset($options['remove-myLink']) ? $options['remove-myLink'] : 0); ?> />
    <?php _e(' Disable the tiny link I have placed in the bottom left corner, though I have spent months developing this plugin and would appreciate the link.'); ?></label></p>
  </div>    
  
  <div id="<?php echo $this->get_field_id('description'); ?>" style="position:relative;width:500px;overflow:hidden;">
    <div id="<?php echo $this->get_field_id('description-text'); ?>">
        <b><?php _e("Reduced Photo Width Explanation:", UPWbyETH_DOMAIN); ?></b><br>
        <?php _e("If photos are not being resized, cropped, or positioned correctly, (or if you would like a smaller photo size) 
        use the Reduced Photo Width option. Otherwise, leave the option blank.", UPWbyETH_DOMAIN); ?><br>
        - <?php _e("The Reduced Photo Width should be less than the Selected Photo Width/Size.", UPWbyETH_DOMAIN); ?><br>
        - <?php _e("For sidebars, between 200 and 250px is usually good.", UPWbyETH_DOMAIN); ?> <br>
        - <?php _e("Decrease the Reduced Photo Width until the issue is resolved.", UPWbyETH_DOMAIN); ?> <br>
      <br clear="all"/>
    </div>
  </div>
  <div>
    <b><?php _e('Useful Links: ', UPWbyETH_DOMAIN); ?></b><br>
    <?php _e('To see examples of each display type, visit ', UPWbyETH_DOMAIN); ?><a href="http://kylinuntitled.com/ultimate-photo-widget/" target="_blank">Kylin Untitled </a>.<br>
    <?php _e('For the full description and explanation of functionality, visit ', UPWbyETH_DOMAIN); ?><a href="http://electrictreehouse.com/ultimate-photo-widget/" target="_blank">Electric Tree House</a>.<br>
    <?php _e('Check out the shortcode generator (Settings->Ultimate Photo Widget).', UPWbyETH_DOMAIN); ?><br>
    <?php _e('Please continue to inform me of errors at ', UPWbyETH_DOMAIN); ?><a href="http://electrictreehouse.com/ultimate-photo-widget/" target="_blank">Electric Tree House</a>.<br><br>
  </div>
    
  <script type="text/javascript">
  jQuery("#<?php echo $this->get_field_id('description'); ?>").height(0);
  jQuery(".reduced-width-link").click(function(event) {
    event.preventDefault();
    var h = jQuery("#<?php echo $this->get_field_id('description-text'); ?>").height();
    jQuery("#<?php echo $this->get_field_id('description'); ?>").animate({height:h}, 1000);
  });      
  </script>

  <?php 
  // End form
  ?>
