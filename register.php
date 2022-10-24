<?php
require_once __DIR__.'/boot.php';
$title = "Register";
if (is_auth()) {
    header('Location: /');
    die;
}

require("layouts/background.php");
require("layouts/header.php");
require('forms/reg_form.php');
?>

