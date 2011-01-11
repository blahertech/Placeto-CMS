<?php
	$config['site']='http://placeto.blahertech.net'; //url of domain, no directory
	$config['directory']='/beta'; //entire url directory of placement, no ending '/'

	$database['type']='mysql'; //database type: mysql, oci (Oracle), sqlite, pgsql (PostgreSQL), informix
	$database['host']='localhost'; //server location, most likely 'localhost'
	$database['user']='blaherte_placeto'; //the user name you login with
	$database['pass']='90marcusofotecalp09'; //the password
	$database['dbname']='blaherte_plbeta'; //the database that placeto goes in
	$database['prefix']='placeto_'; //the table prefixes

	$config['encoding']='utf-8'; //the encoding type
	$config['mimetype']='text/html'; //your mime-type and encoding string
?>