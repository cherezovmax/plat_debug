<?php
include("modules/var.php");
include("modules/connect.php");
session_start();
if (!empty($_GET['action'])){
    if ($_GET['action']=='exit'){

        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Наконец, уничтожаем сессию.
        session_destroy();
    }

}


if (!empty($_POST)){
    if ((!empty($_POST['username']))&(!empty($_POST['userpswr']))){
        $quser = "SELECT
        id,
        username,
        userpswr,
        image,
        idtype
        FROM user WHERE id='".$_POST['username']."';";

        $resuser = mysqli_query($link,$quser);
        $rowuser = mysqli_fetch_array($resuser, MYSQLI_ASSOC); 

        if ($_POST['userpswr']==base64_decode($rowuser['userpswr'])) {
    //        session_start();
            $_SESSION['id']= $rowuser['id'];
            $_SESSION['username']= $rowuser['username'];
            $_SESSION['image']= $rowuser['image'];
            $_SESSION['typeuser']= $rowuser['idtype'];
        };


   


    }
}


if (!empty($_SESSION['username'])) {

    if (!empty($_GET['tablename'])) {
        $TableName = $_GET['tablename'];

        foreach ($BDtable as $val) {
            if ($val['name'] == $TableName) {
                $TableRusName = $val['rusname'];
            }
        }
    }

    if (!empty($_GET['edittablename'])) {
        $TableName = $_GET['edittablename'];

        foreach ($BDtable as $val) {
            if ($val['name'] == $TableName) {
                $TableRusName = $val['rusname'];
            }
        }
    }

    include("shablon/shablon.php");
} else {
    //  echo ("Вход не выполнен");

?>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Платные услуги</title>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link href="./css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="js/script.js"></script>

    </head>
    <div class="container-fluid mt-5 py-2 ">
        <div class="row">


            <div class="col-4">

            </div>
            <div class="col-4" style="text-align: center;">
                <img src="/img/logo.png" alt="" style="margin-bottom: 10px;">
                <div class="bg-success text-light p-2 mb-2 fs-6 rounded-top">Авторизация в системе:<br><?php echo $TitleNameWeb?></div>
                <form method="post" action="/">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user fa-fw" aria-hidden="true"></i>Имя пользователя</span>
                        <?php listsel("username", "username", "user", "id", $link) ?>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-key fa-fw"></i>Пароль</span>

                        <input class="form-control" type="password" name="userpswr">
                    </div>
                    <button class="btn fluid btn-primary btn-lg" type="submit" style="width: 100%;">Вход в систему</button>
                </form>
            </div>
            <div class="col-4">

            </div>
        </div>
    </div>



<?php } ?>