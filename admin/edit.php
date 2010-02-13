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
	include('./key.php');
	placeto_config_unset();
	
	if (!$mysql=@mysql_connect($sql_login['server'], placeto_safe_sql($_SESSION['myuser']), placeto_key_decrypt(placeto_safe_sql($_SESSION['mypass']), $key)))
	{
		header('Location: ./login.php');
		die();
	}
	
	@mysql_select_db($sql_login['db'], $mysql);
	$prefix=$sql_login['prefix'];
	unset($sql_login);
	
	if (!$content=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'content WHERE page="'.$_GET['page'].'"')))
	{
		header('Location: ./pages.php');
		die();
	}
	
	if (isset($_POST['submit']))
	{
		mysql_query('UPDATE '.$prefix.'content SET title="'.placeto_safe($_POST['title']).'", description="'.placeto_safe($_POST['description']).'", keywords="'.placeto_safe($_POST['keywords']).'", header="'.placeto_safe($_POST['header']).'", content="'.placeto_safe_html($_POST['cnt']).'", dependent="'.placeto_safe($_POST['dep']).'", dependentparam="'.placeto_safe($_POST['depp']).'", dynamic="'.placeto_safe($_POST['dynamic']).'" WHERE '.$prefix.'content.page="'.placeto_safe($_POST['before']).'"');
		mysql_query('UPDATE '.$prefix.'content SET page="'.placeto_safe($_POST['page']).'" WHERE '.$prefix.'content.page="'.placeto_safe($_POST['before']).'"');
		header('Location: ./edit.php?page='.placeto_safe($_POST['page']));
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="include/styles.css" />
		<link rel="shortcut icon" href="../admin/images/favicon.ico" type="image/x-icon" />
		<link rel="icon" href="../admin/images/favicon.ico" type="image/x-icon"/>
		<title>Placeto</title>
        <script type="text/javascript" src="./include/ckeditor/ckeditor.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="box">
				<div id="top">
					<a href="/">
						<img id="logo" src="images/logo.png" alt="Placeto" />
					</a>
				</div>
				<div id="content">
                	<a href="./logout.php">Logout</a><br />
                	<a href="./pages.php">&lt;&lt; Go Back</a><br /><br />
                
                	<div id="alerts">
                        <noscript>
                            <p>
                                <strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
                                support, like yours, you should still see the contents (HTML data) and you should
                                be able to edit it normally, without a rich editor interface.
                            </p>
                        </noscript>
                    </div>
                    
                    <form action="edit.php?page=<?php echo $_GET['page']; ?>" method="post" id="editor">
                    	<input type="hidden" name="before" value="<?php echo $_GET['page']; ?>" />
                    
                        <label for="page">URI:</label><br />
                        <input type="text" name="page" value="<?php echo $content['page']; ?>" /><br />
                        
                        <label for="title">Title:</label><br />
                        <textarea name="title" rows="2" cols="50"><?php echo $content['title']; ?></textarea><br />
                        
                        <label for="description">Description:</label><br />
                        <textarea name="description" rows="2" cols="50"><?php echo $content['desc']; ?></textarea><br />
                        
                        <label for="keywords">Keywords (seperate with ','s):</label><br />
                        <textarea name="keywords" rows="2" cols="50"><?php echo $content['keywords']; ?></textarea><br />
                        
                        <label for="header">Header:</label><br />
                        <input type="text" name="header" value="<?php echo $content['header']; ?>" /><br />
                        
                        <label for="cnt">Content:</label><br />
                        <textarea id="cnt" name="cnt" rows="10" cols="60"><?php echo $content['content']; ?></textarea><br />
                        <script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('cnt');
                        //]]>
                        </script>
                        
                        <label for="dep">Dependent:</label><br />
                        <select name="dep">
                            <option <?php if($content['dependent']==0){echo 'selected="selected"';}?> value="0">False</option>
                            <option <?php if($content['dependent']==1){echo 'selected="selected"';}?> value="1">True</option>
                            <option <?php if($content['dependent']==2){echo 'selected="selected"';}?> value="2">Param Set</option>
                        </select><br />
                        
                        <label for="depp">Dependent Param:</label><br />
                        <input type="text" name="depp" value="<?php echo $content['dependentparam']; ?>" /><br />
                        
                        <label for="dynamic">Dynamic:</label><br />
                        <select name="dynamic">
                            <option <?php if($content['dynamic']==0){echo 'selected="selected"';}?> value="0">False</option>
                            <option <?php if($content['dynamic']==1){echo 'selected="selected"';}?> value="1">True</option>
                        </select><br />
                        <br />
                        <input type="submit" name="submit" value="Sumit" />
                    </form>
				</div>
				<div id="bottom"></div>
			</div>
			<div id="copy">
				Placeto &copy; <a href="http://www.blahertech.org">BlaherTech</a> 2009-2010
			</div>
		</div>
	</body>
</html>
