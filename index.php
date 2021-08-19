<?php
    require_once('helpers.php');
    require_once('data.php');
    require_once('config.php');

    date_default_timezone_set("Europe/Moscow");

    $link = mysqli_connect($db_host['host'], $db_host['user'], $db_host['password'], $db_host['database']);

    var_dump($link);

    if (!$link) {
        $error = mysqli_connect_error();
        show_error($error);
    };

    mysqli_set_charset($link, "utf8");
    // SQL-запрос для получения типов контента
    $sql_types = 'SELECT title, class FROM types;';

    // SQL-запрос для получения списка постов, объединённых с пользователями и отсортированный по популярности
    $sql_posts = 'SELECT COUNT(likes.id) likes, posts.title, posts.text_content, posts.img_url, posts.video_url, posts.site_url, user_name AS author, types.class, users.avatar_url FROM posts JOIN users ON posts.user_id = users.id JOIN types ON posts.type_id = types.id JOIN likes ON posts.id = likes.post_id GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;';

    $types = get_arr_from_mysql($link, $sql_types);

    if (!$types) {
        $error = mysqli_error($link);
        show_error($error);
    };

    $posts = get_arr_from_mysql($link, $sql_posts);

    if (!$posts) {
        $error = mysqli_error($link);
        show_error($error);
    };

    $layout_content = include_template('main.php', [
        'posts' => $posts,
        'types' => $types,
    ]);

    show_layout($layout_content);

    /**
     * Отображает шаблон
     * @param string $content HTML секции main шаблона layout.php
     */
    function show_layout($content) {
        print(include_template('layout.php', [
            'is_auth' => rand(0, 1),
            'user_name' => 'Игорь Влащенко',
            'content' => $content,
            'title' => 'readme: популярное',
        ]));
    }

    /**
     * Отображает страницу ошибки и завершает скрипт
     * @param string $error_content Описание ошибки
     */
    function show_error($error_content) {
        show_layout(include_template('error.php', ['error' => $error_content]));
        exit;
    }

    /**
     * Получает массив по SQL запросу
     * @param object $connect_mysql Текущее соединение с сервером MySQL
     * @param string $sql_query SQL запрос
     */
    function get_arr_from_mysql($connect_mysql, $sql_query) {
        $result = mysqli_query($connect_mysql, $sql_query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        return $result;
    }

    /**
     * Преобразует дату по формату
     * @param string $date Исходная дата
     * @param string $format Требуемый формат записи даты
     */
    function format_date($date, $format) {

        return date($format, strtotime($date));
    }

    /**
     * Вычисляет время прошедшее после публикации поста
     * @param string $date_public Дата публикации поста
     */
    function get_diff_time_public_post($date_public) {
        $diff_date_timestamp = time() - strtotime($date_public);
        $diff_time_public_post = '';
        $remaining_time = ceil($diff_date_timestamp / MINUTE);

        switch (true) {
            case ($remaining_time < HOUR):
                $diff_time_public_post = "$remaining_time " . get_noun_plural_form($remaining_time, 'минута', 'минуты', 'минут') . ' назад';
                break;
            case ($remaining_time >= HOUR && $remaining_time < DAY):
                $remaining_time = ceil($remaining_time / HOUR);
                $diff_time_public_post = "$remaining_time " . get_noun_plural_form($remaining_time, 'час', 'часа', 'часов') . ' назад';
                break;
            case ($remaining_time >= DAY && $remaining_time < WEEK):
                $remaining_time = ceil($remaining_time / DAY);
                $diff_time_public_post = "$remaining_time " . get_noun_plural_form($remaining_time, 'день', 'дня', 'дней') . ' назад';
                break;
            case ($remaining_time >= WEEK && $remaining_time < MONTH):
                $remaining_time = ceil($remaining_time / WEEK);
                $diff_time_public_post = "$remaining_time " . get_noun_plural_form($remaining_time, 'неделя', 'недели', 'недель') . ' назад';
                break;
            default:
                $remaining_time = ceil($remaining_time / MONTH);
                $diff_time_public_post = "$remaining_time " . get_noun_plural_form($remaining_time, 'месяц', 'месяца', 'месяцев') . ' назад';
        }

        return $diff_time_public_post;
    }

    /**
     * Урезает текст поста
     * @param string $text Текст поста
     * @param int $length Максимальное число символов, отображаемых в тексте поста
     */
    function cut_text($text, $length = 300) {

        if (mb_strlen($text, 'UTF-8') <= $length) {
            return array($text, false);
        }

        $words = explode(' ', $text);
        $output_string = '';

        foreach ($words as $word) {
            $output_string .= $word;

            if (mb_strlen($output_string, 'UTF-8') > $length) {
                break;
            } else {
                $output_string .= ' ';
            }
        };

        return array($output_string, true);
    }

    // TODO Обернуть htmlspecialchars в функцию?
