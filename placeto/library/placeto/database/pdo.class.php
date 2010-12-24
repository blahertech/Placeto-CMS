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

   /**
	* The extended PDO class, we use in Placeto. Comes with added and simpler
    * functionallity.
	*
	* @version 1.0
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*/
	class placeto_PDO extends PDO
	{
		public $sql_find, $sql_replace;

$sql_find=array
(
'~(FROM\s+)~',
'~(INTO\s+)~',
'~(JOIN\s+)~',
'~(UPDATE\s+)~',
'~(CREATE TABLE\s+)~'
);

$sql_replace=array
(
'$1'.$prefix,
'$1'.$prefix,
'$1'.$prefix,
'$1'.$prefix,
'$1'.$prefix
);
		function prepare($strQuery)
		{
			parent::prepare($strQuery);
		}
		function prepare($strQuery, $driver_options=NULL)
		{
			parent::prepare($strQuery, $driver_options);
		}
	}
?>
