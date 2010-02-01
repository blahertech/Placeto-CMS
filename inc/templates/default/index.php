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
	-	Placeto Template - Default (C) BlaherTech - Benjamin Jay Young 2009
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
		<meta name="robots" content="all" />
		<meta name="generator" content="Placeto CMS" />

		<!-- Design Links -->
		<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
		<link rel="icon" href="./favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="./include/styles.css" />
        <link rel="stylesheet" type="text/css" media="print" href="./include/print.css" />
		<link rel="canonical" href="<?php placeto('canonical'); ?>" />
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
					<a href="./" rel="home" rev="home"><img src="./images/logo.png" alt="<?php placeto('site'); ?>" title="Click to go Home" /></a>
				</div>
				
				<!-- Nav -->
				<ul id="nav">
					<?php placeto_nav(); ?>
				</ul>
				<!-- close #nav -->
				<br class="clear" />
			</div>
			
			<!-- Bread Crumbs -->
			<div id="bread"><?php placeto_breadcrumb(); ?></div>
			<!-- End Bread Crumbs -->
			
			<!-- Header -->
			<h1><?php placeto('header'); ?></h1>
			<!-- End Header -->
			
			<!-- Content -->
			<?php placeto('content'); ?>
			<!-- End Content -->
			
			 <div id="ballon"></div>
		</div>
		<!-- close #wrapper -->
		</div>
		<!-- close #stretcher -->
		
		<!-- Floating footer -->
		
		<!-- Toolbar -->
		<div id="footer">
			<div id="wrap">
				<div class="edge"></div>
				<div id="panel">
					
					<!-- Copyright -->
					<div id="copy">
						<?php placeto('copyright'); ?>.
						All rights reserved.
					</div>
					<!-- End Copyright -->
				</div>
				<!-- close #panel -->
				
				<div class="edge"></div>
			</div>
			<!-- close #wrap -->

		</div>
		<!-- close #footer -->

	</body>
</html>