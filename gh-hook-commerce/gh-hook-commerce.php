<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/iqbal1486/
 * @since             1.0.0
 * @package           Gh_Hook_Commerce
 *
 * @wordpress-plugin
 * Plugin Name:       Hook Commerce
 * Plugin URI:        https://www.geekerhub.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Geekerhub
 * Author URI:        https://profiles.wordpress.org/iqbal1486/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gh-hook-commerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GH_HOOK_COMMERCE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gh-hook-commerce-activator.php
 */
function activate_gh_hook_commerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gh-hook-commerce-activator.php';
	Gh_Hook_Commerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gh-hook-commerce-deactivator.php
 */
function deactivate_gh_hook_commerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gh-hook-commerce-deactivator.php';
	Gh_Hook_Commerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gh_hook_commerce' );
register_deactivation_hook( __FILE__, 'deactivate_gh_hook_commerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gh-hook-commerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gh_hook_commerce() {

	$plugin = new Gh_Hook_Commerce();
	$plugin->run();

}
run_gh_hook_commerce();

/*
add_filter( 'woocommerce_checkout_fields' , 'custom_rename_wc_checkout_fields' );

// Change placeholder and label text
function custom_rename_wc_checkout_fields( $fields ) {
  echo "<pre>";
  print_r($fields);
  echo "</pre>";

  $fields['billing']['billing_first_name']['placeholder'] = 'Wonka';
  $fields['billing']['billing_first_name']['label'] = 'Your Awesome First Name';
  return $fields;
}*/
