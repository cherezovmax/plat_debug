<?php

include "connect.php";

if ((!empty($_GET['username'])) & (!empty($_GET['userpswr']))& (!empty($_GET['image']))& (!empty($_GET['typeuser']))) {

    $q = "INSERT INTO user
(
username
 ,userpswr
 ,image
 ,idtype
)
VALUES
(
 '" . $_GET['username'] . "' -- username - VARCHAR(255)
 ,'" . base64_encode($_GET['userpswr']) . "' -- userpswr - VARCHAR(255)
 ,'".$_GET['image']."'
 ,".$_GET['typeuser']."
);";

    $res = mysqli_query($link, $q);
    if ($res) {
        
        echo ('Пользователь создан!');
    }
};


// ttp://192.168.187.200:9999/modules/createuser.php?username=user2&userpswr=1&image=man.png&typeuser=3