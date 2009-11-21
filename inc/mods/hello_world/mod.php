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
	*	Obviously your mod.php is the main file indexed in a mod, all functions and mod api data should be defined here.
	*	Remember to name your api functions with a naming scheme of placeto_(your_mod)_(some_function), to keep things organized.
	**/
	
	include($base.'inc/mods/hello_world/config.php'); // for those who need configs
	
	//an api function we define for the user to use
	function placeto_hello_world()
	{
		//globalize config vars or placeto api vars
		global $somesetting;
		
		//some code
		if ($somesetting===true)
		{
			echo "Hello World!\n";
		}
		else
		{
			echo 'Hello Other World!';
		}
		
		//always unset data not needed in a function anymore, unless it's global
		unset($somesetting);
	}
	
	//do some stuff at run time of the mod, this can be handy when we need to run a object or other technicies.
	for ($i=0; $i<=3; $i++)
	{
		$n=$i;
	}
	
	//don't forget to always unset data that is not needed anymore.
	unset($i, $n);
?>