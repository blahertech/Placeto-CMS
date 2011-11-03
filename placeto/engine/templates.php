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
	*	@copyright BlaherTech 2009-2011
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

	// engine security check
	if (TOKEN!=='30c42e373acf6f3322f72875e59e677d')
	{
		header('Location: ../../');
		die();
	}

	/*
	 *	We contain the templator in it's own function, becayse this changes the]
	 *	scope the away from the engine. It addes a slightly highten security,
	 *	plus it it helps relieve the designer from easily breaking something or
	 *	accessing something that they shouldn't be.
	 */
	function placeto_templator(P &$p, $strTemplatePath)
	{
		require_once($strTemplatePath);
	}

	include_once($placeto->config->base().'placeto/library/p.class.php');
	$p=new P($placeto);

	placeto_templator
	(
		$p,
		$placeto->config->base().'placeto/templates/'
			.$placeto->preferences->template()
			.'/'.$placeto->content->template()
	);
?>