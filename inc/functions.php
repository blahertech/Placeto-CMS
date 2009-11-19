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
	*	functions.php defines commonly used functions that the engine and template will use.
	*	You may also use these functions within your mods and templates.
	**/

	//pull $prefs
	function placeto_prefs($dbtype)
	{
		global $prefs;
		echo $prefs[$dbtype];
		unset($dbtype);
		return true;
	}

	//pull $configs
	function placeto_configs($dbtype)
	{
		global $config;
		echo $config[$dbtype];
		unset($dbtype);
		return true;
	}

	//pulls you mainly used content needed for the templates
	function placeto($dbtype)
	{
		//globalizing stablizer variable allocations
		global $content, $prefs, $config, $location;
		if ($dbtype==='content')
		{
			eval('?>'.$content['content']."\n");
		}
		else if ($dbtype==='site')
		{
			echo $prefs['name'];
		}
		else if ($dbtype==='base')
		{
			echo $config['site'];
			echo $config['directory'];
			if ($config['directory']!=='/')
			{
				echo '/';
			}
		}
		else if ($dbtype==='directory')
		{
			echo $config['directory'];
			if ($config['directory']!=='/')
			{
				echo '/';
			}
		}
		else if ($dbtype==='canonical')
		{
			echo $config['site'];
			if ($config['directory']!=='/')
			{
				echo $config['directory'];
			}
			echo $location;
		}
		else if ($dbtype==='copyright')
		{
			echo $prefs['copyright'];
		}
		else
		{
			echo $content[$dbtype];
		}
		unset($dbtype);
		return true;
	}

	//returns the mime type of a given known web extension, this is mostly used in the reattachment of you template includes
	function placeto_extension($ext)
	{
		$exts=array(
			".css"=>"text/css",
			".js"=>"text/javascript",
			".png"=>"image/png",
			".gif"=>"mage/gif",
			".jpg"=>"image/jpeg",
			".jpeg"=>"image/jpeg",
			".ico"=>"image/x-icon",
			".htm"=>"text/html",
			".html"=>"text/html",
			".xhtml"=>"text/html",
			".xml"=>"text/xml",
			".txt"=>"text/plain",
			".psd"=>"image/vnd.adobe.photoshop"
		);
		if ($exts[$ext])
		{
			//if we have a match
			$exts=$exts[$ext];
			return $exts;
		}
		else
		{
			//eeerrrrrrr!!!!
			unset($exts);
			return false;
		}
	}
?>