<?php
   /**
	*	Placeto CMS.
	*		A lightweight, easy to use PHP content management system. Written
	*		to be as fast as possible and to use as little memory as possible.
	*		Placeto provides browser caching, server caching, deflating, and
	*		gzip compression, if necessary to cut down on bandwidth and cpu
	*		usage.
	*
	*	Accessor.
	*		The Accessor, p class, is an abstraction between the raw data and
	*		and the templates. It allows easy use for your designers to echo
	*		out the needed content they need.
	*
	*	@package placeto
	*	@subpackage accessor
	*	@version 1.3
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

   /**
	* The easy accessor class.
	*
	* @version 1.0
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*
	* @param Placeto $placeto Your built placeto object.
	*/
	class P
	{
		private $placeto;

	   /**
		* The p class constructor.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @param placeto $placeto Your built placeto object.
		*/
		public function __construct(&$placeto)
		{
			$this->placeto=&$placeto;
		}

	   /**
		* Website name in preferences.
		*
		* @version 1.2
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function site_name()
		{
			if ($this->placeto->preferences->name())
			{
				echo $this->placeto->preferences->name();
				return true;
			}
			return false;
		}

	   /**
		* Website URL.
		*
		* @version 1.2
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function site_url()
		{
			if ($this->placeto->config->site())
			{
				echo $this->placeto->config->site();
				return true;
			}
			return false;
		}

	   /**
		* Current Directory.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function directory()
		{
			if ($this->placeto->config->directory())
			{
				echo $this->placeto->config->directory();
				return true;
			}
			return false;
		}

	   /**
		* Encoding type in config.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function encoding()
		{
			if ($this->placeto->config->encoding->get())
			{
				echo $this->placeto->config->encoding->get();
				return true;
			}
			return false;
		}

	   /**
		* MIME-type in config.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function mime()
		{
			if ($this->placeto->config->MIMEtype->get())
			{
				echo $this->placeto->config->MIMEtype->get();
				return true;
			}
			return false;
		}

	   /**
		* The website owner's name.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function owner()
		{
			if ($this->placeto->preferences->owner())
			{
				echo $this->placeto->preferences->owner();
				return true;
			}
			return false;
		}

	   /**
		* The website admin's email.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function email()
		{
			if ($this->placeto->preferences->email())
			{
				echo $this->placeto->preferences->email();
				return true;
			}
			return false;
		}

	   /**
		* Page META title.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function title()
		{
			if ($this->placeto->content->title())
			{
				echo $this->placeto->content->title();
				return true;
			}
			return false;
		}

	   /**
		* Page META description.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function description()
		{
			if ($this->placeto->content->description())
			{
				echo $this->placeto->content->description();
				return true;
			}
			return false;
		}

	   /**
		* Page META keywords.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function keywords()
		{
			if ($this->placeto->content->keywords())
			{
				echo $this->placeto->content->keywords();
				return true;
			}
			return false;
		}

	   /**
		* The page header or H1.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function header()
		{
			if ($this->placeto->content->header())
			{
				echo $this->placeto->content->header();
				return true;
			}
			return false;
		}

	   /**
		* The page's main content.
		*
		* @version 1.2
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function content()
		{
			if ($this->placeto->content->main->get())
			{
				eval('?>'.$this->placeto->content->main->get());
				return true;
			}
			return false;
		}

	   /**
		* The timestamp when the page was last modified.
		*
		* @version 1.2
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function revised()
		{
			if ($this->placeto->content->modified())
			{
				echo $this->placeto->content->modified();
				return true;
			}
			return false;
		}

	   /**
		* The copyright statement.
		*
		* @version 1.1
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
	    * @return bool If exists and successful.
		*/
		public function copyright()
		{
			if ($this->placeto->preferences->copyright())
			{
				echo $this->placeto->preferences->copyright();
				return true;
			}
			return false;
		}
	}
?>