<?php
$link = mysqli_connect("192.168.187.200", "root", "Max11031979", "myplatusl_debug");
mysqli_query($link,"SET character_set_results = 'utf8', 
			     character_set_client = 'utf8', 
			     character_set_connection = 'utf8',
			     character_set_database = 'utf8', 
			     character_set_server = 'utf8'");
	if (!$link) {
		echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    	echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
   		echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
	} else {
		/*echo '<script>alert("Подключенно!");</script>';*/
	}

?>