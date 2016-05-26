<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://carlalberto.ml/
 * @since             1.0.0
 * @package           Responsive_Slider_Lite
 *
 * @wordpress-plugin
 * Plugin Name:       Responsive Slider Lite
 * Plugin URI:        http://carlalberto.ml/plugins
 * Description:       A lightweight responsive slider utilizing bootstrap
 * Version:           1.0.1
 * Author:            Carl Alberto
 * Author URI:        http://carlalberto.ml/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       responsive-slider-lite
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-responsive-slider-lite-activator.php
 */
function activate_responsive_slider_lite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-responsive-slider-lite-activator.php';
	Responsive_Slider_Lite_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-responsive-slider-lite-deactivator.php
 */
function deactivate_responsive_slider_lite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-responsive-slider-lite-deactivator.php';
	Responsive_Slider_Lite_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_responsive_slider_lite' );
register_deactivation_hook( __FILE__, 'deactivate_responsive_slider_lite' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-responsive-slider-lite.php';
require plugin_dir_path( __FILE__ ) . 'responsive-slider-lite-ordering.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_responsive_slider_lite() {

	$plugin = new Responsive_Slider_Lite();
	$plugin->register_homeslider();
	$plugin->homeslider_style_admin();
	$plugin->activate_slider_responsive_sc();

	$plugin->run();

//	$plugin_admin = new Responsive_Slider_Lite_Admin();
//	$plugin_admin->homeslider_style_admin();
// Responsive_Slider_Lite_Admin::homeslider_style_admin();

}
run_responsive_slider_lite();
