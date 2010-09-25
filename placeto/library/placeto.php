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
	
			class placeto_config_site
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
			class placeto_config_directory
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
			class placeto_config_key
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
			class placeto_config_encoding
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
			class placeto_config_MIMEtype
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
		class placeto_config
		{
			$this->site=new placeto_config_site;
			$this->directory=new placeto_config_directory;
			$this->key=new placeto_config_key;
			$this->encoding=new placeto_config_encoding;
			$this->MIMEtype=new placeto_config_MIMEtype;
		}
			class placeto_mySQL_connection
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
			class placeto_mySQL_database
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
			class placeto_mySQL_prefix
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
			class placeto_mySQL_dieMessage
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
		class placeto_mySQL
		{
			$this->connection=new placeto_mySQL_connection;
			$this->database=new placeto_mySQL_database;
			$this->prefix=new placeto_mySQL_prefix;
			$this->dieMessage=new placeto_mySQL_dieMessage;
		}
		class placeto_preferences
		{
			//not sure what's in here, yet
		}
		class placeto_location
		{
			
		}
		class placeto_base
		{
			
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
			$this->site=new placeto_content_site;
			$this->canonical=new placeto_content_canonical;
			$this->content=new placeto_content_content;
			$this->copyright=new placeto_content_copyright;
		}
	class placeto
	{
		$this->config=new placeto_config;
		$this->mySQL=new placeto_mySQL;
		$this->preferences=new placeto_preferences;
		$this->location=new placeto_location;
		$this->base=new placeto_base;
		$this->content=new placeto_content
	}
	$placeto=new placeto;
?>
