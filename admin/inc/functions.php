<?php
	/**
	*	Placeto CMS - Admin
	*
	*	Authors: Benjamin Jay Young, Michael Weidenhamer and Taylor Wyant
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto CMS - Admin (C) BlaherTech - Benjamin Jay Young 2009
	*	Placeto CMS Admin is released under the GNU GPL 3.0 and is free and open source.
	*	You may edit or distrubute Placeto CMS Admin at your own free will, with the proper accreditation.
	*
	*	////////////////////////////////////////
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