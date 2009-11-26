<?php
	/**
	*	Placeto Setup
	*		This is the installation process portion of Placeto CMS.
	*
	*	Copyright (C) 2009 BlaherTech
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
	*	templae.php consists of the functions to be used in the html design of the setup pages.
	**/

	function intro_box_top()
	{
?>
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
	function intro_box_bottom()
	{
?>
                </div>
                <div id="bottom"></div>
            </div>
            <div id="copy">
                Placeto &copy; <a href="http://www.blahertech.org">BlaherTech</a> 2009
            </div>
        </div>
    </body>
<?php
	}
?>