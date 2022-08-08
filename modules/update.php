<?php 
if (!empty($_POST)){
if(!empty($_POST[array_keys($_POST)[0]])){

$pole = array_keys($_POST);
$valpole = array_values($_POST);

$ss = "";
for ($i=0; $i < count($_POST); $i++) { 
  if ($i < count($_POST)-1) {
  $ss = $ss . $pole[$i]."='".$valpole[$i]."',";} else {
    $ss = $ss . $pole[$i]."='".$valpole[$i]."'";
  }
}


    $q = "UPDATE ".$TableName." 
    SET
      ".$ss."
    WHERE
      id = ".$_GET['index'].";";
//echo $q;
    $result  = mysqli_query($link, $q);
}
}
?>