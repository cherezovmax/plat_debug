<?php

$u = explode('&', $_SERVER['REQUEST_URI']);
$s_u = $u[0];
if (count($u) == 1) {
    if (strpos($_SERVER['REQUEST_URI'], '?') === false) {
        $s_u = $s_u . '?';
    } else {
        $s_u = $s_u . '&';
    }
} else {
    $s_u = $s_u . '&';
}

?>
<script>
    $(document).ready(function() {
        $('#otdelenia').change(function() {
            val = $('#otdelenia').val();
            dateval = $('#zapisdate').val();
            s = "";
            if ((val != null) & (Number.isInteger(Number(val)))) {
                s = s + "<?php echo ($s_u); ?>idotdel=" + val;
                if (dateval != '') {
                    s = s + "&datezap=" + dateval;
                }
            }
            window.location.href = s;
        });



        $('#selectBtnzap').on('click', function() {
            val = $('#otdelenia').val();
            dateval = $('#zapisdate').val();
            s = "";
            if ((val != null) & (Number.isInteger(Number(val)))) {
                s = s + "<?php echo ($s_u); ?>idotdel=" + val;
                if (dateval != '') {
                    s = s + "&datezap=" + dateval;
                }
            }
            window.location.href = s;
        });
    });
</script>

<form>
    <div class="form-group row align-items-center  justify-content-center my-3">

        <div class="col-auto">

            <input id="zapisdate" class="form-control" type="date" name="">
        </div>
        <div class="col-auto">

            <?php
            listsel('id', 'otdelname', 'otdelenia', 0, $link);
            // listselDate('id', 'otdelname', 'otdelenia', 0, $link);
            ?>
        </div>

        <div class="col-4">

            <a id="selectBtnzap" class="btn btn-success btn-lg " type="submit" style="width: 50px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <a id="selectBtnzap" class="btn btn-primary btn-lg disabled" type="submit" style="width: 100%; display: none;">Выбрать</a>
        </div>
    </div>
</form>
<div> <?php



        if (!empty($_GET['pindex'])) {
            $pindex = $_GET['pindex'];
            echo ("<h4>Запись для : ");

            echo (selone('F+I+O', 'pacient', $pindex, $link));
            if (!empty($_GET['idotdel'])) {
                echo (' в ' . selone('otdelname', 'otdelenia', $_GET['idotdel'], $link));
            }
        } else {
            if (!empty($_GET['idotdel'])) {
                echo ("<h4>Просмотр записей : " . selone('otdelname', 'otdelenia', $_GET['idotdel'], $link));
            } else {
                echo ("<h4>Просмотр записей : ");
            }
        }


        ?></h4>
</div>
<script>
    $(document).ready(function() {

        <?php if ($_SESSION['typeuser'] != 3) { ?>

            $('.zapisbtncreate').on('click', function() {
                if ($(this).attr('zap') == '') {
                    url = '<?php echo (base64_encode($_SERVER['REQUEST_URI'])) ?>';
                    urldop = '&action=addzap' + '&date=' + $(this).attr('data') + '&idrasp=' + $(this).attr('rasp');
                    window.location.href = '?edittablename=pacient&typeedit=add&act=zap&u=' + url + urldop;
                } else {

                }
            });

            $('.zapisbtn').on('click', function() {
                if ($(this).attr('zap') != '') {
                    window.location.href = '<?php echo ($_SERVER['REQUEST_URI']) ?>' + '&action=addzap' + '&date=' + $(this).attr('data') + '&idrasp=' + $(this).attr('rasp') + '&idzap=' + $(this).attr('zap');

                } else {
                    window.location.href = '<?php echo ($_SERVER['REQUEST_URI']) ?>' + '&action=addzap' + '&date=' + $(this).attr('data') + '&idrasp=' + $(this).attr('rasp');
                }
            });

            $('.otmenazapbtn').on('click', function() {
                if ($(this).attr('zap') != '') {
                    window.location.href = '<?php echo ($_SERVER['REQUEST_URI']) ?>' + '&action=cancelzap' + '&date=' + $(this).attr('data') + '&idrasp=' + $(this).attr('rasp') + '&idzap=' + $(this).attr('zap');

                } else {}
            });

            $('.payplus').on('click', function() {
                if ($(this).attr('zap') != '') {
                    console.log("zap=" + $(this).attr('zap'));
                    window.location.href = '<?php echo ($_SERVER['REQUEST_URI']) ?>' + '&action=addoplat' + '&idzap=' + $(this).attr('zap');

                } else {}
            });

            $('.payminus').on('click', function() {
                if ($(this).attr('zap') != '') {
                    window.location.href = '<?php echo ($_SERVER['REQUEST_URI']) ?>' + '&action=canceloplat' + '&idzap=' + $(this).attr('zap');

                } else {}
            });
        <?php } ?>

    });
