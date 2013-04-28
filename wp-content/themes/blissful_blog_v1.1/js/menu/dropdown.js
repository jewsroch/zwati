// Menu Dropdown

var $j = jQuery.noConflict();
$j(document).ready(function(){
	$j("ul.sub-menu, ul.children").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)
	$j("ul.menu li a, ul.menu li span").mouseover(function() { //When trigger is clicked...

		//Following events are applied to the subnav itself (moving subnav up and down)
		$j(this).parent().find("ul.sub-menu, ul.children").slideDown(200).show(); //Drop down the subnav on click
		$j(this).parent().hover(function() {
		}, function(){
			$j(this).parent().find("ul.sub-menu, ul.children").slideUp(0); //When the mouse hovers out of the subnav, move it back up
		});

		//Following events are applied to the trigger (Hover events for the trigger)
		}).hover(function() {
			$j(this).addClass("subhover"); //On hover over, add class "subhover"
		}, function(){	//On Hover Out
			$j(this).removeClass("subhover"); //On hover out, remove class "subhover"
			
	});
})(jQuery);