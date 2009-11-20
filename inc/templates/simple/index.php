<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<!--
	-	Placeto CMS - Simple Template
	-		A template designed to show the basic functions of Placeto's template framework
	-
	-	Author: Benjamin Jay Young
	-		http://www.blahertech.org/projects/placeto
	-
	-	Placeto Template - Simple (C) BlaherTech - Benjamin Jay Young 2009
	-	This Placeto Template is released under the GNU GPL 3.0 which is free and open source.
	-	You may edit or distrubute this template at your own free will, with the proper accreditation.
	-->
	<head>
		<!-- URL structure -->
		<base href="<?php placeto('base'); ?>" />
		<!-- Title -->
		<title><?php placeto('title'); ?></title>

		<!-- Metadata -->
		<meta http-equiv="content-type" name="type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" name="language" content="en" />
		<meta name="description" content="<?php placeto('desc'); ?>" />
		<meta name="keywords" content="<?php placeto('keywords'); ?>" />
		<meta name="revised" content="<?php placeto('lastmod'); ?>" />
		<meta name="generator" content="Placeto CMS" />

		<!-- Links -->
		<link rel="canonical" href="<?php placeto('canonical'); ?>" />
	</head>
	<body>
		<ul>
			<!-- Navigation -->
			<?php placeto_nav(); ?>
			<!-- End Navigation -->
		</ul>
		<br />
		<!-- Breadcrumbs -->
		<?php placeto_breadcrumb(); ?>
		<!-- End Breadcrumbs -->
		<br /><br />
		<!-- Header -->
		<h1><?php placeto('header'); ?></h1>
		<!-- Content -->
		<?php placeto('content'); ?>
		<!-- End Content -->
		<br /><br /><br />
		<!-- Copyright -->
		<?php placeto('copyright'); ?>,<br />
		All rights reserved.
	</body>
</html>
