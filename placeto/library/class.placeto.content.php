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

	class placeto_content_site
	{
		function __construct(&$site)
		{

		}
		function get()
		{

		}
		function set($setTo)
		{

		}
	}
	class placeto_content_canonical
	{
		function __construct(&$canonical)
		{

		}
		function get()
		{

		}
		function set($setTo)
		{

		}
	}
	class placeto_content_main
	{
		function __construct(&$main)
		{

		}
		function get()
		{

		}
		function set($setTo)
		{

		}
	}
	class placeto_content_copyright
	{
		function __construct(&$copyright)
		{

		}
		function get()
		{

		}
		function set($setTo)
		{

		}
	}
	class placeto_content
	{
		private $content;

		function __construct(&$db, &$location)
		{
			$query=$db->connection->prepare('SELECT * FROM '.$db->prefix().'content WHERE page="'.$location.'" LIMIT 1');
			$query->execute();
			$this->content=$query->fetch(PDO::FETCH_ASSOC);

			$this->site=new placeto_content_site($this->content['site']);
			$this->canonical=new placeto_content_canonical($this->content['canonical']);
			$this->main=new placeto_content_main($this->content['main']);
			$this->copyright=new placeto_content_copyright($this->content['copyright']);
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
			return $this->site-get();
		}
		function canonical()
		{
			return $this->canonical-get();
		}
		function main()
		{
			return $this->main-get();
		}
		function copyright()
		{
			return $this->copyright-get();
		}
	}
?>