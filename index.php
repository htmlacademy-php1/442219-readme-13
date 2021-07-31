<?php
    require_once('helpers.php');
    require_once('data.php');

    /**
     * Вычисляет дату публикации поста
     * @param int $index_post Индекс элемента массива с постами
     */
    function get_date_public_posts($index_post) {
        date_default_timezone_set("Europe/Moscow");
        $date_datetime = generate_random_date($index_post);
        $date_timestamp = strtotime($date_datetime);
        $date_title = date('d.m.Y H:i', $date_timestamp);
        $diff_date_timestamp = time() - $date_timestamp;
        $diff_time_public = '';
        $remaining_time = ceil($diff_date_timestamp / 60);


        if ($remaining_time < 60) {
            // если до текущего времени прошло меньше 60 минут
            $diff_time_public = "$remaining_time " . get_noun_plural_form($remaining_time, 'минута', 'минуты', 'минут') . ' назад';

        } else if ($remaining_time >= 60 && $remaining_time < 1440) {
            // если до текущего времени прошло больше 60 минут, но меньше 24 часов
            $remaining_time = ceil($remaining_time / 60);
            $diff_time_public = "$remaining_time " . get_noun_plural_form($remaining_time, 'час', 'часа', 'часов') . ' назад';

        } else if ($remaining_time >= 1440 && $remaining_time < 10080) {
            // если до текущего времени прошло больше 24 часов, но меньше 7 дней
            $remaining_time = ceil($remaining_time / 1440);
            $diff_time_public = "$remaining_time " . get_noun_plural_form($remaining_time, 'день', 'дня', 'дней') . ' назад';

        } else if ($remaining_time >= 10080 && $remaining_time < 50400) {
            // если до текущего времени прошло больше 7 дней, но меньше 5 недель
            $remaining_time = ceil($remaining_time / 10080);
            $diff_time_public = "$remaining_time " . get_noun_plural_form($remaining_time, 'неделя', 'недели', 'недель') . ' назад';

        } else if ($remaining_time >= 50400) {
            // если до текущего времени прошло больше 5 недель
            $remaining_time = ceil($remaining_time / 50400);
            $diff_time_public = "$remaining_time " . get_noun_plural_form($remaining_time, 'месяц', 'месяца', 'месяцев') . ' назад';
        };

        return array(
            'datetime' => $date_datetime,
            'datetitle' => $date_title,
            'difftime' => $diff_time_public
        );
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
        'title' => 'readme: популярное'
    ]);

    print($layout_content);
?>
