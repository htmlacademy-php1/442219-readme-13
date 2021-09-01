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
function get_popular_posts_default($connect, $limit_posts = '6')
{
    $sql = "SELECT COUNT(likes.id) likes, posts.view_counter AS views, posts.id AS post_id, posts.title, posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, user_name AS author, types.alias, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id JOIN likes ON posts.id = likes.post_id GROUP BY posts.id ORDER BY posts.view_counter DESC LIMIT $limit_posts;";

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
    $sql = "SELECT COUNT(likes.id) likes, posts.id AS post_id, posts.title, posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, user_name AS author, types.alias, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id JOIN likes ON posts.id = likes.post_id WHERE types.id = ? GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;";

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
    $sql = "SELECT COUNT(likes.id) likes, posts.id, posts.title, posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, posts.view_counter, users.id AS id_user, user_name AS author, types.alias, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id JOIN likes ON posts.id = likes.post_id WHERE posts.id = ? GROUP BY posts.id;";

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
