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
	**/

	require_once($base.'placeto/library/class.placeto.config.php');
	require_once($base.'placeto/library/class.placeto.database.php');
	require_once($base.'placeto/library/class.placeto.preferences.php');
	require_once($base.'placeto/library/class.placeto.content.php');

	class placeto
	{
		private $location, $path;

		function __construct($db=false, $cfg=false, $location=false)
		{
			if (!$location) //optional param
			{
				global $_GET;

				if (isset($_GET['url']))
				{
					$this->location='/'.$_GET['url'];
				}
				else
				{
					global $_SERVER;
					$this->location=$_SERVER['PHP_SELF'];
				}
			}
			else
			{
				$this->location=$location;
			}

			//for those who are trying to view your config or any other file, damn them
			while (stristr($this->location, '../'))
			{
				$this->location=str_replace('../', '', $this->location);
			}

			//used for later
			$this->path=$this->location;

			$this->config=new placeto_config($this->cfg);
			$this->database=new placeto_database($this->db);
			unset($this->cfg, $this->db);

			//checks to make sure that $location didn't go wacky
			$this->location=str_replace('index.php', '', $this->location);
			if (($this->config->directory()!=='/' || $this->config->directory()==NULL) && $this->config->directory()===substr($this->location, 0, strlen($this->config->directory())))
			{
				$this->location=substr($this->location, strlen($this->config->directory()), strlen($this->location));
			}
			if (substr($this->location, strlen($this->location)-1)==='/' && strlen($this->location)!==1)
			{
				$this->location=substr($this->location, 0, strlen($this->location)-1);
			}

			$this->preferences=new placeto_preferences($this->database);
			$this->content=new placeto_content($this->database, $this->location);
		}
		function location()
		{
			return $this->location;
		}
		function path()
		{
			return $this->path;
		}
		function content()
		{
			
		}
	}
?>
