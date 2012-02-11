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
	*	@version 1.1.1
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

			return true;
		}
	}
	class placeto_content_Dependent
	{
		private $dependent, $dependentParam, $param;

		public function __construct(&$bolDependent, &$strParam)
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
	* @version 1.3
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*
	* @param PPDO $objDatabase The PDO handler.
	* @param string $strLocation OPTIONAL:Modified $_GET['url'] set bt HTaccess.
	*/
	class placeto_Content
	{
		private $content, $connection, $preferences;
		public $found, $main, $dependent;

		public function fetch($strLocation)
		{
			$pdoNode=$this->connection->prepare
			(
				'SELECT n.ID, n.ModuleID, n.PrimaryKey, n.ParentID,
						n.Address, n.RedirectURL,
						m.Module, m.Table
					FROM tblNodes AS n
					JOIN tblModules AS m
						ON m.ID=n.ModuleID
					WHERE n.Address=:Address
						AND m.Enabled=\'true\'
						AND m.Type=\'Node\'
					LIMIT 1
				;'
			);
			$pdoNode->execute(array(':Address'=>$strLocation));
			$aryNode=$pdoNode->fetch(PDO::FETCH_ASSOC);
			$pdoNode->closeCursor();
			unset($pdoNode);

			$pdoContent=$this->connection->prepare
			(
				'SELECT c.ID AS '.$aryNode['Module'].'ID, c.*
					FROM '.$aryNode['Table'].' AS c
					WHERE c.ID=:PrimaryKey
					LIMIT 1
				;'
			);
			$pdoContent->execute
			(
				array(':PrimaryKey'=>$aryNode['PrimaryKey'])
			);
			$aryContent=$pdoContent->fetch(PDO::FETCH_ASSOC);
			$pdoContent->closeCursor();
			unset($pdoContent);

			unset($aryContent['ID']);
			if (is_array($aryContent) && is_array($aryNode))
			{
				$aryContent=array_merge($aryContent, $aryNode);
			}
			else
			{
				$aryContent=false;
			}
			unset($aryNode);

			$pdoKeywords=$this->connection->prepare
			(
				'SELECT k.Keyword
					FROM tblNodesKeywords AS nk
					JOIN tblKeywords AS k
						ON k.ID=nk.KeywordID
					WHERE nk.NodeID=:NodeID
					GROUP BY k.Keyword
					ORDER BY nk.Position, nk.KeywordID
				;'
			);
			$pdoKeywords->execute(array(':NodeID'=>$aryContent['ID']));
			$aryKeywords=$pdoKeywords->fetchAll(PDO::FETCH_ASSOC);
			foreach ($aryKeywords as $aryKeyword)
			{
				$aryContent['Keywords'][]=$aryKeyword['Keyword'];
			}
			$pdoKeywords->closeCursor();
			unset($pdoKeywords, $aryKeywords, $aryKeyword);

			return $aryContent;
		}

		public function __construct
		(
			PPDO &$objConnection, &$strLocation, &$aryPreferences=NULL
		)
		{
			$this->connection=&$objConnection;
			if (isset($aryPreferences))
			{
				$this->preferences=$aryPreferences->get();
			}
			$this->found=true;

			$this->content=false;
			if (function_exists('apc_fetch'))
			{
				$this->content=apc_fetch($strLocation);
				if ($this->content['Dynamic']==true)
				{
					$this->content=false;
				}
			}

			if ($this->content===false)
			{
				$this->content=$this->fetch($strLocation);
				if (function_exists('apc_fetch'))
				{
					if (!isset($this->preferences['MemoryCache']))
					{
						$this->preferences['MemoryCache']=15;
					}
					apc_store
					(
						$strLocation,
						$this->content,
						$this->preferences['MemoryCache']*60
					);
				}
			}

			if (!$this->content)
			{
				$this->content=$this->fetch('/error');
				$this->found=false;
			}
			if (!$this->content['TemplateFile'])
			{
				$this->content['TemplateFile']='index.php';
			}

			if (!$this->content['Content'])
			{
				$this->content['Content']='';
			}
			$this->main=new placeto_content_Main($this->content['Content']);
			$this->dependent=new placeto_content_Dependent
			(
				$this->content['Dependent'], $this->content['DependentParam']
			);
		}

		public function template()
		{
			return $this->content['TemplateFile'];
		}

		public function title()
		{
			return $this->content['Title'];
		}

		public function keywords()
		{
			return $this->content['Keywords'];
		}

		public function description()
		{
			return $this->content['Description'];
		}
		
		public function created()
		{
			return $this->content['DateCreated'];
		}

		public function modified()
		{
			return $this->content['DateModified'];
		}

		public function header()
		{
			return $this->content['Header'];
		}
	}
?>