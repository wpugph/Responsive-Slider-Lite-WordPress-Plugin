<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://carlalberto.ml/
 * @since      1.0.0
 *
 * @package    Responsive_Slider_Lite
 * @subpackage Responsive_Slider_Lite/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Responsive_Slider_Lite
 * @subpackage Responsive_Slider_Lite/includes
 * @author     Carl Alberto <cgalbert01@gmail.com>
 */
class Responsive_Slider_Lite_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'responsive-slider-lite',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
