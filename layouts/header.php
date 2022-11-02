<?php   

    require_once './boot.php';

    if (is_auth()) {
        $stmt = pdo() -> prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt -> execute(['id' => $_SESSION['user_id']]);
        $user = $stmt -> fetch(PDO::FETCH_ASSOC);
    }
    ?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta charset = "UTF-8">
        <title> <?= $title ?> </title>
        <link href="styles/style.css?8" rel="stylesheet">
        <link href="styles/background.css" rel="stylesheet"> 
        <link rel="icon" href="logo.ico" type="image/x-icon">
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src = "scripts/scripts.js"></script>
    </head>

    <body>
        <header>
            <div class = 'h_block_1'>
                <a href = "index">
                    <img src = "images/logo.svg" class = "h_logo" alt = "logo">
                    <img src = "images/Name.svg" class = "h_name" alt = "name">
                </a>
            </div>
            <div class = "h_block_2">
                <?php if (!is_auth()) { ?>
                <form action = "/register">
                    <button class = "sign_up_button">SIGN UP</button>
                </form>
                <form action = "/login">
                    <button class = "sign_in_button">LOG IN</button>
                </form>
                <?php } else { ?>
                <form>
                    <button class = "sign_up_button"><?php echo($user['username'])?></button>
                </form>
                <form action = "/do_logout">
                    <button class = "sign_in_button">LOG OUT</button>
                </form>
                <?php } ?>
            </div>
        </header>
        <nav class = "site_navigation <?=$title?>">
                <ul>
                    <li><form action = "/news"><button  class = "news_page">News</button></form></li>
                </ul>
                <ul>
                    <li><form action = "/events"><button  class = "events_page">Events</button></form></li>
                </ul>
                <ul>
                    <li><form action = "/history"><button  class = "history_page">Team History</button></form></li>
                </ul>
                <ul>
                    <li><form action = "/players"><button  class = "players_page">Players</button></form></li>
                </ul>
                </nav>
    </body>