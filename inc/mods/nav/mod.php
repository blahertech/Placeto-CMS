<?php
	/**
	*	Placeto CMS - Nav
	*		Provides a navigation list.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto Mod - Nav (C) BlaherTech - Benjamin Jay Young 2009
    *	Placeto Mods are released under the GNU GPL 3.0 and is free and open source.
	*	You may edit or distrubute any Placeto Mod at your own free will, with the proper accreditation.
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