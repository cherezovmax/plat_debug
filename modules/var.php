<?php
//шифрование
// Ключ шифрования
//$key = "5aa3c281e42ba7101f7227a7519d5e961c7bcf2b10a42914304bffc1afcebb1d2be98f53caa80d05";
// Шифруемые данные
//$data = 'Это строка была закодирована симметричным шифрованием AES';
// Метод шифрования
//$method = "AES-192-CBC";

// Шифруем данные
//$encrypted = openssl_encrypt($data, $method, $key);
//$encrypted = base64_encode($data);
// Смотрим результат
//var_dump($encrypted);
//echo($encrypted);
// Дешифруем данные
//$decrypted = base64_decode($encrypted);
//echo($decrypted);
// Смотрим результат
//var_dump($decrypted);





// используемые таблицы
$TableName = "";
$TableRusName = "";

$TitleNameWeb = "Расписание платных услуг";


$BDtable = array(
    ["name" => "otdelenia", "rusname" => "Отделения", "editone" => 1],
    ["name" => "pacient", "rusname" => "Пациенты", "editone" => 1],
    ["name" => "vrach", "rusname" => "Врачи", "editone" => 1],
    ["name" => "raspisanie", "rusname" => "Расписание", "editone" => 1],
    ["name" => "zapis", "rusname" => "Запись", "editone" => 3] // стартовая база
);



$BDtable_rows = array(
    "otdelenia" => [
        'id' => [
            'RusName' => "ИД",
            'Link' => '',
            'LinkName' => ''
        ],
        'otdelname' => [
            'RusName' => "Отделение",
            'Link' => '',
            'LinkName' => ''
        ]
    ],
    "vrach" => [
        'id' => [
            'RusName' => "ИД",
            'Link' => '',
            'LinkName' => ''
        ],
        'vrachname' => [
            'RusName' => "Врач",
            'Link' => '',
            'LinkName' => ''
        ]
    ],
    "pacient" => [
        "id" => [
            'RusName' => "ИД",
            'Link' => '',
            'LinkName' => ''
        ],
        "F" => [
            'RusName' => "Фамилия",
            'Link' => '',
            'LinkName' => ''
        ],
        "I" => [
            'RusName' => "Имя",
            'Link' => '',
            'LinkName' => ''
        ],
        "O" => [
            'RusName' => "Отчество",
            'Link' => '',
            'LinkName' => ''
        ],
        "tel" => [
            'RusName' => "Телефон",
            'Link' => '',
            'LinkName' => ''
        ]
    ],
    "raspisanie" => [
        "id" => [
            'RusName' => "ИД",
            'Link' => '',
            'LinkName' => ''
        ],
        "idotdel" => [
            'RusName' => "Отделение",
            'Link' => 'otdelenia.id',
            'LinkName' => 'otdelenia.otdelname'
        ],
        "idvarch" => [
            'RusName' => "Врач",
            'Link' => 'vrach.id',
            'LinkName' => 'vrach.vrachname'
        ],
        "timeStart" => [
            'RusName' => "Время начала приема",
            'Link' => '',
            'LinkName' => '',
            'type'=>'TIME'
        ],
        "timeEnd" => [
            'RusName' => "Время окончания приема",
            'Link' => '',
            'LinkName' => '',
            'type'=>'TIME'
        ],
        "dateend"=> [
            'RusName' => "Действует ДО",
            'Link' => '',
            'LinkName' => '',
            'type'=>'DATE'
        ],
        "datestart"=> [
            'RusName' => "Действует C",
            'Link' => '',
            'LinkName' => '',
            'type'=>'DATE'
        ]
    ]
);

$colrecords_table = 30;



function listsel($linkpole,$selpole, $selTB, $sellist_id, $link)
{
    $s = "";
    $q = "SELECT * FROM " . $selTB . "  ORDER BY ".$selpole.";";;
    $result = mysqli_query($link, $q);

    $sostavn = strpos($selpole, "+");

    if ($sostavn === false) {
    } else {
        $a_pole = explode("+", $selpole);
    }

    $s = $s . "<select class='form-select' aria-label='Список' id='" . $selTB . "' name='".$linkpole."'>
        <option selected>Выберите из списка...</option>";
//$s= $s."<input class='form-control' type='text'>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {


        if ($sostavn === false) {
            if ($sellist_id == $row['id']) {
                $s = $s . "<option selected value='" . $row['id'] . "'>" . $row[$selpole] . "</option>";
            } else {
                $s = $s . "<option value='" . $row['id'] . "'>" . $row[$selpole] . "</option>";
            }
        } else {
            if ($sellist_id == $row['id']) {
                $s = $s . "<option selected value='" . $row['id'] . "'>";
            } else {
                $s = $s . "<option value='" . $row['id'] . "'>";
            }

            foreach ($a_pole as $key => $value) {
                $s = $s . $row[$value] . " ";
            }
            $s = $s . "</option>";
        };
    }
    $s = $s . "</select>";
    echo $s;
}

function selone($selpole, $selTB, $sellist_id, $link)
{
    $s = "";
    $q = "SELECT * FROM " . $selTB . " where id=" . $sellist_id . ";";
    $result = mysqli_query($link, $q);
   

    $sostavn = strpos($selpole, "+");

    if ($sostavn === false) {
    } else {
        $a_pole = explode("+", $selpole);
    }

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {


        if ($sostavn === false) {
            $s = $s . $row[$selpole];
        } else {

            foreach ($a_pole as $key => $value) {
                $s = $s . $row[$value] . " ";
            }
        };
    }

    return $s;
}


function listselDate($linkpole,$selpole, $selTB, $sellist_id, $link)
{
    $s = "";
    $q = "SELECT * FROM " . $selTB . " ORDER BY '".$selpole."';";
    $result = mysqli_query($link, $q);

    $sostavn = strpos($selpole, "+");

    if ($sostavn === false) {
    } else {
        $a_pole = explode("+", $selpole);
    }
  $s = $s.'<input class="form-control" list="datalistOptions" id="' . $selTB . '" placeholder="ВВедите ..." name="'.$linkpole.'">';
  
  $s = $s . "<datalist id='datalistOptions'>";
//$s= $s."<input class='form-control' type='text'>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {


        if ($sostavn === false) {
            if ($sellist_id == $row['id']) {
                $s = $s . "<option selected value='" . $row['id'] . "'>" . $row[$selpole] . "</option>";
            } else {
                $s = $s . "<option value='" . $row['id'] . "'>" . $row[$selpole] . "</option>";
            }
        } else {
            if ($sellist_id == $row['id']) {
                $s = $s . "<option selected value='" . $row['id'] . "'>";
            } else {
                $s = $s . "<option value='" . $row['id'] . "'>";
            }

            foreach ($a_pole as $key => $value) {
                $s = $s . $row[$value] . " ";
            }
            $s = $s . "</option>";
        };
    }
    $s = $s . "</datalist>";
    echo $s;
}