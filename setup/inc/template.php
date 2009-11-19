<?php
	/**
	*	Placeto Setup
	*		This is the installation process portion of Placeto CMS.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	This source code is released under the GPL License.
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