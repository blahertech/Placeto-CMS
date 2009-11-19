<?php
	/**
	*	Placeto CMS
	*		A lightweight, easy to use PHP content management system. Written to be as fast as possible and to use as little memory as possible. Placeto forces browser caching, provides gzip compression if necessary and to cut down on bandwidth and cpu time.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	This source code is released under the GPL License.
	*
	*	//////////////////////////////////////////////////
	*
	*	mysql/connect.php connects to the db.
	*
	*	Make sure to close your connection as soon as possible.
	**/

	@$mysqlconnect=mysql_connect($sql_login['server'], $sql_login['user'], $sql_login['pass']) or die($sql_login['die']);
	mysql_select_db($sql_login['db'], $mysqlconnect);
	$prefix=$sql_login['prefix'];
	unset($sql_login);
?>