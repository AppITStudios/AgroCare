<?php
	session_start();

    require_once $_SESSION['ABS_PATH'] . '/util.php';
	require_once $_SESSION['ABS_PATH'] . '/db/db_func.php';
    require_once $_SESSION['ABS_PATH'] . '/config/env_vars.php';
    require_once $_SESSION['ABS_PATH'] . '/config/twig.php';

    $data = array();
    
    $crops = get_farmer_crops($_SESSION['mail']);
    
    $str = "var crops = [";
    
    for ($i=0; $i < count($crops); $i++){
        $str .= "{crop: " . '"' . $crops[$i]['crop'] . '",';
        $str .= "size: " . $crops[$i]['size'] . "},";
        
    }
    $str .= "];";
    
    $data['crops_values'] = $str;
    
    //////////////////////////////////////////7
    
    $crops = get_farmer_diseases($_SESSION['mail']);
    $str = "var diseases = [";
    
    for ($i=0; $i < count($crops); $i++){
        $str .= "{diseases: " . '"' . $crops[$i]['diseases'] . '",';
        $str .= "size: " . $crops[$i]['size'] . "},";
        
    }
    $str .= "];";
    
    $data['diseases_values'] = $str;
    
    /////////////////////////////////////////////
    
    $dis_err = get_farmer_diseases_count($_SESSION['mail'], 0);
    $dis_act = get_farmer_diseases_count($_SESSION['mail'], 1);
    
    $data['erradicated_dis'] = $dis_err;
    $data['active_dis'] = $dis_act;
    ////////////////////////////////////////////////

    //Cargar el template
    $template = $twig->loadTemplate('statistics.html');
    //Imprimir el template
    echo $template->render(array('data' => $data));

?>