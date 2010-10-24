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
	
	class placeto_config_encoding
	{
		private $encoding;

		function __construct(&$enc)
		{
			$this->encoding=&$enc;
		}
		function get()
		{
			return $this->encoding;
		}
		function set($setTo)
		{
			$this->encoding=$setTo;
		}
	}
	class placeto_config_MIMEtype
	{
		private $mimetype;

		function __construct(&$mime)
		{
			$this->mimetype=&$mime;
		}
		function get()
		{
			return $this->mimetype;
		}
		function set($setTo)
		{
			$this->mimetype=$setTo;
		}
	}
	class placeto_config
	{
		private $config;

		function __construct($cfg)
		{
			if (!$cfg) //in the case the developer didn't use the class correctly
			{
				global $base, $config, $config_name;
				if (!isset($cfg['base']) || $cfg['base']=='') //oh my, what a mess to clean up
				{
					if (!isset($base) || $base=='') //just more and more dirt
					{
						$base='./';
					}
					$this->config['base']=$base;
				}
				if (!isset($config) || $config=='') //the developer really dosn't know what they're doing
				{
					if (!isset($config_name) || $config_name=='') //please, read the documentation
					{
						$config_name='default.config.php'; //we're in a big mess if this doesn't work
					}
					require_once($this->config['base'].'placeto/config/'.$config_name);
					$GLOBALS['database']=$database; //doesn't belong here, but it's the only way to save this mess
				}

				$this->config=$config;
			}
			else
			{
				$this->config=$cfg;
			}

			$this->encoding=new placeto_config_encoding($this->config['encoding']);
			$this->MIMEtype=new placeto_config_MIMEtype($this->config['mimetype']);
		}
		function base()
		{
			return $this->config['base'];
		}
		function site()
		{
			return $this->config['site'];
		}
		function directory()
		{
			return $this->config['directory'];
		}
		function encoding()
		{
			return $this->encoding->get();
		}
		function MIMEtype()
		{
			return $this->MIMEtype->get();
		}
	}
?>
