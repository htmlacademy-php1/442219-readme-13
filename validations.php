<?php
/**
 * Обязательные для заполнения поля форм
 */
$form_required_fields = [
    'photo' => [
        'heading',
    ],
    'video' => [
        'heading',
        'video-url',
    ],
    'text' => [
        'heading',
        'post-text',
    ],
    'quote' => [
        'heading',
        'quote-text',
        'quote-author',
    ],
    'link' => [
        'heading',
        'post-link',
    ],
    'registration' => [
        'email',
        'login',
        'password',
        'password-repeat',
    ],
    'comment' => [
        'comment',
    ]
];

/**
 * Все поля форм
 */
$form_all_fields = [
    'photo' => [
        'heading' => FILTER_DEFAULT,
        'photo-url' => FILTER_DEFAULT,
        'hashtags' => FILTER_DEFAULT,
    ],
    'video' => [
        'heading' => FILTER_DEFAULT,
        'video-url' => FILTER_DEFAULT,
        'hashtags' => FILTER_DEFAULT,
    ],
    'text' => [
        'heading' => FILTER_DEFAULT,
        'post-text' => FILTER_DEFAULT,
        'hashtags' => FILTER_DEFAULT,
    ],
    'quote' => [
        'heading' => FILTER_DEFAULT,
        'quote-text' => FILTER_DEFAULT,
        'quote-author' => FILTER_DEFAULT,
        'hashtags' => FILTER_DEFAULT,
    ],
    'link' => [
        'heading' => FILTER_DEFAULT,
        'post-link' => FILTER_DEFAULT,
        'hashtags' => FILTER_DEFAULT,
    ],
    'registration' => [
        'email' => FILTER_DEFAULT,
        'login' => FILTER_DEFAULT,
        'password' => FILTER_DEFAULT,
        'password-repeat' => FILTER_DEFAULT,
    ],
    'authentication' => [
        'email' => FILTER_DEFAULT,
        'password' => FILTER_DEFAULT,
    ],
    'comment' => [
        'comment' => FILTER_DEFAULT,
    ],
];

/**
 * Правила валидации
 */
$rules = [
    'heading' => function($value) {
        return validate_length($value, 5, 200);
    },
    'photo-url' => function($value) {
        return validate_photo_url($value);
    },
    'video-url' => function($value) {
        return validate_video_url($value);
    },
    'post-text' => function($value) {
        return validate_length($value, 10, 3000);
    },
    'quote-text' => function($value) {
        return validate_length($value, 10, 200);
    },
    'quote-author' => function($value) {
        return validate_length($value, 5, 50);
    },
    'post-link' => function($value) {
        return validate_url($value);
    },
    'hashtags' => function($value) {
        return validate_hashtags($value);
    },
    'email' => function($email) {
        return validate_email($email);
    },
    'login' => function($value) {
        return validate_length($value, 4, 50);
    },
    'password' => function($value) {
        return validate_length($value, 5, 50);
    },
    'comment' => function($value) {
        $value = trim($value);
        return validate_length($value, 4, 3000);
    },
];

/**
 * Типы файлов изображений
 */
$image_type = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
    'image/gif' => '.gif',
];

/**
 * Заголовки ошибок
 */
$errors_heading = [
    'heading' => 'Заголовок',
    'photo-url' => 'Ссылка из интернета',
    'video-url' => 'Ссылка youtube',
    'post-text' => 'Текст поста',
    'quote-text' => 'Текст цитаты',
    'quote-author' => 'Автор цитаты',
    'post-link' => 'Ссылка',
    'hashtags' => 'Теги',
    'email' => 'Электронная почта',
    'login' => 'Логин',
    'password' => 'Пароль',
    'password-repeat' => 'Повтор пароля',
];

/**
 * Получает значение из POST-запроса
 */
function get_post_val($name)
{
    return $_POST[$name] ?? "";
}

/**
 * Проверяет размер строки
 * @param string $value Проверяемая строка
 * @param int $min Требуемое минимальное количество символов строки
 * @param int $max Требуемое максимальное количество символов строки
 *
 * @return string Ошибку если валидация не прошла
 */
function validate_length($value, $min, $max)
{
    if ($value) {
        $length = strlen($value);
        if ($length < $min or $length > $max) {
            return "Значение должно быть от $min до $max символов";
        }
    }

    return null;
}

// Валидация поля "Теги":
// - в поле одно или больше слов, а сами слова разделены пробелом;
// - каждый тег состоит только из одного слова;
// - привязка тегов к публикации:
//   - информацию из поля "Теги" надо разделить на отдельные теги-слова;
//   - эти теги сохраняются в отдельной таблице и ссылаются на запись из таблиы постов.
/**
 * Валидация поля "Теги"
 */
function validate_hashtags($value)
{
    if (!empty($value)) {
        validate_length($value, 4, 300);
    }
    return null;
}

/**
 * Проверяет корректность ссылки на фото
 */
function validate_photo_url($url) {
    if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
        return 'Введите корректную ссылку на фото';
    }

    return null;
}

/**
 * Проверяет корректность URL-адреса видео на youtube
 */
function validate_video_url($url) {
    if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
        return 'Введите корректную ссылку на видео';
    }
    check_youtube_url($url);
}

/**
 * Функция проверяет доступно ли видео по ссылке на youtube
 * @param string $url ссылка на видео
 *
 * @return string Ошибку если валидация не прошла
 */
function check_youtube_url($url)
{
    $id = extract_youtube_id($url);

    set_error_handler(function () {}, E_WARNING);
    $headers = get_headers('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . $id);
    restore_error_handler();

    if (!is_array($headers)) {
        return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
    }

    $err_flag = strpos($headers[0], '200') ? 200 : 404;

    if ($err_flag !== 200) {
        return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
    }

    return null;
}

/**
 * Проверяет корректность ссылки
 * @param string $url ссылка на видео
 *
 * @return string Ошибку если валидация не прошла
 */
function validate_url($url) {
    if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
        return 'Введите корректную ссылку на сайт';
    }

    return null;
}

/**
 * Проверяет корректность электронной почты
 * @param string $email адрес электронной почты
 *
 * @return string Ошибку если валидация не прошла
 */
function validate_email($email) {
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Введите корректную электронную почту';
    }

    return null;
}
