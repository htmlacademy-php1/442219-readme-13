<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');
require_once('validations.php');

$types = get_content_types($link);
$type_current = 'photo';

$post_content = include_template('post-add.php', [
    'types' => $types,
    'type_current' => $type_current,
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Тип контента заполненной формы
    $type_current = get_post_val('type-alias');

    // Список обязательных полей с учетом типа формы
    $required_fields = $form_required_fields[$type_current];

    // Массив ошибок
    $errors = [];

    // Проверка полей
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

    // Работа с файлом
    if ($type_current === 'photo') {
        if (!empty($_FILES['file-photo']['name'])) {
            $tmp_name = $_FILES['file-name']['tmp_name'];
            $filename = uniqid() . '.jpg';
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);

            if ($file_type !== 'image/jpeg') {
                $errors['file-photo'] = 'Загрузите изображение в формате JPEG';
            } else {
                move_uploaded_file($tmp_name, 'uploads/' . $filename);
                $new_post['photo-url'] = $filename;
            }
        } else {
            // $errors['file-photo'] = 'Вы не загрузили файл';
        }
        // TODO Дописать логику: обязательно должна быть либо ссылка либо файл с фото
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $post_content = include_template('post-add.php', [
            'types' => $types,
            'type_current' => $type_current,
            'errors' => $errors,
            'new_post' => $new_post,
        ]); // TODO Доделать отображение реальных ошибок в блоке add-errors-block.php
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

show_layout($post_content, true);

// Database table posts:
// id, created_at, title, text_content, author_quote, img_url, video_url, site_url, view_counter, user_id, type_id

// Обязательные для заполнения поля:
// Form:                             Database
// Заголовок      => heading       => title
// Ссылка YouTube => video-url     => video_url
// Текст поста    => post-text     => text_content
// Текст цитаты   => quote-text    => text_content
// Автор цитаты   => quote-author  => author_quote
// Ссылка         => post-link     => site_url
//

// Все заполняемые поля
// Лейбл	             Тип поля	              Активная вкладка	Обязательность
// Заголовок	         Простое текстовое поле	  Любая вкладка	    Да
// Ссылка из интернета	 Простое текстовое поле	  Фото	            Нет => photo-url
// Ссылка YouTube	     Простое текстовое поле	  Видео	            Да
// Текст поста	         Поле типа «textarea»	  Текст	            Да
// Текст цитаты	         Поле типа «textarea»	  Цитата	        Да
// Автор цитаты          Простое текстовое поле	  Цитата	        Да
// Ссылка	             Простое текстовое поле	  Ссылка	        Да
// Теги	                 Простое текстовое поле	  Любая вкладка	    Нет => hashtags
//
