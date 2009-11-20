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
	*	template.php is your main file that should include from the outside.
	*
	*	If you need to include template.php from anywhere other than the root, remember to set $base to how the root directory is relative to the current location.
	**/

	//checks base
	if (!isset($base))
	{
		$base='./';
	}

	//make sure that config.php is ready or go to setup
	if (!file_exists($base.'inc/config.php'))
	{
		header('Location: '.$base.'setup');
		die();
	}

	require('config.php');
	require('mysql/connect.php');
	require('define.php');
	include_once('functions.php');
	include_once('mods.php');

	if ($nf)
	{
		//used for files in the template
		require('reattach.php');
	}
	else if ($dependent==='1' || ($dependent==='2' && isset($_GET[$content['dependentparam']])))
	{
		//independent pages in the db

		//browser caching support
		if ($content['igcache']!==1)
		{
			@placeto_cache_browser(strtotime($content['lastmod']));
		}

		//stop, content time
		eval('?>'.$content['content']);
		placeto_mod_end();
	}
	else
	{
		//normal pages in the db
		header('Content-Type: '.$config['type']);

		//browser caching support
		if ($content['igcache']!==1)
		{
			@placeto_cache_browser(strtotime($content['lastmod']));
		}

		//stop, template time
		include('templates/'.$config['template'].'/index.php');
		placeto_mod_end();
	}

	//watch Asta swim away and await for his next request
	include('clean.php');
	exit(0);
?>