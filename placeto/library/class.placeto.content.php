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

	class placeto_content_dependent_param
	{
		function __construct(&$param)
		{
			$this->param=&$param;
		}
		function get()
		{
			return $this->param;
		}
		function set($setTo)
		{
			$this->param=$setTo;
		}
	}
	class placeto_content_dependent
	{
		function __construct(&$dependent, &$param)
		{
			$this->dependent=&$dependent;
			$this->dependentparam=&$param;
			$this->param=new placeto_content_dependent_param($this->dependentparam);
		}
		function param()
		{
			return $this->dependentparam;
		}
		function get()
		{
			return $this->dependent;
		}
		function set($setTo)
		{
			$this->dependent=$setTo;
		}
	}
	class placeto_content_main
	{
		function __construct(&$main)
		{
			$this->main=&$main;
		}
		function get()
		{
			return $this->main;
		}
		function set($setTo)
		{
			$this->main=$setTo;
		}
	}
	class placeto_content
	{
		private $content;
		public $found;

		function __construct(&$db, &$location)
		{
			$this->found=true;
			$query=$db->connection->prepare('SELECT * FROM '.$db->prefix().'content WHERE page="'.$location.'" LIMIT 1');
			$query->execute();
			$this->content=$query->fetch(PDO::FETCH_ASSOC);
			
			if (!$this->content)
			{
				$query=$db->connection->prepare('SELECT * FROM '.$db->prefix().'content WHERE page="/error" LIMIT 1');
				$query->execute();
				$this->content=$query->fetch(PDO::FETCH_ASSOC);
				$this->found=false;
			}
			if ($this->content['template']=='')
			{
				$this->content['template']=='index.php';
			}

			$this->main=new placeto_content_main($this->content['main']);
			$this->dependent=new placeto_content_dependent($this->content['dependent'], $this->content['dependentparam']);

		}
		function get()
		{
			return $this->content;
		}
		function set($setTo)
		{
			$this->content=$setTo;
		}
		function site()
		{
			return $this->content['site'];
		}
		function canonical()
		{
			return $this->content['canonical'];
		}
		function title()
		{
			return $this->content['title'];
		}
		function description()
		{
			return $this->content['description'];
		}
		function keywords()
		{
			return $this->content['keywords'];
		}
		function header()
		{
			return $this->content['header'];
		}
		function main()
		{
			return $this->main->get();
		}
		function copyright()
		{
			return $this->content['copyright'];
		}
		function lastmod()
		{
			return $this->content['lastmod'];
		}
		function dependent()
		{
			return $this->dependent->get();
		}
		function dynamic()
		{
			return $this->content['dynamic'];
		}
		function template()
		{
			return $this->content['template'];
		}
	}
?>