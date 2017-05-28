=== LinkedIn Share Button ===
Contributors: johnbillion, Frank.Prendergast
Tags: linkedin, share, social, social networking
Requires at least: 2.9
Tested up to: 3.0
Stable tag: trunk

Adds a LinkedIn share button to posts and pages, allowing your visitors to easily and quickly share your content with their LinkedIn network. 

== Description ==

Adds a LinkedIn share button to posts and pages, allowing your visitors to easily and quickly share your content with their LinkedIn network. 

The plugin settings allow you to choose whether to display on:

 * posts
 * pages
 * posts on the home page
 * posts in archive listings
 * posts in search results

You can also specify whether to display inline, float left or right, and show at the top or bottom of the post. You can display the button automatically, or choose to add it on a per post basis, or a mixture of both.

== Installation ==

1. Unzip the ZIP file and drop the folder straight into your 'wp-content/plugins' directory.
2. Activate the plugin through the 'Plugins' menu.
3. Visit the 'Settings -> LinkedIn Button' menu and choose how to display the button.

= Usage =

The linkedIn button will automatically display according to your setting on the 'Settings -> LinkedIn Button' screen.

You can override the individual post setting on a per-post basis from the 'LinkedIn Button' options box on the post/page writing screen.

== Frequently Asked Questions ==

= Can I display the button only on posts or pages that I choose? =

Yes. If you uncheck all the options for displaying the button you can manually add the button on posts and pages by selecting "show the button" in the LinkedIn Button options when editing a post or page.

= Can I add my own button rather than using one of the existing ones? =

Yes! When you visit the 'Settings -> LinkedIn Button' screen, the plugin will look for an image named 'linkedin-button.png' or 'linkedin-button.gif' inside the 'images' directory of your current active theme. If it finds one, it'll show up and you can select it.

= Can I style the button with CSS in my theme? =

Yes. The buttons have a class name of 'linkedin_share_button' and if you're displaying the button using one of the automatic settings then it will be contained within a div with class name 'linkedin_share_container'.

= Is there a template tag I can use in my theme to display the button? =

Yes:

`<?php do_action( 'linkedin_button' ); ?>`

Or, if you wish, you can use the function directly:

`<?php linkedin_button(); ?>`

This function takes two optional parameters: a post ID (defaults to the current post ID) and a boolean to control whether or not to echo the button (defaults to true).

The button will always be displayed using these methods, irrespective of your settings on the 'Settings -> LinkedIn Button' screen.

== Screenshots ==

1. The LinkedIn Share button in action
2. The settings screen

== Changelog ==

= 1.2 =
* Bugfix for users not using automatic button placement.

= 1.1 =
* Activation bugfix for some users.

= 1.0 =
* Initial release.
