<?php
function spld_add_like_dislike_btns($content)
{

    if (!is_single()) return $content;

    //TODO: Default value not returning.
    $like_btn_label     = get_option('spld_like_btn_label', 'Like');
    $dislike_btn_label  = get_option('spld_dislike_btn_label', 'Dislike');

    $post_id = get_the_ID();
    $user_id = get_current_user_id();

    global $wpdb;

    //QUERY: How many likes & dislikes on this post.
    $like_count     = $wpdb->get_var(sprintf("SELECT SUM(`like`) FROM %s WHERE `post_id` = %d AND `like` = 1", SPLD_TABLE_NAME, $post_id));
    $dislike_count  = $wpdb->get_var(sprintf("SELECT SUM(`dislike`) FROM %s WHERE `post_id` = %s AND `dislike` = 1", SPLD_TABLE_NAME, $post_id));

    //QUERY: Determine if this post is liked or disliked by the current user.
    $is_liked    = $wpdb->get_var(sprintf("SELECT COUNT(`id`) FROM %s WHERE `user_id` = %d AND `post_id` = %d AND `like` = 1", SPLD_TABLE_NAME, $user_id, $post_id));
    $is_disliked = $wpdb->get_var(sprintf("SELECT COUNT(`id`) FROM %s WHERE `user_id` = %d AND `post_id` = %d AND `dislike` = 1", SPLD_TABLE_NAME, $user_id, $post_id));

    $html = "<div class='spld_like_dislike_wrap'>";
    $html .= sprintf("<button data-post_id='%d' data-type='like' class='spld-btn spld-like-btn %s'>%s (<span class='count'>%d</span>)</button>", $post_id, $is_liked ? 'active' : '', $like_btn_label, $like_count);
    $html .= sprintf("<button data-post_id='%d' data-type='dislike' class='spld-btn spld-dislike-btn %s'>%s (<span class='count'>%d</span>)</button>", $post_id, $is_disliked ? 'active' : '', $dislike_btn_label, $dislike_count);
    $html .= "<div id='spld_ajax_response' class='spld_ajax_response'></div>";
    $html .= "</div>";

    $content .= $html;

    return $content;
}
