<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');

$post_id = filter_input(INPUT_GET, 'id');
if (!$post_id) {
    show_error('Запрошенная страница не найдена на сервере: ' . '404');
}

// Выбираем пост по ID в запросе
$post = get_posts_by_index($link, $post_id);
if (!$post) {
    show_error('Запрошенная страница не найдена на сервере: ' . '404');
}

// Выбираем число подписчиков у автора поста
$subscribers = get_subscribers_by_user($link, $post['id_user']);

// Выбираем число публикаций у автора поста
$posting = get_posting_by_user($link, $post['id_user']);

$post_content = include_template('post-preview.php', [
    'post' => $post,
    'subscribers' => $subscribers,
    'posting' => $posting,
]);

show_layout($post_content);
