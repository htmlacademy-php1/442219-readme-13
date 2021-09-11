<?php
/**
 * Получает массив типов контента постов
 * @param object $connect Текущее соединение с сервером MySQL
 *
 * @return array Ассоциативный массив типов постов
 */
function get_content_types($connect)
{
    return get_arr_from_mysql($connect, 'SELECT id, title, alias FROM types;');
}

/**
 * Получает массив популярных постов для дефолтных состояний сортировки и фильтра типов постов
 * @param string $limit_posts Максимальное количество постов показываемы на странице
 * @param object $connect Текущее соединение с сервером MySQL
 *
 * @return array Ассоциативный массив популярных постов
 */
function get_popular_posts_default($connect, $limit_posts = '9')
{
    $sql = "SELECT COUNT(likes.id) likes, posts.view_counter AS views, posts.id AS post_id, posts.title, posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, user_name AS author, types.alias, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id LEFT OUTER JOIN likes ON posts.id = likes.post_id GROUP BY posts.id ORDER BY posts.view_counter DESC LIMIT $limit_posts;";

    return get_arr_from_mysql($connect, $sql);
}

/**
 * Получает массив постов с учетом типа контента
 * @param string $type_id Индекс типа контента постов
 * @param object $connect Текущее соединение с сервером MySQL
 *
 * @return array Массив постов выбранных по типу
 */
function get_posts_by_type($connect, $type_id)
{
    $sql = "SELECT COUNT(likes.id) likes, posts.id AS post_id, posts.title, posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, user_name AS author, types.alias, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id LEFT OUTER JOIN likes ON posts.id = likes.post_id WHERE types.id = ? GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;";

    return db_execute_stmt_all($connect, $sql, [$type_id]);
}

/**
 * Получает пост по его индексу
 * @param string $post_id Индекс поста
 * @param object $connect Текущее соединение с сервером MySQL
 *
 * @return array Ассоциативный массив информации о посте выбранного по индексу
 */
function get_posts_by_index($connect, $post_id)
{
    $sql = "SELECT COUNT(likes.id) likes, posts.id, posts.title, posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, posts.view_counter, users.id AS id_user, user_name AS author, types.alias, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id LEFT OUTER JOIN likes ON posts.id = likes.post_id WHERE posts.id = ? GROUP BY posts.id;";

    return db_execute_stmt_assoc($connect, $sql, [$post_id]);
}

/**
 * Получает число подписчиков у автора поста
 * @param string $author_id ID автора поста
 * @param object $connect Текущее соединение с сервером MySQL
 *
 * @return array Число подписчиков
 */
function get_subscribers_by_user($connect, $author_id)
{
    $sql = "SELECT COUNT(author_id) count_sub FROM subscriptions WHERE author_id = ?;";

    $result = db_execute_stmt_assoc($connect, $sql, [$author_id]);

    return $result;
}

/**
 * Получает число публикаций у автора поста
 * @param string $author_id ID автора поста
 * @param object $connect Текущее соединение с сервером MySQL
 *
 * @return array Число публикаций
 */
function get_posting_by_user($connect, $author_id)
{
    $sql = "SELECT COUNT(posts.user_id) count_posts FROM posts WHERE posts.user_id = ?;";

    return db_execute_stmt_assoc($connect, $sql, [$author_id]);
}

/**
 * Добавляет запись о фото посте в БД
 * @param string $title Заголовок поста
 * @param string $img_url Ссылка на сохраненный файл изображения
 * @param int $user_id ID автора поста
 * @param int $type_id ID типа контента поста
 *
 * @return boolean Успешное выполнение
 */
