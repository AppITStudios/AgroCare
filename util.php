<?php
	function imgFromUrl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		$image = curl_exec($ch);
		return $image;
	}
	
	function byteTo64Encode($img){
		return base64_encode($img);
	}
	
	function getYTUrl($string){
		$url = '';
		preg_match('"(http://|https://)?(www[.])?(youtube|vimeo)[^\s]+"is', $string, $url);
		return $url[0];
	}
	
	function hasYTUrl($string){
		$result = preg_match("#https?://(?:www\.)?youtube.com#", $string);
		
		if (empty($result)){
			return false;
		}
		return true;
	}
	
	function getMonthByNum($num){
		switch ($num){
			case 1:
				return 'ene';
				break;
			case 2:
				return 'feb';
				break;
			case 3:
				return 'mar';
				break;
			case 4:
				return 'abr';
				break;
			case 5:
				return 'may';
				break;
			case 6:
				return 'jun';
				break;
			case 7:
				return 'jul';
				break;
			case 8:
				return 'ago';
				break;
			case 9:
				return 'sep';
				break;
			case 10:
				return 'oct';
				break;
			case 11:
				return 'nov';
				break;
			case 12:
				return 'dec';
				break;
		}
	}
	
	function getYouTubeVideoDisplay($link, $width, $height){
		return '<iframe width="' . $width . '" height="' . $height . '" src="//' . $link . '" frameborder="0" allowfullscreen></iframe>';
	}
?>