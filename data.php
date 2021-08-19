<?php
    define('MINUTE', 60);
    define('HOUR', 60);
    define('DAY', 24 * HOUR);
    define('WEEK', 7 * DAY);
    define('MONTH', 5 * WEEK);
    define('DATE_TITLE', 'd.m.Y H:i');

    $is_auth = rand(0, 1);
    $user_name = 'Игорь Влащенко';

    $array_layout_data = [
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'content' => '',
        'title' => 'readme: популярное',
    ];
