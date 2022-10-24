<?php

require_once __DIR__.'/boot.php';
$email = $_POST['email'];
$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `username` = :username");
$stmt -> execute(['username' => $_POST['username']]);

if ($stmt -> rowCount() > 0) {
    flash('This username is already taken');
    header('Location: /register.php');
    die();
}

else if (strlen($_POST['password']) < 6) {
    flash('This password is short');
    header('Location: /register.php');
    die();
}

else if (strlen($_POST['username']) < 3) {
    flash('The length of username must be at least 3 characters');
    header('Location: /register.php');
    die();
}

else if ($_POST['password'] != $_POST['re_password']) {
    flash("Passwords doesn't match");
    header('Location: /register.php');
    die();
}

$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `email` = :email");
$stmt -> execute(['email' => $_POST['email']]);

if ($stmt -> rowCount() > 0) {
    flash('This email is already taken');
    header('Location: /register.php');
    die();
}

$stmt = pdo() -> prepare("DELETE FROM `users` WHERE `status` = '0' AND `reg_date` < (NOW() - INTERVAL 1 DAY)");
$stmt -> execute();
if (!$stmt) {
    flash('error deleting an expired account');
}

$stmt = pdo() -> prepare("INSERT INTO `users` (`username`, `password`, `email`, `reg_date`) VALUES (:username, :password, :email, NOW())");
$stmt -> execute([
    'username' => $_POST['username'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    'email' => $_POST['email']
]);

$stmt = pdo() -> prepare("DELETE FROM `confirm_users` WHERE `reg_date` < (NOW() - INTERVAL 1 DAY)");
$stmt -> execute();
if (!$stmt) {
    flash('error deleting an expired account');
}

$token = md5($email.time());

$quert_insert_confirm = pdo() -> prepare("INSERT INTO `confirm_users` (`email`, `token`, `reg_date`) VALUES (:email, :token, NOW())");
$quert_insert_confirm -> execute([
    'email' => $email,
    'token' => $token
]);

if (!$quert_insert_confirm) {
    flash('DATA BASE ERROR');
    header(':ocation: /register.php');
    die();
} else {
                    //Составляем заголовок письма
                    $subject = "Подтверждение почты на сайте ".$_SERVER['HTTP_HOST'];

                    //Устанавливаем кодировку заголовка письма и кодируем его
                    $subject = "=?utf-8?B?".base64_encode($subject)."?=";

                    //Составляем тело сообщения
                    $message = 'Здравствуйте! <br/> <br/> Сегодня '.date("d.m.Y", time()).', неким пользователем была произведена регистрация на сайте <a href="'.$address.'">'.$_SERVER['HTTP_HOST'].'</a> используя Ваш email. Если это были Вы, то, пожалуйста, подтвердите адрес вашей электронной почты, перейдя по этой ссылке: <a href="'.$address.'activation.php?token='.$token.'&email='.$email.'">'.$address.'activation/'.$token.'</a> <br/> <br/> В противном случае, если это были не Вы, то, просто игнорируйте это письмо. <br/> <br/> <strong>Внимание!</strong> Ссылка действительна 24 часа. После чего Ваш аккаунт будет удален из базы.';
                    
                    //Составляем дополнительные заголовки для почтового сервиса mail.ru
                    //Переменная $email_admin, объявлена в файле dbconnect.php
                    $headers = "FROM: $email_admin\r\nReply-to: $email_admin\r\nContent-type: text/html; charset=utf-8\r\n";
}


if(mail($email, $subject, $message, $headers)) {
    flash('Registration was successful, please confirm your email', 'success');
    header('Location: /login.php');
    die();
} else {
    flash('Email sanding error');
    $stmt = pdo() -> prepare("DELETE FROM `users` WHERE  `username` = :username");
    $stmt -> execute([
        'username' => $_POST['username']
    ]);
    if (!$stmt) {
        flash('error deleting an expired account');
        die();
}
    $stmt = pdo() -> prepare("DELETE FROM `confirm_users`  WHERE `token` = :token");
    $stmt -> execute([
        'token' => $token
    ]);
    if (!$stmt) {
        flash('error deleting an expired account');
        die();
}
    header('Location: /register.php');
    die();
}


?>