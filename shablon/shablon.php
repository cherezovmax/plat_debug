<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Платные услуги</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/script.js"></script>
</head>

<body>
    <?php include("header.php"); ?>
    <?php include("leftblock.php"); ?>

    <div class="container-fluid mt-5 py-2">
        <div class="row">
            <div class="col-1 "> </div>
            <div class="col-10 mb-5">
                <?php
                
                if (!empty($_GET['tablename'])) {

                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/modules/" . $TableName . "/show.php")) {
                        include($_SERVER["DOCUMENT_ROOT"] . "/modules/" . $TableName . "/show.php");
                    } else {

                        include($_SERVER["DOCUMENT_ROOT"] . "/shablon/show.php");
                    }
                }
                if (!empty($_GET['edittablename'])) {

                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/modules/" . $TableName . "/edit.php")) {
                        include($_SERVER["DOCUMENT_ROOT"] . "/modules/" . $TableName . "/edit.php");
                    } else {
                        include($_SERVER["DOCUMENT_ROOT"] . "/shablon/edit.php");
                    }
                }

                if ((empty($_GET['tablename']))&(empty($_GET['edittablename']))){
                    foreach ($BDtable as $i => $table) {
                        if ($table["editone"] == 3) {
                            $TableName = $table["name"];
                            include("modules/" . $TableName . "/show.php");   
                        }
                    }
                }




                ?>
            </div>
            <div class="col-1 "></div>
        </div>
    </div>

    <?php include("footer.php"); ?>

</body>

</html>