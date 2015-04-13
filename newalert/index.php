<?php
//New alert

	session_start();

    require_once $_SESSION['ABS_PATH'] . '/util.php';
	require_once $_SESSION['ABS_PATH'] . '/db/db_func.php';
    require_once $_SESSION['ABS_PATH'] . '/config/env_vars.php';
    require_once $_SESSION['ABS_PATH'] . '/config/twig.php';

    $data = array();

	

	//First time loading
	$crops=get_farmer_crops2($_SESSION['mail']);
	$crops_list="";

	for($i=0; $i<count($crops); $i++){
		$crops_list.= "<option value='".$crops[$i]["id"]."'> ".$crops[$i]["crop"]." </option> ";
	}
	$data['mycrops']=$crops_list;

	//Insercion de datos
	if (isset($_POST['my_crops'])){
		$id=$_POST['my_crops'];
		$lat=$_POST['alert_lat2'];
		$lon=$_POST['alert_lon2'];
		$type=$_POST['crop_type'];
		$desc=$_POST['new_alert_desc'];

		$file = $_FILES['new_alert_picture']['tmp_name'];
		$file_name=md5($file.date('Y-m-d').rand(rand(1,123456))).".jpg";

		if(!empty($id) && !empty($lat) && !empty($lon) && $type!="" && !empty($desc) && !empty($file) ){
			if(add_new_alert($id,$lat,$lon,$type,$desc,$file_name)){
				if(move_uploaded_file($file, "../alert_pics/".$file_name)){
					header("location:../map/index.php");
				}
			}
		}

	}

    //Cargar el template
    $template = $twig->loadTemplate('new_alert.html');
    //Imprimir el template
    echo $template->render(array('data' => $data));
?>