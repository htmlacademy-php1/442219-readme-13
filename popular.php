<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');

is_not_session();

$current_user = get_user_by_id($link, $_SESSION['user_id']);
$is_popular = is_current_page('popular.php');
$layout_header = include_template('main-header.php', [
    'current_user' => $current_user,
    'is_popular' => $is_popular,
]);

$types = get_content_types($link);

if (!$types) {
    show_error($layout_header, 'Ошибка чтения БД: ' . mysqli_error($link), 'readme: популярные записи');
};

$type_id = filter_input(INPUT_GET, 'type_id');

if ($type_id) {
    $posts = get_posts_by_type($link, $type_id);
} else {
    $posts = get_popular_posts_default($link);
};

if (!$posts) {
    show_error($layout_header, 'Ошибка чтения БД: ' . mysqli_error($link),'readme: популярные записи');
};

$layout_content = include_template('main.php', [
    'posts' => $posts,
    'types' => $types,
    'type_id' => $type_id,
]);

show_layout($layout_header, $layout_content, 'readme: популярные записи');
