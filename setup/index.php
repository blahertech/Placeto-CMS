<?php
	/**
	*	Placeto Setup
	*		This is the installation process portion of Placeto CMS.
	*
	*	Copyright (C) 2009 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
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