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

	//TODO: Tags in seperate table

	class placeto_content_dependent_param
	{
		private $param;

		public function __construct(&$param)
		{
			$this->param=&$param;
		}
		public function get()
		{
			return $this->param;
		}
		public function set($setTo)
		{
			$this->param=$setTo;
			unset($setTo);
		}
	}
	class placeto_content_dependent
	{
		private $dependent, $dependentparam, $param;

		public function __construct(&$dependent, &$param)
		{
			$this->dependent=&$dependent;
			$this->dependentparam=&$param;
			$this->param=new placeto_content_dependent_param($this->dependentparam);
		}
		public function param()
		{
			return $this->dependentparam;
		}
		public function get()
		{
			return $this->dependent;
		}
		public function set($setTo)
		{
			$this->dependent=$setTo;
			unset($setTo);
		}
	}
	class placeto_content_main
	{
		private $main;

		public function __construct(&$main)
		{
			$this->main=&$main;
		}
		public function get()
		{
			return $this->main;
		}
		public function set($setTo)
		{
			$this->main=$setTo;
			unset($setTo);
		}
	}
	class placeto_content
	{
		private $content;
		public $found, $main, $dependent;

		public function __construct(&$db, &$location)
		{
			$this->found=true;
			$query=$db->connection->prepare('SELECT * FROM '.$db->prefix().'content WHERE page=:location LIMIT 1');
			$query->execute(array(':location'=>$location));
			$this->content=$query->fetch(PDO::FETCH_ASSOC);
			
			if (!$this->content)
			{
				$query=$db->connection->prepare('SELECT * FROM '.$db->prefix().'content WHERE page="/error" LIMIT 1');
				$query->execute();
				$this->content=$query->fetch(PDO::FETCH_ASSOC);
				$this->found=false;
			}
			if (!$this->content['template'])
			{
				$this->content['template']='index.php';
			}

			$query->closeCursor();
			unset($query);

			$this->main=new placeto_content_main($this->content['content']);
			$this->dependent=new placeto_content_dependent($this->content['dependent'], $this->content['dependentparam']);
		}
		public function get()
		{
			return $this->content;
		}
		public function set($setTo)
		{
			$this->content=$setTo;
		}
		public function page()
		{
			return $this->content['site'];
		}
		public function title()
		{
			return $this->content['title'];
		}
		public function description()
		{
			return $this->content['description'];
		}
		public function keywords()
		{
			return $this->content['keywords'];
		}
		public function header()
		{
			return $this->content['header'];
		}
		public function main()
		{
			return $this->main->get();
		}
		public function modified()
		{
			return $this->content['lastmod'];
		}
		public function dependent()
		{
			return $this->dependent->get();
		}
		public function dynamic()
		{
			return $this->content['dynamic'];
		}
		public function template()
		{
			return $this->content['template'];
		}
	}
?>