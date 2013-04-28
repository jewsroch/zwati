=== Ultimate Photo Widget for Flickr, Tumblr, and Pinterest ===
Contributors: electrictreehouse, kylinuntitled
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=electrictreehouse%40gmail%2ecom&lc=US&item_name=Electric%20Tree%20House&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: photos, flickr, tumblr, pinterest, photostream, javascript, jQuery, stylish, pictures, images, slideshow, widget, sidebar, moving
Requires at least: 2.8
Tested up to: 3.3.2
Stable tag: 2.0.2.3


== Description == 
The Ultimate Photo Widget for Flickr, Tumblr, and Pinterest is intended to create a means of retrieving photos from various popular sites and displaying them in a stylish and uniform way. The Ulimate Photo Widget is currently capable of retrieving photos from Flickr, Tumblr, and Pinterest and displaying them in three styles styles: vertical, tiles, and slideshow. This lightweight but powerful widget takes advantage of WordPress's built in JQuery scripts to create a sleek presentation that I hope you will like. A full description is available at ElectricTreeHouse (http://electrictreehouse.com/ultimate-photo-widget/) and a demo page is available at Kylin Untitled (http://kylinuntitled.com/ultimate-photo-widget/).


== Installation ==

1. Upload `ultimate-photo-widget-by-eth` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the widget like any other widget.
4. Customize based on your preference.
5. Create shortcodes on the Plugins->Ultimate Photo Widget page.

== Frequently Asked Questions ==

None yet, but I'd like to hear from you. Leave a message at http://electrictreehouse.com/

== Screenshots ==

1. The widgets screen showing an Ultimate Photo Widget in use.

== Changelog ==

= 1.0.1 =
* First Attempt. Basic functions, sourcing, and styles.

= 1.0.2 =
* Address size storage problem
* Tested List implementation of getimagesize()

= 1.0.4 =
* Fixed Vertical Max-Width
* Added Tumblr Custom URL
* Moved admin jQuery to external (instead of wrapping with CDATA[ ])

= 2.0.1 =
* Rewrote Slideshow, Tiles, and Square Tiles jQuery
* Added corner link
* Remove style preview and rearrange toggles
* Removed the use of PHP function getimagesize()
* Resolve script and style update error

= 2.0.2 =
* Added shortcode and shortcode generator
* Added <noscript> condition
* Moved styling to external CSS file and added class-based styling
* Resolved several theme override issues in styling (more work needs to be done)
* Added aditional filtering to text entry, in particular to custom Tumblr url
* Combined tile styles into single option
* Fixed slideshow height changes
* Added Pinterest button links
* Added update function and version record for widget options
* Created plugin banner for Wordpress.org

= 2.0.2.1 =
* Added Tumblr RSS fetch
* Set Tumblr to try all three methods before giving up

= 2.0.2.3 =
* Tabs in Setting Page
* Pinterest pin board options
* Flickr multiple methods
* Begin Internationalizing