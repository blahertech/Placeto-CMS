<?php
	/**
	*	Placeto CMS - Admin
	*		The Placeto CMS Administration application.
	*
	*	Copyright (C) 2009-2010 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto/
	*
	*	//////////////////////////////////////////////////
	*/

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
			".txt"=>"text/plain"
		);
		if ($exts[$ext])
		{
			return $exts[$ext];
		}
		else
		{
			return false;
		}
	}
	if (isset($_GET['url']))
	{
		$location='/'.$_GET['url'];
	}
	else
	{
		$location=$_SERVER['PHP_SELF'];
	}
	$path=$location;
	$location=str_replace('index.php', '', $location);
	if (substr($location, strlen($location)-1)=='/' && strlen($location)!=1)
	{
		$location=substr($location, 0, strlen($location)-1);
	}
	$tmpfile='includes/'.$location;
	$base=str_ireplace('index.php', '', __FILE__);
	if (file_exists($base.$tmpfile) && $location!='/')
	{
		$extension=strrchr($path, '.');
		if (placeto_extension($extension))
		{
			header('Content-Type: '.placeto_extension($extension));
		}
		else if (function_exists('finfo_file'))
		{
			$finfo=finfo_open(FILEINFO_MIME);
			header('Content-Type: '.finfo_file($finfo, $base.$tmpfile));
			finfo_close($finfo);
		}
		else
		{
			header('Content-Type: '.mime_content_type($base.$tmpfile));
		}
		header('Content-Length:'.filesize($base.$tmpfile));
		if (date('d')!=1)
		{
			$expires=substr(date('r', mktime(date('G'), date('i'), date('s'), date('m'), date('d')-1, date('y')+1)), 0, 25);
		}
		else
		{
			$expires=substr(date('r', mktime(date('G'), date('i'), date('s'), date('m')-1, date('d')+28, date('y')+1)), 0, 25);
		}
		$etag=md5($tmpfile.gmdate('dmyHis', filemtime($base.$tmpfile)));
		header('Expires: '.$expires.' GMT');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($base.$tmpfile)).' GMT');
		header('Cache-Control: public, max-age=31536000');
		header('ETag: '.$etag);
		header('Vary: Accept-Encoding');
		readfile($base.$tmpfile);
		die();
	}
	else
	{
		header('Content-Type: '.$config['type']);
		header('HTTP/1.0 404 Not Found');
		include('lost.php');
	}
?>