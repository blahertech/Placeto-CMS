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
	*	Include a uninstall.php file if added anything to the DB.
	*	This file will be ran when the used clicks uninstall, which will deleted all the files afterwards
	**/
	
	//make sure you include instructions in this function, to protect from outside installing
	function placeto_mod_uninstall()
	{
		//Make to remove all of your generated tables and mod_vars
	}
?>