<?php
    require_once('functions.php');
    require_once('data.php');
    require_once('config.php');

    $link = mysqli_connect($db_host['host'], $db_host['user'], $db_host['password'], $db_host['database']);

    if (!$link) {
        show_error('Ошибка подключения к серверу MySQL: ' . mysqli_connect_error());
    };

    mysqli_set_charset($link, "utf8");
    // SQL-запрос для получения типов контента
    $sql_types = 'SELECT id, title, class FROM types;';

    // Дефолтная сортировка постов
    $sql_posts = 'SELECT COUNT(likes.id) likes, posts.id AS post_id, posts.title, posts.text_content, posts.img_url, posts.video_url, posts.site_url, user_name AS author, types.class, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id JOIN likes ON posts.id = likes.post_id GROUP BY posts.id ORDER BY COUNT(likes.id) DESC LIMIT 6;';

    $types = get_arr_from_mysql($link, $sql_types);

    if (!$types) {
        show_error('Ошибка чтения БД: ' . mysqli_error($link));
    };

    // Фильтруем посты по типу контента:
    $type_id = filter_input(INPUT_GET, 'id');

    if ($type_id) {
        $sql_posts = 'SELECT COUNT(likes.id) likes, posts.id AS post_id, posts.title, posts.text_content, posts.img_url, posts.video_url, posts.site_url, user_name AS author, types.class, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id JOIN likes ON posts.id = likes.post_id WHERE types.id = ? GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;';

        $posts = db_execute_stmt($link, $sql_posts, [$type_id], false);
    } else {
        $posts = get_arr_from_mysql($link, $sql_posts);
    };

    if (!$posts) {
        show_error('Ошибка чтения БД: ' . mysqli_error($link));
    };

    $layout_content = include_template('main.php', [
        'posts' => $posts,
        'types' => $types,
        'type_id' => $type_id,
    ]);

    show_layout($layout_content);
