<?php
   /**
	*	Placeto CMS.
	*		A lightweight, easy to use PHP content management system. Written
	*		to be as fast as possible and to use as little memory as possible.
	*		Placeto provides browser caching, server caching, deflating, and
	*		gzip compression, if necessary to cut down on bandwidth and cpu
	*		usage.
	*
	*	Engine.
	*		The engine is what handles the requested content and generates
	*		everything on demand, manipulating what needs to be where and what
	*		is provided, based on what is in the database, template, and
	*		modules.
	*
	*	@package placeto
	*	@subpackage engine
	*	@version 1.0.5
	*
	*	@author Benjamin Jay Young <blaher@blahertech.org>
	*	@link http://www.blahertech.org/projects/placeto/ Placeto CMS
	*	@link http://www.blahertech.org/ BlaherTech.org
	*	@license http://www.gnu.org/licenses/gpl.html GPL v3
	*	@copyright BlaherTech 2009-2010
	*
	*	This program is free software: you can redistribute it and/or modify it
	*	under the terms of the GNU General Public License as published by the
	*	Free Software Foundation, either version 3 of the License, or (at your
	*	option) any later version. This program is distributed in the hope that
	*	it will be useful,  but WITHOUT ANY WARRANTY; without even the implied
	*	warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See
	*	the GNU General Public License for more details. You should have
	*	received a copy of the GNU General Public License along with this
	*	program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*/

	//where's waldo?
	$tmpfile=
		$placeto->config->base().'placeto/templates/'
		.$placeto->preferences->template().$placeto->config->location();

	@include
	(
		$placeto->config->base().'placeto/templates/'
		.$placeto->preferences->template().'/data.php'
	);
	/*foreach ($templates[$prefs['template']]['files'] as &$tempd)
	{
		if ('/'.$tempd==$location)
		{
			$break=true;
		}
	}*/

	//is waldo missing?
	if (file_exists($tmpfile) && $placeto->config->location()!=='/' && !$break)
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
			header('Content-Type: '.finfo_file($finfo, $tmpfile));
			finfo_close($finfo);
			unset($finfo);
		}
		else
		{
			//old way, please update your phpd
			header('Content-Type: '.mime_content_type($tmpfile));
		}

		unset($path, $extension);
		header('Content-Length:'.filesize($tmpfile));

		//readfile is faster than include, trust me
		readfile($tmpfile);

		//bye waldo
		//placeto_mod_end();
		unset($tmpfile, $tempd, $break);
		//include('cleanup.php');
		die();
	}
	else
	{
		unset($tempd, $break);
		//in the case the file was not found in the template directory, uh oh
		header('Content-Type: '.$placeto->config->encoding());
		header('HTTP/1.0 404 Not Found');

		include($base.'placeto/templates/'.$prefs['template'].'/'.$content['template']);
	}
?>