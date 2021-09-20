<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');
require_once('validations.php');

is_not_session();

$current_user = get_user_by_id($link, $_SESSION['user_id']);

$sub_id = filter_input(INPUT_GET, 'user_id');
$user = get_profile_user_by_index($link, $sub_id);
$is_subscribe = !empty(get_id_subscriber_by_user($link, $user['id'], $current_user['id']));
$link_ref = get_path_referer();

if (!$user) {
    header("Location: /$link_ref");
    exit;
}

if (!$is_subscribe) {
    add_new_subscriber($link, $sub_id, $current_user['id']);
    header("Location: /$link_ref");
    exit;
}

if ($is_subscribe) {
    del_id_subscriber_by_user($link, $sub_id, $current_user['id']);
    header("Location: /$link_ref");
    exit;
}

// TODO добавить отправку уведомлений
