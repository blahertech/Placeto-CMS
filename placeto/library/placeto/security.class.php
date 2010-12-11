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
	* The security class is a toolkit for our developers, to ease the load of
    * checking every hole in their code. We provide you with not only member
    * functions, but secure any global variables that could contain harmful
    * information.
	*
	* @version 2.0
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*/
	class placeto_Security
	{
		public $gets, $posts, $sessions, $cookies;

		public function encrypt(&$string, &$key)
		{
			$result='';
			for($i=0; $i<strlen($string); $i++)
			{
				$char=substr($string, $i, 1);
				$keychar=substr($key, ($i % strlen($key))-1, 1);
				$char=chr(ord($char)+ord($keychar));
				$result.=$char;
			}

			unset($i, $char, $keychar);
			return base64_encode($result);
		}
		public function decrypt($string, &$key)
		{
			$result='';
			$string=base64_decode($string);

			for($i=0; $i<strlen($string); $i++)
			{
				$char=substr($string, $i, 1);
				$keychar=substr($key, ($i % strlen($key))-1, 1);
				$char=chr(ord($char)-ord($keychar));
				$result.=$char;
			}

			unset($i, $char, $keychar);
			return $result;
		}

		public function safe($input)
		{
			$input=str_replace('\r', '', $input);
			$input=str_replace('\n', '', $input);
			$input=str_replace('\t', '', $input);

			if (get_magic_quotes_gpc())
			{
				$input=stripslashes($input);
			}

			$input=htmlentities($input);
			$input=strip_tags($input);

			return $input;
		}
		public function safeHTML($input)
		{
			if (get_magic_quotes_gpc())
			{
				$input=stripslashes($input);
			}
			$input=htmlentities($input, ENT_QUOTES);

			return $input;
		}

		public function  __construct()
		{
			foreach ($_GET as $key=>$value)
			{
				$this->gets[$this->safe($key)]=$this->safe($value);
			}
			foreach ($_POST as $key=>$value)
			{
				$this->posts[$this->safe($key)]=$this->safe($value);
			}
			if (isset($_SESSION))
			{
				foreach ($_SESSION as $key=>$value)
				{
					$this->sessions[$this->safe($key)]=$this->safe($value);
				}
			}
			foreach ($_COOKIE as $key=>$value)
			{
				$this->cookies[$this->safe($key)]=$this->safe($value);
			}
			//TODO: $_FILES

			unset($key, $value);
		}
	}
?>
