<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<!--
	-	Placeto CMS - Default Template
	-		The default template for Placeto CMS
	-
	-	Author: Benjamin Jay Young
	-		http://www.blahertech.org/projects/placeto
	-
	-	Copyright (C) 2009-2011 BlaherTech
	-
	-	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	-	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	-	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	-->
	<head>
		<!-- URL structure -->
		<!--<base href="<?php //placeto('base'); ?>" />-->
		<!-- Title -->
		<title><?php $p->title(); ?></title>

		<!-- Metadata -->
		<!--<meta http-equiv="content-type" name="type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" name="language" content="en" />-->
		<meta name="description" content="<?php $p->description(); ?>" />
		<meta name="keywords" content="<?php $p->keywords(); ?>" />
		<meta name="revised" content="<?php $p->revised(); ?>" />
		<meta name="robots" content="all" />
		<meta name="generator" content="Placeto CMS" />

		<!-- Design Links -->
		<link rel="shortcut icon" href="<?php $p->directory(); ?>/favicon.ico" type="image/x-icon" />
		<link rel="icon" href="<?php $p->directory(); ?>/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="<?php $p->directory(); ?>/include/styles.css" />
		<link rel="stylesheet" type="text/css" media="print" href="<?php $p->directory(); ?>/include/print.css" />
		<!--<link rel="canonical" href="<?php //placeto('canonical'); ?>" />-->
	</head>
	<body>
	
		<!-- No Script -->
		<noscript>
			<div>You do not have scripts enabled, please enable them to access the features of this site.</div>
		</noscript>

		<div id="stretcher">
			<div id="wrapper">

				<div id="top">
					<div id="logo">
						<a href="<?php $p->directory(); ?>/" rel="home" rev="home"><?php $p->site_name(); ?></a>
					</div>

					<!-- Nav -->
					<ul id="nav">
						<?php //$p->mods->navigation(); //(DEFAULT 1,2) ?>
					</ul>
					<!-- close #nav -->
					<br class="clear" />
				</div>

				<!-- Bread Crumbs -->
				<div id="bread"><?php //$p->mods->breadcrumb(); ?></div>
				<!-- End Bread Crumbs -->

				<!-- Header -->
				<h1><?php $p->header(); ?></h1>
				<!-- End Header -->

				<!-- Content -->
				<?php $p->content(); ?>
				<!-- End Content -->

				 <div id="ballon"></div>
			</div> <!-- close #wrapper -->
		</div> <!-- close #stretcher -->
		
		<!-- Floating footer -->
		
		<!-- Toolbar -->
		<div id="footer">
			<div id="wrap">
				<div class="edge"></div>
				<div id="panel">
					
					<!-- Copyright -->
					<div id="copy">
						<?php $p->copyright(); ?>, All rights reserved.<br />
                        Powered by <a href="http://www.blahertech.org/projects/placeto/">Placeto CMS</a>
					</div>
					<!-- End Copyright -->
				</div> <!-- close #panel -->
				
				<div class="edge"></div>
			</div> <!-- close #wrap -->

		</div> <!-- close #footer -->

	</body>
</html>
