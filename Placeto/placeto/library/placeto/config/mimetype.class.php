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

   /**
	* The MIME-type class, used in the configuration class.
	*
	* @version 2.2
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*
	* @param string $strMIME The mime-type.
	*/
	class placeto_config_MIMEtype
	{
		private $mimetype;

	   /**
		* The placeto_config_MIMEtype class constructor.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @param string $strMIME The mime-type.
		*/
		public function __construct(&$strMIME)
		{
			$this->mimetype=&$strMIME;
		}

	   /**
		* Get the MIME-type.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return string The MIME-type.
		*/
		public function get()
		{
			return $this->mimetype;
		}

	   /**
		* Set the MIME-type.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return bool If successful.
		*/
		public function set($strMIME)
		{
			if (gettype($strMIME)==='string' && $this->mimetype=&$strMIME)
			{
				unset($strMIME);
				return true;
			}
			else
			{
				unset($strMIME);
				return false;
			}
		}
	}
?>
