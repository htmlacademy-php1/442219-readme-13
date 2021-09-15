<?php
    require_once('config.php');

    $link = mysqli_connect($db_host['host'], $db_host['user'], $db_host['password'], $db_host['database']);

    if (!$link) {
        // show_error('Ошибка подключения к серверу MySQL: ' . mysqli_connect_error());
    };

    mysqli_set_charset($link, "utf8");
