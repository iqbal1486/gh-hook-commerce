<?php

/**
 * Fired during plugin activation
 *
 * @link       https://profiles.wordpress.org/iqbal1486/
 * @since      1.0.0
 *
 * @package    Gh_Cf7_Insightly
 * @subpackage Gh_Cf7_Insightly/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Gh_Cf7_Insightly
 * @subpackage Gh_Cf7_Insightly/includes
 * @author     Momin Iqbal <Iqbal.Brightnessgroup@gmail.com>
 */
class Gh_Cf7_Insightly_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb; 
		$db_table_name = GH_CF7_INSIGHTLY_TABLE_MAPPING;
		$charset_collate = $wpdb->get_charset_collate();

		//Check to see if the table exists already, if not, then create it
		if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
		{
		   $sql = "CREATE TABLE $db_table_name (
		            id int(11) NOT NULL auto_increment,
		            form_ID int(11) NOT NULL,
		            mapping text NOT NULL,
		            UNIQUE KEY id (id),
		            UNIQUE KEY form_ID (form_ID)
		    ) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option( 'test_db_version', $test_db_version );
		}
	}

}
