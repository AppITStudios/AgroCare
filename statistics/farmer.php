<?php
	session_start();

    require_once $_SESSION['ABS_PATH'] . '/util.php';
	require_once $_SESSION['ABS_PATH'] . '/db/db_func.php';
    require_once $_SESSION['ABS_PATH'] . '/config/env_vars.php';
    require_once $_SESSION['ABS_PATH'] . '/config/twig.php';
    
    
    $data = get_farmer_diseases($_SESSION['mail']);
    echo json_encode($data);
?>