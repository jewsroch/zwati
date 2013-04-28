/*
* Square, an extension of the Ultimate Photo Widget
* By: Eric Burger, http://electrictreehouse.com
* Version: 2.0.0
* Updated: January 27th, 2012
* 
*/
// For Tiles
  function uftp_tiles_resize(a,id) {
    var parent = jQuery("#"+id+"-tile-parent");
    var pWidth = parent.width();
    
    var minWidth = pWidth;
    
    for(i=0;i<a;i++){
      var currentImg = jQuery("#"+id+"-tile-"+i);
      if(i%3==0) {
        if(currentImg.width() < minWidth ) {
          minWidth = currentImg.width();
        }
      }
      else{
        if(2*currentImg.width() < minWidth ) {
          minWidth = 2*currentImg.width();
        }
      }
    }
    parent.width(minWidth);
    jQuery("#"+id+"-display-link").width(minWidth); // Shrink width of link div
    
    for(i=0;i<a;i++){
      if(i%3==0) {
        uftp_single_tile_resize(i,id,minWidth);
      }
      else if(i%3==2) {
        uftp_double_tile_resize(i-1,i,id,minWidth);
      }
    }
    parent.css({"opacity":"1.0"});
  }
  function uftp_single_tile_resize(a,id,width) {
    // Get the image
    var imgA = jQuery("#"+id+"-tile-"+a);
    // Set the container and image width to width to insure consistency
    // (even though we will just enlarge again)
    jQuery("#"+id+"-tile-div-"+a).width(width);
    imgA.width(width);
    // Get new h
    var hA = imgA.height();

    // First, expand container width
    jQuery("#"+id+"-tile-div-"+a).width(width+200);
    // Then set container height
    jQuery("#"+id+"-tile-div-"+a).height(hA);

  }

  function uftp_double_tile_resize(a,b,id,width){
    // Get image elements
    var imgA = jQuery("#"+id+"-tile-"+a);
    var imgAdiv = jQuery("#"+id+"-tile-image-div-"+a);
    var imgB = jQuery("#"+id+"-tile-"+b);
    var imgBdiv = jQuery("#"+id+"-tile-image-div-"+b);
    
    var theW = (width/2)-2;
    // Set the space between the pair of images at 4px
    imgAdiv.width(theW);
    imgBdiv.width(theW);

    // Reassign the reduced image width
    imgA.width(theW);
    imgB.width(theW);
    


    // Find proportional height
    var hA = imgA.height();
    var hB = imgB.height();
    
    // Fix image A
    if(hA<hB){
      // Assign the new container height
      jQuery("#"+id+"-tile-div-"+(a)).height(hA);
    }
    else{
      // Assign the new container height
      jQuery("#"+id+"-tile-div-"+(a)).height(hB);
    }
    
    // For the sake of keeping things together...
    // Add top and bottom margins to image pairs
    jQuery("#"+id+"-tile-div-"+(a)).css({"margin-top":"4px","margin-bottom":"4px"});
    jQuery("#"+id+"-by-link").css({"padding-bottom":"8px"});
  }

  
  
  
  
