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
	*
	*	template.php is used to construct the html template of all admin pages.
	*/
	
	function template_header()
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="include/styles.css" />
		<link rel="shortcut icon" href="../admin/images/favicon.ico" type="image/x-icon" />
		<link rel="icon" href="../admin/images/favicon.ico" type="image/x-icon"/>
<?php
	}

	function template_box_top()
	{
?>
	</head>
    <body>
        <div id="container">
            <div id="box">
                <div id="top">
                    <a href="/">
                        <img id="logo" src="../admin/images/logo.png" alt="Placeto" />
                    </a>
                </div>
                <div id="content">
<?php
	}
	function template_box_bottom()
	{
?>
                </div>
                <div id="bottom"></div>
            </div>
            <div id="copy">
                <a href="http://www.blahertech.org/projects/placeto/">Placeto CMS</a> &copy; <a href="http://www.blahertech.org">BlaherTech</a> 2009-2010
            </div>
        </div>
    </body>
<?php
	}

	function intro_box_top()
	{
?>
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
<?php
	}
	function intro_box_bottom()
	{
?>
				</div>
				<div id="bottom"></div>
			</div>
			<div id="copy">
				<a href="http://www.blahertech.org/projects/placeto/">Placeto CMS</a> &copy; <a href="http://www.blahertech.org">BlaherTech</a> 2009-2010
			</div>
		</div>
	</body>
</html>
<?php
	}
?>