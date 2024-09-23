<?php 
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

global $wpdb;
$forms_table = $wpdb->prefix . "formcraft_b_forms";
$submissions_table = $wpdb->prefix . "formcraft_b_submissions";
$views_table = $wpdb->prefix . "formcraft_b_views";

// phpcs:ignore
$wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS $forms_table" ) );
// phpcs:ignore
$wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS $submissions_table" ) );
// phpcs:ignore
$wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS $views_table" ) );

?>