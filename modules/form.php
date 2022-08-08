<div class="container my-5">

    <h3>
        <?php
        if ($_GET['typeedit'] == 'add') {
            include('add.php');

            if (!empty($result)) {

                // === не для классического шаблона 
                if (!empty($_GET['u'])) {
                    // echo ($_GET['u']);
                    // находим макс ид пациента
                    $urldop = "";
                    $qmax = 'SELECT
                        MAX(id) AS max
                        FROM pacient;';
                    $resmax = mysqli_query($link, $qmax);
                    while ($rowmax = mysqli_fetch_array($resmax, MYSQLI_ASSOC)) {
                        $maxmax = $rowmax['max'];
                    }
                    $urldop = $urldop . "&action=" . $_GET['action'];
                    $urldop = $urldop . "&date=" . $_GET['date'];
                    $urldop = $urldop . "&idrasp=" . $_GET['idrasp'];
                    // находим макс ид пациента
                    //echo (base64_decode($_GET['u']) . '&pindex=' . $maxmax . $urldop );
                    echo ('<script>window.location.href ="' . base64_decode($_GET['u']) . '&pindex=' . $maxmax . $urldop . '"</script>');
                }
                // === не для классического шаблона 
            }

            echo ('Создание нового: ');
        }
        if ($_GET['typeedit'] == 'update') {
            include('update.php');


            // listsel('F+I+O','pacient',2,$link);
            echo ('Редактирование: ');
        }
        if ($_GET['typeedit'] == 'del') {
            echo ('Удаление: ');
        }
        echo ($TableRusName);
        ?>

    </h3>
    <?php if ($_GET['typeedit'] == 'del') { ?><p class="fw-ligth fs-6">Вы хотите удалить запись:</p><?php } else { ?><p class="fw-ligth fs-6">Заполните данные :</p><?php } ?>

    <form action="<?php if ($_GET['typeedit'] == 'del') {
                        echo ("modules/del.php");
                    } else {
                        echo ($_SERVER['REQUEST_URI']);
                    } ?>" method="post" class="needs-validation">



        <?php
        if ($_GET['typeedit'] == 'update') {
            $id = $_GET['index'];
            $q = "SELECT * FROM " . $TableName . " WHERE id=" . $id;

            $result  = mysqli_query($link, $q);

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {


                $colinfo = mysqli_fetch_fields($result);

                foreach ($colinfo as $val) {
                    if ($val->name != 'id') {
                        echo "<div class='mb-3'>";
                        echo "<label for='" . $val->name . "' class='form-label'>" . $BDtable_rows[$TableName][$val->name]['RusName'] . "</label>";

                        if (!empty($BDtable_rows[$TableName][$val->name]['Link'])) {

                            $arr_temp = explode('.', $BDtable_rows[$TableName][$val->name]['LinkName']);
                            listsel($val->name, $arr_temp[1], $arr_temp[0], $row[$val->name], $link);
                        } else {

                            if (!empty($BDtable_rows[$TableName][$val->name]['type'])) {
                                echo "<input class='form-control' type='" . $BDtable_rows[$TableName][$val->name]['type'] . "' id='" . $val->name . "'";
                                echo "value='" . $row[$val->name] . "' name='" . $val->name . "' placeholder='" . $BDtable_rows[$TableName][$val->name]['RusName']  . "' aria-label='' aria-describedby='my-addon' >";
                            } else {
                                echo "<input class='form-control' type='text' id='" . $val->name . "'";
                                echo "value='" . $row[$val->name] . "' name='" . $val->name . "' placeholder='" . $BDtable_rows[$TableName][$val->name]['RusName']  . "' aria-label='' aria-describedby='my-addon' >";
                            }
                        }
                        echo "</div>";
                    }
                }
            }
        }
        if ($_GET['typeedit'] == 'del') {
            $id = $_GET['index'];
            $q = "SELECT * FROM " . $TableName . " WHERE id=" . $id;
            $result  = mysqli_query($link, $q);

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {


                $colinfo = mysqli_fetch_fields($result);
                foreach ($colinfo as $val) {
                    if ($val->name != 'id') {
                        echo "<div class='mb-3'>";
                        echo "<label for='" . $val->name . "' class='form-label'>" . $BDtable_rows[$TableName][$val->name]['RusName']  . "</label>";

                        if (!empty($BDtable_rows[$TableName][$val->name]['Link'])) {
                            echo "<input class='form-control' type='text' id='" . $val->name . "'";
                            $arr_temp = explode('.', $BDtable_rows[$TableName][$val->name]['LinkName']);
                            echo "value='" . selone($arr_temp[1], $arr_temp[0], $row[$val->name], $link) . "' name='" . $val->name . "' placeholder='" . $BDtable_rows[$TableName][$val->name]['RusName']  . "' aria-label='' aria-describedby='my-addon' disabled>";
                        } else {
                            echo "<input class='form-control' type='text' id='" . $val->name . "'";
                            echo "value='" . $row[$val->name] . "' name='" . $val->name . "' placeholder='" . $BDtable_rows[$TableName][$val->name]['RusName']  . "' aria-label='' aria-describedby='my-addon' disabled>";
                        }

                        echo "</div>";
                    }
                }
            }
            echo "<input type='hidden' name='id' value='" . $id . "'>";
            $url = $_SERVER['REQUEST_URI'];
            $url = explode('?', $url);
            $url = $url[0] . "?tablename=" . $TableName;
            echo "<input type='hidden' name='tablename' value='" . $TableName . "'>";
            echo "<input type='hidden' name='url' value='" . $url . "'>";
        }


        if ($_GET['typeedit'] == 'add') {
            foreach (array_keys($BDtable_rows[$TableName]) as $val) {
                if ($val != 'id') {
                    echo "<div class='mb-3'>";
                    echo "<label for='" . $val . "' class='form-label'>" . $BDtable_rows[$TableName][$val]['RusName'] . "</label>";

                    if (!empty($BDtable_rows[$TableName][$val]['Link'])) {
                        $arr_temp = explode('.', $BDtable_rows[$TableName][$val]['LinkName']);
                        listsel($val, $arr_temp[1], $arr_temp[0], '', $link);
                    } else {
                        if (!empty($BDtable_rows[$TableName][$val]['type'])) {
                            echo "<input class='form-control' type='".$BDtable_rows[$TableName][$val]['type']."' value='' name='" . $val . "' placeholder='" . $BDtable_rows[$TableName][$val]['RusName'] . "' aria-label='' aria-describedby='my-addon' required>";
                        } else {
                            echo "<input class='form-control' type='text' value='' name='" . $val . "' placeholder='" . $BDtable_rows[$TableName][$val]['RusName'] . "' aria-label='' aria-describedby='my-addon' required>";
                        }
                    }



                    echo "</div>";
                }
            }

            // === не для классического шаблона 
            if (!empty($_GET['act'])) {

                //    echo "<input type='hidden' name='url' value='" . $_GET['u'] . "'>";
            }
            // === не для классического шаблона 
        }
        ?>



        <div class="my-5 d-grid gap-2 col-6 mx-auto">



            <a class="btn btn-success" href="<?php
                                                $url = $_SERVER['REQUEST_URI'];
                                                $url = explode('?', $url);
                                                $url = $url[0] . "?tablename=" . $TableName;
                                                echo $url; ?>" role="button">Вернутся ...</a>


            <button type="submit" class="btn btn-primary btn-lg">Применить</button>
        </div>

    </form>
</div>