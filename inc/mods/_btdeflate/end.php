<?php
	/**
	*	Placeto CMS - BTDeflate
	*		Deflates your pages of unnessicary whitespace, before sending, to save on bandwidth and time.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto Mod - BTDeflate (C) BlaherTech - Benjamin Jay Young 2009
    *	Placeto Mods are released under the GNU GPL 3.0 which is free and open source.
	*	You may edit or distrubute any Placeto Mod at your own free will, with the proper accreditation.
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