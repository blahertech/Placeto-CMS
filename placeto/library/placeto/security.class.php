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
		private $key, $salt;

		public function safe($strPhrase)
		{
			$strPhrase=str_replace('\r', '', $strPhrase);
			$strPhrase=str_replace('\n', '', $strPhrase);
			$strPhrase=str_replace('\t', '', $strPhrase);

			if (get_magic_quotes_gpc())
			{
				$strPhrase=stripslashes($strPhrase);
			}

			$strPhrase=htmlentities($strPhrase);
			$strPhrase=strip_tags($strPhrase);

			return $strPhrase;
		}

		public function  __construct($strKey=false, $strSalt=false)
		{
			if (!$strKey)
			{
				$this->key=sha1('placeto_key');
			}
			else
			{
				$this->key=sha1($strKey);
			}
			if (!$strSalt)
			{
				$this->salt=md5('placeto_salt');
			}
			else
			{
				$this->key=md5($strSalt);
			}

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

		public function safeHTML($strPhrase)
		{
			if (get_magic_quotes_gpc())
			{
				$strPhrase=stripslashes($strPhrase);
			}
			$strPhrase=htmlentities($strPhrase, ENT_QUOTES);

			return $strPhrase;
		}

		public function hash($strPhrase, $strSalt=false)
		{
			if (!$strSalt)
			{
				$strSalt=$this->salt;
			}
			$strSalt=md5(sha1($strSalt).$strSalt);

			return hash('sha256', $strSalt.$strPhrase);
		}

		public function encrypt($strPhrase, $strKey=false, $strSalt=false)
		{
			if (!$strSalt)
			{
				$strSalt=$this->salt;
			}
			else
			{
				$strSalt=md5($strSalt);
			}
			if (!$strKey)
			{
				$strKey=$this->key;
			}
			else
			{
				$strKey=sha1($strKey);
			}
			$strKey.=$strSalt; // What!?! Did he just do that??? Oh, yes he did!

			$strResult='';
			$strPhrase=$strSalt.$strPhrase;
			for($i=0; $i<strlen($strPhrase); $i++)
			{
				$strChar=substr($strPhrase, $i, 1);
				$strKeyChar=substr($strKey, ($i % strlen($strKey))-1, 1);
				$strResult.=chr(ord($strChar)+ord($strKeyChar));
			}

			unset($strPhrase, $i, $strChar, $strKeyChar);
			return base64_encode($strSalt.$strResult);
		}
		public function decrypt($strPhrase, $strKey=false, $strSalt=false)
		{
			if (!$strSalt)
			{
				$strSalt=$this->salt;
			}
			else
			{
				$strSalt=md5($strSalt);
			}
			if (!$strKey)
			{
				$strKey=$this->key;
			}
			else
			{
				$strKey=sha1($strKey);
			}
			$strKey.=$strSalt; // What!?! Did he just do that??? Oh, yes he did!

			$strResult='';
			$strPhrase=substr(base64_decode($strPhrase), strlen($strSalt));

			for($i=0; $i<strlen($strPhrase); $i++)
			{
				$strChar=substr($strPhrase, $i, 1);
				$strKeyChar=substr($strKey, ($i % strlen($strKey))-1, 1);
				$strResult.=chr(ord($strChar)-ord($strKeyChar));
			}

			$strResult=substr($strResult, strlen($strSalt));

			unset($strPhrase, $i, $strChar, $strKeyChar);
			return $strResult;
		}

		// encrypts, sends, stores in DB as AES. For personal information, like passwords, credit cards, addresses.
		// returns as encrypted, you can decrypt. If hashed, compare hashes.
		public function databaseSendSecure($strData, $bolEncrypt=true, $bolHash=false)
		{
			if ($bolHash)
			{
				$strData=$this->hash($strData);
			}
			if ($bolEncrypt)
			{
				$strData=$this->encrypt($strData);
			}

			return ' AES_ENCRYPT(\''.$strData.'\', \''.$this->key.'\') ';
		}

		// you still need to decrypt this
		public function databaseGetSecure($strField)
		{
			return ' AES_DECRYPT(\''.$strField.'\', \''.$this->key.'\') AS '.$strField.' ';
		}
	}
?>
