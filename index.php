<?php
    require_once('helpers.php');
    require_once('data.php');

    date_default_timezone_set("Europe/Moscow");

    /**
     * Вычисляет дату публикации поста для каждого элемента массива с постами
     * @param int $index_post Индекс элемента массива с постами
     */
    function get_date_public_posts($index_post) {
        $date = generate_random_date($index_post);

        return $date;
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

    $page_content = include_template('main.php', [
        'posts' => $posts,
    ]);

    $layout_content = include_template('layout.php', [
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'content' => $page_content,
        'title' => 'readme: популярное',
    ]);

    print($layout_content);

    // TODO Обернуть htmlspecialchars в функцию
