<?php
	session_start();
    
    require_once $_SESSION['ABS_PATH'] . '/util.php';
	require_once $_SESSION['ABS_PATH'] . '/db/db_func.php';
    require_once $_SESSION['ABS_PATH'] . '/config/env_vars.php';
    require_once $_SESSION['ABS_PATH'] . '/config/twig.php';
    
    if (isset($_POST['max_x'])){
        $exclude = array();
        $exclude['lat'] = array();
        $exclude['lng'] = array();
        
        $min_x = $_POST['min_x'];
        $max_x = $_POST['max_x'];
        
        $min_y = $_POST['min_y'];
        $max_y = $_POST['max_y'];
        
        foreach($_POST['exclude'] as $marker){
            array_push($exclude['lat'], $marker[0]);
            array_push($exclude['lng'], $marker[1]);
        }
        
        
        //$data = get_new_markers($min_x, $max_x, $min_y, $max_y, $exclude);
        
        $data = get_diseases(1, $min_x, $max_x, $min_y, $max_y, $exclude);
        //var_dump($data);
        echo json_encode($data);
        
    } else{
        echo "No se recibio el valo de id";
    }
?>