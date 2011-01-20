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
	*	@copyright BlaherTech 2009-2011
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

	// engine security check
	if (TOKEN!=='30c42e373acf6f3322f72875e59e677d')
	{
		header('Location: ../../');
		die();
	}

	// where's waldo?
	$strFile=$placeto->config->base().'placeto/templates/'
		.$placeto->preferences->template().$placeto->config->location();

	@include
	(
		$placeto->config->base().'placeto/templates/'
		.$placeto->preferences->template().'/data.php'
	);

	$boolBreak=false;
	// TODO: figure out why I wrote this and update it to match the new placeto.
	// NOTE: It may be a list of ingored tempalte files.
	/*foreach ($templates[$prefs['template']]['files'] as &$strTempFile)
	{
		if ('/'.$strTempFile==$location)
		{
			$bolBreak=true;
		}
	}*/
	unset($strTempFile);

	// is waldo missing?
	if (file_exists($strFile) && $placeto->config->location()!=='/' && !$bool)
	{
		//what's waldo's mime type?
		$strExtension=strrchr($placeto->config->path(), '.');

		// check php compatibilty
		if (placeto_extension($strExtension, $placeto->config->base()))
		{
			// prefered way
			header
			(
				'Content-Type: '
				.placeto_extension
				(
					$strExtension, $placeto->config->base()
				)
			);
		}
		else if (function_exists('finfo_file'))
		{
			//new way
			$finfo=finfo_open(FILEINFO_MIME);
			header('Content-Type: '.finfo_file($finfo, $strFile));
			finfo_close($finfo);
			unset($finfo);
		}
		else
		{
			// old way, please update your phpd
			header('Content-Type: '.mime_content_type($strFile));
		}

		unset($strExtension);
		header('Content-Length:'.filesize($strFile));

		// readfile is faster than include, trust me
		readfile($strFile);

		// bye waldo
		// placeto_mod_end();
		unset($strFile, $bool);
		//include('cleanup.php');
		die();
	}
	else
	{
		unset($strTempFile, $bool);
		// in the case the file was not found in the template directory, uh oh
		header('Content-Type: '.$placeto->config->encoding());
		header('HTTP/1.0 404 Not Found');

		include
		(
			$placeto->config->base()
			.'placeto/templates/'.$placeto->preferences->template()
			.'/'.$placeto->content->template()
		);
	}
?>