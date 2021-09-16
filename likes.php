<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');
require_once('validations.php');

is_not_session();

$current_user = get_user_by_id($link, $_SESSION['user_id']);
$link_ref = get_path_referer();

$post_id = filter_input(INPUT_GET, 'post_id');

$post = get_posts_by_index($link, $post_id);

if (!$post) {
    header("Location: /$link_ref");
    exit;
}

$is_post_likes = !empty(get_like_by_post($link, $post['post_id'], $current_user['id']));

if ($is_post_likes) {
    header("Location: /$link_ref");
    exit;
}

if (!$is_post_likes) {
    add_like_post($link, $current_user['user_id'], $post['post_id']);
    header("Location: /$link_ref");
    exit;
}
