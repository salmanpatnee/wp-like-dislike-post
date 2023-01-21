<?php
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
global $wpdb;
$table_name = $wpdb->prefix . "spld_post_like_dislike";
$wpdb->query(sprintf("DROP TABLE IF EXISTS %s", $table_name));