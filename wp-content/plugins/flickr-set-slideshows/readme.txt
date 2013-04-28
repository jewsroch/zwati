=== Flickr set slideshows ===
Contributors: Dourou
Tags: flickr, flickr sets, flickr slideshows, flickr photoset slideshows, flickr photosets
Requires at least: 3.3.0
Tested up to: 3.5
Stable tag: 0.5
License: GPLv2 or later

The quick and easy way to embed native Flickr slideshows of your Flickr photosets in your posts and pages.

== Description ==

Easily embed slideshows of your [Flickr photosets](http://www.steves-digicams.com/knowledge-center/how-tos/online-sharing-social-networking/how-to-create-a-set-within-flickr.html#b "What are photosets in Flickr")
in your posts and pages with this **Flickr set slideshows** plugin.

Once you have linked your Flickr account to the plugin (see Plugin Setup section),
creating a slideshow of one of your Flickr photosets is as easy as choosing the set and the slideshow's dimensions from a drop down list.
You can then embed the slideshow anywhere in your posts or pages by copying and pasting a [shortcode](http://codex.wordpress.org/Shortcode_API "Shortcodes in Wordpress").

When you create or edit a slideshow, Flickr set slideshow will provide you with an instant preview.

== Installation ==

= The easy way = 
1. Download the plugin - it will come as a .zip file
2. Log in to your Wordpress dashboard
3. Go to **Plugins > Add new**
4. Under the `Install Plugins` header, click `Upload`
5. Click the `Choose File` button, browse your computer to find the .zip file downloaded at step 1, click `Install now`
6. Click the `Activate plugin` link

See [`Plugin Setup`](http://wordpress.org/extend/plugins/flickr-set-slideshows/other_notes/ "Flickr set slideshow settings") to link to your Flickr account.

= The show off way =
1. Download the plugin .zip file
2. Unzip the file
3. Upload the `flickr-set-slideshows` directory to the `/wp-content/plugins/` directory
4. Activate the plugin through the `Plugins` menu in WordPress

See [`Plugin Setup`](http://wordpress.org/extend/plugins/flickr-set-slideshows/other_notes/ "Flickr set slideshows settings") to link to your Flickr account.

== Frequently Asked Questions ==

= I've installed the plugin. What now? =
You need to link it to your Flickr account. To do this, go to your Wordpress dashboard. Go to **`Settings` > `Flickr set slideshows`**.
Enter your Flickr username and a Flickr API key.

= What is my Flickr username exactly? =
It's the name that appears in the top right-hand corner of the screen when you are logged in to Flickr (`Signed in as...`).

= How do I get an API key =
The following Youtube video explains how to get an API key for the Flickr Set Slideshows plugin: [http://www.youtube.com/watch?v=Lq1XRx6dsDU](http://www.youtube.com/watch?v=Lq1XRx6dsDU "Youtube video on how to obtain a Flickr API key")

= Some of my Flickr photosets are not appearing in my set list. Why? =
Only the sets that are public can be used by this plugin. Private sets (which is any set that contains at least one private picture) will not be returned by Flickr to be publicly displayed as a slideshow.
Make sure that all the sets you want to show in your website are public. If the problem persists, please get in touch (see below).

= Where do I go to report bugs and for complaints, moans, suggestions or to sing your praises? =
Just send an email to info at majweb dot co dot uk

== Screenshots ==

1. A Flickr slideshow in a blog post.
2. Flickr set slideshows settings page.
3. Slideshow creation page.
4. Slideshow listing and edition page.

== Changelog ==

= 0.5 =
* updated gallery code to repair incompatibility with some themes

= 0.4 =
* replace file_get_contents() functions by wp_remote_get() to sort out incompatibilities with some servers.
Many thanks to [Marcello Seri](http://www.illusionimentali.it/ "Marcello Seri's website") for pointing out the problem and offering solutions!

= 0.3 =
* fixed broken link in message

= 0.2 =
* fixed broken submission url when Wordpress files installed in directory other than root
* Updated FAQ

== Upgrade Notice ==

= 0.2 =
Fixed bug. It's always better to upgrade! 

== Plugin Setup ==
To link the plugin to your Flickr account:

1. Get your Flickr username; that is the name that appears in the top right-hand corner of the screen when you are logged in to Flickr (`Signed in as...`),
2. Get a Flickr API Key; the following Youtube video will tell you how: [http://www.youtube.com/watch?v=Lq1XRx6dsDU](http://www.youtube.com/watch?v=Lq1XRx6dsDU "Youtube video on how to obtain a Flickr API key")
3. Go to your Wordpress dashboard,
4. Go to **`Settings` > `Flickr set slideshows`**,
5. Enter your Flickr username and API key,
6. Click `Save changes`

The plugin is now ready to use.

== User guide ==

= To create a new slideshow =
From your Wordpress dashboard,

1. Go to **`Flickr Set Slideshows` > `Add new`**,
2. Select a photoset from the drop down list,
3. Select a size for your slideshow,
4. Click `Save changes`,
5. A confirmation message will appear at the top of the screen with a shortcode following the format [fsg_gallery id="XX"], where XX is a number.
Copy and paste this shortcode wherever you want the slideshow to appear in your posts and pages.

= To insert a slideshow into a post or page =
On creating a slideshow, you will receive a short code following the format [fsg_gallery id="XX"], where XX is a number. Copy and paste this code
in the page or post where you want the slideshow to appear.

You can come back to the shortcode later, it will be saved in your slideshow listing at `Flickr set slideshows` > `Flickr set slideshows`.

= To edit/remove a slideshow =
You can do this from your slideshow listing located at **`Flickr set slideshows` > `Flickr set slideshows`**

**Note the deleting a slideshow will remove it from the posts and pages in which you have inserted it.**

To change the size of a slideshow, simply click on the `change size` link of the corresponding slideshow, choose a new size from the drop down list and Voila!