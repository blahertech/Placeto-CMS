<?php
	/**
	*	Placeto CMS - aDNS
	*		Emulates a aDNS with subdomains and redirects them to a specified page.
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