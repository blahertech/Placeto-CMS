<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<!--
	-	Placeto CMS - Simple Template
	-		A template designed to show the basic functions of Placeto's template framework
	-
	-	Author: Benjamin Jay Young
	-		http://www.blahertech.org/projects/placeto
	-
    -	Copyright (C) 2009-2010 BlaherTech
    -
	-	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	-	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	-	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
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
