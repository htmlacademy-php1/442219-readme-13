<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');

// Получаем типы контента постов
$types = get_content_types($link);

if (!$types) {
    show_error('Ошибка чтения БД: ' . mysqli_error($link));
};

// Фильтруем посты по типу контента:
$type_id = filter_input(INPUT_GET, 'id');

if ($type_id) {
    $posts = get_posts_by_type($link, $type_id);
} else {
    // Дефолтная сортировка постов
    $posts = get_popular_posts_default($link);
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
