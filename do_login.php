<?php

require_once __DIR__.'/boot.php';

$stmt = pdo() -> prepare("DELETE FROM `users` WHERE `status` = '0' AND `reg_date` < (NOW() - INTERVAL 1 DAY)");
$stmt -> execute();
if (!$stmt) {
    flash('error deleting an expired account');
    die();
}
$stmt = pdo() -> prepare("DELETE FROM `confirm_users` WHERE `reg_date` < (NOW() - INTERVAL 1 DAY)");
$stmt -> execute();
if (!$stmt) {
    flash('error deleting an expired account');
    die();
}


$stmt = pdo() -> prepare("SELECT * FROM `users` WHERE `username` = :username");
$stmt -> execute(['username' => $_POST['username']]);
if (!$stmt -> rowCount()) {
    flash('User not found');
    header('Location: Login.php');
    die;
}

$user = $stmt -> fetch(PDO::FETCH_ASSOC);

if (password_verify($_POST['password'], $user['password'])) {
    if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
        $newHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = pdo() -> prepare('UPDATE `users` SET `password` = :password WHERE `username` = :username');
        $stmt -> execute([
            'username' => $_POST['username'],
            'password' => $newHash,
        ]);
    }

    $_SESSION['user_id'] = $user['id'];
    header('Location: /');
    die;
}

flash('Invalid password', 'success');
header('Location: login.php');
?>