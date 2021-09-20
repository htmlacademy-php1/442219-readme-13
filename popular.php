<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');

is_not_session();

$current_user = get_user_by_id($link, $_SESSION['user_id']);
$current_page = filter_input(INPUT_GET, 'page') ?? 1;
$sort_post = filter_input(INPUT_GET, 'sort') ?? 'popular';
$type_id = filter_input(INPUT_GET, 'type_id') ?? 0;
$max_posts = MAX_POSTS;
$page_prev_url = '';
$page_next_url = '';

$is_popular = is_current_page('popular.php');
$layout_header = include_template('main-header.php', [
    'current_user' => $current_user,
    'is_popular' => $is_popular,
]);

if ($type_id) {
    $count_posts = mysqli_num_rows(mysqli_query($link, "SELECT id FROM posts WHERE posts.type_id = $type_id;"));
} else {
    $count_posts = mysqli_num_rows(mysqli_query($link,'SELECT id FROM posts;'));
};

$types = get_arr_from_mysql($link, 'SELECT id, title, alias FROM types;');

if (!$types) {
    show_error($layout_header, 'Ошибка чтения БД: ' . mysqli_error($link), 'readme: популярные записи');
};

$pages_count = ceil($count_posts / $max_posts);
$offset = ($current_page - 1) * $max_posts;

if ($type_id) {
    $posts = get_posts_by_type($link, $type_id, $offset);
} else {
    $posts = get_popular_posts_default($link, $sort_post, $offset);
};

if (!$posts) {
    show_error($layout_header, 'Ошибка чтения БД: ' . mysqli_error($link),'readme: популярные записи');
};

if ($current_page > 1) {
    $page_prev = $current_page - 1;
    $page_prev_url = 'popular.php?page=' . $page_prev . '&type_id=' . $type_id;
}

if ($current_page < $pages_count) {
    $page_next = $current_page + 1;
    $page_next_url = 'popular.php?page=' . $page_next . '&type_id=' . $type_id;
}

$layout_content = include_template('popular-main.php', [
    'posts' => $posts,
    'types' => $types,
    'type_id' => $type_id,
    'pages_count' => $pages_count,
    'page_prev_url' => $page_prev_url,
    'page_next_url' => $page_next_url,
]);

show_layout($layout_header, $layout_content, 'readme: популярные записи');
