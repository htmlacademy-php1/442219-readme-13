<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');
require_once('validations.php');

session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /feed.php");
    exit();
}

$page_content = include_template('authentication.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $aut_user = filter_input_array(INPUT_POST, $form_all_fields['authentication'], true);
    foreach ($aut_user as $field => $value) {
        if (empty($value)) {
            $errors[$field] = 'Заполните это поле';
        }
    }

    if (empty($errors['email'])) {
        $user_db = get_user_by_email($link, $aut_user['email']);
        if (empty($user_db)) {
            $errors['email'] = 'Неверный email';
        } elseif (!password_verify($aut_user['password'], $user_db['user_password'])) {
            $errors['password'] = 'Пароли не совпадают';
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $page_content = include_template('authentication.php', [
            'aut_user' => $aut_user,
            'errors' => $errors,
        ]);
    } else {
        $_SESSION['user_id'] = $user_db['id'];
        header("Location: /feed.php");
        exit();
    }
}

$layout_header = include_template('enter-header.php');

show_layout($layout_header, $page_content, 'readme: вход на сайт');
