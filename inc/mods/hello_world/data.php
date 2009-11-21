<?php
	/**
	*	Placeto CMS - Hello_world Mod
	*		Provides a "Hello World" output and also demonstrates Placeto's mod protocal.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto Mod - Hello_world (C) BlaherTech - Benjamin Jay Young 2009
    *	Placeto Mods are released under the GNU GPL 3.0 which is free and open source.
	*	You may edit or distrubute any Placeto Mod at your own free will, with the proper accreditation.
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
		'release'=>'2009-04-28' // Release date
	);
?>