// For Square Tiles
  function uftp_square_tiles_resize(a,id) {
    var parent = jQuery("#"+id+"-tile-parent");
    var pWidth = parent.width();
    
    var minWidth = pWidth;
    
    for(i=0;i<a;i++){
      var currentImg = jQuery("#"+id+"-tile-"+i);
      if(i%3==0) {
        if(currentImg.width() < minWidth ) {
          minWidth = currentImg.width();
        }
        if(currentImg.height() < minWidth ) {
          minWidth = currentImg.height();
        }  
      }
      else{
        if(2*currentImg.width() < minWidth ) {
          minWidth = 2*currentImg.width();
        }
      }
    }
    parent.width(minWidth);
    jQuery("#"+id+"-display-link").width(minWidth); // Shrink width of link div
    
    for(i=0;i<a;i++){
      if(i%3==0) {
        uftp_single_square_tile_resize(i,id,minWidth);
      }
      else if(i%3==2) {
        uftp_double_square_tile_resize(i-1,i,id,minWidth);
      }
    }
    
    parent.css({"opacity":"1.0"});
  }
  
  function uftp_single_square_tile_resize(a,id,width) {
    // Get the image
    var imgA = jQuery("#"+id+"-tile-"+a);
    // Set the container and image width to width to insure consistency
    // (even though we might just need to enlarge again)
    jQuery("#"+id+"-tile-div-"+a).width(width);
    imgA.width(width);
    // Get new h
    var hA = imgA.height();

    if(hA>=width){ // don't need to make taller
      // First, expand container width
      jQuery("#"+id+"-tile-div-"+a).width(width+200);
      // Then set container height
      jQuery("#"+id+"-tile-div-"+a).height(width);
    }
    else{
      // First, expand container width
      var wA = width*width/hA;
      jQuery("#"+id+"-tile-div-"+a).width(wA);
      imgA.width(wA);
      // Then set container height
      jQuery("#"+id+"-tile-div-"+a).height(width);
    }
  }

  function uftp_double_square_tile_resize(a,b,id,width){
    // Get image elements
    var imgA = jQuery("#"+id+"-tile-"+a);
    var imgAdiv = jQuery("#"+id+"-tile-image-div-"+a);
    var imgB = jQuery("#"+id+"-tile-"+b);
    var imgBdiv = jQuery("#"+id+"-tile-image-div-"+b);
    
    var theW = (width/2)-2;
    // Set the space between the pair of images at 4px
    imgAdiv.width(theW);
    imgBdiv.width(theW);

    // Reassign the reduced image width
    imgA.width(theW);
    imgB.width(theW);
    
    // Assign the new width as the container height
    jQuery("#"+id+"-tile-div-"+(a)).height(theW);

    // Find proportional height
    var hA = imgA.height();
    var hB = imgB.height();
    
    // Fix image A
    if(hA<theW){ // Width should be increased
      newW = theW*theW/hA+2;
      imgA.width(newW);
    }
    // Fix image B
    if(hB<theW){
      newW = theW*theW/hB+2;
      imgB.width(newW);
    }
    
    // For the sake of keeping things together...
    // Add top and bottom margins to image pairs
    jQuery("#"+id+"-tile-div-"+(a)).css({"margin-top":"4px","margin-bottom":"4px"});
    jQuery("#"+id+"-by-link").css({"padding-bottom":"8px"});
  }
  

  
  
  

  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////

  // For Sliding Slideshow
  function uftpSlideSwitchNext(slideWidth,uftp,s_option,fixedHeight) {   
    // Set necessary div variables
    var slideshow = jQuery("#"+uftp+"_slideshow_container");
    var activeDiv = jQuery("#"+uftp+"_slideshow_container div.active");   
    var slideshowWindow = jQuery("#"+uftp+"_slideshow_window");
    
    if(slideshow.attr("class")=="go" && slideshow.attr("class")!="hover"){
      // Prevent multiple calls
      slideshow.removeClass("go");
      if ( activeDiv.length == 0 ) activeDiv = jQuery("#"+uftp+"_slideshow_container div:first");

      // Use this to pull the images in the order they appear in the markup
      var nextDiv =  activeDiv.next().length ? activeDiv.next() : jQuery("#"+uftp+"_slideshow_container div:first");
      nextDiv.addClass('next');
      var nextImg = jQuery("#"+uftp+"_slideshow_container div.next img");
      
      // Start height animation
      slideshowWindow.animate({height: nextImg.height()},1500);

      
      if(s_option==1){
        activeDiv.animate({left: 0},1500, function(){
          // After animation complete
          activeDiv.css({opacity: 0.0}); 
        });    
        nextDiv.css({left:2*slideWidth,opacity: 1.0,"position":"absolute",top:0}); 
        nextDiv.animate({left:slideWidth},1500, function(){
          slideshow.addClass("go");
        });
      }   
      else if(s_option==2){
        activeDiv.animate({opacity: 0.0},1500, function(){
          // After animation complete
          activeDiv.css({left: 0}); // Move so that links work
        });    
        nextDiv.css({left:slideWidth,opacity: 0.0,"position":"absolute",top:0}); 
        nextDiv.animate({opacity: 1.0,top:0},1500, function(){
          slideshow.addClass("go");
        });
      
      }
      else if(s_option==3){
        activeDiv.animate({opacity: 0.0,left:0},1000, function(){
          // After animation complete
          nextDiv.css({left:0,opacity: 0.0,"position":"absolute",top:0}); 
          nextDiv.animate({opacity: 1.0,left:slideWidth},1000, function(){
            slideshow.addClass("go");
          });
        });    
      }
      
      // After animation complete
      activeDiv.removeClass('active');  
      //activeDiv.addClass('prev');
      nextDiv.removeClass('next');
      nextDiv.addClass('active');
    }  
  }
  function uftpSlideSwitchPrev(slideWidth,uftp,s_option,fixedHeight) { 
    var slideshow = jQuery("#"+uftp+"_slideshow_container");
    var activeDiv = jQuery("#"+uftp+"_slideshow_container div.active");   
    var slideshowWindow = jQuery("#"+uftp+"_slideshow_window");
 
    if(slideshow.attr("class")=="go"){
      slideshow.removeClass("go");
      if ( activeDiv.length == 0 ) activeDiv = jQuery("#"+uftp+"_slideshow_container div:first");
      //activeDiv.addClass('active');
      //var activeImg = jQuery("#"+uftp+"_slideshow_container div.active img"); 
      
      // use this to pull the images in the order they appear in the markup
      var prevDiv =  activeDiv.prev().length ? activeDiv.prev() : jQuery("#"+uftp+"_slideshow_container div:last");
      prevDiv.addClass('prev');
      var prevImg = jQuery("#"+uftp+"_slideshow_container div.prev img");
      
      slideshowWindow.animate({height: prevImg.height()},1500);

      if(s_option==1){
        activeDiv.animate({left: 2*slideWidth},1500, function(){
          activeDiv.css({opacity: 0.0}); 
        });    
     
        prevDiv.css({left:0,opacity:1.0,"position":"absolute",top:0}); 
        prevDiv.animate({left:slideWidth}, 1500, function(){
          slideshow.addClass("go");
        }); 
      }
      else if(s_option==2){
        activeDiv.animate({opacity: 0.0},1500, function(){
          // After animation complete
          activeDiv.css({left: 0}); // Move so that links work
        });    
        
        prevDiv.css({left:slideWidth,opacity: 0.0,"position":"absolute",top:0}); 
        prevDiv.animate({opacity: 1.0},1500, function(){
          slideshow.addClass("go");
        });
      
      }
      else if(s_option==3){
        activeDiv.animate({opacity: 0.0,left:0},1000, function(){       
          prevDiv.css({left:0,opacity: 0.0,"position":"absolute",top:0}); 
          prevDiv.animate({opacity: 1.0,left:slideWidth},1000, function(){
            slideshow.addClass("go");
          });
        });    
      }
      
      // After animation complete
      activeDiv.removeClass('active');  
      //activeDiv.addClass('next');
      prevDiv.removeClass('prev');
      prevDiv.addClass('active');
    }   
  }
  
  function uftpFindMinWidth(id){
    var allDivs = jQuery(id);  
    Array.max = function( array ){
        return Math.max.apply( Math, array );
    };
    // Function to get the Min value in Array
    Array.min = function( array ){
       return Math.min.apply( Math, array );
    };

    //updated as per Sime Vidas comment.
    var widths= allDivs.map(function() {
        return jQuery(this).width();
    }).get();

    //alert("Max Width: " + Array.max(widths));
    //alert("Min Width: " + Array.min(widths));
    return Array.min(widths);
  }
  function uftpFindMinHeight(id){
    var allDivs = jQuery(id);  
    Array.max = function( array ){
        return Math.max.apply( Math, array );
    };
    // Function to get the Min value in Array
    Array.min = function( array ){
       return Math.min.apply( Math, array );
    };

    //updated as per Sime Vidas comment.
    var heights= allDivs.map(function() {
        return jQuery(this).height();
    }).get();

    //alert("Max Width: " + Array.max(heights));
    //alert("Min Width: " + Array.min(heights));
    return Array.max(heights);
  }
  function uftpFindMaxHeight(id){
    var allDivs = jQuery(id);  
    Array.max = function( array ){
        return Math.max.apply( Math, array );
    };
    // Function to get the Min value in Array
    Array.min = function( array ){
       return Math.min.apply( Math, array );
    };

    //updated as per Sime Vidas comment.
    var heights= allDivs.map(function() {
        return jQuery(this).height();
    }).get();

    //alert("Max Width: " + Array.max(heights));
    //alert("Min Width: " + Array.min(heights));
    return Array.max(heights);
  }
  
  function uftpStartSlideshow(uftp,s_option,fixedHeight,removeNextPrev) {
    // Create div variables
    var slideWindow = jQuery("#"+uftp+"_slideshow_window");
    var slideshow = jQuery("#"+uftp+"_slideshow_container");
    var activeDiv = jQuery("#"+uftp+"_slideshow_container div.active");   
    var activeImg = jQuery("#"+uftp+"_slideshow_container img.active");  
    var allDivs = jQuery("#"+uftp+"_slideshow_container div"); 
    var floatDiv = jQuery("#"+uftp+"_float");
    
    // Find min width or apply reduced width
    var slideWidth = uftpFindMinWidth("#"+uftp+"_slideshow_container img");
    if ( floatDiv.width() < slideWidth ){
      slideWidth = floatDiv.width();
    }else{
      floatDiv.width(slideWidth);
    }
    allDivs.css({"max-width":slideWidth+"px","position":"absolute","top":"0px","text-align":"center",opacity:0.0});
    
    // After width is set, find height
    var slideHeight = activeImg.height();
    // Set up div for images to move within
    slideshow.css({width:3*slideWidth,height:slideHeight,left:-slideWidth});
    // and position first image
    activeDiv.css({left:slideWidth});
    // and make sure only image is visible
    slideWindow.css({height:slideHeight,width:slideWidth,"position":"relative","overflow":"hidden"});
    
    // If fixed height, set min height of window
    if(fixedHeight){
      var maxHeight = uftpFindMaxHeight("#"+uftp+"_slideshow_container img");
      if(!removeNextPrev){
        floatDiv.height(maxHeight+60); // 35 for user link
      }else{
        floatDiv.height(maxHeight+35); // 35 for user link (link only needs 15 but Pinterest image much larger)
      }
    }

    // All set, so begin
    activeDiv.css({"opacity":"1.0"});
    floatDiv.css({"opacity":"1.0"});
    slideshow.addClass("go");
    
    if(!removeNextPrev){
      if(slideWidth < 100){      
        var prevLink = '<a href="#" style="text-align:left;position:absolute;left:5%;top:2px;font-size:10px;" class="prev-'+uftp+'">Prev</a>';
        var nextLink = '<a href="#" style="text-align:right;position:absolute;right:5%;top:2px;font-size:10px;" class="next-'+uftp+'">Next</a>';
      }
      else if(slideWidth >= 125){
        var prevLink = '<a href="#" style="text-align:left;position:absolute;left:5%;top:2px;font-size:12px;" class="prev-'+uftp+'">&lsaquo;&lsaquo; Prev</a>';
        var nextLink = '<a href="#" style="text-align:right;position:absolute;right:5%;top:2px;font-size:12px;" class="next-'+uftp+'">Next &rsaquo;&rsaquo;</a>';
      }      
      else{
        var prevLink = '<a href="#" style="text-align:left;position:absolute;left:5%;top:2px;font-size:12px;" class="prev-'+uftp+'">&lsaquo; Prev</a>';
        var nextLink = '<a href="#" style="text-align:right;position:absolute;right:5%;top:2px;font-size:12px;" class="next-'+uftp+'">Next &rsaquo;</a>';
      }
      slideWindow.before('<div style="position:relative;width:100%;height:25px;">'+prevLink+'');
      jQuery(".prev-"+uftp+"").after(''+nextLink+'</div>');

      jQuery(".next-"+uftp+"").click(function(event) {
        event.preventDefault();
        uftpSlideSwitchNext(slideWidth,uftp,s_option,fixedHeight);
      });
      jQuery(".prev-"+uftp+"").click(function(event) {
        event.preventDefault();
        uftpSlideSwitchPrev(slideWidth,uftp,s_option,fixedHeight);
      });
    }

    allDivs.hover(function(){
      slideshow.addClass("hover");
    }, function(){
      slideshow.removeClass("hover");
    });
    
    setInterval( "uftpSlideSwitchNext("+slideWidth+","+"'"+uftp+"'"+","+s_option+","+"'"+fixedHeight+"'"+")", 4000 );
  
  }
  
  
  function uftpGallery() {
  
  
  
  }
  
  
 