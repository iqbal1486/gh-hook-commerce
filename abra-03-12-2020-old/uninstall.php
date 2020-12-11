<?php
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;
global $wpdb, $wp_version;

/**
 * Defined ABRAC_REMOVE_ALL_DATA to true to remove all data on uninstallation
 * 
 */
if ( ! defined( 'ABRAC_REMOVE_ALL_DATA' ) ) {
    define( 'ABRAC_REMOVE_ALL_DATA', true );
}


if ( defined( 'ABRAC_REMOVE_ALL_DATA' ) && true === ABRAC_REMOVE_ALL_DATA ) {
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}abra_transaction" );
}
wp_cache_flush();