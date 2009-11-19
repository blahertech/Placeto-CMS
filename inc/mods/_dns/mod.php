<?php
	/**
	*	Placeto CMS - DNS
	*		Emulates a DNS with subdomains and redirects them to a specified page.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto Mod - DNS (C) BlaherTech - Benjamin Jay Young 2009
    *	Placeto Mods are released under the GNU GPL 3.0 and is free and open source.
	*	You may edit or distrubute any Placeto Mod at your own free will, with the proper accreditation.
	**/

	//format string
	$endpos=strchr($_SERVER['HTTP_HOST'], '.');
	$endpos=stripos($_SERVER['HTTP_HOST'], $endpos);
	$redirectstr=substr($_SERVER['HTTP_HOST'], 0, $endpos);
	$domaindir=substr($_SERVER['HTTP_HOST'], $endpos+1);
	$addondir=substr($_SERVER['REQUEST_URI'], 1);

	//fetch from db
	$relink=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'mod_dns WHERE subdomain="'.$redirectstr.'"'));

	if (mysql_fetch_array(mysql_query('SELECT * FROM '.$prefix.'mod_dns WHERE subdomain="'.$redirectstr.'"'))!=NULL)
	{
		//for a dns match
		header('Location: '.$config['site'].$relink['link'].$addondir);
		unset($endpos, $redirectstr, $domaindir, $addondir, $relink);
		exit();
	}
	else if (str_ireplace('https://', '', str_ireplace('http://', '', $prefs['site']))!==$_SERVER['HTTP_HOST'])
	{
		//if no match, but we're outside the default domain
		header('Location: '.$config['site'].'/'.$addondir);
		unset($endpos, $redirectstr, $domaindir, $addondir, $relink);
		exit();
	}

	unset($endpos, $redirectstr, $domaindir, $addondir, $relink);
?>