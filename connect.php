<?php
    require_once('config.php');
    require_once('functions.php');

    $link = mysqli_connect($db_host['host'], $db_host['user'], $db_host['password'], $db_host['database']);

    if (!$link) {
        $layout_header = include_template('enter-header.php');
        show_error($layout_header, 'Ошибка подключения к серверу MySQL: ' . mysqli_connect_error(), 'readme: соединение с базой данных');
    };

    mysqli_set_charset($link, "utf8");
