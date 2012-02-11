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
	* The encoding class, used in the config class.
	*
	* @version 2.2
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*
	* @param string $strMIME The mime-type.
	*/
	class placeto_config_Encoding
	{
		private $encoding;

	   /**
		* The placeto_config_Encoding class constructor.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @param string $strEncoding The encoding.
		*/
		public function __construct(&$strEncoding)
		{
			$this->encoding=&$strEncoding;
		}

	   /**
		* Get the encoding.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return string The encoding.
		*/
		public function get()
		{
			return $this->encoding;
		}

	   /**
		* Set the encoding.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return bool If sucessful.
		*/
		public function set($strEncoding)
		{
			if
			(
				gettype($strEncoding)==='string'
				&& $this->encoding=&$strEncoding
			)
			{
				unset($strEncoding);
				return true;
			}
			else
			{
				unset($strEncoding);
				return false;
			}
		}
	}
?>
