<?php
function spld_activation(){
    global $wpdb;
    
    $table_name = $wpdb->prefix . "spld_post_like_dislike"; 
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (`id` BIGINT(20) NOT NULL AUTO_INCREMENT , `user_id` BIGINT(20) NOT NULL , `post_id` BIGINT(20) NOT NULL , `like` MEDIUMINT(9) NULL , `dislike` MEDIUMINT(9) NULL , `created_at` DATETIME NOT NULL , PRIMARY KEY (`id`)) {$charset_collate};";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}