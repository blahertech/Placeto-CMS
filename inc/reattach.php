<?php
	/**
	*	Placeto CMS
	*		A lightweight, easy to use PHP content management system. Written to be as fast as possible and to use as little memory as possible. Placeto provides browser caching, server caching, deflating and gzip compression if necessary to cut down on bandwidth and cpu time.
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
	*	reattach.php does all your dirty work. It's responsible for reattaching all your included template files and then some.
	*
	*	It's always a good idea to throw your css, js and template images in with the actual template. This way, Placeto automatically takes care of browser caching that will save you a ton of bandwidth and will save the user from downloading the file every single page visit.
	**/

	//where's waldo?
	$tmpfile='templates/'.$config['template'].$location;
	$mbase=str_ireplace('reattach.php', '', __FILE__);

	//is waldo missing?
	if (file_exists($mbase.$tmpfile) && $location!=='/')
	{
		//what's waldo's mime type?
		$extension=strrchr($path, '.');
		//check php compatibilty
		if (placeto_extension($extension))
		{
			//prefered way
			header('Content-Type: '.placeto_extension($extension));
		}
		else if (function_exists('finfo_file'))
		{
			//new way
			$finfo=finfo_open(FILEINFO_MIME);
			header('Content-Type: '.finfo_file($finfo, $mbase.$tmpfile));
			finfo_close($finfo);
			unset($finfo);
		}
		else
		{
			//old way, please update your phpd
			header('Content-Type: '.mime_content_type($mbase.$tmpfile));
		}

		unset($path, $extension);
		header('Content-Length:'.filesize($mbase.$tmpfile));

		//readfile is faster than include, trust me
		readfile($mbase.$tmpfile);

		//bye waldo
		placeto_mod_end();
		unset($mbase, $tmpfile);
		include('mysql/close.php');
		die();
	}
	else
	{
		//in the case the file was not found in the template directory, uh oh
		header('Content-Type: '.$config['type']);
		header('HTTP/1.0 404 Not Found');

		include('templates/'.$config['template'].'/index.php');
	}
?>