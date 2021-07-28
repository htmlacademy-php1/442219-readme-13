<?php
    $is_auth = rand(0, 1);

    $user_name = 'Игорь Влащенко';

    $posts = [
        [
            'title' => 'Цитата',
            'type' => 'post-quote',
            'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
            'name' => 'Лариса', 'avatar' => 'userpic-larisa-small.jpg',
        ],
        [
            'title' => 'Игра престолов',
            'type' => 'post-text',
            'content' => 'Не могу дождаться, начала финального сезона своего любимого сериала!',
            'name' => 'Владик',
            'avatar' => 'userpic.jpg',
        ],
        [
            'title' => 'Наконец, обработал фотки!',
            'type' => 'post-photo',
            'content' => 'rock-medium.jpg',
            'name' => 'Виктор',
            'avatar' => 'userpic-mark.jpg',
        ],
        [
            'title' => 'Моя мечта',
            'type' => 'post-photo',
            'content' => 'coast-medium.jpg',
            'name' => 'Лариса',
            'avatar' => 'userpic-larisa-small.jpg',
        ],
        [
            'title' => 'Лучшие курсы',
            'type' => 'post-link',
            'content' => 'www.htmlacademy.ru',
            'name' => 'Владик',
            'avatar' => 'userpic.jpg',
        ],
    ];

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

    /**
     * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
     * @param string $name Путь к файлу шаблона относительно папки templates
     * @param array $data Ассоциативный массив с данными для шаблона
     * @return string Итоговый HTML
     */
    function include_template($name, array $data = [])
    {
        $name = 'templates/' . $name;
        $result = '';

        if (!is_readable($name)) {
            return $result;
        }

        ob_start();
        extract($data);
        require $name;

        $result = ob_get_clean();

        return $result;
    }

    $page_content = include_template('main.php', ['posts' => $posts]);

    $layout_content = include_template('layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name,'content' => $page_content, 'title' => 'readme: популярное']);

    print($layout_content);

?>