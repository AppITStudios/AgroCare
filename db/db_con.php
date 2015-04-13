<?php
	session_start();
	
	#Conexion a servidor de base de datos
	@require_once $_SESSION['ABS_PATH'] . '/config/db_config.php';

	$db_con = new mysqli($host,$usuario,$password, $db_name);
?>