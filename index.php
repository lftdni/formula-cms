<?php

// Settings
date_default_timezone_set('Europe/Zagreb');
$current_datetime = date('Y-m-d H:i:s');

// // ini_set('display_errors',1);
// // ini_set('display_startup_errors',1);
// // error_reporting(-1);

// Include
include('php/config/db.php');
include('php/config/config.php');

// //session start
// session_start();

// //include classes
// include('php/class/user.class.php');

// //load class
// $user = new user($db);
// $is_logged_in = $user->login_isvalid();


// All pages
$pages = array(
	'pocetna'			=> 1,
	'o-nama'			=> 1,
	'vozila'			=> 1,
	'instruktori'		=> 1,
	'instruktor'		=> 1,
	'cijene'			=> 1,
	'kontakt'			=> 1,
	'kako-do-vozacke'	=> 1
	
);

// URL rewrite
$request_arr 	= @explode('/', trim($_GET['r'], '/'), 5); 		# 0 > page, 1,2,3.. > options
$request_page 	= @$request_arr[0]; 							# request page

// Check if page exists
if (!empty($pages[$request_page])) {
	$include_page = $request_page;
} else {
	if ($request_page) {
		// 404
		$include_page = '404';
	} else {
		// Default page
		$include_page = 'pocetna';
	}
}


// Check if page exists on server
$include_page = 'php/'.$include_page.'.php';
if (file_exists($include_page)) {
	include($include_page);
} else {
	die('File does not exist!');
}


?>