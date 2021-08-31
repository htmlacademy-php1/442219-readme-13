<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');

$sql_types = get_content_types();
$types = get_arr_from_mysql($link, $sql_types);
$type_current = 'photo';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // форма отправлена
    // Список обязательных полей
    $required_fields = $form_required_fields[$type_current];
    $errors = [];

    // Порядок валидации:
    // 1. Определить обязательные к заполнению поля;
    // 2. Нужен ли формат данных для полей: email, номер телефона, формат пароля;
    // 3. Проверить каждое поле на заполненность и соответствие формату;
    // 4. Сохранить список ошибок;
    // 5. Показать ошибки в форме и подсветить нужные поля.

    // Проверка заполненности поля
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }

    if (count($errors)) {
        // показать ошибку валидации
        // var_dump($errors);
    }

    print('<br> Form posting '); // For debugging

}

$post_content = include_template('post-add.php', [
    'types' => $types,
    'type_current' => $type_current,
]);

show_layout($post_content, true);

// Database table posts:
// id, created_at, title, text_content, author_quote, img_url, video_url, site_url, view_counter, user_id, type_id

// Обязательные для заполнения поля:
// Form:                             Database
// Заголовок      => photo-heading =>
//                   video-heading =>
//                   text-heading  =>
//                   quote-heading =>
//                   link-heading  =>
// Ссылка YouTube => video-url     =>
// Текст поста    => post-text     =>
// Текст цитаты   => quote-text    =>
// Автор цитаты   => quote-author  =>
// Ссылка         => post-link     =>
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
// Теги	                 Простое текстовое поле	  Любая вкладка	    Нет => photo-tags
//                                                                         video-tags
//                                                                         text-tags
//                                                                         quote-tags
//                                                                         link-tags
