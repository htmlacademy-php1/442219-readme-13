<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');
require_once('validations.php');

is_not_session();

$current_user = get_user_by_id($link, $_SESSION['user_id']);
$is_add = is_current_page('add.php');
$link_ref = $_SERVER['HTTP_REFERER'];

$types = get_content_types($link);
$type_current = 'photo';

$post_content = include_template('post-add.php', [
    'types' => $types,
    'type_current' => $type_current,
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type_current = get_post_val('type-alias');
    $required_fields = $form_required_fields[$type_current];
    $errors = [];
    $new_post = filter_input_array(INPUT_POST, $form_all_fields[$type_current], true);

    foreach ($new_post as $field_form => $content_field_form) {
        if (isset($rules[$field_form])) {
            $rule = $rules[$field_form];
            $errors[$field_form] = $rule($content_field_form);
        }
        if (in_array($field_form, $required_fields) && empty($content_field_form)) {
            $errors[$field_form] = "Заполните это поле";
        }
    }

    if ($type_current === 'photo') {
        if (!empty($_FILES['file-photo']['name'])) {
            $tmp_name = $_FILES['file-name']['tmp_name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);
            $file_ext = get_file_extension($file_type, $image_type);
            if ($file_ext) {
                $filename = uniqid() . $file_ext;
                move_uploaded_file($tmp_name, 'uploads/' . $filename);
                $new_post['photo-url'] = $filename;
            } else {
                $errors['file-photo'] = 'Загрузите изображение в формате JPEG, PNG или GIF';
            }
        } elseif (empty($new_post['photo-url'])) {
            $errors['photo-url'] = 'Загрузите фото или укажите ссылку на фото из интернета';
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $post_content = include_template('post-add.php', [
            'types' => $types,
            'type_current' => $type_current,
            'errors' => $errors,
            'errors_heading' => $errors_heading,
            'new_post' => $new_post,
        ]);
    } else {
        switch ($type_current) {
            case 'photo':
                $new_post_bd = add_post_photo($link, $new_post['heading'], $new_post['photo-url'], 1);
                break;
            case 'video':
                $new_post_bd = add_post_video($link, $new_post['heading'], $new_post['video-url'], 1);
                break;
            case 'text':
                $new_post_bd = add_post_text($link, $new_post['heading'], $new_post['post-text'], 1);
                break;
            case 'quote':
                $new_post_bd = add_post_quote($link, $new_post['heading'], $new_post['quote-text'], $new_post['quote-author'], 1);
                break;
            case 'link':
                $new_post_bd = add_post_link($link, $new_post['heading'], $new_post['post-link'], 1);
                break;
        }

        if ($new_post_bd) {
            $new_post_id = mysqli_insert_id($link);
            header("Location: /post.php?id=" . $new_post_id);
        }
    }
}

$layout_header = include_template('main-header.php', [
    'current_user' => $current_user,
    'is_add' => $is_add,
    'link_ref' => $link_ref,
]);

show_layout($layout_header, $post_content, 'readme: публикация поста');
