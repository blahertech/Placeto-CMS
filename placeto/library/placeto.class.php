<?php
	/**
	*	Placeto CMS
	*		A lightweight, easy to use PHP content management system. Written to be as fast as possible and to use as little memory as possible. Placeto provides browser caching, server caching, deflating and gzip compression if necessary to cut down on bandwidth and cpu time.
	*
	*	Copyright (C) 2009-2010 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto/
	**/

	require_once($base.'placeto/library/placeto/configuration.class.php');
	require_once($base.'placeto/library/placeto/database.class.php');
	require_once($base.'placeto/library/placeto/preferences.class.php');
	require_once($base.'placeto/library/placeto/content.class.php');
	require_once($base.'placeto/library/placeto/security.class.php');

	class placeto
	{
		public $config, $database, $preferences, $content, $security;

		public function __construct($db=false, $cfg=false, $location=false)
		{
			$this->config=new placeto_config($this->cfg, $this->location);
			$this->database=new placeto_database($this->db);
			unset($cfg, $db, $location);

			$this->preferences=new placeto_preferences($this->database);
			$this->content=new placeto_content($this->database, $this->config->location());
			$this->security=new placeto_security();
		}
		public function preferences()
		{
			return $this->preferences-get();
		}
		public function content()
		{
			return $this->content->get();
		}
	}
?>
