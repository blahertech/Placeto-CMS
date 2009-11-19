<?php
	/**
	*	Placeto Setup
	*		This is the installation process portion of Placeto CMS.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	This source code is released under the GPL License.
	*	
	*	//////////////////////////////////////////////////
	*
	*	Security template. Checks to see if the pass and setup still exists.
	**/
	
	$filelct='./run.php';
	if (file_exists($filelct))
	{
		//if setup script still exists
		@include('./pass.php');
		//please don't die kenny
		include($filelct);
	}
	else
	{
		//other wise, danger will robinson proceed to safety
		header('Location: /');
		exit();
	}
	
	//let's have a fast car that gets 55mpg
	unset($filelct);
	exit(0);
?>