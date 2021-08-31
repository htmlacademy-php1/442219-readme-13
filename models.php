<?php
/**
 * Формирует SQL-запрос для получения типов контента постов
 *
 * @return string SQL-запрос
 */
function get_content_types()
{
    return 'SELECT id, title, alias FROM types;';
}

/**
 * Формирует SQL-запрос для получения популярных постов для дефолтных состояний сортировки и фильтра типов постов
 * @param string $limit_posts Максимальное количество постов показываемы на странице
 *
 * @return string SQL-запрос
 */
function get_popular_posts_default($limit_posts = '9')
{
    return "SELECT COUNT(likes.id) likes, posts.id AS post_id, posts.title, posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, user_name AS author, types.alias, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id JOIN likes ON posts.id = likes.post_id GROUP BY posts.id ORDER BY COUNT(likes.id) DESC LIMIT $limit_posts;";
}

/**
 * Формирует SQL-запрос для получения списка постов с учетом типа контента
 * @param string $type_id Индекс типа сонтента
 *
 * @return string SQL-запрос
 */
function get_posts_by_type($type_id = '?')
{
    return "SELECT COUNT(likes.id) likes, posts.id AS post_id, posts.title, posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, user_name AS author, types.alias, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id JOIN likes ON posts.id = likes.post_id WHERE types.id = $type_id GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;";
}

/**
 * Формирует SQL-запрос для получения поста по его индексу
 * @param string $post_id Индекс поста
 *
 * @return string SQL-запрос
 */
function get_posts_by_index($post_id = '?')
{
    return "SELECT COUNT(likes.id) likes, posts.id, posts.title, posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, posts.view_counter, users.id AS id_user, user_name AS author, types.alias, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id JOIN likes ON posts.id = likes.post_id WHERE posts.id = $post_id GROUP BY posts.id;";
}

/**
 * Формирует SQL-запрос для получения числа подписчиков автора поста
 * @param string $author_id ID автора поста
 *
 * @return string SQL-запрос
 */
function get_subscribers_by_user($author_id = '?')
{
    return "SELECT COUNT(author_id) count_sub FROM subscriptions WHERE author_id = $author_id;";
}

/**
 * Формирует SQL-запрос для получения числа публикаций у автора поста
 * @param string $author_id ID автора поста
 *
 * @return string SQL-запрос
 */
function get_posting_by_user($author_id = '?')
{
    return "SELECT COUNT(posts.user_id) count_posts FROM posts WHERE posts.user_id = $author_id;";
}
