<?php
   /**
	*	Placeto CMS.
	*		A lightweight, easy to use PHP content management system. Written
	*		to be as fast as possible and to use as little memory as possible.
	*		Placeto provides browser caching, server caching, deflating, and
	*		gzip compression, if necessary to cut down on bandwidth and cpu
	*		usage.
	*
	*	Engine.
	*		The engine is what handles the requested content and generates
	*		everything on demand, manipulating what needs to be where and what
	*		is provided, based on what is in the database, template, and
	*		modules.
	*
	*	@package placeto
	*	@subpackage engine
	*	@version 1.0.5
	*
	*	@author Benjamin Jay Young <blaher@blahertech.org>
	*	@link http://www.blahertech.org/projects/placeto/ Placeto CMS
	*	@link http://www.blahertech.org/ BlaherTech.org
	*	@license http://www.gnu.org/licenses/gpl.html GPL v3
	*	@copyright BlaherTech 2009-2010
	*
	*	This program is free software: you can redistribute it and/or modify it
	*	under the terms of the GNU General Public License as published by the
	*	Free Software Foundation, either version 3 of the License, or (at your
	*	option) any later version. This program is distributed in the hope that
	*	it will be useful,  but WITHOUT ANY WARRANTY; without even the implied
	*	warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See
	*	the GNU General Public License for more details. You should have
	*	received a copy of the GNU General Public License along with this
	*	program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*/

	//TODO: put in class

	//see if the mods are enabled
	$query=$placeto->database->connection->prepare('SELECT * FROM '.$placeto->database->prefix().'mods ORDER BY name');
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_ASSOC);
	$query->closeCursor();
	unset($query);

	foreach ($results as $mod)
	{
		$mods[$mod['name']]=$mod['enable'];
	}

	$dirList=scandir($placeto->config->base().'placeto/modules');

	//attach all the enabled mods
	foreach ($dirList as $dir)
	{
		//for non-content mods
		$mpre=0;
		if (substr($mfile, 0, 1)==='_')
		{
			$mpre=1;
			$mfile=substr($mfile, 1);
		}

		//include enabled mods
		if (!strrpos($mfile, '.') && $mfile!=='.' && $mod_starts[$mfile]['enable'])
		{
			if ($mpre===1)
			{
				$mfile='_'.$mfile;
			}
			@include($base.'placeto/mods/'.$mfile.'/mod.php');
		}
		else if (!strrpos($mfile, '.') && $mfile!=='.') //include the prototype, incase someone forgot to rid the functions
		{
			if ($mpre===1)
			{
				$mfile='_'.$mfile;
			}
			@include($base.'placeto/mods/'.$mfile.'/prototype.php');
		}
	}

	//pull mod vars
	$result=mysql_query('SELECT * FROM '.$prefix.'mods_vars');
	while ($mod_temps=mysql_fetch_assoc($result))
	{
		$mod_vars[$mod_temps['mod']][$mod_temps['name']]=$mod_temps['value'];
	}

	unset($mfiles, $mfile, $mod_starts, $mod_temps, $mpre);
	
	function placeto_mod_end()
	{
		global $prefix, $base;
		
		//see if the mods are enabled
		$result=mysql_query('SELECT * FROM '.$prefix.'mods');
		while ($mod_temps=mysql_fetch_assoc($result))
		{
			$mod_ary[$mod_temps['name']]=$mod_temps['enable'];
		}
	
		$mfiles=scandir($base.'placeto/mods');

		//attach all the enabled mods
		foreach ($mfiles as $mfile)
		{
			//for non-content mods
			$mpre=0;
			if (substr($mfile, 0, 1)==='_')
			{
				$mpre=1;
				$mfile=substr($mfile, 1);
			}

			//include enabled mods
			if (!strrpos($mfile, '.') && $mfile!=='.' && $mod_ary[$mfile])
			{
				if ($mpre===1)
				{
					$mfile='_'.$mfile;
				}

				if (file_exists($base.'placeto/mods/'.$mfile.'/end.php'))
				{
					include($base.'placeto/mods/'.$mfile.'/end.php');
				}
			}
		}
	}
?>
