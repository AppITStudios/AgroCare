<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	
	require_once $root . 'Twig/Autoloader.php';
	Twig_Autoloader::register();

	$loader = null;
	
	try{
		$loader = new Twig_Loader_Filesystem('../templates');
	} catch(Exception $ex){
		$loader = new Twig_Loader_Filesystem('templates');
	}
	
	$twig = new Twig_Environment($loader);
?>