<?php
	/**
	*	Placeto CMS - Nav
	*		Provides a navigation list.
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

	function placeto_nav()
	{
		global $content, $prefix;

		//fetch data from the db
		$navrows=mysql_num_rows(mysql_query('SELECT * FROM '.$prefix.'mod_nav'));
		for ($i=0; $i<$navrows; $i++)
		{
			$nav[$i]=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'mod_nav WHERE id='.$i));
		}
		
		//reorganize a new array for location finder
		$navlist=$nav;
		for ($i=0; $i<$navrows; $i++)
		{
			$navorder[$navlist[$i]['id']]=$navlist[$i]['link'];
		}
		unset($navlist);
		
		function ascii_sort($val_1, $val_2)
		{
			//initialize the return value to zero
			$retVal=0;
			
			//compare lengths
			$firstVal=strlen($val_1);
			$secondVal=strlen($val_2);
			
			if ($firstVal>$secondVal)
			{
				$retVal=1;
			}
			else if ($firstVal<$secondVal)
			{
				$retVal=-1;
			}
			
			unset($val_1, $val_2, $firstVal, $secondVal);
			return $retVal;
		}
		uasort($navorder, 'ascii_sort');
		rsort($navorder);

		//find where the page belongs
		$navactive="";
		if ($content['page']==='/')
		{
			//we're at home, so no need to go out
			$navactive='/';
		}
		else
		{
			foreach ($navorder as $val)
			{
				if ($val!=='/' && $val===substr($content['page'], 0, strlen($val)))
				{
					//we have a winner
					$navactive=$val;
					break;
				}
			}
			unset($val);
		}
		unset($navorder, $navlist);
		
		//echo out the list
		for ($i=0; $i<$navrows; $i++)
		{
			if ($nav[$i]['link']===$navactive)
			{
				echo '<li class="active"><a href=".',$nav[$i]['link'],'" rel="index">',$nav[$i]['title'],"</a></li>\n";
			}
			else
			{
				echo '<li><a href=".',$nav[$i]['link'],'" rel="bookmark">',$nav[$i]['title'],"</a></li>\n";
			}
		}
		
		//bye
		unset($nav, $navactive, $i, $navrows);
	}
?>