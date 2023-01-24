<?php
function spld_handle_like_dislike()
{
    $response = ['type' => 'error'];

    $type    = $_POST['type'];
    $post_id = $_POST['post_id'];
    $user_id = get_current_user_id();

    if ($user_id === 0) {
        $response['message'] = sprintf("<a href='%s'>Login</a> to send your feedback.", wp_login_url(get_permalink($post_id)));
    } else {
        if (isset($post_id)) {

            // QUERY: Checking if this post liked or disliked by the current user.
            $check = spld_check_like_dislike_by_user($user_id, $post_id, $type);

            if ($type === 'like') {

                // If already like it then send an error.
                if ($check > 0) {
                    $response['message'] = "You already {$type} this post.";
                } else {

                    // QUERY: Checking if this post disliked by the current user.
                    $check_dislike = spld_check_like_dislike_by_user($user_id, $post_id, 'dislike');
                    $is_liked = false;
                    // If dislike then revert it.
                    if ($check_dislike > 0) {
                        $is_reverted = spld_revert_like_dislike($type, $user_id, $post_id);
                    } else {
                        $is_liked = spld_like_it($user_id, $post_id);
                        print_r($is_liked);
                        exit();
                    }

                    if ($is_reverted || $is_liked) {
                        $response = ['type' => 'success', 'message' => 'Thank you for loving this post!'];
                    }
                }
            } else {

                if ($check > 0) {
                    $response = $response['message'] = "You already {$type} this post.";
                } else {

                    $check_like = spld_check_like_dislike_by_user($user_id, $post_id, 'like');
                    $is_disliked = false;

                    if ($check_like > 0) {

                        $is_reverted = spld_revert_like_dislike($type, $user_id, $post_id);
                    } else {

                        $is_disliked = spld_disspld_like_it($user_id, $post_id);
                    }

                    if ($is_reverted || $is_disliked) {
                        $response = ['type' => 'success', 'message' => 'Thank you for your feedback!'];
                    }
                }
            }
        }
    }


    $result = json_encode($response);
    echo $result;
    wp_die();
}

function spld_check_like_dislike_by_user($user_id, $post_id, $type)
{
    global $wpdb;

    return $wpdb->get_var(sprintf("SELECT COUNT(*) FROM %s WHERE `user_id` = %d AND `post_id` = %d AND `%s` = 1", SPLD_TABLE_NAME, $user_id, $post_id, $type));
}

function spld_revert_like_dislike($type, $user_id, $post_id)
{
    global $wpdb;

    $like    = 1;
    $dislike = 0;

    if ($type === 'dislike') {
        $like    = 0;
        $dislike = 1;
    }

    return $wpdb->update(
        SPLD_TABLE_NAME,
        array(
            'like'    => $like,
            'dislike' => $dislike
        ),
        array(
            'user_id' => $user_id,
            'post_id' => $post_id
        ),
        array(
            '%d', '%d'
        ),
        array('%d', '%d')
    );
}

function spld_like_it($user_id, $post_id)
{

    global $wpdb;


    $inserted = $wpdb->insert(
        SPLD_TABLE_NAME,
        array(
            'user_id' => $user_id,
            'post_id'   => $post_id,
            'like'  => 1,
        ),
        array(
            '%d', '%d', '%d'
        )
    );

    print_r($inserted);
    exit();
}

function spld_disspld_like_it($user_id, $post_id)
{
    global $wpdb;
    $wpdb->insert(SPLD_TABLE_NAME, array(
        'user_id' => $user_id,
        'post_id'   => $post_id,
        'dislike'  => 1,
        'created_at' => current_time('mysql')
    ), array(
        '%d', '%d', '%d, %s'
    ));
}
