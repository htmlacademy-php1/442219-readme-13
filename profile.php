<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');
require_once('validations.php');

is_not_session();

$current_user = get_user_by_id($link, $_SESSION['user_id']);
$link_ref = $_SERVER['HTTP_REFERER'];

$layout_header = include_template('main-header.php', [
    'current_user' => $current_user,
]);

$user_id = filter_input(INPUT_GET, 'user_id');
if (!$user_id) {
    show_error($layout_header, 'Запрошенная страница не найдена на сервере: ' . '404', 'readme: профиль пользователя');
}

$user = get_profile_user_by_index($link, $user_id);
if (!$user) {
    show_error($layout_header, 'Запрошенная страница не найдена на сервере: ' . '404', 'readme: профиль пользователя');
}

$is_show_comments = false;
$is_not_you = $user['id'] !== $current_user['id'];

$user_posts = get_posts_by_user($link, $user_id);

$user_subscribe = get_subscribers_by_user($link, $user_id)['count_sub'];

$user_publications = get_posting_by_user($link, $user_id)['count_posts'];

$is_subscribe = !empty(get_id_subscriber_by_user($link, $user['id'], $current_user['id']));
$comments = get_comments_post($link, $post['post_id']);

$layout_content = include_template('profile-main.php', [
    'user' => $user,
    'user_posts' => $user_posts,
    'user_subscribe' => $user_subscribe,
    'user_publications' => $user_publications,
    'current_user' => $current_user,
    'is_subscribe' => $is_subscribe,
    'is_not_you' => $is_not_you,
    'comments' => $comments,
    'is_show_comments' => $is_show_comments,
]);

show_layout($layout_header, $layout_content, 'readme: профиль пользователя');
