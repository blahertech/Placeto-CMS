<?php
	/**
	*	Placeto CMS - BTDeflate
	*		Deflates your pages of unnessicary whitespace, before sending, to save on bandwidth and time.
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

	function placeto_btdeflate_ext($ext)
	{
		//list of supported file types
		$exts=array(
			'.css'=>TRUE,
			'.htm'=>TRUE,
			'.html'=>TRUE,
			'.shtml'=>TRUE,
			'.xhtml'=>TRUE,
			'.xml'=>TRUE
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

	global $nf, $location;
	$extension=strrchr($location, '.');

	//let's not destroy images
	if (!$nf || placeto_btdeflate_ext($extension))
	{
		//fetch content
		$content=ob_get_contents();
		ob_clean();
		
		//remove special characters
		$rps=array("\n", "\t", "\r", "\0", "\x0B");
		$content=str_replace($rps, ' ', $content);
		unset($rps);
	
		//find double spaces
		while (strstr($content, '  '))
		{
			//replace all double spaces
			$content=str_replace('  ', ' ', $content);
		}
	
		//byes
		echo $content;
		unset($content);
	}
?>