<?php
	/**
	*	Placeto CMS - Cache
	*		Creates cache files for your non-dynamic content. Saves huge amounts of processing time.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Copyright (C) 2009-2010 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	**/

	global $mdplace, $gztrue, $content;

	//makes a cache file	
	if (!isset($content) || $content['dynamic']!=1)
	{
		//retrieve list of enable mods
		$result=mysql_query('SELECT * FROM '.$prefix.'mods');
		while ($mod_temps=mysql_fetch_assoc($result))
		{
			$mod_starts[$mod_temps['name']]=$mod_temps['enable'];
		}
		
		//check if _gzip is enabled
		if ($gztrue)
		{
			//let's do this my way, instead
			$fp=gzopen($mdplace.'.gz', 'w9');
			gzwrite($fp, ob_get_contents());
			gzclose($fp);
		}
		
		// Now the script has run, generate a new cache file
		$fp=fopen($mdplace, 'w');

		// save the contents of output buffer to the file
		fwrite($fp, ob_get_contents());
		fclose($fp);
	}
	unset($mdplace, $fp, $mod_starts, $mod_temps);
?>