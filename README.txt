=== Responsive Slider lite ===
Contributors: carl-alberto
Donate link: http://carlalberto.ml/
Tags: slider, responsive slider, lightweight slider, bootstrap slider, image slider, image gallery, images, gallery, responsive wordpress slider
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A lightweight responsive slider utilizing the default custom post type and featured image. Served in the front-end using bootstrap.

== Description ==

A lightweight responsive slider utilizing the default custom post type and featured image. Served in the front-end using bootstrap. Image order can be arranged at the wp-admin using drag and drop.

== Installation ==

1. Upload the whole `responsive-slider-lite` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Responsive slider lite and add your images as featured images, you have the option to assign a category
4. Use shortcode [rsliderl] in any page or post to load all images, Optional

Additional Parameters:

Load only a particular category:
[rsliderl cat="category_name"]

Show Image title:
[rsliderl title=true]

Show Image description:
[rsliderl description=true]


== Frequently Asked Questions ==

= Why are the images not appearing=

You need to put the shortcode first in any of your post/pages and enable the plugin


== Screenshots ==




== Changelog ==

= 1.0.3 =
Fixed book post type issue

= 1.0.1 =
* Use title and wp-content for the image overlays
* Added category filters in the admin list
* Sort by category under the default admin list

= 1.0.0 =
* Can be categorized, images can be assigned to multiple categories
* Drag and Drop reordering of the image sequence
* Loadable via shortcode or in template files
* Detect if bootstrap is already used from elsewhere

In progress features:
* Options page -  max image size can be defined so images can be auto cropped or set to a standard size, transition delay
* Multiple template to suit end user tastes
* Different transitions
* thumbnail option
