<?php
	/**
	*	Placeto CMS - Cache
	*		Compresses the page in Gzip format.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto Mod - Cache (C) BlaherTech - Benjamin Jay Young 2009
    *	Placeto Mods are released under the GNU GPL 3.0 and is free and open source.
	*	You may edit or distrubute any Placeto Mod at your own free will, with the proper accreditation.
	**/

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
	
	//makes a cache file
	function placeto_cache_make()
	{
		global $mdplace, $gztrue;
		
		if ($content['igcache']!==1)
		{
			//retrieve list of enable mods
			$result=mysql_query('SELECT * FROM '.$prefix.'mods');
			while ($mod_temps=mysql_fetch_assoc($result))
			{
				$mod_starts[$mod_temps['name']]=$mod_temps['enable'];
			}
			
			//check if _gzip is enabled
			if ($gztrue)
			{
				//let's do this my way, instead
				$fp=gzopen($mdplace.'.gz', 'w9');
				gzwrite($fp, ob_get_contents());
				gzclose($fp);
			}
			
			// Now the script has run, generate a new cache file
			$fp=fopen($mdplace, 'w');

			// save the contents of output buffer to the file
			fwrite($fp, ob_get_contents());
			fclose($fp);
		}
		unset($mdplace, $fp, $mod_starts, $mod_temps);
	}
	
	//time for server caching
	if ($content['igcache']!==1)
	{
		//set up pre-reqs
		$mdhash=md5($location);
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
	
	
?>