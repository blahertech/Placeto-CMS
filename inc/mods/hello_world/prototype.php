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
	*	Your prototype.php should be used to define null versions of any function you declare in index.php.
	*	This is to avoid error messages from happening when the user disables your mod, but does not rid of your mod's api function within their template.
	*	Also leave a comment for each function to help developers distinguish what it does.
	**/

	//for each function, you should have it return a string of what it does

	function placeto_hello_world(){return 'Print "Hello World!"';} // Echos "Hello World" and other variations
?>