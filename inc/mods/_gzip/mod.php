<?php
	/**
	*	Placeto CMS - GZip
	*		Compresses the page in Gzip format.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto Mod - Gzip (C) BlaherTech - Benjamin Jay Young 2009
    *	Placeto Mods are released under the GNU GPL 3.0 which is free and open source.
	*	You may edit or distrubute any Placeto Mod at your own free will, with the proper accreditation.
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