</script>
<?php
// сюда обработку действий
// &idotdel=2&datezap=20.01.2022
// ==
$surl = '/';
/*if (!empty($_GET['pindex'])) {
    $surl = $surl . "?pindex=" . $_GET['pindex'];

    if (!empty($_GET['idotdel'])) {
        $surl = $surl . "&idotdel=" . $_GET['idotdel'];
    }
    if (!empty($_GET['datezap'])) {
        $surl = $surl . "&datezap=" . $_GET['datezap'];
    }
} else {*/
if (!empty($_GET['idotdel'])) {
    $surl = $surl . "?idotdel=" . $_GET['idotdel'];
}
if (!empty($_GET['datezap'])) {
    $surl = $surl . "&datezap=" . $_GET['datezap'];
}
//}

if (!empty($_GET['action'])) {

    if ($_GET['action'] == 'addzap') {
        $q = 'INSERT INTO zapis
        (
          date
         ,idrasp
         ,idpacient
         ,oplata
        )
        VALUES
        (

        "' . $_GET['date'] . '" -- date - DATE NOT NULL
         ,' . $_GET['idrasp'] . ' -- idrasp - INT(11) NOT NULL
         ,' . $_GET['pindex'] . ' -- idpacient - INT(11) NOT NULL
         ,' . 0 . ' -- oplata - TINYINT(1)
        );';
        $result  = mysqli_query($link, $q);
        if ($result) {
            echo ('<script>window.location.href ="' . $surl . '"</script>');
        }
    };

    if ($_GET['action'] == 'cancelzap') {
        $q = 'DELETE FROM zapis
        WHERE
          id = ' . $_GET['idzap'];
        $result  = mysqli_query($link, $q);
        if ($result) {
            echo ('<script>window.location.href ="' . $surl . '"</script>');
        }
    };

    if ($_GET['action'] == 'addoplat') {
        $q = 'UPDATE zapis 
        SET

         oplata = 1 -- oplata - TINYINT(1)
        WHERE
           id = ' . $_GET['idzap'];
        $result  = mysqli_query($link, $q);
        if ($result) {
            echo ('<script>window.location.href ="' . $surl . '"</script>');
        }
    };


    if ($_GET['action'] == 'canceloplat') {
        $q = 'UPDATE zapis 
        SET

         oplata = 0 -- oplata - TINYINT(1)
        WHERE
           id = ' . $_GET['idzap'];
        $result  = mysqli_query($link, $q);
        if ($result) {
            echo ('<script>window.location.href ="' . $surl . '"</script>');
        }
    }
}





