<?php
	session_start();
	
	$_SESSION['ABS_PATH'] = dirname(__FILE__);
	
	require_once $_SESSION['ABS_PATH'] . '/social/fb.php';
	require_once $_SESSION['ABS_PATH'] . '/db/db_func.php';
    require_once $_SESSION['ABS_PATH'] . '/config/env_vars.php';
	require_once $_SESSION['ABS_PATH'] . '/config/twig.php';
    
    
    $facebook_session = getFBSession();
	if ($facebook_session){
		$mail = getFBMail($facebook_session);
		
		if (check_user_exists($mail)){
			$_SESSION['status'] = 'logged';
			$_SESSION['token'] = $facebook_session->getToken();
            $_SESSION['mail'] = $mail;
            $_SESSION['profile_pic_path'] = '/' . $PROFILE_PICS_PATH . '/' . get_profile_pic_file($mail);
            $_SESSION['display_name'] = get_user_names($mail);
			session_regenerate_id();
            header('Location: /map/');
        } else{
            $_SESSION['status'] = 'signup_fb';
			$_SESSION['fb_img_url'] = getFBUserImgLink($facebook_session);
			$_SESSION['mail'] = $mail;
			$_SESSION['first_name'] = getFBUserProfile($facebook_session)->getFirstName();
			$_SESSION['last_name'] = getFBUserProfile($facebook_session)->getLastName();
			header('Location: /register/');
        }
    }
	
	$data = array();
	$data['fb_url'] = getFBLink();
	
	
	$template = $twig->loadTemplate('pagina_index.html');
	echo $template->render(array('data' => $data));
?>