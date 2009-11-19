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
	*	clean.php is resposible for picking up after it's self.
	*
	*	Think of it as a dog who carries around a pooper scooper.
	**/

	unset($config, $content, $prefs, $nf, $mod_starts, $base);
	include('mysql/close.php');
	while (@ob_end_flush());
?>