<?php
	/**
	*	Placeto CMS - GZip
	*		Compresses the page in Gzip format.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Copyright (C) 2009-2010 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	**/

	//for external files
	function placeto_gzip_extension($ext)
	{
		//list of supported file types
		$exts=array(
			'.css'=>TRUE,
			'.js'=>TRUE,
			'.htm'=>TRUE,
			'.html'=>TRUE,
			'.xhtml'=>TRUE,
			'.shtml'=>TRUE,
			'.xml'=>TRUE,
			'.txt'=>TRUE
		);
		if ($exts[$ext])
		{
			//yes
			unset($exts, $ext);
			return TRUE;
		}
		else
		{
			//no
			unset($exts, $ext);
			return FALSE;
		}
	}
	
	//check your footing before you continue
	$extension=strchr($location, '.');
	if (!$nf || placeto_gzip_extension($extension))
	{
		//check user support and ignore cache var
		if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') && $content['dynamic']!==1)
		{
			//zip it, zip it good
			$gztrue=true;
			ob_start('ob_gzhandler');
		}
	}
?>