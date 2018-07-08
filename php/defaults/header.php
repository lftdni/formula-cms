<?php

$navgations = array(
	'' 				=> 'Početna', 
	'o-nama' 		=> 'O nama',
	'vozila' 		=> 'Vozila',
	'instruktori' 	=> 'Instruktori',
	'cijene'		=> 'Cijene',
	'kontakt'		=> 'Kontakt'
);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Autoškola Formula</title>
    <!-- CSS Global -->
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/assets/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/plugins/prettyphoto/css/prettyPhoto.css" rel="stylesheet">
    <link href="/assets/plugins/owl-carousel2/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/assets/plugins/owl-carousel2/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="/assets/plugins/animate/animate.min.css" rel="stylesheet">
    <link href="/assets/plugins/swiper/css/swiper.min.css" rel="stylesheet">
	<link href="/assets/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic,900,900italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Theme CSS -->
    <link href="/assets/css/theme.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="assets/plugins/iesupport/html5shiv.js"></script>
    <script src="assets/plugins/iesupport/respond.min.js"></script>
    <![endif]-->
	
</head>
<body id="home" class="wide">
<!-- PRELOADER -->
<div id="preloader">
    <div id="preloader-status">
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
        <div id="preloader-title">Učitavanje</div>
    </div>
</div>
<!-- /PRELOADER -->

<!-- WRAPPER -->
<div class="wrapper">

<div style="height: 82px;" class="sticky-wrapper" id="undefined-sticky-wrapper">
	<header style="" class="header fixed">
        <div class="header-wrapper">
            <div class="container">
                <!-- Logo -->
                <div class="logo">
                    <a href="/"> <img src="/assets/img/Formula.jpg" alt="Autoškola Formula Logo"></a>
                </div>
                <!-- /Logo -->

                <!-- Mobile menu toggle button -->
                <a href="#" class="menu-toggle btn ripple-effect btn-theme-transparent"><i class="fa fa-bars"></i></a>
                <!-- /Mobile menu toggle button -->

                <!-- Navigation -->
                <nav class="navigation closed clearfix swiper-container-vertical swiper-container-free-mode">
                    <div style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);" class="swiper-wrapper">
                        <div class="swiper-slide swiper-slide-active">
                            <!-- navigation menu -->
                            <a href="#" class="menu-toggle-close btn"><i class="fa fa-times"></i></a>
                            <ul class="nav sf-menu sf-js-enabled sf-arrows">
							<?php foreach($navgations as $link => $name) : ?>
								<li<?php echo($link == $request_arr[0] ? ' class="active"' : '');?> > <a href="/<?php echo $link;?>"><?php echo $name;?></a></li>
							<?php endforeach; ?>
                            </ul>
                            <!-- /navigation menu -->
                        </div>
                    </div>
                    <!-- Add Scroll Bar -->
                    <div style="opacity: 0; transition-duration: 400ms; display: none;" class="swiper-scrollbar"><div style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px); height: 0px;" class="swiper-scrollbar-drag"></div></div>
                </nav>
                <!-- /Navigation -->
            </div>
        </div>
    </header>
</div>