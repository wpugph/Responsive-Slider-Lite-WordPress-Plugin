=== Responsive Slider lite ===
Contributors: carl-alberto
Donate link: http://carlalberto.ml/
Tags: responsive, slider, lightweight, bootstrap
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A lightweight responsive slider utilizing the default custom post type and featured image. Served in the front-end using bootstrap. 

== Description ==

A lightweight responsive slider utilizing the default custom post type and featured image. Served in the front-end using bootstrap. Image order can be arranged at the wp-admin using drag and drop.
 
== Installation ==

1. Upload the whole `responsive-slider-lite` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Responsive slider lite and add your images as featured images, you have the option to assign a category
4. Use shortcode [rsliderl] in any page or post to load all images, you can also use
[rsliderl cat="category name"] to load a specific set of images from a category

== Frequently Asked Questions ==

= Why are the images not appearing=

You need to put the shortcode first in your content and enable the plugin


== Screenshots ==




== Changelog ==

= 1.0 =
* Can be categorized, images can be assigned to multiple categories
* Drag and Drop reordering of the image sequence
* Loadable via shortcode or in template files
* Detect if bootstrap is already used from elsewhere

In progress features:
* Access can be restricted on certain user groups
* Will use title and wp-content for the image overlays
* Options page -  max image size can be defined so images can be auto cropped or set to a standard size, transition delay
* Multiple template to suit end user tastes
* Different transitions
* thumbnail option
* Sort by category under the default admin list