<?php
$page = "Players";
$title = "Players";
require("layouts/background.php");
require("layouts/header.php");



function team_table($table, $add_st_name, $added_st_name, $table_name) {
    $stmt = pdo() -> prepare('SELECT MAX(`id`) FROM '.$table);
    $stmt -> execute();

    $count = $stmt -> fetch(PDO::FETCH_ASSOC);


    if(isset($_POST[$add_st_name."_delete_"])) {
        $stmt = pdo() -> prepare("DELETE FROM ".$table." WHERE `id` = :id");
        $stmt -> execute([
            'id' => $_POST['id']
        ]);
        if(!$stmt) {
            echo('SQL ERROR');
        }
        header('Location: /players.php');
        die();
    

    }


    if(isset($_POST[$add_st_name."_confirm_"])) {
        if($_POST['red_mate_name'] != '') {
            $stmt = pdo() -> prepare("UPDATE ".$table." SET `username` = :username WHERE `id` = :id");

            $stmt -> execute([
                'username' => $_POST['red_mate_name'],
                'id' => $_POST['id']
            ]);
        }
        if($_POST['red_mate_div'] != '') {
            $stmt = pdo() -> prepare("UPDATE ".$table." SET `division` = :division WHERE `id` = :id");

            $stmt -> execute([
                'division' => $_POST['red_mate_div'],
                'id' => $_POST['id']
            ]);
        }
        
        if($_POST['red_mate_contact'] != '') {
            $stmt = pdo() -> prepare("UPDATE ".$table." SET `contact` = :contact WHERE `id` = :id");

            $stmt -> execute([
                'contact' => $_POST['red_mate_contact'],
                'id' => $_POST['id']
            ]);
        }
        if($_POST['red_mate_ec'] != '') {
            $stmt = pdo() -> prepare("UPDATE ".$table." SET `ec` = :ec WHERE `id` = :id");

            $stmt -> execute([
                'ec' => $_POST['red_mate_ec'],
                'id' => $_POST['id']
            ]);
        }
        
        

        if(!$stmt) {
            echo('SQL ERROR');
        }
        header('Location: /players.php');
        die();
    
    }

    if (isset($_POST[$added_st_name])) {
        $stmt = pdo() -> prepare('INSERT INTO '.$table.' (`username`, `division`, `contact`, `ec`) VALUES (:username, :division, :contact, :ec)');
        if (!$_POST['add_mate_ec']) {
            $_POST['add_mate_ec'] = 0;
        }
        $stmt -> execute([
            'username' => $_POST['add_mate_name'],
            'division'=> $_POST['add_mate_div'],
            'contact' => $_POST['add_mate_contact'],
            'ec' => $_POST['add_mate_ec']
        ]);


        if(!$stmt) {
            echo('SQL ERROR');
        }
        header('Location: /players.php');
        die();

    }

    ?>
        <table class = 'players_table table_sort'>
            <caption class = 'table_name'><?=$table_name?></caption>
            <thead>
            <tr>
            <th>Nickname</th>
            <th>Division</th>
            <th>Contact</rh>
            <th>EC</th>
    </tr>
    </thead>
    <tbody>
        <?php
            $stmt = pdo() -> prepare("SELECT * FROM".$table." WHERE `id` = :id");
            for ($i = 1; $i <= $count["MAX(`id`)"]; $i++) {
                $stmt -> execute(['id' => $i]);
                $mate = $stmt -> fetch(PDO::FETCH_ASSOC);
                if (isset($mate['username']) && (!isset($_POST[$add_st_name."_redact_".$i]))) {
                ?>
                <tr>
                    <td class = 'table_td_1'><?=$mate['username']?></td>
                    <td class = 'table_td_2'><?=$mate['division']?></td>
                    <td class = 'table_td_2'><?=$mate['contact']?></td>
                    <td class = 'table_td_3'><?=$mate['ec']?></td>
                    <?php
                    if (access_level() > 1) {
                        ?>
                        <td>
                        <form method = "post" action = "">
                            <button class = "b_red" type = "submit"  name = <?=$add_st_name."_redact_".$i?> value = <?=$i?>>
                            <image class = "b_red" src="/images/redact.png">
                    </button>
                    </form>
                    </td>
                        <?php
                    } 
                    ?>
            </tr>
            <?php } else if (isset($mate['username']) && (isset($_POST[$add_st_name."_redact_".$i]))) {
                ?>
            <form method = "post" action = "">
            <tr>
                    <td class = 'table_td_1'>
                        <div class="input add_mate">
                            <label for="red_mate_name"><?=$mate['username']?></label>
                            <input type="text" name="red_mate_name" id="red_mate_name">
                            <span class="spin"></span>
                        </div>
                    </td>
                    <td class = 'table_td_2'>
                        <div class="input add_mate">
                            <label for="red_mate_div"><?=$mate['division']?></label>
                            <input type="text" name="red_mate_div" id="red_mate_div">
                            <span class="spin"></span>
                        </div>
                    </td>
                    <td class = 'table_td_2'>
                        <div class="input add_mate">
                            <label for="red_mate_contact"><?=$mate['contact']?></label>
                            <input type="text" name="red_mate_contact" id="red_mate_contact">
                            <span class="spin"></span>
                        </div>
                    </td>
                    <td class = 'table_td_3'>
                        <div class="input add_mate">
                            <label for="red_mate_ec"><?=$mate['ec']?></label>
                            <input type="text" name="red_mate_ec" id="red_mate_ec">
                            <span class="spin"></span>
                        </div>
                    </td>
                    <td>
                            <input type = "hidden" name = "id" value = <?=$i?>>
                    <button class = "b_red" type = "submit"  name = <?=$add_st_name."_confirm_"?> value = <?=$i?>>
                            <image class = "b_red" src="/images/confirm.png">
                    </button>
                    <button class = "b_red" type = "submit"  name = <?=$add_st_name."_delete_"?> value = <?=$i?>>
                            <image class = "b_red" src="/images/delete.png">
                    </button>

                    </td>
            </tr>
            </form> <?php }
            }
            ?></tbody> <?php
            if (isset($_POST[$add_st_name])) {
            ?>
                <form method = "post" action="">
                <tr>
                    <td class = 'table_td_1'>
                        <div class="input add_mate">
                            <label for="add_mate_name">Username</label>
                            <input type="text" name="add_mate_name" id="add_mate_name" required>
                            <span class="spin"></span>
                        </div>
                    </td>
                    <td class = 'table_td_2'>
                        <div class="input add_mate">
                            <label for="add_mate_div">Division</label>
                            <input type="text" name="add_mate_div" id="add_mate_div" required>
                            <span class="spin"></span>
                        </div>
                    </td>
                    <td class = 'table_td_2'>
                        <div class="input add_mate">
                            <label for="add_mate_contact">Contact</label>
                            <input type="text" name="add_mate_contact" id="add_mate_contact">
                            <span class="spin"></span>
                        </div>
                    </td>
                    <td class = 'table_td_3'>
                        <div class="input add_mate">
                            <label for="add_mate_ec">EC</label>
                            <input type="text" name="add_mate_ec" id="add_mate_ec">
                            <span class="spin"></span>
                        </div>
                    </td>
            </tr>
                <tr>
                    <td colspan = 4>
                <input class = 'adding_button' type = "submit" name = <?=$added_st_name?> value = "Confirm">
                </td>
            </tr>
            </form>
            <?php
            }
            
        if (access_level() > 1 && !isset($_POST[$add_st_name])) {
            ?>
            <tr>
                <td colspan = 4>
                    <form action = "" method = "post">
                <input class = 'adding_button' type = "submit" name = <?=$add_st_name?> value = "Add mate">
        </form>
                </td>
        </tr>
            <?php
            flash();
        }
        ?>


        </table>

    <?php

}


team_table("`extrim_main_command`", "add_mate", "added_mate", "Main Team");
team_table("`extrim_academy_command`", "ad_add_mate", "ad_added_mate", "Academy Team");
flash();
