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
	*	All make safe functions of the library.
	**/

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
	function placeto_safe_sql($variable)
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
		 
		return $variable;
	}
?>
