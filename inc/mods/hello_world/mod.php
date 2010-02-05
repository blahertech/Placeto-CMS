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