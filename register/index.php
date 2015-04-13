<?php
    session_start();
    
    require_once $_SESSION['ABS_PATH'] . '/util.php';
	require_once $_SESSION['ABS_PATH'] . '/db/db_func.php';
    require_once $_SESSION['ABS_PATH'] . '/config/env_vars.php';
    require_once $_SESSION['ABS_PATH'] . '/config/twig.php';
    
    if (isset($_POST['first_name'])){
        $clean = array();
        $clean['first_name'] = '';
        $clean['last_name'] = '';
        $clean['mail'] = '';
        
        $clean['first_name'] = $_POST['first_name'];
        $clean['last_name'] = $_POST['last_name'];
        $clean['city'] = $_POST['city'];
        $clean['country'] = $_POST['country'];
        
        if (filter_var($_SESSION['mail'], FILTER_VALIDATE_EMAIL)){
            $clean['mail'] = $_SESSION['mail'];
        }
        
        if (!empty($clean['first_name']) && !empty($clean['last_name']) && !empty($clean['mail'])){
            $clean['profile_pic_path'] = md5($clean['mail'] . time() . rand(0, 65530)) . '.jpg';
            $clean['password'] = rand(0, 65530) . rand(0, 65530) . rand(0, 65530) . $clean['mail'];
        
            if (add_new_user($clean['mail'], $clean['first_name'], $clean['last_name'], $clean['password'], '1', $clean['profile_pic_path'], $clean['country'], $clean['city'])){
                $path = '../' . $PROFILE_PICS_PATH . '/' . $clean['profile_pic_path'];
                $data = imgFromUrl($_SESSION['fb_img_url']);
            
                unset($_SESSION['fb_img_url']);
                unset($_SESSION['first_name']);
                unset($_SESSION['last_name']);
                $_SESSION['status'] = 'logged';
                $_SESSION['profile_pic_path'] = $path;
            
                file_put_contents($path, $data);
                session_regenerate_id();
                header('Location: /map/');
            }
        } else{
            echo "Datos no filtrados";
        }
    }
    
    $data = array();
    $data['first_name'] = $_SESSION['first_name'];
    $data['last_name'] = $_SESSION['last_name'];
    $data['mail'] = $_SESSION['mail'];
    $data['profile_pic_url'] = $_SESSION['fb_img_url'];
    
    $template = $twig->loadTemplate('register.html');
    echo $template->render(array('data' => $data));
?>