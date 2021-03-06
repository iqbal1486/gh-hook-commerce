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
 * @package           Gh_Cf7_Insightly
 *
 * @wordpress-plugin
 * Plugin Name:       CF7 to Insightly Connector
 * Plugin URI:        https://www.geekerhub.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Momin Iqbal
 * Author URI:        https://profiles.wordpress.org/iqbal1486/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gh-cf7-insightly
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

global $wpdb;

$gh_cf7_insightly_options  	= get_option( 'gh_cf7_insightly_options' );

$gh_enable_widget			= ($gh_cf7_insightly_options['gh_enable_widget_on_cart'] == 1) ? true : false;
$gh_cf7_insightly_api_key 	= $gh_cf7_insightly_options['gh_cf7_insightly_api_key'];

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GH_CF7_INSIGHTLY_VERSION', '1.0.0' );

if ( ! defined( 'GH_CF7_INSIGHTLY_TABLE_MAPPING' ) ) {
    define( 'GH_CF7_INSIGHTLY_TABLE_MAPPING', $wpdb->prefix . 'gh_cf7_insightly_mapping' );
}


if ( ! defined( 'GH_CF7_INSIGHTLY_ENABLE' ) ) {
    define( 'GH_CF7_INSIGHTLY_ENABLE', $gh_enable_widget );
}

if ( ! defined( 'GH_CF7_INSIGHTLY_API_KEY' ) ) {
    define( 'GH_CF7_INSIGHTLY_API_KEY', $gh_cf7_insightly_api_key );
}

if ( ! defined( 'GH_CF7_INSIGHTLY_API_URL' ) ) {
    define( 'GH_CF7_INSIGHTLY_API_URL', "https://api.insightly.com/v3.1/" );
}

if ( ! defined( 'GH_CF7_INSIGHTLY_MAPPING_URL' ) ) {
    define( 'GH_CF7_INSIGHTLY_MAPPING_URL', get_admin_url().'admin.php?page=gh-cf-insightly&tab=mapping' );
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gh-cf7-insightly-activator.php
 */
function activate_gh_cf7_insightly() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gh-cf7-insightly-activator.php';
	Gh_Cf7_Insightly_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gh-cf7-insightly-deactivator.php
 */
function deactivate_gh_cf7_insightly() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gh-cf7-insightly-deactivator.php';
	Gh_Cf7_Insightly_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gh_cf7_insightly' );
register_deactivation_hook( __FILE__, 'deactivate_gh_cf7_insightly' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gh-cf7-insightly.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gh_cf7_insightly() {

	$plugin = new Gh_Cf7_Insightly();
	$plugin->run();
}
run_gh_cf7_insightly();