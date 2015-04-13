<?php
	session_start();
    
    require_once $_SESSION['ABS_PATH'] . '/util.php';
    require_once $_SESSION['ABS_PATH'] . '/config/social_config.php';
    
	require_once('Facebook/FacebookSession.php');
	require_once('Facebook/FacebookRedirectLoginHelper.php');
	require_once('Facebook/FacebookRequest.php');
	require_once('Facebook/FacebookResponse.php');
	require_once('Facebook/FacebookSDKException.php');
	require_once('Facebook/FacebookRequestException.php');
	require_once('Facebook/FacebookPermissionException.php');
	require_once('Facebook/FacebookAuthorizationException.php');
	require_once('Facebook/GraphObject.php');
	require_once('Facebook/GraphUser.php');
	require_once('Facebook/GraphSessionInfo.php');

	require_once('Facebook/HttpClients/FacebookHttpable.php');
	require_once('Facebook/HttpClients/FacebookCurl.php');
	require_once('Facebook/HttpClients/FacebookCurlHttpClient.php');
	require_once('Facebook/Entities/AccessToken.php');
	require_once('Facebook/Entities/SignedRequest.php');


	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookResponse;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	use Facebook\GraphUser;
	use Facebook\GraphSessionInfo;
	
    FacebookSession::setDefaultApplication($FB_APP_ID, $FB_APP_SECRET);
	$helper_fb = new FacebookRedirectLoginHelper($FB_REDIRECT_URL);
	$session_fb = $helper_fb->getSessionFromRedirect();
	
	function getFBSession(){
		global $session_fb;
		return $session_fb;
	}
	
	function getFBLink(){
		global $helper_fb;
		global $FB_PERMISSIONS;
		return $helper_fb->getLoginUrl(array('scope' => $FB_PERMISSIONS));
	}
	
	function getFBUserProfile($session){
		$request = new FacebookRequest($session, 'GET', '/me');
		$response = $request->execute();
		$graph = $response->getGraphObject(GraphUser::className());
		return $graph;
	}
	
	function getFBMail($session){
		$user_profile = getFBUserProfile($session);
		return $user_profile->getProperty('email');
	}
	
	function makeSessionByToken($token){
		$session = new FacebookSession($_SESSION['token']);
		try{
			$session->validate($FB_APP_ID, $FB_APP_SECRET);
			return $session;
		}catch(FacebookAuthorizationException $e){
			echo $e->getMessage();
			return null;
		}
	}
	
	function postFBLink($session, $page, $message){
		$response = (new FacebookRequest($session, 'POST', '/me/feed', array(
			'link' => $page,
			'message' => $message
		)))->execute()->getGraphObject();
	}
	
	function getFBUserImgLink($session){
		$response = (new FacebookRequest($session, 'GET', '/me/picture?height=50&width=50&redirect=false'))->execute();
		$url = $response->getGraphObject()->asArray()['url'];
		return $url;
	}
	
	function getFBUserImgByte($session){
		return imgFromUrl(getFBUserImgLink($session));
	}
?>