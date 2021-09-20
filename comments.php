<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');
require_once('validations.php');

is_not_session();

$current_user = get_user_by_id($link, $_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $current_post = get_post_val('post-id');
    $post = get_posts_by_index($link, $current_post);

    if (!$post) {
        show_error($layout_header, 'Запрошенная страница не найдена на сервере: ' . '404', 'readme: просмотр поста');
    }

    $required_fields = $form_required_fields['comment'];

    $new_comment = filter_input_array(INPUT_POST, $form_all_fields['comment'], true);

    foreach ($new_comment as $field_form => $content_field_form) {
        if (isset($rules[$field_form])) {
            $rule = $rules[$field_form];
            $errors[$field_form] = $rule($content_field_form);
        }
        if (in_array($field_form, $required_fields) && empty($content_field_form)) {
            $errors[$field_form] = "Заполните это поле";
        }
    }

    $errors = array_filter($errors);
    if (count($errors)) {
        header("Location: /post.php?post_id=$current_post");
        exit();
        // $post_content = include_template('post-preview.php', [
            // 'errors' => $errors,
            // 'post' => $post,
            // 'subscribers' => $subscribers,
            // 'posting' => $posting,
            // 'comments' => $comments,
        // ]);
    }

    if (add_comment($link, trim($new_comment['comment']), $current_user['id'], $current_post)) {
        header("Location: /profile.php?user_id=" . $post['id_user']);
        exit();
    }
}
