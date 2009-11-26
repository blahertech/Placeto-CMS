<?php
	/**
	*	Placeto CMS - Admin
	*		The Placeto CMS Administration application.
	*
	*	Copyright (C) 2009 BlaherTech
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
	*	functions.php is a list of functions used for the admin.
	**/

	//retuns a list of most used keywords
	function placeto_suggest_keywords($contents)
	{
		//ignore list
		include('ignore_keywords.php');

		//get rid of the fluff
		$contents=strip_tags($contents);
		$contents=strtolower($contents);
		$contents=preg_replace('/[(\.,"><;\'\:)]/', '', $contents);
		$contents=trim($contents);
		$array=explode(' ', $contents);
		
		//counting time
		foreach ($array as $value)
		{
			if (!isset($$ignore_list[$value]))
			{
				$array2[$value]=substr_count($contents, $value);
			}
		}
		arsort($array2);
		
		unset($contents, $array, $value);
		return $array2;
	}
?>