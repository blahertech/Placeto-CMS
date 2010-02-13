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
	
	include('./inc/functions.php');
	include('../inc/config.php');
	placeto_config_unset();
	include('./key.php');
	
	if (!$mysql=@mysql_connect($sql_login['server'], placeto_safe_sql($_SESSION['myuser']), placeto_key_decrypt(placeto_safe_sql($_SESSION['mypass']), $key)))
	{
		header('Location: ./login.php');
		die();
	}
	
	@mysql_select_db($sql_login['db'], $mysql);
	$prefix=$sql_login['prefix'];
	unset($sql_login);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="include/styles.css" />
		<link rel="shortcut icon" href="../admin/images/favicon.ico" type="image/x-icon" />
		<link rel="icon" href="../admin/images/favicon.ico" type="image/x-icon"/>
		<title>Placeto</title>
	</head>
	<body>
		<div id="container">
			<div id="box">
				<div id="top">
					<a href="./">
						<img id="logo" src="images/logo.png" alt="Placeto" />
					</a>
				</div>
				<div id="content">
                	<a href="./logout.php">Logout</a><br />
					<ul>
                    	<li><a href="./pages.php">Pages</a></li>
                    </ul>
				</div>
				<div id="bottom"></div>
			</div>
			<div id="copy">
				Placeto &copy; <a href="http://www.blahertech.org">BlaherTech</a> 2009-2010
			</div>
		</div>
	</body>
</html>
