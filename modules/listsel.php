<?php

//$TB = $_GET['tb'];
//$pole = $_GET['pole'];

$q = "SELECT * FROM " . $selTB . ";";
$result = mysqli_query($link, $q);

$sostavn = strpos($selpole, "+");

if ($sostavn === false) {
} else {
    $a_pole = explode("+", $selpole);
}
?>

<select class="form-select" aria-label="Список" id='<?php echo ("SelList_" . $selTB) ?>'>
    <option selected>Выберите из списка...</option>
    <?php
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        

        if ($sostavn === false) {
           echo ("<option value='" . $row['id'] . "'>" . $row[$selpole] . "</option>"); 
        } else {
            echo ("<option value='" . $row['id'] . "'>");
            foreach ($a_pole as $key => $value) {
                echo($row[$value]." ");
            }
            echo("</option>");
        };

    }
    ?>

</select>