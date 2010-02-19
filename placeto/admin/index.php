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
	
	session_start();
	
	require('./inc/functions.php');
	require('../inc/config.php');
	placeto_config_unset();
	require('./key.php');
	
	if (!$mysql=@mysql_connect($sql_login['server'], placeto_safe_sql($_SESSION['myuser']), placeto_key_decrypt(placeto_safe_sql($_SESSION['mypass']), $key)))
	{
		header('Location: ./login.php');
		die();
	}
	
	@mysql_select_db($sql_login['db'], $mysql);
	$prefix=$sql_login['prefix'];
	unset($sql_login);
	
	require('./inc/template.php');
	template_header();
?>
		<title>Placeto CMS</title>
<?php template_box_top(); ?>
                	<a href="./logout.php">Logout</a><br />
					<ul>
                    	<li><a href="./pages.php">Pages</a></li>
                    </ul>
<?php template_box_bottom(); ?>