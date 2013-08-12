<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress_Themes
 * @subpackage Gridlock
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php echo bloginfo('name') . (is_home() ? "" : ' - ' . wp_title('', false)); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/style.css" />
<link href='//fonts.googleapis.com/css?family=Lora|Roboto+Condensed' rel='stylesheet' type='text/css'>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/jquery-2.0.3.min.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/script.js" type="text/javascript"></script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="main" class="container">


	<div id="masthead">
	
		<div id="title">
			
					<img src="https://fbcdn-sphotos-h-a.akamaihd.net/hphotos-ak-frc3/v/999591_10151641256479563_1817972351_n.jpg?oh=1f8d5f4345914e9efeff3212fb1870e5&oe=5209F7B6&__gda__=1376382729_77f2b80ee576163f4a603ca4309b7869">
			
		</div>
		<div id="issue">
					<p><span class="issuenumber"> ISSUE 3 </span></p><br>
					<p><span class="date"> AUG 31, 2013</span></p> 
		</div>	
	</div>
		
	<div id="nav">
		<div id="logo">
			<img src="http://jourdandraws.files.wordpress.com/2013/03/gazelle_logo-web.png?w=500">
		</div>	
			<ul>
				
			<li id="opinions">
				opinions
			</li>
			<li id="news">
				news
			</li>
			<li id="featured">
				features
			</li>
			<div id="largesearch">
				<input type="text">
			</div>
			</li>
		
	</div>
			
  <div id="body" class="container">
