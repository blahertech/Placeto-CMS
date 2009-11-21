<?php
	/**
	*	Placeto CMS - Images
	*		Supports Images in the database and enables caching and other features.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto Mod - Images (C) BlaherTech - Benjamin Jay Young 2009
    *	Placeto Mods are released under the GNU GPL 3.0 which is free and open source.
	*	You may edit or distrubute any Placeto Mod at your own free will, with the proper accreditation.
	**/

	//are we on the right page?
	if (substr($location, 0, 8)==='/images/')
	{
		$file=substr($location, 8);

		//does the image exist in the db or template?
		if (mysql_fetch_array(mysql_query('SELECT * FROM '.$prefix.'mod_images WHERE image="'.$file.'"')))
		{
			//db, so we'll attach it
			$content=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'content WHERE page="/images"'));
			$location='/images';
			$dependent='1';
			$nf=false;
		}
		else
		{
			//not found
			unset($file);
		}
	}

	//image directory
	function ahobbler_images($sort, $way)
	{
		//sorting
		if ($sort='')
		{
			$sort='image';
		}
		if ($sort!=='image' && $sort!=='type' && $sort!=='size' && $sort!=='alt')
		{
			$sort='image';
		}

		//start table
		echo '<table><tr><th>Preview</th>';
		echo '<th><a href="/images?sort=image';
		$arrowd='&nbsp;<img src="/images/arrowdn.png" alt="" />';
		$arrowu='&nbsp;<img src="/images/arrowup.png" alt="" />';

		//name
		if ($sort==='image' && $_GET['way']!=="desc")
		{
			echo '&amp;way=desc';
		}
		echo '" rel="alternative" rev="alternative">Name';
		if ($sort==='image' && $way!=='desc')
		{
			echo $arrowd;
		}
		else if ($sort==='image')
		{
			echo $arrowu;
		}

		//size
		echo '</a></th><th><a href="/images?sort=size';
		if ($sort==='size' && $way!=='desc')
		{
			echo '&amp;way=desc';
		}
		echo '" rel="alternative" rev="alternative">Size';
		if ($sort==='size' && $way!=='desc')
		{
			echo $arrowd;
		}
		else if($sort==='size')
		{
			echo $arrowu;
		}

		//type
		echo '</a></th><th><a href="/images?sort=type';
		if ($sort==='type' && $way!=='desc')
		{
			echo '&amp;way=desc';
		}
		echo '" rel="alternative" rev="alternative">Type';
		if ($sort==='type' && $way!=='desc')
		{
			echo $arrowd;
		}
		else if ($sort==='type')
		{
			echo $arrowu;
		}
		echo '</a></th></tr>';
		unset($arrowu, $arrowd);

		//which way
		if ($way==='desc')
		{
			$wayl=" DESC";
		}
		$query=mysql_query('SELECT * FROM '.$prefix.'mod_images ORDER BY '.$sort.$wayl);
		unset($sort, $wayl, $way);

		//images
		while ($img=mysql_fetch_assoc($query))
		{
			echo '<tr><th><a href="/images/'.$img['image'].'"><img src="/images/'.$img['image'].'" class="icon" alt="'.$img['image'].'" /></a></th><td><a href="/images/'.$img['image'].'">'.$img['image'].'</a></td><td>';

			//figure out unit
			$sizetype=' B';
			if (($img['size']/1024)>=0.5)
			{
				$img['size']=$img['size']/1024;
				$sizetype=' KB';
			}
			if (($img['size']/1024)>=0.5)
			{
				$img['size']=$img['size']/1024;
				$sizetype=' MB';
			}
			if (($img['size']/1024)>=0.5)
			{
				$img['size']=$img['size']/1024;
				$sizetype=' GB';
			}
			
			$img['size']=round($img['size'], 2);
			echo $img['size'].$sizetype.'</td><td>'.$img['type'].'</td></tr>';
		}

		//bye
		echo "</table>\n";
		unset($img, $sizetype, $query);
	}

	//show a image from the db
	function ahobbler_images_show($file)
	{
		//fetch image
		$img=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'mod_images WHERE image="'.$file.'"'));
		//not found
		if ($img['content']==NULL)
		{
			//make sure it's not in the template
			global $config;
			$tmpfile='templates/'.$config['template'].'/images/'.$file;
			$base=str_ireplace('mods/images/index.php', '', __FILE__);
			
			//template reattach
			if (file_exists($base.$tmpfile))
			{
				//match
				$base='../';
				$_GET['url']='/images/'.$file;
				include('../index.php');
			}
			else
			{
				//still not found
				header('Content-Type: '.$config['type']);
				header('HTTP/1.0 404 Not Found');
				
				echo 'Image Not Found';
				die();
			}
			unset($base, $tmpfile, $config);
		}

		//meta data
		header('Content-type: '.$img['type']);
		//cach control
		if (date('d')!==1)
		{
			$expires=substr(date('r', mktime(date('G'), date('i'), date('s'), date('m'), date('d')-1, date('y')+1)), 0, 25);
		}
		else
		{
			$expires=substr(date('r', mktime(date('G'), date('i'), date('s'), date('m')-1, date('d')+28, date('y')+1)), 0, 25);
		}
		$etag=md5($file.gmdate('dmyHis', $img['lastmod']));
		header('Expires: '.$expires.' GMT');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s', $img['lastmod']).' GMT');
		header('Cache-Control: public, max-age=31536000');
		header('ETag: '.$etag);
		unset($expires, $etag);
		header('Vary: Accept-Encoding');

		//show image
		if (stristr($file, '.php'))
		{
			eval('?>'.$img['content']);
		}
		else
		{
			echo $img['content'];
		}

		//bye
		unset($img, $file);
		die();
	}
?>