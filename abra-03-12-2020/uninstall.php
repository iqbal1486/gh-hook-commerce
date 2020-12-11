<?php

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;
global $wpdb, $wp_version;

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}transak_transaction" );

wp_cache_flush();
?>