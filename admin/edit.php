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
	
	if (!$content=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'content WHERE page="'.$_GET['page'].'"')))
	{
		header('Location: ./pages.php');
		die();
	}
	
	if (isset($_POST['submit']))
	{
		mysql_query('UPDATE '.$prefix.'content SET title="'.placeto_safe($_POST['title']).'", description="'.placeto_safe($_POST['description']).'", keywords="'.placeto_safe($_POST['keywords']).'", header="'.placeto_safe($_POST['header']).'", content="'.placeto_safe_html(htmlspecialchars_decode($_POST['cnt'], ENT_QUOTES)).'", dependent="'.placeto_safe($_POST['dep']).'", dependentparam="'.placeto_safe($_POST['depp']).'", dynamic="'.placeto_safe($_POST['dynamic']).'" WHERE '.$prefix.'content.page="'.placeto_safe($_POST['before']).'"');
		mysql_query('UPDATE '.$prefix.'content SET page="'.placeto_safe($_POST['page']).'" WHERE '.$prefix.'content.page="'.placeto_safe($_POST['before']).'"');
		header('Location: ./edit.php?page='.placeto_safe($_POST['page']));
	}
	
	require('./inc/template.php');
	template_header();
?>
		<title>Placeto CMS - Edit <?php echo $_GET['page']; ?></title>
        <script type="text/javascript" src="./include/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="./include/editarea/edit_area_full.js"></script>
<?php template_box_top(); ?>
                	<a href="./logout.php">Logout</a><br />
                	<a href="./pages.php">&lt;&lt; Go Back</a><br />
                    <a href="..<?php echo $_GET['page']; ?>">View Page</a><br /><br />
                
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
                        <textarea name="description" rows="2" cols="50"><?php echo $content['description']; ?></textarea><br />
                        
                        <label for="keywords">Keywords (seperate with ','s):</label><br />
                        <textarea name="keywords" rows="2" cols="50"><?php echo $content['keywords']; ?></textarea><br />
                        
                        <label for="header">Header:</label><br />
                        <input type="text" name="header" value="<?php echo $content['header']; ?>" /><br />
                        
                        <label for="cnt">Content:</label><br />
                        <textarea id="cnt" name="cnt" rows="10" cols="60"><?php echo htmlspecialchars($content['content'], ENT_QUOTES, 'UTF-8', true); ?></textarea><br />
                        <select name="editorsel" id="editorsel" onchange="placeto_editor(this);">
                        	<option value="wysiwyg" selected="selected">WYSIWYG</option>
                            <option value="source">Source</option>
                            <option value="none">None</option>
                        </select><br />
                        
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
                    <script type="text/javascript" src="./include/editor.js"></script>
<?php template_box_bottom(); ?>