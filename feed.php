<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');

is_not_session();

$current_user = get_user_by_id($link, $_SESSION['user_id']);
$is_feed = is_current_page('feed.php');
$type_id = filter_input(INPUT_GET, 'type_id') ?? 0;
$layout_header = include_template('main-header.php', [
    'current_user' => $current_user,
    'is_feed' => $is_feed,
]);

$types = get_arr_from_mysql($link, 'SELECT id, title, alias FROM types;');

if (!$types) {
    show_error($layout_header, 'Ошибка чтения БД: ' . mysqli_error($link), 'readme: моя лента');
};

if ($type_id) {
    $posts = get_posts_by_user_type($link, $current_user['id'], $type_id);
} else {
    $posts = get_posts_by_user($link, $current_user['id']);
};

$layout_content = include_template('feed-main.php', [
    'posts' => $posts,
    'types' => $types,
    'type_id' => $type_id,
]);

show_layout($layout_header, $layout_content, 'readme: лента');
