<?php
	/**
	*	Placeto CMS - Hello_world Mod
	*		Provides a "Hello World" output and also demonstrates Placeto's mod protocal.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Copyright (C) 2009-2010 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*	
	*	//////////////////////////////////////////////////
	*
	*	data.php in mods contain author and release information.
	*	This also helps the system to check version numbers and if a update for a mod is available.
	**/
	
	//Everything should be stored in a named array and follow the following protocal:
	$mods['hello_world']=array //name of directory
	(
		'name'=>'Hello World Test', // Full name of the mod
		'author'=>'Benjamin Jay Young', // Author
		'version'=>'1.0', // Version number
		'description'=>'This module is used to show how Placeto\'s mods should be set up.', // Description of mod
		'release'=>'2010-02-05' // Release date
	);
?>