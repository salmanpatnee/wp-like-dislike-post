<?php
function spld_activation(){
    global $wpdb;
     
    $charset_collate = $wpdb->get_charset_collate();

    $sql = sprintf("CREATE TABLE IF NOT EXISTS %s (`id` BIGINT(20) NOT NULL AUTO_INCREMENT , `user_id` BIGINT(20) NOT NULL , `post_id` BIGINT(20) NOT NULL , `like` MEDIUMINT(9) NULL , `dislike` MEDIUMINT(9) NULL , `created_at` DATETIME NOT NULL , PRIMARY KEY (`id`)) %s;", SPLD_TABLE_NAME, $charset_collate);

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}