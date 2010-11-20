<?php
   /**
	*	Placeto CMS.
	*		A lightweight, easy to use PHP content management system. Written
	*		to be as fast as possible and to use as little memory as possible.
	*		Placeto provides browser caching, server caching, deflating, and
	*		gzip compression, if necessary to cut down on bandwidth and cpu
	*		usage.
	*
	*	Class.
	*		This is the main abstraction class to fetch all needed data, from
	*		the database and other data resources.
	*
	*	@package placeto
	*	@subpackage class
	*	@version 1.0.2
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
	
	class placeto_config_encoding
	{
		private $encoding;

		public function __construct(&$enc)
		{
			$this->encoding=&$enc;
		}
		public function get()
		{
			return $this->encoding;
		}
		public function set($setTo)
		{
			$this->encoding=$setTo;
			unset($setTo);
		}
	}
	class placeto_config_MIMEtype
	{
		private $mimetype;

		public function __construct(&$mime)
		{
			$this->mimetype=&$mime;
		}
		public function get()
		{
			return $this->mimetype;
		}
		public function set($setTo)
		{
			$this->mimetype=$setTo;
			unset($setTo);
		}
	}

   /**
	* The main config class, that builds off of the childern. Here you can find
    * anything put in the user selected config file.
	*
	* @version 1.4
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*
	* @param array $cfg The general configuration array.
	* @param string $location OPTIONAL:Modified $_GET['url'] set bt HTaccess.
	*/
	class placeto_config
	{
		private $config, $location, $path;
		public $encoding, $MIMEtype;

		public function base()
		{
			return $this->config['base'];
		}
		public function site()
		{
			return $this->config['site'];
		}
		public function directory()
		{
			return $this->config['directory'];
		}

		public function __construct($cfg, $location=false)
		{
			if (!$cfg) //in the case the developer didn't use the class correctly
			{
				global $base, $config, $config_name;
				if (!$cfg['base']) //oh my, what a mess to clean up
				{
					if (!$base) //just more and more dirt
					{
						$base='./';
					}
					$this->config['base']=$base;
				}
				if (!$config) //the developer really dosn't know what they're doing
				{
					if (!$config_name) //please, read the documentation
					{
						$config_name='default.config.php'; //we're in a big mess if this doesn't work
					}
					require_once($this->config['base'].'placeto/config/'.$config_name);
					$GLOBALS['database']=$database; //doesn't belong here, but it's the only way to save this mess
				}

				$this->config=$config;
				unset($config, $config_name, $base);
			}
			else
			{
				$this->config=$cfg;
			}
			unset($cfg);

			//now then, since that mess is out of the way, let's get back to work
			if (!$location) //optional param
			{
				global $_GET;

				if (isset($_GET['url']))
				{
					$this->location='/'.$_GET['url'];
				}
				else
				{
					global $_SERVER;
					$this->location=$_SERVER['PHP_SELF'];
				}
			}
			else
			{
				$this->location=$location;
			}
			unset($location);

			//for those who are trying to view your config or any other file, damn them
			while (stristr($this->location, '../'))
			{
				$this->location=str_replace('../', '', $this->location);
			}

			//used for later (e.g. in reattach)
			$this->path=$this->location;

			//checks to make sure that $location didn't go wacky
			$this->location=str_replace('index.php', '', $this->location);
			if (($this->directory()!=='/' || $this->directory()==NULL) && $this->directory()===substr($this->location, 0, strlen($this->directory())))
			{
				$this->location=substr($this->location, strlen($this->directory()), strlen($this->location));
			}
			if (substr($this->location, strlen($this->location)-1)==='/' && strlen($this->location)!==1)
			{
				$this->location=substr($this->location, 0, strlen($this->location)-1);
			}

			$this->encoding=new placeto_config_encoding($this->config['encoding']);
			$this->MIMEtype=new placeto_config_MIMEtype($this->config['mimetype']);
		}

		public function location()
		{
			return $this->location;
		}
		public function path()
		{
			return $this->path;
		}
		public function encoding()
		{
			return $this->encoding->get();
		}
		public function MIMEtype()
		{
			return $this->MIMEtype->get();
		}
	}
?>
