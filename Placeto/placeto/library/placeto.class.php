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
	*	@version 1.1.2
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

	require_once('mud.class.php');
	require_once('ppdo.class.php');
	require_once('borrow.class.php');

	require_once('placeto/config.class.php');
	require_once('placeto/database.class.php');
	require_once('placeto/preferences.class.php');
	require_once('placeto/content.class.php');

   /**
	* The main abstraction class to be used during the programming side
	* of Placeto CMS. Includes everything, from PDO access, content, user set
	* preferences and secured global variables.
	*
	* @version 2.3
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*
	* @param array $aryDatabase The database configuration array.
	* @param array $aryConfig The general configuration array.
	* @param string $strLocation OPTIONAL:Modified $_GET['url'] set bt HTaccess.
	*/
	class Placeto
	{
		public $mud, $burrow;
		//TODO: use _server path instead of base
		public $config, $database, $preferences, $content;

	   /**
		* The Placeto class constructor.
		*
		* @version 1.3
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @param array $aryDatabase The database configuration array.
		* @param array $aryConfig The general configuration array.
		* @param string $strLocation OPTIONAL: Modified $_GET['url'].
		*/
		public function __construct
		(
			$aryDatabase=false, $aryConfig=false, $strLocation=false
		)
		{
			$this->mud=new Mud();
			$this->burrow=new Burrow();

			$this->config=new placeto_Config
			(
				$aryConfig, $strLocation, $mud->security
			);
			$this->database=new placeto_Database($aryDatabase);
			unset($aryConfig, $aryDatabase, $strLocation);

			$this->preferences=new placeto_Preferences($this->database->connection);
			$this->content=new placeto_Content
			(
				$this->database->connection,
				$this->config->location(),
				$this->preferences
			);
		}

	   /**
		* Returned preferences.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return array Array of all user set preferences.
		*/
		public function preferences()
		{
			return $this->preferences->get();
		}

	   /**
		* Returned content.
		*
		* @version 1.0
		* @author Benjamin Jay Young <blaher@blahertech.org>
		*
		* @access public
		* @return array Array of all page content.
		*/
		public function content()
		{
			return $this->content->get();
		}
	}
?>