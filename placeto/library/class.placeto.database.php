<?php
	/**
	*	Placeto CMS
	*		A lightweight, easy to use PHP content management system. Written to be as fast as possible and to use as little memory as possible. Placeto provides browser caching, server caching, deflating and gzip compression if necessary to cut down on bandwidth and cpu time.
	*
	*	Copyright (C) 2009-2010 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto/
	**/

	class placeto_database
	{
		public $connection;
		private $database;

		function __construct($db)
		{
			if (!$db) //in the case the developer didn't use the class correctly
			{
				global $database;
				$this->database=$database;
			}
			else
			{
				$this->database=$db;
			}

			try
			{
				if ($this->database['type']=='oci') //Oracle
				{
					$this->connection=new PDO('oci:', $this->database['user'], $this->database['pass']);
				}
				elseif ($this->database['type']=='informix')
				{
					$this->connection=new PDO('informix:DSN='.$this->database['dbname'], $this->database['user'], $this->database['pass']);
				}
				elseif ($this->database['type']=='pgsql') //PostgreSQL
				{
					$this->connection=new PDO('pgsql:host='.$this->database['host'].';dbname='.$this->database['dbname'], $this->database['user'], $this->database['pass']);
				}
				elseif ($this->database['type']=='sqlite')
				{
					$this->connection=new PDO('sqlite:'.$this->database['host']);
				}
				else //mySQL by default
				{
					$this->connection=new PDO('mysql:host='.$this->database['host'].';dbname='.$this->database['dbname'], $this->database['user'], $this->database['pass']);
				}
			}
			catch (PDOException $e)
			{
				die('Database failed to connect, please contact the website webmaster.');
			}
		}

		function prefix()
		{
			return $this->database['prefix'];
		}
	}
?>
