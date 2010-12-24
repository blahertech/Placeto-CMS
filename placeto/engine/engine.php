<?php
   /**
	*	Placeto CMS.
	*		A lightweight, easy to use PHP content management system. Written
	*		to be as fast as possible and to use as little memory as possible.
	*		Placeto provides browser caching, server caching, deflating, and
	*		gzip compression, if necessary to cut down on bandwidth and cpu
	*		usage.
	*
	*	Engine.
	*		The engine is what handles the requested content and generates
	*		everything on demand, manipulating what needs to be where and what
	*		is provided, based on what is in the database, template, and
	*		modules.
	*
	*	@package placeto
	*	@subpackage engine
	*	@version 1.0.5
	*
	*	@author Benjamin Jay Young <blaher@blahertech.org>
	*	@link http://www.blahertech.org/projects/placeto/ Placeto CMS
	*	@link http://www.blahertech.org/ BlaherTech.org
	*	@license http://www.gnu.org/licenses/gpl.html GPL v3
	*	@copyright BlaherTech 2009-2010
	*
	*	This program is free software: you can redistribute it and/or modify it
	*	under the terms of the GNU General Public License as published by the
	*	Free Software Foundation, either version 3 of the License, or (at your
	*	option) any later version. This program is distributed in the hope that
	*	it will be useful,  but WITHOUT ANY WARRANTY; without even the implied
	*	warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See
	*	the GNU General Public License for more details. You should have
	*	received a copy of the GNU General Public License along with this
	*	program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*/

	// checks base
	if (!isset($base))
	{
		$base='./';
	}
	// multiple site support check
	if (!isset($config_name))
	{
		$config_name='default.config.php';
	}
	else
	{
		$config_name.='.php';
	}

	// make sure that config.php is ready or go to setup
	if (!file_exists($base.'placeto/config/'.$cfg))
	{
		header('Location: '.$base.'placeto/setup');
		die();
	}
	
	require_once($base.'placeto/config/'.$config_name);
	require_once($base.'placeto/library/placeto.class.php');
	require_once($base.'placeto/library/common.php');
	$config['base']=$base;
	$placeto=new Placeto($database, $config);

	unset($config, $config_name, $database, $base, $location);

	if (isset($dependent))
	{
		$placeto->content->dependent->set($dependent);
		unset($dependent);
	}

	//include_once($placeto->config->base().'placeto/engine/modules.php');
	
	/* // */if ($_GET['vars']=='true') {var_dump(get_defined_vars());}

	if (!$placeto->content->found)
	{
		// used for files in the template
		require($placeto->config->base().'placeto/engine/reattach.php');
	}
	else if
	(
		$placeto->content->dependent==='1'
		|| (
			$placeto->content->dependent==='2'
			&& isset($_GET[$placeto->content->dependent->param])
		)
	)
	{
		// independent pages in the db
		eval('?>'.$placeto->content->main);
		// placeto_mod_end();
	}
	else
	{
		// normal pages in the db
		header('Content-Type: '.$placeto->config->MIMEtype());
		// stop, template time
		include_once($placeto->config->base().'placeto/engine/templates.php');
		//placeto_mod_end();
	}

	// watch Asta swim away and await for his next request
	//include('cleanup.php');
	exit(0);
?>