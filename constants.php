<?php
    define('MINUTE', 60);
    define('HOUR', 60);
    define('DAY', 24 * HOUR);
    define('WEEK', 7 * DAY);
    define('MONTH', 5 * WEEK);
    define('DATE_TITLE', 'd.m.Y H:i');
    define('MAX_LENGTH_TEXT', 300);

    $form_required_fields = [
        'photo' => [
            'photo-heading',
        ],
        'video' => [
            'video-heading',
            'video-url',
        ],
        'text' => [
            'text-heading',
            'post-text',
        ],
        'quote' => [
            'quote-heading',
            'quote-text',
            'quote-author',
        ],
        'link' => [
            'link-heading',
            'post-link',
        ],
    ];
