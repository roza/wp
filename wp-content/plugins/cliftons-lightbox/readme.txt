=== Clifton's Lightbox ===
Contributors: Clifton Hatfield
Donate link: 
Tags: lightbox, popup, Clifton, ColorBox
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 2.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Clifton's Lightbox implements a lightbox subscription form overlay. Features a title, list, call-to-action, and image or video.

== Description ==

Clifton's Lightbox implements a lightbox subscription form overlay. Features a title, list, call-to-action, and image or YouTube video. Users can embed their subscription form into the lightbox and use the call-to-action area to encourage new subscribers.

== Installation ==

1. Activate the plugin through the 'Plugins' menu in WordPress
2. Go to Settings > Lightbox to setup the lightbox.
3. Preview the lightbox by clicking on the Preview button.
4. After you've set up and previewed the lightbox, enable it from Settings > Lightbox.

== Frequently asked questions ==

= Why isn't the lightbox appearing on my site? =

First, check if the lightbox is **Enabled**. This is different than Activated. After you've activated the plugin, you will need to set up the plugin at Settings > Lightbox. Once the plugin is setup, you can Enable it.

If you still don't see the lightbox, prehaps you've already set the cookie. Go to Settings > Lightbox and click on the Delete Cookie button. That will delete the cookie preventing the lightbox from appearing.

= Does this lightbox work with GetResponse or Aweber or any other email marketing software? =

In theory, it should work with any email marketing service. I've tested the plugin with GetResponse, Aweber, iContact, MailChimp, and others. The plugin requires the form markup to contain Name and Email fields.

= Can I use a YouTube video? =

Yes, you can set your own image or use a video from YouTube. Videos are a great way to deliver your message to visitors.

== Screenshots ==

1. Lightbox Preview
2. Lightbox Settings
3. Lightbox Settings

== Changelog ==

= 2.3.1 =
* Updated Facebook Support Group text
* Added Close button to upper right corner of lightbox
* Removed old lightbox JavaScript
* Updated powered by link to new plugin name
* Fixed bg_btn 404 not found error


= 2.3 =

* removed talk fusion options
* added option to display Powered By link
* changed name from Clifton's Lightbox Plugin to Clifton's Lightbox

= 2.2.9 =

* escape html variable when binding paste

= 2.2.8 =

* minor bug fixes

= 2.2.7 =

* minor bug fixes

= 2.2.6 =

* added colorbox
* fixed talk fusion autoresponder
* added new settings page
* added one click updates
* added rel=0 for youtube videos

= 2.2.5 =

* added the delete cookie feature
* added aweber hack

= 2.2.4 =

* added get_iframe_src
* compatible with Talk Fusion iframe web forms

= 2.2.3 =

* fixed regex to find email & name fields. A fix for iContact

= 2.2.2 =

* changed background graphic
* added stripslashes() to privacy statement in box
* removed support for mobile devices
* fixed javascript error media setting

= 2.2.1 =

* fixed preg_match issue

= 2.2 =

* made multisite compatible by switching out WP_PLUGIN_URL with plugins_url function
* added SSL compatible
* added enabled/disabled checkbox
* added about page
* fixed preg_match('/name/'i) issue
* removed old lightbox javascript, replace with custom scripts I wrote

= 2.1 =

* switched to use shadowbox
* added time delay and cookie life

= 2.0 =

* replaced Delete Cookie button with Preview button in dashboard.
* moved jquery and thick scripts to function to work properly
* removed thickbox title
* fixed CSS issues with thickbox.css for #TB_window

= 1.0.1 =

* Add background color option
* Add links to lightbox and forms

== Upgrade notice ==

= 2.3.1 =

This upgrade removes unused JavaScript blocks. Adds a close button to the upper right corner of the lightbox. Other minor improvements.

