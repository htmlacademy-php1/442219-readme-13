<?php
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date): bool
{
    $format_to_check = 'Y-m-d';
    $date_time_obj = date_create_from_format($format_to_check, $date);

    return $date_time_obj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form(int $number, string $one, string $two, string $many): string
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 *
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

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            switch (true) {
                case is_int($value):
                    $type = 'i';
                    break;
                case is_string($value):
                    $type = 's';
                    break;
                case is_double($value):
                    $type = 'd';
                    break;
                default:
                    $type = 's';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        mysqli_stmt_bind_param(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Выполняет подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return array Двухмерный массив из подготовленного запроса
 */
function db_execute_stmt_all($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $result_stmt = mysqli_stmt_get_result($stmt);

    return $result_arr = mysqli_fetch_all($result_stmt, MYSQLI_ASSOC);
}

/**
 * Выполняет подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return array Ассоциативный Массив из подготовленного запроса
 */
function db_execute_stmt_assoc($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $result_stmt = mysqli_stmt_get_result($stmt);

    return $result_arr = mysqli_fetch_assoc($result_stmt);
}

/**
 * Возвращает код iframe для вставки youtube видео на страницу
 * @param string $youtube_url Ссылка на youtube видео
 *
 * @return string
 */
function embed_youtube_video($youtube_url)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);

    if ($id) {
        $src = "https://www.youtube.com/embed/" . $id;
        $res = '<iframe width="760" height="400" src="' . $src . '" frameborder="0"></iframe>';
    }

    return $res;
}

/**
 * Возвращает img-тег с обложкой видео для вставки на страницу
 * @param string $youtube_url Ссылка на youtube видео
 *
 * @return string
 */
function embed_youtube_cover($youtube_url)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);

    if ($id) {
        $src = sprintf("https://img.youtube.com/vi/%s/mqdefault.jpg", $id);
        $res = '<img alt="youtube cover" width="320" height="120" src="' . $src . '" />';
    }

    return $res;
}

/**
 * Извлекает из ссылки на youtube видео его уникальный ID
 * @param string $youtube_url Ссылка на youtube видео
 *
 * @return array
 */
function extract_youtube_id($youtube_url)
{
    $id = false;

    $parts = parse_url($youtube_url);

    if ($parts) {
        if ($parts['path'] === '/watch') {
            parse_str($parts['query'], $vars);
            $id = $vars['v'] ?? null;
        } else {
            if ($parts['host'] === 'youtu.be') {
                $id = substr($parts['path'], 1);
            }
        }
    }

    return $id;
}

/**
 * Отображает шаблон
 * @param string $content_header HTML секции header шаблона layout.php
 * @param string $content HTML секции main шаблона layout.php
 *
 * @return string Показ layout.php
 */
function show_layout($content_header, $content, $title_page = 'readme')
{
    print(include_template('layout.php', [
        'content_header' => $content_header,
        'content' => $content,
        'title_page' => $title_page,
    ]));
}

/**
 * Отображает страницу ошибки и завершает скрипт
 * @param string $error_content Описание ошибки
 *
 * @return string Показ layout.php с ошибкой
 */
function show_error($content_header, $error_content, $title_page)
{
    show_layout($content_header, include_template('error.php', ['error' => $error_content]), $title_page);
    exit;
}

/**
 * Получает массив по SQL запросу
 * @param object $connect_mysql Текущее соединение с сервером MySQL
 * @param string $sql_query SQL запрос
 */
function get_arr_from_mysql($connect_mysql, $sql_query)
{
    $result = mysqli_query($connect_mysql, $sql_query);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
}

/**
 * Вычисляет время прошедшее после публикации поста
 * @param string $date_public Дата публикации поста
 *
 * @return string Прошедшее время
 */
function get_diff_time_public_post($date_public)
{
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
 *
 * @return string Урезанный текст если он большой
 */
function cut_text($text, $length = MAX_LENGTH_TEXT)
{

    if (!is_text_big($text, $length)) {
        return $text;
    }

    $words = explode(' ', $text);
    $output_string = '';

    foreach ($words as $word) {
        $output_string .= $word;

        if (is_text_big($output_string, $length)) {
            break;
        } else {
            $output_string .= ' ';
        }
    };

    return $output_string .= '...';
}

/**
 * Определяет что длина текста поста больше максимума
 * @param string $text Текст поста
 * @param int $max_length_text Максимальное число символов, отображаемых в тексте поста
 *
 * return bool Текст большой или нет
 */
function is_text_big($text, $max_length_text)
{
    if (mb_strlen($text, 'UTF-8') > $max_length_text) {
        return true;
    }

    return false;
}

/**
 * Устанавливает расширение файла по его типу
 * @param string $fyle_type
 * @param array $arr_type
 *
 * @return string Расширение файла или false если нет такого типа
 */
function get_file_extension($file_type, $arr_type)
{
    foreach ($arr_type as $type => $extension) {
        if ($file_type === $type) {
            return $extension;
        }
    }

    return false;
}

/**
 * Получает значение из массива $_GET
 * @param string $name Значение атрибута поля формы
 *
 * @return string Значение из массива $_GET
 */
function get_value_get($name) // TODO Удалить излишнюю функцию после замены в коде
{
    return htmlspecialchars($_GET[$name] ?? '');
}

/**
 * Подтверждает нахождение на странице
 * @param string $page_url Путь страницы
 *
 * @return bool True если на этой странице, иначе false
 */
function is_current_page($page_url)
{
    if (basename($_SERVER['SCRIPT_FILENAME']) === $page_url) {

        return true;
    }

    return false;
}
