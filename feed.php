<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');
require_once('validations.php');

is_not_session();

$current_user = get_user_by_id($link, $_SESSION['user_id']);

$layout_content = include_template('feed-main.php');

show_layout($layout_content, $current_user, 'readme: лента');
