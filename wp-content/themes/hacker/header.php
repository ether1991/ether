<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hacker
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="renderer" content="webkit">
	<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<div id="primary" class="content-area">
		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
				<?php hacker_site_branding(); ?>
			</div>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php 
					wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) );
				?>
			</nav>
			<!-- END #site-navigation -->
		</header>
		<!-- END .site-header -->
		<div id="content" class="site-content">