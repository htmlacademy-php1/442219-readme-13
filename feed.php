<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');
require_once('validations.php');

is_not_session();

$current_user = get_user_by_id($link, $_SESSION['user_id']);
$is_feed = is_current_page('feed.php');
$layout_header = include_template('main-header.php', [
    'current_user' => $current_user,
    'is_feed' => $is_feed,
]);

$layout_content = include_template('feed-main.php');

show_layout($layout_header, $layout_content, 'readme: лента');