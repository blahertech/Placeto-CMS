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
	}
?>
