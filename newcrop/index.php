<?php
	session_start();

    require_once $_SESSION['ABS_PATH'] . '/util.php';
	require_once $_SESSION['ABS_PATH'] . '/db/db_func.php';
    require_once $_SESSION['ABS_PATH'] . '/config/env_vars.php';
    require_once $_SESSION['ABS_PATH'] . '/config/twig.php';

    $data = array();

	if (isset($_POST['new_crop_name'])){
		$name=$_POST['new_crop_name'];
		$size=$_POST['new_crop_size'];
		$user=$_SESSION['mail'];

		if(!empty($name) && !empty($size)){
			if (add_new_crop($name,$size,$user)){
				header("location:../map/index.php");
			}
		}

	}

    //Cargar el template
    $template = $twig->loadTemplate('new_crop.html');
    //Imprimir el template
    echo $template->render(array('data' => $data));

?>