function add_post_photo($connect, $title, $img_url, $user_id, $type_id = 1)
{
    $sql = "INSERT INTO posts (created_at, title, text_content, author_quote, img_url, video_url, site_url, view_counter, user_id, type_id)
    VALUES (NOW(), ?, NULL, NULL, ?, NULL, NULL, 0, $user_id, $type_id);";

    $stmt = db_get_prepare_stmt($connect, $sql, [$title, $img_url]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Добавляет запись о видео посте в БД
 * @param string $title Заголовок поста
 * @param string $video_url Ссылка на видео с youtube
 * @param int $user_id ID автора поста
 * @param int $type_id ID типа сонтента поста
 *
 * @return boolean Успешное выполнение
 */
function add_post_video($connect, $title, $video_url, $user_id, $type_id = 2)
{
    $sql = "INSERT INTO posts (created_at, title, text_content, author_quote, img_url, video_url, site_url, view_counter, user_id, type_id)
    VALUES (NOW(), ?, NULL, NULL, NULL, ?, NULL, 0, $user_id, $type_id);";

    $stmt = db_get_prepare_stmt($connect, $sql, [$title, $video_url]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Добавляет запись о текстовом посте в БД
 * @param string $title Заголовок поста
 * @param string $text_content Текстовое содержание
 * @param int $user_id ID автора поста
 * @param int $type_id ID типа сонтента поста
 *
 * @return boolean Успешное выполнение
 */
function add_post_text($connect, $title, $text_content, $user_id, $type_id = 3)
{
    $sql = "INSERT INTO posts (created_at, title, text_content, author_quote, img_url, video_url, site_url, view_counter, user_id, type_id)
    VALUES (NOW(), ?, ?, NULL, NULL, NULL, NULL, 0, $user_id, $type_id);";

    $stmt = db_get_prepare_stmt($connect, $sql, [$title, $text_content]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Добавляет запись о посте цитате в БД
 * @param string $title Заголовок поста
 * @param string $text_content Текстовое содержание
 * @param string $author_quote Автор цитаты
 * @param int $user_id ID автора поста
 *
 * @return boolean Успешное выполнение
 */
function add_post_quote($connect, $title, $text_content, $author_quote, $user_id, $type_id = 4)
{
    $sql = "INSERT INTO posts (created_at, title, text_content, author_quote, img_url, video_url, site_url, view_counter, user_id, type_id)
    VALUES (NOW(), ?, ?, ?, NULL, NULL, NULL, 0, $user_id, $type_id);";

    $stmt = db_get_prepare_stmt($connect, $sql, [$title, $text_content, $author_quote]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Добавляет запись о посте ссылке в БД
 * @param string $title Заголовок поста
 * @param string $site_url ссылка на сайт
 * @param int $user_id ID автора поста
 * @param int $type_id ID типа сонтента поста
 *
 * @return boolean Успешное выполнение
 */
function add_post_link($connect, $title, $site_url, $user_id, $type_id = 5)
{
    $sql = "INSERT INTO posts (created_at, title, text_content, author_quote, img_url, video_url, site_url, view_counter, user_id, type_id)
    VALUES (NOW(), ?, NULL, NULL, NULL, NULL, ?, 0, $user_id, $type_id);";

    $stmt = db_get_prepare_stmt($connect, $sql, [$title, $site_url]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Добавляет нового пользователя в БД
 */
function add_new_user($connect, $email, $user_name, $user_password, $avatar_url = '')
{
    $sql = "INSERT INTO users (registered_at, email, user_name, user_password, avatar_url) VALUES (NOW(), ?, ?, ?, ?);";
    $stmt = db_get_prepare_stmt($connect, $sql, [$email, $user_name, $user_password, $avatar_url]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Получает пользователя по email
 * @param string $user_email Email пользователя
 * @param object $connect Текущее соединение с сервером MySQL
 *
 * @return array Данные пользователя
 */
function get_user_by_email($connect, $user_email)
{
    $sql = "SELECT * FROM users WHERE email = ?;";

    return db_execute_stmt_assoc($connect, $sql, [$user_email]);
}

/**
 * Получает пользователя по его ID
 * @param string $user_id ID пользователя
 * @param object $connect Текущее соединение с сервером MySQL
 *
 * @return array Данные пользователя
 */
function get_user_by_id($connect, $user_id)
{
    $sql = "SELECT * FROM users WHERE id = ?;";

    return db_execute_stmt_assoc($connect, $sql, [$user_id]);
}

/**
 * Проверяет есть сессия с пользователем
 *
 * @return Если нет сессии перенапрявляет на страницу входа
 */
function is_not_session()
{
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: /index.php");
        exit();
    }
}
