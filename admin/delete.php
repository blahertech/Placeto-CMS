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
	
	if (isset($_GET['page']))
	{
		foreach ($_GET['page'] as $p)
		{
			if ($_GET['confirm'])
			{
				mysql_query('DELETE FROM '.$prefix.'content WHERE page="'.$p.'"');
			}
		}
		if ($_GET['confirm'])
		{
			header('Location: ./pages.php');
			die();
		}
	}
	else
	{
		//header('Location: ./pages.php');
		die();
	}
	
	require('./inc/template.php');
	template_header();
?>
		<title>Placeto CMS - Delete Page</title>
<?php template_box_top(); ?>
                	<a href="./logout.php">Logout</a><br />
                	<a href="./pages.php">&lt;&lt; Go Back</a><br /><br />

                    <form action="./delete.php">
                    	<p>Are you sure you want to delete page(s):</p>
                        <ul>
<?php
	foreach ($_GET['page'] as $p)
	{
		echo '<li>',$p,'</li>';
	}
?>
						</ul>
<?php
	foreach ($_GET['page'] as $p)
	{
		echo '<input type="hidden" name="page[]" value="'.$p.'" />',"\n";
	}
?>
                    	<input type="hidden" name="confirm" value="true" />
                        <input type="submit" value="Confirm" />
                    </form>
<?php template_box_bottom(); ?>