<?php
/**
 * Получает массив популярных постов для дефолтных состояний сортировки и фильтра типов постов
 * @param int $limit_posts Максимальное количество постов показываемы на странице
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $sort Вид сортировки постов показываемы на странице
 *
 * @return array Ассоциативный массив популярных постов
 */
function get_popular_posts_default($connect, $sort_post, $offset = 0, $limit_posts = MAX_POSTS)
{
    switch ($sort_post) {
        case 'popular':
            $sort = 'posts.view_counter';
            break;
        case 'like':
            $sort = 'COUNT(likes.id)';
            break;
        case 'date':
            //
            break;
    }

    $sql = "SELECT COUNT(likes.id) likes, COUNT(comments.id) comments, posts.view_counter AS views, posts.id AS post_id, posts.title, posts.text_content, "
    . "posts.created_at, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, posts.user_id, user_name AS author, types.alias, users.avatar_url "
    . "FROM posts "
    . "JOIN users ON posts.user_id = users.id "
    . "JOIN types ON posts.type_id = types.id "
    . "LEFT OUTER JOIN likes ON posts.id = likes.post_id "
    . "LEFT OUTER JOIN comments ON posts.id = comments.post_id "
    . "GROUP BY posts.id ORDER BY $sort DESC LIMIT $limit_posts OFFSET $offset;";

    return get_arr_from_mysql($connect, $sql);
}

/**
 * Получает массив постов с учетом типа контента
 * @param string $type_id Индекс типа контента постов
 * @param object $connect Текущее соединение с сервером MySQL
 *
 * @return array Массив постов выбранных по типу
 */
