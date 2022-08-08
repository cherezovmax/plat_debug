<?php 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
include('connect.php');
include('var.php');

//echo ($_POST['id']);
//echo ($_POST['tablename']);



$q = "DELETE FROM ".$_POST['tablename']."
WHERE
  id = ".$_POST['id']." -- id - INT(11) NOT NULL
;";
$result  = mysqli_query($link, $q);

header_remove("Location");
header("Location: ".$_POST['url']);
die();