if (!empty($_GET['idotdel'])) {
    $idopdelzapis = $_GET['idotdel'];



    $qzap_base = "SELECT
        raspisanie.*,
        zapis.id AS id_zapis,
        zapis.date,
        zapis.idpacient,
        zapis.oplata
        FROM raspisanie
        LEFT OUTER JOIN zapis
        ON raspisanie.id = zapis.idrasp";


    if (!empty($_GET['datezap'])) {
        $datezap = $_GET['datezap'];

        $datestart = date_create($datezap);
    } else {
        $datestart = date_create(date('d.m.Y'));
    }






    $datenames = array('Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
    for ($index = 1; $index <= 14; $index++) {
        $qzap = '';
        $qzap = $qzap_base . " AND zapis.date = '" . date_format($datestart, 'Y-m-d') . "'";
        $qzap = $qzap . " WHERE raspisanie.idotdel = " . $idopdelzapis . " AND (dateend IS NULL OR dateend>'" . date_format($datestart, 'Y-m-d') . "' AND datestart<='" . date_format($datestart, 'Y-m-d') . "') ORDER BY raspisanie.timeStart";

        $datename = $datenames[date_format($datestart, 'w')];
        //for start    
        //echo $qzap;
        if (($datename != 'Воскресенье') & ($datename != 'Суббота')) {
            echo ('<div class="card mb-3" id="datezap">
            <h5 class="card-header text-darck smallhead" style="background-color: #8edbb7;">' . date_format($datestart, 'd.m.Y')
                . " : " . $datename . '</h5><div class="card-group">');

            $resultzap = mysqli_query($link, $qzap);

            while ($rowzap = mysqli_fetch_array($resultzap, MYSQLI_ASSOC)) {
                //  print_r($rowzap);
                echo ('<div  class="card  smallhead" style="min-width: 20rem; max-width: 25rem;" id="rasp_' . $rowzap['id'] . '">
                    <h5 class="card-header bg-success text-light smallhead">' . $rowzap['timeStart'] . ' - ' . $rowzap['timeEnd'] . '</h5>
                    <div class="card-body"><p class="card-text">');
                echo ('Врач: ' . selone('vrachname', 'vrach', $rowzap['idvarch'], $link) . '<br>');

                if (!isset($rowzap['idpacient'])) {
                    echo ('Пациент: Свободно <br>');
                    echo ('Оплата: <span class="text-success">Нет оплаты </span><a class="btn btn-danger btn-sm disabled payplus" id="payplus">$</a><br></p>');
                } else {
                    echo ('Пациент: ' . selone('F+I+O', 'pacient', $rowzap['idpacient'], $link) . '<br>');
                    echo ('<i class="fa fa-phone" aria-hidden="true"></i> ' .  selone('tel', 'pacient', $rowzap['idpacient'], $link) . '<br>');
                    if ($rowzap['oplata'] == 0) {
                        echo (' Оплата: <span class="text-success">Нет оплаты </span><a  class="btn btn-danger btn-sm payplus" id="" zap="' . $rowzap['id_zapis'] . '" data-bs-toggle="tooltip" data-bs-placement="left" title="Установить отметку об оплате">$</a><br></p>');
                    } else {
                        echo (' Оплата: <span class="text-success">Произведена </span><a class="btn btn-success btn-sm payminus" id="" zap="' . $rowzap['id_zapis'] . '" data-bs-toggle="tooltip" data-bs-placement="left" title="Снять отметку об оплате">$</a><br></p>');
                    }
                }


                if (!isset($rowzap['idpacient'])) {

                    if (!empty($_GET['pindex'])) {
                        echo (' <a  class="btn btn-warning zapisbtn" id="zapisbtn" zap="' . $rowzap['id_zapis'] . '" rasp="' . $rowzap['id'] . '" data="' . date_format($datestart, 'Y-m-d') . '">Записать пациента</a>       </div>
                </div>');
                    } else {
                        echo (' <a  class="btn btn-warning zapisbtncreate" id="zapisbtn" zap="' . $rowzap['id_zapis'] . '" rasp="' . $rowzap['id'] . '" data="' . date_format($datestart, 'Y-m-d') . '">Создать пациента и Записать</a>       </div>
                    </div>');
                    }
                } else {
                    echo (' <a  class="btn btn-danger otmenazapbtn" id="otmenazapbtn" zap="' . $rowzap['id_zapis'] . '" rasp="' . $rowzap['id'] . '" data="' . date_format($datestart, 'Y-m-d') . '">Отменить Запись</a>       </div>
                     </div>');
                }
            };

?>








<?php
            echo ('</div>

        </div>');
        };


        date_modify($datestart, '1 day');
    }
} else {
    // если не выбран
}

?>