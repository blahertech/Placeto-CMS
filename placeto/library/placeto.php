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

	require_once($base.'placeto/library/config.php');

			class placeto_database_connection
			{
				function __construct()
				{
					
				}
				function connect()
				{
					
				}
				function disconnect()
				{
					
				}
			}
			class placeto_database_database
			{
				function __construct()
				{
					
				}
				function get()
				{
					
				}
				function set($setTo)
				{
					
				}
				function select($selectTo)
				{
					
				}
			}
			class placeto_database_prefix
			{
				function __construct()
				{
					
				}
				function get()
				{
					
				}
				function set($setTo)
				{
					
				}
			}
			class placeto_database_dieMessage
			{
				function __construct()
				{
					
				}
				function get()
				{
					
				}
				function set($setTo)
				{
					
				}
			}
		class placeto_database
		{
			private $dbh;

			function __construct()
			{
				global $config;
				$this->database=$GLOBALS['database'];

				try
				{
					if ($this->database['type']=='oci') //Oracle
					{
						$this->dbh=new PDO('oci:', $this->database['user'], $this->database['pass']);
					}
					elseif ($this->database['type']=='informix')
					{
						$this->dbh=new PDO('informix:DSN='.$this->database['dbname'], $this->database['user'], $this->database['pass']);
					}
					elseif ($this->database['type']=='pgsql') //PostgreSQL
					{
						$this->dbh=new PDO('pgsql:host='.$this->database['host'].';dbname='.$this->database['dbname'], $this->database['user'], $this->database['pass']);
					}
					elseif ($this->database['type']=='sqlite')
					{
						$this->dbh=new PDO('sqlite:'.$this->database['host']);
					}
					else //mySQL by default
					{
						$this->dbh=new PDO('mysql:host='.$this->database['host'].';dbname='.$this->database['dbname'], $this->database['user'], $this->database['pass']);
					}
					$this->dbh->exec('SET CHARACTER SET '.$config['encoding']);
				}
				catch (PDOException $e)
				{
					die($e->getMessage());
				}

				$this->connection=new placeto_database_connection;
				$this->database=new placeto_database_database;
				$this->prefix=new placeto_database_prefix;
				$this->dieMessage=new placeto_database_dieMessage;

				unset($GLOBALS['database'], $GLOBALS['config']);
			}
			function server()
			{
				
			}
			function user()
			{
				
			}
			function password()
			{
				
			}
			function lock()
			{
				
			}
		}
		class placeto_preferences
		{
			function __construct()
			{
				
			}
			//not sure what's in here, yet
		}
		class placeto_location
		{
			function __construct()
			{
				
			}
		}
		class placeto_base
		{
			function __construct()
			{
				
			}
		}
			class placeto_content_site
			{
				function __construct()
				{
					
				}
				function get()
				{
					
				}
				function set($setTo)
				{
					
				}
			}
			class placeto_content_canonical
			{
				function __construct()
				{
					
				}
				function get()
				{
					
				}
				function set($setTo)
				{
					
				}
			}
			class placeto_content_content
			{
				function __construct()
				{
					
				}
				function get()
				{
					
				}
				function set($setTo)
				{
					
				}
			}
			class placeto_content_copyright
			{
				function __construct()
				{
					
				}
				function get()
				{
					
				}
				function set($setTo)
				{
					
				}
			}
		class placeto_content
		{
			function __construct()
			{
				$this->site=new placeto_content_site;
				$this->canonical=new placeto_content_canonical;
				$this->content=new placeto_content_content;
				$this->copyright=new placeto_content_copyright;
			}
			function get()
			{
			
			}
			function set()
			{
			
			}
			function site()
			{
			
			}
			function canonical()
			{
			
			}
			function copyright()
			{
			
			}
		}
	class placeto
	{
		function __construct()
		{
			$this->config=new placeto_config;
			$this->database=new placeto_database;
			$this->preferences=new placeto_preferences;
			$this->location=new placeto_location;
			$this->base=new placeto_base;
			$this->content=new placeto_content;
		}
		function location()
		{
			
		}
		function base()
		{
			
		}
		function content()
		{
			
		}
	}
?>