function get_posts_by_type($connect, $type_id, $offset = 0, $limit_posts = MAX_POSTS)
{
    $sql = "SELECT COUNT(likes.id) likes, COUNT(comments.id) comments, posts.id AS post_id, posts.created_at, posts.title, posts.text_content, posts.author_quote, "
    . "posts.img_url, posts.video_url, posts.site_url, posts.user_id, user_name AS author, types.alias, users.avatar_url "
    . "FROM posts "
    . "JOIN users ON posts.user_id = users.id "
    . "JOIN types ON posts.type_id = types.id "
    . "LEFT OUTER JOIN likes ON posts.id = likes.post_id "
    . "LEFT OUTER JOIN comments ON posts.id = comments.post_id "
    . "WHERE types.id = ? GROUP BY posts.id ORDER BY posts.view_counter DESC LIMIT $limit_posts OFFSET $offset;";

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
    $sql = "SELECT COUNT(likes.id) likes, COUNT(comments.id) comments, posts.id AS post_id, posts.created_at, posts.title, posts.text_content, posts.author_quote, posts.img_url, "
    . "posts.video_url, posts.site_url, posts.view_counter, users.id AS id_user, user_name AS author, users.registered_at, types.alias, users.avatar_url "
    . "FROM posts "
    . "JOIN users ON posts.user_id = users.id "
    . "JOIN types ON posts.type_id = types.id "
    . "LEFT OUTER JOIN likes ON posts.id = likes.post_id "
    . "LEFT OUTER JOIN comments ON posts.id = comments.post_id "
    . "WHERE posts.id = ? GROUP BY posts.id;";

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
 * Получает массив публикаций пользователя
 * @param string $author_id Индекс пользователя
 * @param object $connect Текущее соединение с сервером MySQL
 *
 * @return array Массив постов пользователя
 */
function get_posts_by_user($connect, $author_id)
{
    $sql = "SELECT COUNT(likes.id) likes, COUNT(comments.id) comments, posts.id AS post_id, posts.title, posts.text_content, posts.author_quote, "
    . "posts.img_url, posts.video_url, posts.site_url, posts.user_id, user_name AS author, types.alias, users.avatar_url "
    . "FROM posts "
    . "JOIN users ON posts.user_id = users.id "
    . "JOIN types ON posts.type_id = types.id "
    . "LEFT OUTER JOIN likes ON posts.id = likes.post_id "
    . "LEFT OUTER JOIN comments ON posts.id = comments.post_id "
    . "WHERE posts.user_id = ? GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;";

    return db_execute_stmt_all($connect, $sql, [$author_id]);
}

/**
 * Получает массив публикаций пользователя определенного типа
 * @param string $author_id Индекс пользователя
 * @param string $type_id Индекс типа контента
 * @param object $connect Текущее соединение с сервером MySQL
 *
 * @return array Массив постов пользователя
 */
function get_posts_by_user_type($connect, $author_id, $type_id)
{
    $sql = "SELECT COUNT(likes.id) likes, COUNT(comments.id) comments, posts.id AS post_id, posts.title, posts.text_content, posts.author_quote, "
    . "posts.img_url, posts.video_url, posts.site_url, posts.user_id, user_name AS author, types.alias, users.avatar_url "
    . "FROM posts "
    . "JOIN users ON posts.user_id = users.id "
    . "JOIN types ON posts.type_id = types.id "
    . "LEFT OUTER JOIN likes ON posts.id = likes.post_id "
    . "LEFT OUTER JOIN comments ON posts.id = comments.post_id "
    . "WHERE posts.user_id = ? AND types.id = ? GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;";

    return db_execute_stmt_all($connect, $sql, [$author_id, $type_id]);
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
 * @return bool Успешное выполнение
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
 * @return bool Успешное выполнение
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
 * @return bool Успешное выполнение
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
 * @return bool Успешное выполнение
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
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $title Заголовок поста
 * @param string $site_url ссылка на сайт
 * @param int $user_id ID автора поста
 * @param int $type_id ID типа сонтента поста
 *
 * @return bool Успешное выполнение
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
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $email Email пользователя
 * @param string $user_name Имя пользователя
 * @param string $user_password Пароль пользователя
 * @param string $avatar_url Путь к аватарке пользователя
 *
 * @return bool Успешное выполнение
 */
function add_new_user($connect, $email, $user_name, $user_password, $avatar_url = NULL)
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

/**
 * Получает посты с результами полнотекстового поиска
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $query Искомое слово
 *
 * @return array Посты с найденным словом по убыванию релевантности
 */
function get_posts_by_search($connect, $query)
{
    $sql = "SELECT posts.id, posts.created_at, posts.title, posts.text_content, posts.author_quote, posts.img_url, posts.video_url, "
    . "posts.site_url, posts.view_counter, users.id AS id_user, user_name AS author, types.alias, users.avatar_url "
    . "FROM posts JOIN users ON posts.user_id = users.id "
    . "JOIN types ON posts.type_id = types.id "
    // . "LEFT OUTER JOIN likes ON posts.id = likes.post_id "
    . "WHERE MATCH(posts.title, posts.text_content) AGAINST(?);";

    return db_execute_stmt_all($connect, $sql, [$query]);
}

/**
 * Получает количество лайков для поста
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $post_id ID поста
 *
 * @return array Количество лайков
 */
function get_likes_by_posts($connect, $post_id)
{
    $sql = "SELECT posts.id AS post_id, COUNT(likes.id) count_likes "
    . "FROM likes "
    . "JOIN posts on posts.id = likes.post_id "
    . "WHERE post_id = ?;";

    return db_execute_stmt_assoc($connect, $sql, [$post_id]);
}

/**
 * Получает информацию о пользователе по его ID
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $user_id ID пользователя
 *
 * @return array Информация о пользователе
 */
function get_profile_user_by_index($connect, $user_id)
{
    $sql = "SELECT * "
    . "FROM users "
    . "WHERE users.id = ?;";

    return db_execute_stmt_assoc($connect, $sql, [$user_id]);
}

/**
 * Подписываемся на пользователя
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $author_id ID пользователя
 * @param string $subscriber_id ID подписчика
 *
 * @return bool Успешное выполнение
 */
function add_new_subscriber($connect, $author_id, $subscriber_id)
{
    $sql = "INSERT INTO subscriptions (author_id, subscriber_id) "
    . "VALUES (?, ?);";
    $stmt = db_get_prepare_stmt($connect, $sql, [$author_id, $subscriber_id]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Получаем подписчика на пользователя
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $author_id ID пользователя
 * @param string $subscriber_id ID подписчика
 *
 * @return array Информация о пользователе
 */
function get_id_subscriber_by_user($connect, $author_id, $subscriber_id)
{
    $sql = "SELECT subscriptions.author_id FROM subscriptions "
    . "WHERE subscriptions.author_id = ? AND subscriptions.subscriber_id = ?;";

    return db_execute_stmt_assoc($connect, $sql, [$author_id, $subscriber_id]);
}

/**
 * Отписываемся от пользователя
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $author_id ID пользователя
 * @param string $subscriber_id ID подписчика
 *
 * @return bool Успешное выполнение
 */
function del_id_subscriber_by_user($connect, $author_id, $subscriber_id)
{
    $sql = "DELETE FROM subscriptions "
    . "WHERE subscriptions.author_id = ? AND subscriptions.subscriber_id = ?;";
    $stmt = db_get_prepare_stmt($connect, $sql, [$author_id, $subscriber_id]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Поличает имя страницы с GET запросом с которой пришли на текущию страницу
 *
 * @return string Имя страницы с GET запросом
 */
function get_path_referer()
{
    return end(explode("/", $_SERVER['HTTP_REFERER']));
}

/**
 * Получаем лайки на пост от пользователя
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $user_id ID пользователя
 * @param string $post_id ID поста
 *
 * @return array Информация о пользователе
 */
function get_like_by_post($connect, $post_id, $user_id)
{
    $sql = "SELECT likes.user_id FROM likes "
    . "WHERE likes.post_id = ? AND likes.user_id = ?;";

    return db_execute_stmt_assoc($connect, $sql, [$post_id, $user_id]);
}

/**
 * Добавляет лайк посту
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $user_id ID пользователя
 * @param string $post_id ID поста
 *
 * @return bool Успешное выполнение
 */
function add_like_post($connect, $user_id, $post_id)
{
    $sql = "INSERT INTO likes (user_id, post_id) "
    . "VALUES (?, ?);";
    $stmt = db_get_prepare_stmt($connect, $sql, [$user_id, $post_id]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Удаляем лайк поста
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $user_id ID пользователя
 * @param string $post_id ID поста
 *
 * @return bool Успешное выполнение
 */
function del_like_post($connect, $user_id, $post_id)
{
    $sql = "DELETE FROM likes "
    . "WHERE likes.user_id = ? AND likes.post_id = ?;";
    $stmt = db_get_prepare_stmt($connect, $sql, [$user_id, $post_id]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Получает комментарии к посту
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $post_id ID поста
 *
 * @return array Информация о комментарии к посту
 */
function get_comments_post($connect, $post_id)
{
    $sql = "SELECT comments.id, created_at, content, author_id, post_id, users.user_name, users.avatar_url "
    . "FROM readme.comments "
    . "JOIN users ON users.id = comments.author_id "
    . "WHERE comments.post_id = ?;";

    return db_execute_stmt_all($connect, $sql, [$post_id]);
}

/**
 * Добавляет комментарий к посту
 * @param object $connect Текущее соединение с сервером MySQL
 * @param string $content Текст комментария
 * @param string $user_id ID пользователя
 * @param string $post_id ID поста
 *
 * @return bool Успешное выполнение
 */
function add_comment($connect, $content, $user_id, $post_id)
{
    $sql = "INSERT INTO comments (created_at, content, author_id, post_id) "
    . "VALUES (NOW(), ?, ?, ?)";

    $stmt = db_get_prepare_stmt($connect, $sql, [$content, $user_id, $post_id]);

    return mysqli_stmt_execute($stmt);
}
