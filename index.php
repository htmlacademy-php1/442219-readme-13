<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');

// Получаем типы контента постов
$sql_types = get_content_types();

// Дефолтная сортировка постов
$sql_posts = get_popular_posts_default();

$types = get_arr_from_mysql($link, $sql_types);

if (!$types) {
    show_error('Ошибка чтения БД: ' . mysqli_error($link));
};

// Фильтруем посты по типу контента:
$type_id = filter_input(INPUT_GET, 'id');

if ($type_id) {
    $sql_posts = get_posts_by_type();

    $posts = db_execute_stmt_all($link, $sql_posts, [$type_id]);
} else {
    $posts = get_arr_from_mysql($link, $sql_posts);
};

if (!$posts) {
    show_error('Ошибка чтения БД: ' . mysqli_error($link));
};

$layout_content = include_template('main.php', [
    'posts' => $posts,
    'types' => $types,
    'type_id' => $type_id,
]);

show_layout($layout_content);
