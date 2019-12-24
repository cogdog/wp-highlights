<!doctype html>
<html <?php language_attributes(); ?>>
	<head>

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		

		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		
		<?php wp_head(); ?>

		<style>
		html {
			background: url('<?php echo get_stylesheet_directory_uri()?>/assets/css/images/overlay.png'), url("<?php header_image(); ?>");
			background-color: #313a3d;
			background-attachment: fixed,	fixed;
			background-position: top left,	center center;
			background-size: auto,	cover;
		}	
		
		<?php if ( is_admin_bar_showing() ) :?>
		#header { top: 30px;}
		#header .container {bottom: 30px;}
		<?php endif?>	
		</style>

		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->

	</head>
	<?php echo '<body class="'.join(' ', get_body_class()).'">'; ?>

		<!-- Header -->
			<section id="header">
				<header class="major">