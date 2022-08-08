<?php
if (!empty($_POST)) {

    if (!empty($_POST[array_keys($_POST)[0]])) {
        // echo($_POST['otdelname']);
        //  print_r($_POST);
        $valpole = array_values($_POST);
        $ss = "";

        for ($i = 0; $i < count($_POST); $i++) {
            if ($i < count($_POST) - 1) {
                $ss = $ss . "'" . $valpole[$i] . "',";
            } else {
                $ss = $ss . "'" . $valpole[$i] . "'";
            }
        }


        // echo ($ss);
        $q = "INSERT INTO " . $TableName . "
            (" . implode(',', array_keys($_POST)) . "
            )
            VALUES
            (
            " . $ss . "
            );";
        //  echo $q;
        $result  = mysqli_query($link, $q);
    };
}
