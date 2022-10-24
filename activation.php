<?php 
$title = "ACTIVATION";
require_once __DIR__.'/boot.php';
require("layouts/background.php");
require("layouts/header.php");

if(isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];
}  else {
    flash('Token error', 'alert');
    die();

}

if(isset($_GET['email']) && !empty($_GET['email'])) {
    $email = $_GET['email'];
}  else {
    flash('Email error', 'alert');
    header('Location: login');
    die();

}

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


$stmt = pdo() -> prepare("SELECT * FROM `confirm_users` WHERE `email` = :email");
$stmt -> execute(['email' => $email]);
$confirmed = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($stmt -> rowCount() == 1) {
    if($token == $confirmed['token']){
        $stmt = pdo() -> prepare("UPDATE `users` SET `status` = '1' WHERE `email` = :email");
        $stmt -> execute(['email' => $email]);

        if(!$stmt) {
            flash('Status updating error', 'alert');
            header('Location: login');
            die();
        } else {
            $stmt = pdo() -> prepare("DELETE FROM `confirm_users` WHERE `email` = :email");
            $stmt -> execute(['email' => $email]);

            if (!$stmt) {
                flash('Temporary table deliting error', 'alert');
                header('Location: login');
                die();
            } else {
                header('Location: login');
                flash('activation is successful', 'success');
                die();
            }
        }
    }   else {
        flash('Invalid token', 'alert');
        header('Location: login');
        die();
    }
} else {
    flash('Invalid user', 'alert');
    header('Location: login');
    die();
}