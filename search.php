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

$query = trim(get_value_get('search'));
$posts_search = [];

if ($query) {
    $posts_search = get_posts_by_search($link, $query);
}

$layout_header = include_template('main-header.php', [
    'current_user' => $current_user,
    'query' => $query,
]);

$layout_content = include_template('search-main.php', [
    'posts_search' => $posts_search,
    'query' => $query,
    'link_ref' => $link_ref,
]);

show_layout($layout_header, $layout_content, 'readme: результаты поиска');
