<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/iqbal1486/
 * @since      1.0.0
 *
 * @package    Gh_Cf7_Insightly
 * @subpackage Gh_Cf7_Insightly/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Gh_Cf7_Insightly
 * @subpackage Gh_Cf7_Insightly/includes
 * @author     Momin Iqbal <Iqbal.Brightnessgroup@gmail.com>
 */
class Gh_Cf7_Insightly_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'gh-cf7-insightly',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
