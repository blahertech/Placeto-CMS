<?php
   /**
	*	Placeto CMS.
	*		A lightweight, easy to use PHP content management system. Written
	*		to be as fast as possible and to use as little memory as possible.
	*		Placeto provides browser caching, server caching, deflating, and
	*		gzip compression, if necessary to cut down on bandwidth and cpu
	*		usage.
	*
	*	@package placeto
	*	@version 0.1.0
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

	if (isset($_GET['uri']))
	{
		$strURI=$_GET['uri'];
	}
	else
	{
		$strURI='index.php';
	}

	if (file_exists('../../placeto/admin/index.php'))
	{
		// Pull outside public_html, more secure.
		$BASE='../../';
	}
	elseif (file_exists('../placeto/admin/index.php'))
	{
		// Pull inside public_html.
		$BASE='../';
	}
	else
	{
		// If there is no admin, have the engine pull the page.
		include('../index.php');
		die();
	}

	if (strstr($strURI, '..') || strstr($strURI, '://'))
	{
		// Silly cracker, tricks are for kids!
		die();
	}
	elseif (!include($BASE.'placeto/admin/'.$strURI))
	{
		// If this file is not found, pull page from engine.
		include('../index.php');
	}
?>