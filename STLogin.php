<?php
    $logins = array(
        "user1" => "pass",
        "user2" => "pass"
    );
    $access = false;
    if(array_key_exists(strtolower($_POST['user']), $logins)){
        if($logins[$_POST['user']] == strtolower($_POST['pass'])){
            $access = true;
        }
    }
    echo $access;
?>