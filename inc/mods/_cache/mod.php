<?php
	/**
	*	Placeto CMS - Cache
	*		Creates cache files for your non-dynamic content. Saves huge amounts of processing time.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Copyright (C) 2009-2010 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	**/

	//check and make cache directory
	if (!file_exists($base.'.cache'))
	{
		mkdir($base.'.cache', 0777);
	}

	//time for server caching
	if ($content['dynamic']!=1)
	{
		//set up pre-reqs
		$mdhash=md5($_SERVER['REQUEST_URI']);
		$mdplace=$base.'.cache/'.$mdhash;

		$tmpfile='templates/'.$config['template'].$location;
		$mbase=str_ireplace('reattach.php', '', __FILE__);

		//see if it's a reattached file or db file
		if ($content && $content['page']!=='/error')
		{
			$filemtime=strtotime($content['lastmod']);
		}
		else if (file_exists($mbase.$tmpfile) && $location!=='/')
		{
			$filemtime=filemtime($mbase.$tmpfile);
		}
		else
		{
			$filemtime=-1;
		}

		//checks for pre-existing cache
		if ((file_exists($mdplace) || (file_exists($mdplace.'.gz' && substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')))) && filemtime($mdplace)>=$filemtime && $filemtime>0)
		{
			//retrieve list of enable mods
			$result=mysql_query('SELECT * FROM '.$prefix.'mods');
			while ($mod_temps=mysql_fetch_assoc($result))
			{
				$mod_starts[$mod_temps['name']]=$mod_temps['enable'];
			}

			//check if _gzip is enabled
			if ($mod_starts['gzip']['enable'] && file_exists($mdplace.'.gz') && substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
			{
				//browser caching
				placeto_cache_browser(filemtime($mdplace.'.gz'));
				header('Content-Encoding: gzip');
				readfile($mdplace.'.gz');
			}
			else
			{
				//browser caching
				placeto_cache_browser(filemtime($mdplace));
				readfile($mdplace);
			}

			//we have a hit, so let's save some time
			unset($mdhash, $mpfile, $mbase, $filemname, $mod_temps, $mod_starts);
			exit(1);
		}

		//if not, let's make some babies
		ob_start();
		unset($mdhash, $mpfile, $mbase, $filemname);
	}
	
	//adds browser caching support
	function placeto_cache_browser($filemtime)
	{
		global $location;

		//here comes the browser caching support
		if (date('d')!==1)
		{
			$expires=substr(date('r', mktime(date('G'), date('i'), date('s'), date('m'), date('d')-1, date('y')+1)), 0, 25);
		}
		else
		{
			$expires=substr(date('r', mktime(date('G'), date('i'), date('s'), date('m')-1, date('d')+28, date('y')+1)), 0, 25);
		}

		//so we don't have to find waldo more than once
		$etag=md5($location.gmdate('dmyHis', $filemtime));
		header('Expires: '.$expires.' GMT');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s', $filemtime).' GMT');
		header('Cache-Control: public, max-age=31536000');
		header('ETag: '.$etag);
		unset($expires, $etag);
		header('Vary: Accept-Encoding');
	}
	
	//cache clear function
	function placeto_cache_clear()
	{
		$files=scandir('../.cache/');
		foreach ($files as $file)
		{
			if ($file!=='.' || $file!=='..')
			{
				unlink($page);
			}
		}
	}

	//browser cache checking
	if ($nf)
	{
		//where's waldo?
		$tmpfile='templates/'.$prefs['template'].$location;
		$mbase=str_ireplace('mods/_cache/mod.php', '', __FILE__);

		//found it
		if (file_exists($mbase.$tmpfile) && $location!=='/')
		{
			placeto_cache_browser(filemtime($mbase.$tmpfile));
		}
	}
	else
	{
		//browser caching support
		if ($content['dynamic']!=1)
		{
			placeto_cache_browser(strtotime($content['lastmod']));
		}
	}
?>