/*
* Admin Widget Menu, an extension of the Ultimate Photo Widget
* By: Eric Burger, http://electrictreehouse.com
* Since Version: 1.0.3
* Updated: January 18th, 2012
* 
*/
  
  function uftpLoadSourceMenu(a){
    if(jQuery("#"+a).val()=="flickr"){
      jQuery("#"+a+"_flickr_opt").show();
      jQuery("#"+a+"_tumblr_opt").hide();
      jQuery("#"+a+"_pinterest_opt").hide();
    }
    if(jQuery("#"+a).val()=="tumblr"){
      jQuery("#"+a+"_flickr_opt").hide();
      jQuery("#"+a+"_tumblr_opt").show();
      jQuery("#"+a+"_pinterest_opt").hide();
      }
    if(jQuery("#"+a).val()=="pinterest"){
      jQuery("#"+a+"_flickr_opt").hide();
      jQuery("#"+a+"_tumblr_opt").hide();
      jQuery("#"+a+"_pinterest_opt").show();
    }
  };
  function uftpLoadFlickrMenu(a){
    if(jQuery("#"+a).val()=="user" || jQuery("#"+a).val()=="favorites"){
      jQuery("#"+a+"_id").show();   
      jQuery("#"+a+"_user").show();
      jQuery("#"+a+"_group").hide();
      jQuery("#"+a+"_set").hide();
      jQuery("#"+a+"_community").hide();
      jQuery("#"+a+"_get_ID").show();
    }
    if(jQuery("#"+a).val()=="group"){  
      jQuery("#"+a+"_id").show();         
      jQuery("#"+a+"_user").hide();
      jQuery("#"+a+"_group").show();
      jQuery("#"+a+"_set").hide();
      jQuery("#"+a+"_community").hide();
      jQuery("#"+a+"_get_ID").show();
    }
    if(jQuery("#"+a).val()=="set"){   
      jQuery("#"+a+"_id").show();      
      jQuery("#"+a+"_user").show();
      jQuery("#"+a+"_group").hide();
      jQuery("#"+a+"_set").show();
      jQuery("#"+a+"_community").hide();
      jQuery("#"+a+"_get_ID").show();
    }
    if(jQuery("#"+a).val()=="community"){  
      jQuery("#"+a+"_id").hide();
      jQuery("#"+a+"_community").show();
    }
  };
  
  function uftpLoadCustomTubmlrURL(a,b){
    if(jQuery("#"+a).attr('checked')){
      jQuery("#"+b+"_label").hide();  
      jQuery("#"+b).css({'width':'170px'});
    }
    if(!jQuery("#"+a).attr('checked')){
      jQuery("#"+b+"_label").show();  
      jQuery("#"+b).css({'width':'100px'});
    }
  };
  
  function uftpLoadStyleMenu(a){
    if(jQuery("#"+a).val()=="vertical"){
      jQuery("#"+a+"_vertical").show();
      jQuery("#"+a+"_tiles").hide();
      jQuery("#"+a+"_slideshow").hide();
      jQuery("#"+a+"_gallery").hide();
    }
    if(jQuery("#"+a).val()=="tiles"){
      jQuery("#"+a+"_vertical").hide();
      jQuery("#"+a+"_tiles").show();
      jQuery("#"+a+"_slideshow").hide();
      jQuery("#"+a+"_gallery").hide();
    }
    if(jQuery("#"+a).val()=="gallery"){
      jQuery("#"+a+"_vertical").hide();
      jQuery("#"+a+"_tiles").hide();
      jQuery("#"+a+"_slideshow").hide();
      jQuery("#"+a+"_gallery").show();
    }
    if(jQuery("#"+a).val()=="slideshow"){
      jQuery("#"+a+"_vertical").hide();
      jQuery("#"+a+"_tiles").hide();
      jQuery("#"+a+"_slideshow").show();
      jQuery("#"+a+"_gallery").hide();
    }
  };
  
  
  function uftpToggleSourceMenu(a){
    if(jQuery("#"+a).val()=="flickr"){
      jQuery("#"+a+"_flickr_opt").show(1000);
      jQuery("#"+a+"_tumblr_opt").hide(1000);
      jQuery("#"+a+"_pinterest_opt").hide(1000);
    }
    if(jQuery("#"+a).val()=="tumblr"){
      jQuery("#"+a+"_flickr_opt").hide(1000);
      jQuery("#"+a+"_tumblr_opt").show(1000);
      jQuery("#"+a+"_pinterest_opt").hide(1000);
      }
    if(jQuery("#"+a).val()=="pinterest"){
      jQuery("#"+a+"_flickr_opt").hide(1000);
      jQuery("#"+a+"_tumblr_opt").hide(1000);
      jQuery("#"+a+"_pinterest_opt").show(1000);
    }
  };
  function uftpToggleFlickrMenu(a){
    if(jQuery("#"+a).val()=="user" || jQuery("#"+a).val()=="favorites"){
      jQuery("#"+a+"_id").show();   
      jQuery("#"+a+"_user").show();
      jQuery("#"+a+"_group").hide();
      jQuery("#"+a+"_set").hide();
      jQuery("#"+a+"_community").hide();
      jQuery("#"+a+"_get_ID").show();
    }
    if(jQuery("#"+a).val()=="group"){  
      jQuery("#"+a+"_id").show();         
      jQuery("#"+a+"_user").hide();
      jQuery("#"+a+"_group").show();
      jQuery("#"+a+"_set").hide();
      jQuery("#"+a+"_community").hide();
      jQuery("#"+a+"_get_ID").show();
    }
    if(jQuery("#"+a).val()=="set"){   
      jQuery("#"+a+"_id").show();      
      jQuery("#"+a+"_user").show();
      jQuery("#"+a+"_group").hide();
      jQuery("#"+a+"_set").show();
      jQuery("#"+a+"_community").hide();
      jQuery("#"+a+"_get_ID").show();
    }
    if(jQuery("#"+a).val()=="community"){  
      jQuery("#"+a+"_id").hide();
      jQuery("#"+a+"_community").show();
    }
  };
  
  function uftpToggleCustomTubmlrURL(a,b){
    if(jQuery("#"+a).attr('checked')){
      jQuery("#"+b+"_label").hide(1000);  
      jQuery("#"+b).animate({'width':'170px'},1000);
    }
    if(!jQuery("#"+a).attr('checked')){
      jQuery("#"+b+"_label").show(1000);  
      jQuery("#"+b).animate({'width':'100px'},1000);
    }
  };
  
  function uftpToggleStyleMenu(a){
    if(jQuery("#"+a).val()=="vertical"){
      jQuery("#"+a+"_vertical").show(1000);
      jQuery("#"+a+"_tiles").hide(1000);
      jQuery("#"+a+"_gallery").hide(1000);
      jQuery("#"+a+"_slideshow").hide(1000);
    }
    if(jQuery("#"+a).val()=="tiles"){
      jQuery("#"+a+"_vertical").hide(1000);
      jQuery("#"+a+"_tiles").show(1000);
      jQuery("#"+a+"_gallery").hide(1000);
      jQuery("#"+a+"_slideshow").hide(1000);
    }
    if(jQuery("#"+a).val()=="gallery"){
      jQuery("#"+a+"_vertical").hide(1000);
      jQuery("#"+a+"_tiles").hide(1000);
      jQuery("#"+a+"_gallery").show(1000);
      jQuery("#"+a+"_slideshow").hide(1000);
    }
    if(jQuery("#"+a).val()=="slideshow"){
      jQuery("#"+a+"_vertical").hide(1000);
      jQuery("#"+a+"_tiles").hide(1000);
      jQuery("#"+a+"_gallery").hide(1000);
      jQuery("#"+a+"_slideshow").show(1000);
    }
  };
  
