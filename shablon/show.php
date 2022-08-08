<?php
//print_r( $BDtable_rows);
$urll = explode('&', $_SERVER['REQUEST_URI']);
$shot_url = $urll[0];


?>

<script>
    //var idid = "";
    $(document).ready(function() {

        // движ по таблице выбор
        var idid_old = "";

        $('.table tr').on('click', function() {
            idid = $(this).attr('id');
            if (idid != null) {
                console.log(idid);

                $(this).addClass('tableselrow');
                if ((idid_old != "") & (idid != idid_old)) {
                    $('.table #' + idid_old).removeClass('tableselrow');
                }
                idid_old = idid;
            }
        });
        // движ по таблице выбор

        $("table thead td input[id^='Search']").keydown(function(event) {
            if (event.keyCode == 13) {
                vall = $(this).val();
                if (vall != null) {
                    pole = $(this).attr('search');
                    $(this).val('');
                    //console.log(' <?php echo ($shot_url); ?>');
                    window.location.href = '<?php echo ($shot_url); ?>&searchpole=' + pole + '&searchval=' + vall;
                }
            }
        });





    })
</script>

<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//echo $_SERVER["DOCUMENT_ROOT"];

//echo __DIR__;
if (!empty($_GET['searchpole'])) {
    $searchpole = $_GET['searchpole'];
    $searchval = $_GET['searchval'];

    if (empty($BDtable_rows[$TableName][$searchpole]['Link'])) {
        $q_search = " WHERE " . $searchpole . " LIKE '%" . $searchval . "%' ";
    } else {
        $q_search = " WHERE " . explode('.', $BDtable_rows[$TableName][$searchpole]['LinkName'])[1] . " LIKE '%" . $searchval . "%' ";
    }
} else {
    $q_search = "";
}



$arr_temp = array_keys($BDtable_rows[$TableName]);


foreach ($arr_temp as $key => $value) {
    $arr_temp[$key] = $TableName . "." . $arr_temp[$key];
}
$ss_colum = implode(',', $arr_temp);


$q_link = "";
foreach ($BDtable_rows[$TableName] as $key => $value) {
    //echo (explode('.', $BDtable_rows[$TableName][$key]['Link'])[0]);
    if (empty($BDtable_rows[$TableName][$key]['Link'])) {
        // $q_link = "";
    } else {
        $q_link = $q_link . " INNER JOIN " . explode('.', $BDtable_rows[$TableName][$key]['Link'])[0] .
            " ON " . $TableName . "." . $key . " = " . $BDtable_rows[$TableName][$key]['Link'] . " ";
    }
    //echo $q_link;
}
//echo $q_link;

$q = "SELECT COUNT(*) FROM " . $TableName . $q_link . $q_search;

$res = mysqli_query($link, $q);
while ($row = mysqli_fetch_row($res)) {;
    $countrow = $row[0]; // всего записей

}
//$countrow = 112;
$countpage = intdiv($countrow, $colrecords_table);
$lastrecords = $countrow - $countpage * $colrecords_table;




if (empty($_GET["limit"])) {
    $activpage = 0;


    $q = "SELECT " . $ss_colum . " FROM " . $TableName . $q_link . $q_search . " LIMIT " . $colrecords_table . " OFFSET 0 ;";
    //echo $q; 
    $res = mysqli_query($link, $q);
} else {
    $activpage = $_GET['page'];
    $q = "SELECT " . $ss_colum . " FROM " . $TableName . $q_link . $q_search . " LIMIT " . $colrecords_table . " OFFSET " . $_GET['ofset'] . ";";
    $res = mysqli_query($link, $q);
}
//echo $q;
$array_list_table = array();

$ss = "limit=" . $colrecords_table . "&ofset=0&page=0";
$array_list_table[] = ['ofset' => 0, 'activ' => 0, 'url' => "?tablename=" . $TableName . "&" . $ss, 'list' => 1];
for ($i = 1; $i < $countpage; $i++) {
    $ss = "limit=" . $colrecords_table . "&ofset=" . ($i * $colrecords_table) . "&page=" . $i;
    $array_list_table[] = ['ofset' => ($i * $colrecords_table), 'activ' => 0, 'url' => "?tablename=" . $TableName . "&" . $ss, 'list' => $i + 1];
};
$ss = "limit=" . $lastrecords . "&ofset=" . ($countpage * $colrecords_table) . "&page=" . $countpage;
$array_list_table[] = ['ofset' => ($countpage * $colrecords_table), 'activ' => 0, 'url' => "?tablename=" . $TableName . "&" . $ss, 'list' => $countpage + 1];

//print_r($array_list_table);

?>

<div class="container-fluid mt-3 mb-5">
    <nav aria-label="Page table">
        <ul class="pagination" class="text-success">
            <?php
            foreach ($array_list_table as $i => $value) {
                // if ($activpage==$array_list_table[$i]["list"]-1){
                //  echo "<li class='page-item active'><a class='page-link ' href='" . $array_list_table[$i]["url"] . "'>" . $array_list_table[$i]["list"] . "</a></li>";

                //  } else {
                echo "<li class='page-item'><a class='page-link text-success' href='" . $array_list_table[$i]["url"] . "'>" . $array_list_table[$i]["list"] . "</a></li>";

                //  }
            } ?>


        </ul>
    </nav>



    <h3>
        <?php echo ($TableRusName);  ?></h3>
    <table class="table table-striped table-hover caption-top">

        <thead class="table-success">
            <tr>
                <?php
                $colinfo = mysqli_fetch_fields($res);
                foreach ($colinfo as $val) {
                    echo "<td>" . $BDtable_rows[$TableName][$val->name]['RusName'] . " 
                    <input id='Search' search='" . $val->name . "' class='form-control mr-2' type='search' placeholder='Поиск' aria-label='Поиск'></td>";
                }
                ?>
            </tr>
        </thead>
        <tbody>

            <?php
            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                echo "<tr id='tr_" . $row["id"] . "'>";
                $colinfo = mysqli_fetch_fields($res);
                foreach ($colinfo as $val) {
                    if (!empty($BDtable_rows[$TableName][$val->name]['Link'])) {
                        $arr_temp = explode('.', $BDtable_rows[$TableName][$val->name]['LinkName']);
                        // print_r($arr_temp);
                        //   echo($row[$val->name]);
                        echo "<td>" . selone($arr_temp[1], $arr_temp[0], $row[$val->name], $link) . "</td>";
                    } else {
                       /* if ((!empty($BDtable_rows[$TableName][$val->name]['type']))&($BDtable_rows[$TableName][$val->name]['type']=='DATE')) {
                            echo "<td>" . date_format($row[$val->name], 'Y-m-d') . "</td>";
                        } else {*/
                            echo "<td>" . $row[$val->name] . "</td>";
                     //   }
                        
                    }
                }
                echo "</tr>";
            }
            ?>

        </tbody>
    </table>





    <nav aria-label="Page table">
        <ul class="pagination">
            <?php
            foreach ($array_list_table as $i => $value) {
                echo "<li class='page-item'><a class='page-link text-success' href='" . $array_list_table[$i]["url"] . "'>" . $array_list_table[$i]["list"] . "</a></li>";
            } ?>


        </ul>
    </nav>
</div>