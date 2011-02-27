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

	//TODO: Tags in seperate table

	class placeto_content_dependent_Param
	{
		private $param;

		public function __construct(&$strParam)
		{
			$this->param=&$strParam;
		}
		public function get()
		{
			return $this->param;
		}
		public function set($strParam)
		{
			$this->param=$strParam;
			unset($strParam);
		}
	}
	class placeto_content_Dependent
	{
		private $dependent, $dependentParam, $param;

		public function __construct(&$boolDependent, &$strParam)
		{
			$this->dependent=&$boolDependent;
			$this->dependentParam=&$strParam;
			$this->param=new placeto_content_dependent_Param
			(
				$this->dependentParam
			);
		}
		public function param()
		{
			return $this->dependentParam;
		}
		public function get()
		{
			return $this->dependent;
		}
		public function set($boolDependent)
		{
			$this->dependent=$boolDependent;
			unset($boolDependent);
		}
	}
	class placeto_content_Main
	{
		private $main;

		public function __construct(&$strContent)
		{
			$this->main=&$strContent;
		}
		public function get()
		{
			return $this->main;
		}
		public function set($strContent)
		{
			$this->main=$strContent;
			unset($strContent);
		}
	}

   /**
	* The main content abstraction layer. Here, all raw data is pulled from the
    * database, under any visitor page. You can also use this class to set or
    * modify any needed content.
	*
	* @version 1.2
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*
	* @param placeto_Database $objDatabase The PDO handler.
	* @param string $strLocation OPTIONAL:Modified $_GET['url'] set bt HTaccess.
	*/
	class placeto_Content
	{
		private $content;
		public $found, $main, $dependent;

		public function __construct
		(
			placeto_Database &$objDatabase, &$strLocation
		)
		{
			$this->found=true;
			$pdoContent=$objDatabase->connection->prepare
			(
				'SELECT c.*
					FROM tblContent
					WHERE c.Page=:Page
					LIMIT 1
				;'
			);
			$pdoContent->execute(array(':Page'=>$strLocation));
			$this->content=$pdoContent->fetch(PDO::FETCH_ASSOC);
			
			if (!$this->content)
			{
				$pdoContent->execute(array(':Page'=>'/error'));
				$this->content=$pdoContent->fetch(PDO::FETCH_ASSOC);
				$this->found=false;
			}
			if (!$this->content['template'])
			{
				$this->content['template']='index.php';
			}

			$pdoContent->closeCursor();
			unset($pdoContent);

			$this->main=new placeto_content_Main($this->content['content']);
			$this->dependent=new placeto_content_Dependent
			(
				$this->content['dependent'], $this->content['dependentparam']
			);
		}
	}
?>