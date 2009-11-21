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
		//'strings to be replace', 'replaced to',
		$replace=array(
			'	', '',
			'    ', '',
			'   ', '',
			'  ', ' ',
			' >', '>',
			'< ', '<',
			' <=', '<=',
			' ,', ',',
			': ', ':',
			' :', ':',
			' ;', ';',
			') ', ')',
			' )', ')',
			' (', '(',
			'( ', '(',
			' &&', '&&',
			'&& ', '&&',
			' ||', '||',
			'|| ', '||',
			' =', '=',
			'= ', '=',
			' !', '!',
			' +', '+',
			'+ ', '+',
			' *', '*',
			' /', '/',
			'/ ', '/',
			' {', '{',
			'{ ', '{',
			'} ', '}',
			' }', '}',
			"\n", ''
		);
	
		//fetch content
		$content=ob_get_contents();
		ob_clean();
	
		//go through array
		for ($i=0; $i<count($replace); $i+=2)
		{
			//go through content
			$content=str_replace($replace[$i], $replace[$i+1], $content);
		}
	
		//byes
		echo $content;
		unset($replace, $content, $i);
	}
?>