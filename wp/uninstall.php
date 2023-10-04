<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

global $wpdb, $table_prefix;
$wp_emp = $table_prefix.'emp';

$q = "DROP TABLE `$wp_emp`;";
$wpdb->query($q);