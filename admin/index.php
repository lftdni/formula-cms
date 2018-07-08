<?php

date_default_timezone_set('Europe/Zagreb');
$current_datetime = date('Y-m-d H:i:s');

// ini_set('display_errors',1);
// ini_set('display_startup_errors',1);
// error_reporting(-1);

// Include
include('tpl/config/db.php');
include('tpl/config/config.php');

// Session start
session_start();

// Include Classes
include('tpl/classes/user.class.php');

// Load Class
$user = new User($db);
$is_logged_in = $user->login_isValid();


// All pages
$pages = array(
	'login'					=> 1,
	'logout'				=> 1,
	'home'					=> 1,
	'drivers'				=> 1,
	'drivers-add'			=> 1,
	'users'	 				=> 1,
	'users-add'	 			=> 1,
	'info-add'				=> 1,
	'info'					=> 1,
	'banners-add'			=> 1,
	'banners'				=> 1,
	'banner'				=> 1,
	'vehicles'				=> 1,
	'vehicles-add'			=> 1,
	'users'					=> 1,
	'users-add'				=> 1,
	'motorcycles'			=> 1,
	'driver'				=> 1,
	'vehicle'				=> 1
	
);

// URL rewrite
$request_arr = @explode('/', trim($_GET['r'], '/'), 5); # 0 > page, 1,2,3.. > options
$request_page = @$request_arr[0]; # request page

// Check if page exists
if (!$is_logged_in AND $request_page !== 'login') {
	header('Location: /admin/login'); exit;
}
elseif (!empty($pages[$request_page])) {
	$include_page = $request_page;
}
else {
	header('Location: /admin/404'); exit;
}

// Check if page exists on server
$include_page = 'tpl/'.$include_page.'.php';

if (file_exists($include_page)) {
	include($include_page);	
}
else {
	die(' Stranica je nepostojeća. ');
	
}


?>