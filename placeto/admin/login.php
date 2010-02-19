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
	
	if (isset($_POST['submit']))
	{
		require('./inc/functions.php');
		require('../inc/config.php');
		placeto_config_unset();
		require('./key.php');
		
		if (@mysql_connect($sql_login['server'], placeto_safe_sql($_POST['myuser']), placeto_safe_sql($_POST['mypass'])))
		{
			$_SESSION['myuser']=placeto_safe($_POST['myuser']);
			$_SESSION['mypass']=placeto_key_encrypt(placeto_safe($_POST['mypass']), $key);
			header('Location: ./index.php');
			die();
		}
		else
		{
			$wrong=true;
		}
	}
	
	require('./inc/template.php');
	template_header_login();
?>
		<title>Placeto CMS - Login</title>
<?php intro_box_top(); ?>
                	<?php if($wrong){echo '<div style="text-align:center;"><strong>Login failed!</strong></div><br />';}?>
					<form id="login" method="post">
                    	<label for="myuser">
                        	MySQL User:
                        </label>
                    	<input type="text" name="myuser" /><br />
                        
                        <label for="mypass">
                        	MySQL Password:
                        </label>
                        <input type="password" name="mypass" /><br />
                        
                        <input type="submit" name="submit" value="Submit" />
                    </form>
<?php intro_box_bottom(); ?>
