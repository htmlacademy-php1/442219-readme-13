<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');

is_not_session();

$current_user = get_user_by_id($link, $_SESSION['user_id']);

$post_id = filter_input(INPUT_GET, 'post_id');
if (!$post_id) {
    // show_error('Запрошенная страница не найдена на сервере: ' . '404');
}

$post = get_posts_by_index($link, $post_id);
if (!$post) {
    // show_error('Запрошенная страница не найдена на сервере: ' . '404');
}

$subscribers = get_subscribers_by_user($link, $post['id_user']);

$posting = get_posting_by_user($link, $post['id_user']);

$layout_header = include_template('popular-header.php', ['current_user' => $current_user]);

$post_content = include_template('post-preview.php', [
    'post' => $post,
    'subscribers' => $subscribers,
    'posting' => $posting,
]);

show_layout($layout_header, $post_content, 'readme: пост');
