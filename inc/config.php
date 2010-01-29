<?php
	/**
	*	Placeto CMS
	*		A lightweight, easy to use PHP content management system. Written to be as fast as possible and to use as little memory as possible. Placeto provides browser caching, server caching, deflating and gzip compression if necessary to cut down on bandwidth and cpu time.
	*
	*	Copyright (C) 2009 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto/
	*/

	$config['site']='http://www.somesite.com';
	$config['directory']='/';

	$sql_login['server']='localhost';
	$sql_login['user']='user';
	$sql_login['pass']='AHardToGuessPassword';
	$sql_login['db']='site_placeto';
	$sql_login['prefix']='';
	$sql_login['die']='Databases failed, please contact <a href="mailto:support@somesite.com></a>.';

	$config['encode']='utf-8';
	$config['type']='text/html; charset='.$config['encode'];
?>