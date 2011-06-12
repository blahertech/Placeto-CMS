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
	*	@version 1.1.0
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
	* The abstraction for any admin set info, can be pulled from here.
	*
	* @version 2.0
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*
	* @param PPDO $db The PDO handler.
	*/
	class placeto_Preferences
	{
		private $preferences, $connection;

		public function __construct(PPDO &$objConnection)
		{
			$this->connection=$objConnection;
			$pdoPreferences=$this->connection->prepare
			(
				'SELECT p.*
					FROM tblPreferences AS p
				;'
			);
			$pdoPreferences->execute();

			while ($aryPreference=$pdoPreferences->fetch())
			{
				$this->preferences[$aryPreference['Variable']]
					=$aryPreference['Value'];
			}

			$pdoPreferences->closeCursor();
			unset($pdoPreferences);
		}
		public function get()
		{
			return $this->preferences;
		}
		public function name()
		{
			return $this->preferences['Name'];
		}
		public function owner()
		{
			return $this->preferences['Owner'];
		}
		public function copyright()
		{
			return $this->preferences['Copyright'];
		}
		public function email()
		{
			return $this->preferences['Email'];
		}
		public function template()
		{
			return $this->preferences['Template'];
		}
	}
?>