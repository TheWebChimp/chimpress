<!DOCTYPE HTML>
	<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]-->
	<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]-->
	<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]-->
	<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]-->
	<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->
	<head>
		<title><?php bloginfo( 'name' ); ?><?php wp_title( '|' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1">

		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php echo home_url( '/rss' ); ?>">

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico">
		<link rel="shortcut icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.png">

		<script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>