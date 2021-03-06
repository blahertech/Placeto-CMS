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
	*	@version 1.0.3
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

	require_once('config/encoding.class.php');
	require_once('config/mimetype.class.php');

   /**
	* The main configuration class, that builds off of the childern. Here you
    * can find anything put in the user selected config file.
	*
	* @version 1.4
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*
	* @param array $aryConfig The general configuration array.
	* @param string $strLocation OPTIONAL:Modified $_GET['url'] set bt HTaccess.
	*/
	class placeto_Config
	{
		private $config, $location, $path;
		public $encoding, $MIMEtype;

	   /**
		* The placeto_Config class constructor.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @param array $aryConfig The general configuration array.
		* @param string $strLocation OPTIONAL: Modified $_GET['url'].
	    * @param placeto_Security $security the security object
		*/
		public function __construct
		(
			$aryConfig=false, $strLocation=false, &$objSecurity=false
		)
		{
			if (!$objSecurity)
			{
				$objMud=new Mud();
				$objSecurity=&$objMud->security;
			}
			
			// in case the developer didn't use the class correctly
			if (!$aryConfig)
			{
				global $BASE, $CONFIG, $CONFIG_NAME, $DATABASE;
				if (!$aryConfig['base']) // oh my, what a mess to clean up
				{
					if (!$BASE) // just more and more dirt
					{
						$BASE='./';
					}
					$this->config['base']=$BASE;
				}
				if (!$CONFIG) // developer really dosn't know what they're doing
				{
					if (!$CONFIG_NAME) // please, read the documentation
					{
						// we're in a big mess if this doesn't work
						$CONFIG_NAME='default.config.php';
					}
					require_once
					(
						$this->config['base'].'placeto/config/'.$CONFIG_NAME
					);
					// doesn't belong here, but only way to save this mess
					$GLOBALS['database']=$DATABASE;
				}

				$this->config=$CONFIG;
				unset($CONFIG, $CONFIG_NAME, $BASE, $DATABASE);
			}
			else
			{
				$this->config=$aryConfig;
			}
			unset($aryConfig);

			// make sure they didn't put a '/' on the end of the domain
			if (substr(strrev($this->config['site']), 0, 1)==='/')
			{
				$this->config['site']=substr
				(
					$this->config['directory'],
					0,
					strlen($this->config['directory'])-1
				);
			}
			
			// let's make sure the url is correctly entered
			if
			(
				substr($this->config['site'], 0, 7)!=='http://'
				&& substr($this->config['site'], 0, 7)!=='https://'
			)
			{
				if ($_SERVER['SERVER_PORT']==443 || $_SERVER['HTTPS'])
				{
					$this->config['site']='https://'.$this->config['site'];
				}
				else
				{
					$this->config['site']='http://'.$this->config['site'];
				}
			}

			// validate the url, if it's not right, grab it
			$strRegEx="#((http|https)://(\S*?\.\S*?))(\s|\;|\)|\]|\[|\{|\}|,|\"|'|:|\<|$|\.\s)#ie";
			if (!preg_match($strRegEx, $this->config['site']))
			{
				if ($_SERVER['SERVER_PORT']==80)
				{
					$this->config['site']='http://'.$_SERVER['SERVER_NAME'];
				}
				elseif ($_SERVER['SERVER_PORT']==443 || $_SERVER['HTTPS'])
				{
					$this->config['site']='https://'.$_SERVER['SERVER_NAME'];
				}
				else
				{
					$this->config['site']='http://'.$_SERVER['SERVER_NAME']
						.':'.$_SERVER['SERVER_PORT'];
				}
				unset($strDomain);
			}
			unset($strRegEx);

			// make sure there is a directory
			if
			(
				!isset($this->config['directory'])
				|| $this->config['directory']==''
			)
			{
				$this->config['directory']=substr
				(
					$_SERVER['REQUEST_URI'],
					0,
					strlen($_SERVER['REQUEST_URI'])
						-strlen($objSecurity->gets['uri'])
				);
			}

			// make sure they didn't put a '/' on the end of the directory
			if
			(
				substr(strrev($this->config['directory']), 0, 1)==='/'
				&& $this->config['directory']!=='/'
			)
			{
				$this->config['directory']=substr
				(
					$this->config['directory'],
					0,
					strlen($this->config['directory'])-1
				);
			}

			// since that mess is out of the way, let's get back to work
			if (!$strLocation) // optional param
			{
				if (isset($objSecurity->gets['uri']))
				{
					$this->location='/'.$objSecurity->gets['uri'];
				}
				else
				{
					$this->location=$_SERVER['PHP_SELF'];
				}
			}
			else
			{
				$this->location=$strLocation;
			}
			unset($strLocation);

			// for those who are trying to view your config, damn them
			while (stristr($this->location, '../'))
			{
				$this->location=str_replace('../', '/', $this->location);
			}
			while (stristr($this->location, './'))
			{
				$this->location=str_replace('./', '/', $this->location);
			}
			while (stristr($this->location, '//'))
			{
				$this->location=str_replace('//', '/', $this->location);
			}

			// used for later (e.g. in reattach)
			$this->path=$this->location;

			// checks to make sure that $location didn't go wacky
			$this->location=str_replace('index.php', '', $this->location);
			if
			(
				(
					$this->directory()!=='/'
					|| $this->directory()==NULL
				)
				&& $this->directory()===substr
				(
					$this->location, 0, strlen($this->directory())
				)
			)
			{
				$this->location=substr
				(
					$this->location,
					strlen($this->directory()),
					strlen($this->location)
				);
			}
			if
			(
				substr($this->location, strlen($this->location)-1)==='/'
				&& strlen($this->location)!==1
			)
			{
				$this->location=substr
				(
					$this->location, 0, strlen($this->location)-1
				);
			}

			$this->encoding=new placeto_config_Encoding
			(
				$this->config['encoding']
			);
			$this->MIMEtype=new placeto_config_MIMEtype
			(
				$this->config['mimetype']
			);
		}

	   /**
		* Returned base.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return string The base that leads to where the initial file was at.
		*/
		public function base()
		{
			return $this->config['base'];
		}

	   /**
		* Returned URL.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return string The URL of the website.
		*/
		public function site()
		{
			return $this->config['site'];
		}

	   /**
		* Returned directory.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return string The current directory that the CMS is located.
		*/
		public function directory()
		{
			return $this->config['directory'];
		}

	   /**
		* Returned location.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return string The set URI.
		*/
		public function location()
		{
			return $this->location;
		}

	   /**
		* Returned path.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return string The orginal path.
		*/
		public function path()
		{
			return $this->path;
		}

	   /**
		* Returned encoding.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return string The site encoding.
		*/
		public function encoding()
		{
			return $this->encoding->get();
		}

	   /**
		* Returned MIME-type.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return string The MIME-type.
		*/
		public function MIMEtype()
		{
			return $this->MIMEtype->get();
		}
	}
?>