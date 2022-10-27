<?php
$page = "Players";
$title = "Players";
$config = include __DIR__.'/config.php';
require("layouts/background.php");
require("layouts/header.php");

$api = file_get_contents('https://eu.api.blizzard.com/sc2/profile/2/1/315071?:regionId=2&:realmId=1&locale=en_US&access_token='. $config['api_token']);
?>

<div class = 'add_player'>
    <button class = 'add_button'>+</button>
</div>

<?php echo($api) ?>