<?php
	/**
	*	Placeto CMS - Cache
	*		Creates cache files for your non-dynamic content. Saves huge amounts of processing time.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto Mod - Cache (C) BlaherTech - Benjamin Jay Young 2009
    *	Placeto Mods are released under the GNU GPL 3.0 which is free and open source.
	*	You may edit or distrubute any Placeto Mod at your own free will, with the proper accreditation.
	**/

	global $mdplace, $gztrue, $content;

	//makes a cache file	
	if (!isset($content) || $content['igcache']!=1)
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