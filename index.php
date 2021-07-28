<?php
    require_once('helpers.php');
    require_once('data.php');
    
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

    $page_content = include_template('main.php', ['posts' => $posts]);

    $layout_content = include_template('layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name,'content' => $page_content, 'title' => 'readme: популярное']);

    print($layout_content);
?>