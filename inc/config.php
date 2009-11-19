<?php
	$config['site']='http://placeto.blahertech.org';
	$config['directory']='/';
	$config['template']='blahertech';

	$sql_login['server']='localhost';
	$sql_login['user']='howardmc_placeto';
	$sql_login['pass']='AHardToGuessPassword';
	$sql_login['db']='howardmc_placetodb';
	$sql_login['prefix']='';
	$sql_login['die']='Databases failed, please contact <a href="mailto:blaher@blahertech.org"></a>.';
	
	$config['encode']='utf-8';
	$config['type']='text/html; charset='.$config['encode'];
?>