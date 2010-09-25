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
	
	class placeto_config
	{
		global $base, $config_name;
		private $config, $sql_login;
		require($base.'placeto/config/'.$cfg);
		
		public function getSite()
		{
			return $config['site'];
		}
		public function getDirectory()
		{
			return $config['directory'];
		}
		public function getEncoding()
		{
			return $config['encode'];
		}
		public function getMIMEtype()
		{
			return $config['type'];
		}
		
		public function setSite($input)
		{
			$config['site']=$input;
		}
		public function setDirectory($input)
		{
			$config['directory']=$input;
		}
		public function setEncoding($input)
		{
			$config['encode']=$input;
		}
		public function setMIMEtype($input)
		{
			$config['type']=$input;
		}
		
		public function getServer()
		{
			return $sql_login['server'];
		}
		public function getDatabase()
		{
			return $sql_login['db'];
		}
		public function getUser()
		{
			return $sql_login['user'];
		}
		public function getPassword()
		{
			return $sql_login['pass'];
		}
		public function getPrefix()
		{
			return $sql_login['prefix'];
		}
		public function getDieMessage()
		{
			return $sql_login['die'];
		}
		
	}
	class placeto_config_lock extends placeto_config
	{
		private function getUser();
		private function getPassword();
	}
?>
