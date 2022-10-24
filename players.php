<?php
$page = "Players";
$title = "Players";
require("layouts/background.php");
require("layouts/header.php");

$json = file_get_contents('https://us.api.blizzard.com/sc2/legacy/profile/2/1/315071?access_token=EUOlAPgQfgX3szfK6yLr5pr7fFYcoql3SR');
$player = json_decode($json, true);
print_r($player['clanName']);
print_r( $player['displayName']);
?>
