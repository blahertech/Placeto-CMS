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
	*	@version 1.0
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
	* ...
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
		* @version 1.0
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
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function name()
		{
			echo $this->placeto->preferences->name();
		}

	   /**
		* Website URL.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function website()
		{
			echo $this->placeto->config->site();
		}

	   /**
		* Current Directory.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function directory()
		{
			echo $this->placeto->config->directory();
		}

	   /**
		* Encoding type in config.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function encoding()
		{
			echo $this->placeto->config->encoding->get();
		}

	   /**
		* MIME-type in config.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function mime()
		{
			echo $this->placeto->config->MIMEtype->get();
		}

	   /**
		* The website owner's name.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function owner()
		{
			echo $this->placeto->preferences->owner();
		}

	   /**
		* The website admin's email.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function email()
		{
			echo $this->placeto->preferences->email();
		}

	   /**
		* Page META title.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function title()
		{
			echo $this->placeto->content->title();
		}

	   /**
		* Page META description.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function description()
		{
			echo $this->placeto->content->description();
		}

	   /**
		* Page META keywords.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function keywords()
		{
			echo $this->placeto->content->keywords();
		}

	   /**
		* The page header or H1.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function header()
		{
			echo $this->placeto->content->header();
		}

	   /**
		* The page's main content.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function content()
		{
			echo $this->placeto->content->main->get();
		}

	   /**
		* The timestamp when the page was last modified.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function modified()
		{
			echo $this->placeto->content->modified();
		}

	   /**
		* The copyright statement.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		* @access public
		*/
		public function copyright()
		{
			echo $this->placeto->preferences->copyright();
		}
	}
?>