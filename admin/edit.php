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
	
	include('./inc/functions.php');
	include('../inc/config.php');
	placeto_config_unset();
	
	if (!$mysql=mysql_connect($sql_login['server'], placeto_safe($_SESSION['myuser']), placeto_key_decrypt(placeto_safe($_SESSION['mypass']), $key)))
	{
		header('Location: ./login.php');
		die();
	}
	
	@mysql_select_db($sql_login['db'], $mysql);
	$prefix=$sql_login['prefix'];
	unset($sql_login);
	
	if (!$content=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'content WHERE page="'.$_GET['page'].'";')))
	{
		header('Location: ./pages.php');
		die();
	}
	
	if (isset($_POST['submit']))
	{
		mysql_query('UPDATE '.$prefix.'content SET title="'.placeto_safe($_POST['title']).'", desc="'.placeto_safe($_POST['desc']).'", keywords="'.placeto_safe($_POST['keywords']).'", header="'.placeto_safe($_POST['header']).'", content="'.placeto_safe_html($_POST['content']).'", dependent="'.placeto_safe($_POST['dep']).'", dependentparam="'.placeto_safe($_POST['depp']).'", dynamic="'.placeto_safe($_POST['dynamic']).'", page="'.placeto_safe($_POST['page']).'" WHERE page="'.placeto_safe($_GET['page']).'"');
		
		header('Location: ./pages.php');
		die();
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
        <script type="text/javascript" src="./include/chkeditor/ckeditor.js"></script>
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
                	<div id="alerts">
                        <noscript>
                            <p>
                                <strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
                                support, like yours, you should still see the contents (HTML data) and you should
                                be able to edit it normally, without a rich editor interface.
                            </p>
                        </noscript>
                    </div>
                    
                    <form method="post">
                        <label for="page">URI:</label>
                        <input type="text" name="page" value="<?php echo $content['page']; ?>" />
                        
                        <label for="title">Title:</label>
                        <textarea name="title" rows="5" cols="50">
                            <?php echo $content['title']; ?>
                        </textarea>
                        
                        <label for="desc">Description:</label>
                        <textarea name="desc" rows="5" cols="50">
                            <?php echo $content['desc']; ?>
                        </textarea>
                        
                        <label for="keywords">Keywords (seperate with ','s):</label>
                        <textarea name="keywords" rows="5" cols="50">
                            <?php echo $content['keywords']; ?>
                        </textarea>
                        
                        <label for="header">Header:</label>
                        <input type="text" name="header" value="<?php echo $content['header']; ?>" />
                        
                        <label for="content">Content:</label>
                        <textarea id="content" name="content" rows="10" cols="80">
                            <?php echo $content['content']; ?>
                        </textarea>
                        <script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('content');
                        //]]>
                        </script>
                        
                        <label for="dep">Dependent:</label>
                        <select name="dep">
                            <option <?php if($content['dependent']==0){echo 'selected="selected"';}?> value="0">False</option>
                            <option <?php if($content['dependent']==1){echo 'selected="selected"';}?> value="1">True</option>
                            <option <?php if($content['dependent']==2){echo 'selected="selected"';}?> value="2">Param Set</option>
                        </select>
                        
                        <label for="depp">Dependent Param:</label>
                        <input type="text" name="depp" value="<?php echo $content['dependentparam']; ?>" />
                        
                        <label for="dynamic">Dynamic:</label>
                        <select name="dynamic">
                            <option <?php if($content['dynamic']==0){echo 'selected="selected"';}?> value="0">False</option>
                            <option <?php if($content['dynamic']==1){echo 'selected="selected"';}?> value="1">True</option>
                        </select>
                        
                        <input type="submit" value="Sumit" />
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
