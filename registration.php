<?php
require_once('functions.php');
require_once('constants.php');
require_once('config.php');
require_once('connect.php');
require_once('models.php');
require_once('validations.php');

$reg_content = include_template('reg-form.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $required_fields = $form_required_fields['registration'];
    $errors = [];
    $new_user = filter_input_array(INPUT_POST, $form_all_fields['registration'], true);

    foreach ($new_user as $field_form => $content_field_form) {
        if (isset($rules[$field_form])) {
            $rule = $rules[$field_form];
            $errors[$field_form] = $rule($content_field_form);
        }
        if (in_array($field_form, $required_fields) && empty($content_field_form)) {
            $errors[$field_form] = "Заполните это поле";
        }
    }
    if (empty($errors['email'])) {
        $email = mysqli_real_escape_string($link, $new_user['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($link, $sql);
        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
    }
    if (empty($errors['password'])) {
        if ($new_user['password'] !== $new_user['password-repeat']) {
            $errors['password-repeat'] = 'Введенные пароли не совпадают';
        }
    }

    if (!empty($_FILES['avatar']['name'])) {
        $tmp_name = $_FILES['file-name']['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        $file_ext = get_file_extension($file_type, $image_type);
        if ($file_ext) {
            $filename = uniqid() . $file_ext;
            move_uploaded_file($tmp_name, 'uploads/' . $filename);
            $new_user['avatar-path'] = $filename;
        } else {
            $errors['avatar'] = 'Загрузите изображение в формате JPEG, PNG или GIF';
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $reg_content = include_template('reg-form.php', [
            'errors' => $errors,
            'errors_heading' => $errors_heading,
            'new_user' => $new_user,
        ]);
    } else {
        $hash = password_hash($new_user['password'], PASSWORD_DEFAULT);
        $new_user_bd = add_new_user($link, $new_user['email'], $new_user['login'], $hash);
        if ($new_user_bd) {
            $new_user_id = mysqli_insert_id($link);
            header("Location: /index.php");
            exit();
        }
    }
}

show_layout($reg_content, true);
