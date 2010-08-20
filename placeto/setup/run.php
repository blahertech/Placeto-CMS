<?php
	/**
	*	Placeto Setup
	*		This is the installation process portion of Placeto CMS.
	*
	*	Copyright (C) 2009-2010 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*	
	*	//////////////////////////////////////////////////
	*
	*	This is the main proccess page for the setup.
	**/

/////////////////////////////////
//	TODO: Make template seperate from admin, due to new format and caching problems.
//	TODO: Set the safe functions to pull from the library.
/////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="../admin/include/login.css" />
		<link rel="shortcut icon" href="../admin/images/favicon.ico" type="image/x-icon" />
		<link rel="icon" href="../admin/images/favicon.ico" type="image/x-icon"/>
		<title>Placeto - Setup</title>
<?php
	//top of the template
	require('../admin/inc/template.php');
	require('../admin/inc/functions.php');
	intro_box_top();
	if (!$pass)
	{
		//no cookies for you
?>
					<h1>Not Found</h1>
					<p>
						Sorry, but I deleted the installation files to keep other users from cracking my shell.
					</p><br class="clear" />
<?php
	}
	else if (!isset($_GET['step']))
	{
		//oh, so you're new here
?>
					<h1>Welcome to Placeto CMS</h1>
					<p>
						Hello, my name is Asta (The Crayfish) and thank you for choosing Placeto CMS. We will now be going through the installation process, and I will try to keep this as easy as possible for you. If you are ready to start, then go ahead and click start, otherwise I can wait.
					</p>
					<form method="get">
						<input type="hidden" name="step" value="1" />
						<input type="submit" value="Start" />
					</form>
<?php
	}
	else if (placeto_safe_sql($_GET['step'])==='1')
	{
		//db info
?>
					<h1>Placeto Database Information</h1>
					<p>
						First off, I need to know some database server information, in order for me to store information. You may need to retrieve this from your hosting provider or your server/network administrator.
					</p>
					<form method="post" action="?step=2">
						<label for="config_file">Config Filename</label>
						<input type="text" name="config_file" value="default.config" />
						<label for="db_server">Database Server</label>
						<p>Keep this "default.config", unless you know what you're doing.</p>
						<input type="text" name="db_server" value="localhost" />
						<p>90% of the time, this will be localhost.</p>
						<label for="db_user">Database User</label>
						<input type="text" name="db_user" />
						<label for="db_pass">Database User's Password</label>
						<input type="password" name="db_pass" />
						<label for="db_name">Placeto's Database Name</label>
						<input type="text" name="db_name" value="placeto_db" />
						<label for="db_prefix">Table Prefix?</label>
						<input type="text" name="db_prefix" value="placeto_" />
						<p>This will be applied before every table name.</p>
						<label for="db_create">Create Database?</label>
						<input type="checkbox" name="db_create" checked="checked" />
						<p>If you don't have create privlages, you will have to manually create the database and don't select this. If you use a shared hosting service, you will have to do this manually.</p>
						<br />
						<input type="submit" value="Continue" />
					</form>
<?php
	}
	else if (placeto_safe_sql($_GET['step'])==='2')
	{
		//check db connection
		$db_error=0;
		@$mysql=mysql_connect(placeto_safe_sql($_POST['db_server']), placeto_safe_sql($_POST['db_user']), placeto_safe_sql($_POST['db_pass'])) or $db_error=1;
		
		if ($db_error===0)
		{
			if (mysql_select_db(placeto_safe($_POST['db_name']), $mysql) && !$_POST['db_name'])
			{
				//check if they can select
				$db_error=2;
			}
		}
		if ($db_error===0)
		{
			if ($_POST['db_create'])
			{
				//check if they can create
				@mysql_query('CREATE DATABASE '.placeto_safe($_POST['db_name']), $mysql) or $db_error=3;
			}
			else if (!mysql_select_db($_POST['db_name'], $mysql))
			{
				//check if they can create and select
				$db_error=4;
			}
			
		}
		mysql_close($mysql);
		unset($mysql);
		
		//throw up what ever we eat
		if ($db_error===1)
		{
?>
					<h1>Error</h1>
					<p>
						I'm sorry, but I could not connect with the database. The server name and/or username and/or password may have been wrong. Please try again.
					</p>
<?php
		}
		if ($db_error===2)
		{
?>
					<h1>Error</h1>
					<p>
						I'm sorry, I found the database you entered already exists. Please try again.
					</p>
<?php
		}
		if ($db_error===3)
		{
?>
					<h1>Error</h1>
					<p>
						I'm sorry, but the username you entered does not let me have the privalages to create a new database. Please try again.
					</p>
<?php
		}
		if ($db_error===4)
		{
?>
					<h1>Error</h1>
					<p>
						I'm sorry, I could not find the database you entered. Please try again.
					</p>
<?php
		}
		if ($db_error!==0)
		{
			//let's try again
?>
				<form method="post" action="?step=2">
					<label for="config_file">Config Filename</label>
					<input type="text" name="config_file" value="<?php echo $_POST['config_file']; ?>" />
					<p>Keep this "default.config", unless you know what you're doing.</p>
					<label for="db_server">Database Server</label>
					<input type="text" name="db_server" value="<?php echo $_POST['db_server']; ?>" />
					<p>90% of the time, this will be localhost.</p>
					<label for="db_user">Database User</label>
					<input type="text" name="db_user" value="<?php echo $_POST['db_user']; ?>" />
					<label for="db_pass">Database User's Password</label>
					<input type="password" name="db_pass" value="<?php echo $_POST['db_pass']; ?>" />
					<label for="db_name">Placeto's Database Name</label>
					<input type="text" name="db_name" value="<?php echo $_POST['db_name']; ?>" />
					<label for="db_prefix">Table Prefix?</label>
					<input type="text" name="db_prefix" value="<?php echo $_POST['db_prefix']; ?>" />
					<p>This will be applied before every table name.</p>
					<label for="db_create">Create Database?</label>
					<input type="checkbox" name="db_create"<?php if($_POST['db_create']){echo ' checked="checked"';} ?> />
					<p>If you don't have create privlages, you will have to manually create the database and don't select this.</p>
					<br />
					<input type="submit" value="Try Again" />
				</form>
<?php
		}
		else
		{
			//yay it worked
?>
				<h1>Placeto Setup</h1>
				<p>
					Now that I have all the required information and have verified that everything is in working order, I will now begin to set up the application. Before I do so, I warn you it may take some time for me to swim back and forth between setup, so please be patient. When you are ready, click 'Install'.
				</p>
				<form method="post" action="?step=3">
					<input type="hidden" name="config_file" value="<?php echo $_POST['config_file']; ?>" />
					<input type="hidden" name="db_server" value="<?php echo $_POST['db_server']; ?>" />
					<input type="hidden" name="db_user" value="<?php echo $_POST['db_user']; ?>" />
					<input type="hidden" name="db_pass" value="<?php echo $_POST['db_pass']; ?>" />
					<input type="hidden" name="db_name" value="<?php echo $_POST['db_name']; ?>" />
					<input type="hidden" name="db_prefix" value="<?php echo $_POST['db_prefix']; ?>" />
					<input type="submit" value="Install" />
				</form>
<?php
		}
		unset($db_error);
	}
	else if (placeto_safe_sql($_GET['step'])==='3')
	{
		//setup the db
?>
				<h1>Placeto Checking Setup</h1>
<?php
		$mysql=mysql_connect(placeto_safe_sql($_POST['db_server']), placeto_safe_sql($_POST['db_user']), placeto_safe_sql($_POST['db_pass']));
		mysql_select_db(placeto_safe($_POST['db_name']), $mysql);
		
		//import sql commands file
		$sqlfile=fopen('db.sql', 'r');
		$sqldata=fread($sqlfile, filesize('db.sql'));
		fclose($sqlfile);
		
		//set prefix if set
		if ($_POST['db_prefix'])
		{
			$sqldata=str_replace('CREATE TABLE IF NOT EXISTS `', 'CREATE TABLE IF NOT EXISTS `'.placeto_safe($_POST['db_prefix']), $sqldata);
			$sqldata=str_replace('INSERT INTO `', 'INSERT INTO `'.placeto_safe($_POST['db_prefix']), $sqldata);
			$sqldata=str_replace('ALTER TABLE `', 'ALTER TABLE `'.placeto_safe($_POST['db_prefix']), $sqldata);
			$sqldata=str_replace('ADD CONSTRAINT `', 'ADD CONSTRAINT `'.placeto_safe($_POST['db_prefix']), $sqldata);
			$sqldata=str_replace('REFERENCES `', 'REFERENCES `'.placeto_safe($_POST['db_prefix']), $sqldata);
		}
		
		//why I had to do it this way, don't ask
		$sqlary=explode(';;', $sqldata);
		$sqlec=0;
		$sqlet=0;
		$sqlstmt='';
		unset($sqldata, $sqlfile);
		
		//loop through each command
		foreach ($sqlary as $stmt)
		{
			if (strlen($stmt)>3)
			{
				$result=mysql_query($stmt);
				if (!$result)
				{
					$sqlec=mysql_errno();
					$sqlet=mysql_error();
					$sqlstmt=$stmt;
					break;
				}
			}
		}
		
		mysql_close($mysql);
		unset($mysql, $stmt, $result, $sqlary);
		
		//set up the config file
		if ($sqlec===0)
		{
			if(substr($_SERVER['PHP_SELF'], 0, strripos($_SERVER['PHP_SELF'], 'setup'))!=='/')
			{
				$dirc=substr($_SERVER['PHP_SELF'], 0, strripos($_SERVER['PHP_SELF'], 'setup')-1);
			}
			else
			{
				$dirc='/';
			}
			
			//configgy!
			$configcnt="<?php\n\t\$config['site']='http://".$_SERVER['HTTP_HOST']."';\n\t\$config['directory']='".$dirc."';\n\n\t\$sql_login['server']='".$_POST['db_server']."';\n\t\$sql_login['user']='".placeto_safe_sql($_POST['db_user'])."';\n\t\$sql_login['pass']='".placeto_safe_sql($_POST['db_pass'])."';\n\t\$sql_login['db']='".placeto_safe_sql($_POST['db_name'])."';\n\t\$sql_login['prefix']='".$_POST['db_prefix']."';\n\t\$sql_login['die']='Databases failed, please contact the website admin.';\n\n\t\$config['encode']='utf-8';\n\t\$config['type']='text/html; charset='.\$config['encode'];\n?>";
			
			unset($dirc);
			@unlink('../config/'.placeto_safe_sql($_POST['config_file']).'.php');
			$cnfff=false;
			
			//write the config
			@$configf=fopen('../config/'.placeto_safe_sql($_POST['config_file']).'.php', 'w') or $cnfff=true;
			@fwrite($configf, $configcnt) or $cnfff=true;
			fclose($configf);
			
			if ($cnfff)
			{
				//uh oh, no no writable
				echo 'I couldn\'t write to the configuration file. You will need to look at the online support and manually add the config file. When you\'r done, please click "Continue".';
			}
			else
			{
				//yay
				echo 'Installation Complete! Please Continue for the final step of setup.';
			}
?>
				<form method="post" action="?step=4">
					<input type="hidden" name="db_server" value="<?php echo $_POST['db_server']; ?>" />
					<input type="hidden" name="db_user" value="<?php echo $_POST['db_user']; ?>" />
					<input type="hidden" name="db_pass" value="<?php echo $_POST['db_pass']; ?>" />
					<input type="hidden" name="db_name" value="<?php echo $_POST['db_name']; ?>" />
					<input type="hidden" name="db_prefix" value="<?php echo $_POST['db_prefix']; ?>" />
					<input type="submit" value="Continue" />
				</form>
<?php
			unset($cnfff, $configf, $configcnt);
		}
		else
		{
			//grrr
			echo 'An error occured during installation!<br />';
			echo 'Error code: '.$sqlec.'<br />';
			echo 'Error text: '.$sqlet.'<br />';
			echo '<br />Statement:<br />'.$sqlstmt.'<br />';
		}
		unset($sqlstmt, $sqlec, $sqlet);
	}
	else if (placeto_safe_sql($_GET['step'])==='4')
	{
		//preferences
?>
				<h1>Placeto Personal Information</h1>
				<p>
					Now that I have everything set up correctly, I will now need some personal information that will be stored on your server. It will also help me get to know you better. This information WILL NOT be sent any where other than to your website.
				</p>
				<form method="post" action="?step=5">
					<input type="hidden" name="db_server" value="<?php echo $_POST['db_server']; ?>" />
					<input type="hidden" name="db_user" value="<?php echo $_POST['db_user']; ?>" />
					<input type="hidden" name="db_pass" value="<?php echo $_POST['db_pass']; ?>" />
					<input type="hidden" name="db_name" value="<?php echo $_POST['db_name']; ?>" />
					<input type="hidden" name="db_prefix" value="<?php echo $_POST['db_prefix']; ?>" />
					<label for="name">Your Full Name</label>
					<input type="text" name="name" />
					<p>First and last.</p>
					<label for="site">Website's Name</label>
					<input type="text" name="site" />
					<p>ie. Foosite Co.</p>
					<label for="copyright">Copyright Statement</label>
					<input type="text" name="copyright" value="Your site &amp;copy; Your name 2009" />
					<label for="admin">Admin Email</label>
					<input type="text" name="admin" />
					<br />
					<input type="submit" value="Finish" />
				</form>
<?php
	}
	else if (placeto_safe_sql($_GET['step'])==='5')
	{
		//complete
		$mysql=mysql_connect(placeto_safe_sql($_POST['db_server']), placeto_safe_sql($_POST['db_user']), placeto_safe_sql($_POST['db_pass']));
		mysql_select_db(placeto_safe($_POST['db_name']), $mysql);
		$query='INSERT INTO '.placeto_safe($_POST['db_prefix'])."preferences (name, owner, copyright, adminemail, template) VALUES ('".placeto_safe($_POST['site'])."', '".placeto_safe($_POST['name'])."', '".placeto_safe($_POST['copyright'])."', '".placeto_safe($_POST['admin'])."', 'default')";
		mysql_query($query);
		mysql_close($mysql);
		unset($mysql, $query);
?>
				<h1>Placeto Completed</h1>
				<p>
					Congratulations! I have finished setting up Placeto and it's now ready to use.
				</p>
<?php
		//see if we can delete the pass, so no one else can run the setup
		$unlinkf=false;
		@unlink('./pass.php') or $unlinkf=true;
		if ($unlinkf)
		{
			//nope
			echo '<p>However I was not able to delete the file pass.php. If you would kindly do that your self from keeping others from cracking my shell, I would appreciate that.</p>';
		}
		unset($unlinkf);
		
		//bring me to your leader
?>
				<form method="post" action="../admin/login.php">
					<input type="hidden" name="myuser" value="<?php echo $_POST['db_user']; ?>" />
					<input type="hidden" name="mypass" value="<?php echo $_POST['db_pass']; ?>" />
					<input type="submit" name="submit" value="Go to Admin" />
				</form>
<?php
	}
	unset($pass);
	intro_box_bottom();
?>
</html>
