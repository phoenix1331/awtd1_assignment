<?php
/*
* Main header.php
*/
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Scottish Distilleries</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">


        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
		<!--Google Maps-->
		<script type="text/javascript"
			src="https://maps.googleapis.com/maps/api/js?sensor=false">
		</script>
		<!--Google Chart-->
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<!--Instagram Feed-->
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' type='text/javascript' charset='utf-8'></script>
		<script src='js/instajava.js' type='text/javascript' charset='utf-8'></script>
        <link rel="stylesheet" type="text/css" href="css/instajava.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		<div id="topWrap">
		<?php
		if(loggedIn()){ ?>
			<p>Welcome back <?php echo $_SESSION['username']; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="index.php?page=log-out" title="Logout">Logout</a></p>
		<?php }else{ ?>
			<p><a href="index.php?page=log-in" title="Login">Login</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="index.php?page=sign-up" title="Sign-Up">Sign-Up</a></p>
		<?php } ?>
			
		</div>
        <div id="mainWrap">
		<header><img src="img/banner.jpg" alt="Distillery Banner" /></header>