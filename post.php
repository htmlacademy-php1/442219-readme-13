<?php
    require_once('functions.php');
    require_once('data.php');
    require_once('config.php');

    $link = mysqli_connect($db_host['host'], $db_host['user'], $db_host['password'], $db_host['database']);

    if (!$link) {
        show_error('Ошибка подключения к серверу MySQL: ' . mysqli_connect_error());
    };

    mysqli_set_charset($link, "utf8");

    $post_id = filter_input(INPUT_GET, 'id');
    if (!$post_id) {
        show_error('Запрошенная страница не найдена на сервере: ' . '404');
    }

    // Выбираем пост по ID в запросе
    $sql_post = 'SELECT COUNT(likes.id) likes, posts.id, posts.title, posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, posts.view_counter, users.id AS id_user, user_name AS author, types.class, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id JOIN likes ON posts.id = likes.post_id WHERE posts.id = ? GROUP BY posts.id;';

    // Выбираем число подписчиков у автора поста
    $sql_subscribers = 'SELECT COUNT(author_id) count_sub FROM subscriptions WHERE author_id = ?;';

    // Выбираем число публикаций у автора поста
    $sql_posting = 'SELECT COUNT(posts.user_id) count_posts FROM posts WHERE posts.user_id = ?;';

    $post = db_execute_stmt($link, $sql_post, [$post_id], true);
    if (!$post) {
        show_error('Запрошенная страница не найдена на сервере: ' . '404');
    }

    $subscribers = db_execute_stmt($link, $sql_subscribers, [$post['id_user']], true);

    $posting = db_execute_stmt($link, $sql_posting, [$post['id_user']], true);

    $post_content = include_template('post-preview.php', [
        'post' => $post,
        'subscribers' => $subscribers,
        'posting' => $posting,
    ]);

    show_layout($post_content);
