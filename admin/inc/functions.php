<?php
	/**
	*	Placeto CMS - Admin
	*		The Placeto CMS Administration application.
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
	*	functions.php is a list of functions used for the admin.
	**/

	//retuns a list of most used keywords
	function placeto_keywords_suggest($contents)
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
	
	function placeto_key_encrypt($string, $key)
	{
		$result = '';
		for($i=0; $i<strlen($string); $i++)
		{
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}
		
		return base64_encode($result);
	}
		
	function placeto_key_decrypt($string, $key)
	{
		$result = '';
		$string = base64_decode($string);
		
		for($i=0; $i<strlen($string); $i++)
		{
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)-ord($keychar));
			$result.=$char;
		}
		
		return $result;
	} 
	
	//mike's safe function
	function placeto_safe($variable)
	{
		$variable = str_replace('\r', '', $variable);
		$variable = str_replace('\n', '', $variable);
		$variable = str_replace('\t', '', $variable);
		  
		if (get_magic_quotes_gpc())
		{ 
			$variable = stripslashes($variable); 
		}
		
		$variable = htmlentities($variable, ENT_QUOTES);
		  
		$variable = strip_tags($variable);
		$variable = mysql_real_escape_string(trim($variable));
		 
		return $variable;
	}
	function placeto_safe_html($variable)
	{
		if (get_magic_quotes_gpc())
		{ 
			$variable = stripslashes($variable); 
		}
		$variable = mysql_real_escape_string(trim($variable));
		 
		return $variable;
	}
	
	function placeto_config_unset()
	{
		global $sql_login;
		unset $sql_login['user'], $sql_login['pass'];
	}
?>