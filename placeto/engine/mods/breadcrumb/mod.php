<?php
	/**
	*	Placeto CMS - Breadcrumb
	*		Provides a breadcrumb navigation with proper directory structure.
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
	
	function placeto_breadcrumb()
	{
		global $config, $prefix;

		//$location is your URI fetched from .htaccess
		if (isset($_GET['url']))
		{
			$location='/'.$_GET['url'];
		}
		else
		{
			$location=$_SERVER['PHP_SELF'];
		}

		while (stristr($location, '../'))
		{
			$location=str_replace('../', '', $location);
		}

		//checks to make sure that $location didn't go wacky
		$location=str_replace('index.php', '', $location);
		if (($config['directory']!=='/' || $config['directory']==NULL) && $config['directory']===substr($location, 0, strlen($config['directory'])))
		{
			$location=substr($location, strlen($config['directory']), strlen($location));
		}
		if (substr($location, strlen($location)-1)==='/' && strlen($location)!==1)
		{
			$location=substr($location, 0, strlen($location)-1);
		}
		
		//fetches directory structure
		$crumbs=explode('/', $location);
		
		//loop time
		$crmlc[0]='/';
		for ($i=0; $i<count($crumbs); $i++)
		{
			//fixes the structure with each location
			for ($n=$i; $n>0; $n--)
			{
				@$crmlc[$i]='/'.$crumbs[$n].$crmlc[$i];
			}

			//for places outside of home, keeps breadcrumb from displaying on home
			if ($location!=='/')
			{
				if ($bread=@mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'mod_breadcrumb WHERE page="'.$crmlc[$i].'"'))) //if the user set a title in the breadcrumb mod
				{
					if ($i!==count($crumbs)-1) //for other pages
					{
						//proper rel and rev structure
						echo '<a href=".',$bread['page'];
						if ((count($crumbs)-$i)>2)
						{
							echo '" rel="index" rev="subsection">';
						}
						else
						{
							echo '" rel="index" rev="section">';
						}
						echo $bread['title'],"</a> &gt;\n";
					}
					else //current page
					{
						echo $bread['title'],"\n";
					}
				}
				else if ($bread=@mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'content WHERE page="'.$crmlc[$i].'"'))) //else, pull the title from content
				{
					
					//same thing from above happens here
					if ($i!==count($crumbs)-1)
					{
						echo '<a href=".',$bread['page'];
						if ((count($crumbs)-$i)>2)
						{
							echo '" rel="index" rev="subsection">';
						}
						else
						{
							echo '" rel="index" rev="section">';
						}
						echo $bread['header'],"</a> &gt;\n";
					}
					else
					{
						echo $bread['header'],"\n";
					}
				}
			}
		}
		
		unset($crumbs, $n, $i, $crmlc, $bread, $location); //bye
	}
?>