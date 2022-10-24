<?php

session_start();

function pdo(): PDO {
    static $pdo;

    if (!$pdo) {
        $config = include __DIR__.'/config.php';
        $dsn = 'mysql:dbname='.$config['db_name'].';host='.$config['db_host'];
        $pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $pdo;
}
$config = include __DIR__.'/config.php';
$mysqli = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

function flash(?string $message = null, ?string $class = "alert") {
    
    if ($message) {
        $_SESSION['flash'] = [$message, $class];
    } else {
        if (!empty($_SESSION['flash'][0])) { ?>
            <div class=<?=$_SESSION['flash'][1]?>>
                <?=$_SESSION['flash'][0]?>
            </div>
          <?php }
          unset($_SESSION['flash']);
    }
}

function is_auth():bool {   
    return isset($_SESSION['user_id']);
}


$email_admin = "ellectronchik@mail.ru";
$address = 'http://62.113.114.94:44545/';
?>