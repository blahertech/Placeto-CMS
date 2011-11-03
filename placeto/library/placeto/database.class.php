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

	//TODO: extend private PDO class to handle prefixes

   /**
	* Here we provide you with an extended PDO connection handeler, fit to be
    * used on Placeto. We provide support for several database types and take
    * care of any user set properties.
	*
	* @version 2.3
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*
	* @param array $aryDatabase The database configuration array.
	*/
	class placeto_Database
	{
		public $connection;
		private $database;

		public function __construct($aryDatabase)
		{
			if (!$aryDatabase) // in case the developer didn't use the class correctly
			{
				global $database;
				$this->database=$database;
			}
			else
			{
				$this->database=$aryDatabase;
			}
			unset($aryDatabase);

			try
			{
				/*if (strtolower($this->database['type'])==='oci') // Oracle
				{
					$this->connection=new PPDO
					(
						'oci:',
						$this->database['user'],
						$this->database['pass'],
						NULL,
						$this->database['prefix']
					);
				}
				elseif (strtolower($this->database['type'])==='informix')
				{
					$this->connection=new PPDO
					(
						'informix:DSN='.$this->database['dbname'],
						$this->database['user'],
						$this->database['pass'],
						NULL,
						$this->database['prefix']
					);
				}
				elseif (strtolower($this->database['type'])==='pgsql')
				{
					$this->connection=new PPDO
					(
						'pgsql:host='.$this->database['host']
							.';dbname='.$this->database['dbname'],
						$this->database['user'],
						$this->database['pass'],
						NULL,
						$this->database['prefix']
					);
				}
				elseif (strtolower($this->database['type'])==='sqlite')
				{
					$this->connection=new PPDO
					(
						'sqlite:'.$this->database['host'],
						NULL,
						NULL,
						NULL,
						$this->database['prefix']
					);
				}
				elseif (strtolower($this->database['type'])==='mssql')
				{
					$this->connection=new PPDO
					(
						'mssql:'.$this->database['host']
							.';dbname='.$this->database['dbname'],
						$this->database['user'],
						$this->database['pass'],
						NULL,
						$this->database['prefix']
					);
				}
				else // MySQL by default
				{*/
					$this->connection=new PPDO
					(
						'mysql:host='.$this->database['host']
							.';dbname='.$this->database['dbname'],
						$this->database['user'],
						$this->database['pass'],
						NULL,
						$this->database['prefix']
					);
				//}
			}
			catch (PDOException $objException)
			{
				die('Failed to connect to the database!');
			}
		}

		public function prefix()
		{
			return $this->database['prefix'];
		}

		private function buildRecursive(&$aryTables, $strTable, $intParent=0)
		{
			$intTable=array_push
			(
				$aryTables, array('table'=>$strTable, 'parent'=>$intParent)
			);
			$intTable--;

			$pdoDescribe=$this->connection->prepare
			(
				'DESCRIBE tbl'.$strTable.';'
			);
			$pdoDescribe->execute();
			$aryDesribe=$pdoDescribe->fetchAll();
			$pdoDescribe->closeCursor();
			unset($pdoDescribe);

			foreach ($aryDesribe as $aryColumn)
			{
				$intIdPos=strlen($aryColumn['Field'])-2;
				if
				(
					substr($aryColumn['Field'], $intIdPos)=='ID'
					&& $aryColumn['Field']!='ID'
				)
				{
					$this->buildRecursive
					(
						$aryTables,
						substr($aryColumn['Field'], 0, $intIdPos),
						$intTable
					);
				}
			}

			if ($intParent==0)
			{
				return $aryTables;
			}
		}

		public function build($strTable, $intID=false)
		{
			$aryTables=array();
			$strTable=substr($strTable, 3);
			$aryTables=$this->buildRecursive($aryTables, $strTable);

			$strJoins='';
			foreach ($aryTables as $key=>$aryTable)
			{
				if ($key)
				{
					$strJoins.=' LEFT JOIN tbl'.$aryTable['table']
						.' ON tbl'.$aryTable['table'].'.ID'
						.'=tbl'.$aryTables[$aryTable['parent']]['table'].'.ID'
						."\n";
				}
			}

			if ($intID || $intID===0)
			{
				$this->connection->prepare
				(
					'SELECT *
						FROM tbl'.$strTable.'
						'.$strJoins.'
						LIMIT 1
					;'
				);
			}
			else
			{

			}

			echo $strJoins;
		}

		//we want to force the token idea, to stop XSS hacking.

		//$intID insert($intToken, $strTable, $aryData)
		//$bolSuccess update($intToken, $strTable, $intID, $aryData)
		//$bolSuccess updateMultiple($intToken, $strTable, $aryIDs, $aryData)
		//$bolSuccess remove($intToken, $strTable, $intID)
		//token [token->start]
		//$intToken token->start()
		//$bolSuccess token->end()
	}
?>
