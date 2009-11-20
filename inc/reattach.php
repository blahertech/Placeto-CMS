<?php
	/**
	*	Placeto CMS
	*		A lightweight, easy to use PHP content management system. Written to be as fast as possible and to use as little memory as possible. Placeto forces browser caching, provides gzip compression if necessary and to cut down on bandwidth and cpu time.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	This source code is released under the GPL License.
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

		//browser caching support
		@placeto_cache_browser(filemtime($mbase.$tmpfile));

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