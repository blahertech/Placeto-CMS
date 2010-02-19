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
	
	if (isset($_POST['action']))
	{
		if ($_POST['action']==='del')
		{
			$getstr='';
			foreach ($_POST['page'] as $p)
			{
				$getstr.='page[]='.$p.'&';
			}
			$getstr=substr($getstr, 0, strlen($getstr)-1);
	
			header('Location: delete.php?'.$getstr);
		}
	}
	
	require('./inc/template.php');
	template_header();
?>
		<title>Placeto CMS - Pages</title>
<?php template_box_top(); ?>
                	<a href="./logout.php">Logout</a><br />
                	<a href="./index.php">&lt;&lt; Go Back</a><br /><br />
                
                	<form method="post"><table>
                    	<thead><tr><td></td><th>Page</th><th>Title</th><th>Modifed</th><th>Actions</th></tr></thead>
                        <tbody>
<?php
	$result=mysql_query('SELECT * FROM '.$prefix.'content');
	while ($page=mysql_fetch_assoc($result))
	{
?>
							<tr><td><input type="checkbox" name="page[]" value="<?php echo $page['page']; ?>" /></td><td><a href="./edit.php?page=<?php echo $page['page']; ?>"><?php echo $page['page']; ?></a></td><td><?php echo $page['title']; ?></td><td><?php echo $page['lastmod']; ?></td><td><a href="..<?php echo $page['page']; ?>">View</a> <a href="./delete.php?page[]=<?php echo $page['page']; ?>">Delete</a> <a href="./edit.php?page=<?php echo $page['page']; ?>">Edit</a></td></tr>
<?php
	}
?>
						</tbody>
                    </table><br />
                    
                    <label for="action">Actions: </label>
                    <select name="action">
                    	<option value="">---</option>
                    	<option value="del">Delete</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" />
                    
                    </form>
                    <br />
                    <form action="./add.php">
                    	<label for="page">New page: </label>
                    	<input type="text" name="page" value="/untitled" />
                        <input type="submit" value="Add" />
                    </form>
<?php template_box_bottom(); ?>