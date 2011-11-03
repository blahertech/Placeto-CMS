<?php
   /**
	*	Placeto CMS.
	*		A lightweight, easy to use PHP content management system. Written
	*		to be as fast as possible and to use as little memory as possible.
	*		Placeto provides browser caching, server caching, deflating, and
	*		gzip compression, if necessary to cut down on bandwidth and cpu
	*		usage.
	*
	*	PDO.
	*		A extended PDO class, made for the developers of Placeto.
	*
	*	@package placeto
	*	@subpackage pdo
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

   /**
	* The extended PDO class, we use in Placeto. Comes with added and simpler
    * functionallity.
	*
	* @version 1.2
	* @author Benjamin Jay Young <blaher@blahertech.org>
	*/
	class PPDO extends PDO // Stands for Placeto PDO or Prefixed PDO
	{
		public $bolStrictPrepend=true;
		private $aryFind, $aryReplace;

		public function __construct
		(
			$strDSN, $strUsername, $strPassword, $aryOptions=NULL, $strPrefix=''
		)
		{
			$this->strPrefix=$strPrefix;
			$this->aryFind=array
			(
				'~(FROM\s+)~',
				'~(INTO\s+)~',
				'~(JOIN\s+)~',
				'~(UPDATE\s+)~',
				'~(CREATE TABLE\s+)~',
				'~(DESCRIBE\s+)~'
			);
			$this->aryReplace=array
			(
				'$1'.$strPrefix,
				'$1'.$strPrefix,
				'$1'.$strPrefix,
				'$1'.$strPrefix,
				'$1'.$strPrefix,
				'$1'.$strPrefix
			);
			parent::__construct
			(
				$strDSN, $strUsername, $strPassword, $aryOptions
			);
		}

		protected function prefix($strQuery)
		{
			if ($this->strPrefix!=='')
			{
				$strQuery=str_replace
				(
					array(':prefix ', ':prefix'),
					array($this->strPrefix, $this->strPrefix),
					$strQuery
				);
				$strQuery=preg_replace
				(
					$this->aryFind, $this->aryReplace, $strQuery
				);
			}

			return $strQuery;
		}

		public function setPrefix($strPrefix='')
		{
			$this->strPrefix=$strPrefix;
			$this->aryReplace=array
			(
				'$1'.$strPrefix,
				'$1'.$strPrefix,
				'$1'.$strPrefix,
				'$1'.$strPrefix,
				'$1'.$strPrefix,
				'$1'.$strPrefix
			);

			return true;
		}

		public function prepare($strQuery)
		{
			return parent::prepare($this->prefix($strQuery));
		}

		public function execute($aryAppends)
		{
			if ($this->bolStrictPrepend!==false)
			{
				foreach ($aryAppends as $strAppend=>$strValue)
				{
					if (strpos($strAppend, ':')!==0)
					{
						$aryAppends[':'.$strAppend]=$strValue;
						unset($aryAppends[':'.$strAppend]);
					}
				}
			}
			return parent::execute();
		}

		public function fetch($intFetchStyle=PDO::FETCH_ASSOC)
		{
			return parent::fetch($intFetchStyle);
		}

		public function fetchAll($intFetchStyle=PDO::FETCH_ASSOC)
		{
			return parent::fetchAll($intFetchStyle);
		}
	}
?>
