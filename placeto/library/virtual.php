<?php
	/**
	*	Placeto CMS
	*		A lightweight, easy to use PHP content management system. Written to be as fast as possible and to use as little memory as possible. Placeto provides browser caching, server caching, deflating and gzip compression if necessary to cut down on bandwidth and cpu time.
	*
	*	Copyright (C) 2009-2010 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto/
	*
	*	//////////////////////////////////////////////////
	*
	*	All functions that pull virtual data.
	**/

	//pull $prefs
	function placeto_prefs(&$dbtype)
	{
		global $prefs;
		echo $prefs[$dbtype];
		return true;
	}

	//pull $configs
	function placeto_configs(&$dbtype)
	{
		global $config;
		echo $config[$dbtype];
		return true;
	}

	//pulls you mainly used content needed for the templates
	function placeto(&$dbtype)
	{
		//globalizing stabalizer variable allocations
		global $content, $prefs, $config, $location;

		///////////////////////////////////////////////////////////////////////////
		//	TODO: Pull global vars here, if they don't exist.
		///////////////////////////////////////////////////////////////////////////

		if ($dbtype==='content')
		{
			eval('?>'.$content['content']."\n");
		}
		else if ($dbtype==='site')
		{
			echo $prefs['name'];
		}
		else if ($dbtype==='base')
		{
			echo $config['site'];
			echo $config['directory'];
			if ($config['directory']!=='/')
			{
				echo '/';
			}
		}
		else if ($dbtype==='directory')
		{
			echo $config['directory'];
			if ($config['directory']!=='/')
			{
				echo '/';
			}
		}
		else if ($dbtype==='canonical')
		{
			echo $config['site'];
			if ($config['directory']!=='/')
			{
				echo $config['directory'];
			}
			echo $location;
		}
		else if ($dbtype==='copyright')
		{
			echo $prefs['copyright'];
		}
		else
		{
			echo $content[$dbtype];
		}
		return true;
	}

	function placeto_config_unset()
	{
		global $sql_login;
		unset($sql_login['user'], $sql_login['pass']);
	}
?>
