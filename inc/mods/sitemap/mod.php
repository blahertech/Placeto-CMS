<?php
	/**
	*	Placeto CMS - Sitemap
	*		Provides a visitor and xml sitemap
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto Mod - Sitemap (C) BlaherTech - Benjamin Jay Young 2009
    *	Placeto Mods are released under the GNU GPL 3.0 which is free and open source.
	*	You may edit or distrubute any Placeto Mod at your own free will, with the proper accreditation.
	**/

	//displays the sitemap page
	function placeto_sitemap_page()
	{
		global $prefix;
		
		//fetch the content pages
		$query=mysql_query('SELECT * FROM '.$prefix.'content WHERE dependent!=1 ORDER BY page');
		//order them in to an array
		while ($page=mysql_fetch_assoc($query))
		{
			$pages[$page['page']]=$page;
		}
		unset($page, $query);
		
		//recursion function
		function sitemap_loop(&$pages, $lca, &$upages)
		{
			//display the page
			echo '<li>','<strong><a href="',$lca,'">',$pages[$lca]['header'],'</a></strong> - ',$pages[$lca]['desc'];
			//make sure the page isn't displayed twice
			unset($upages[$lca]);
			
			//bit ops
			$s=0;
			$e=0;
			//loop through all the containing pages
			foreach ($pages as $page)
			{
				if ($lca!==$page['page'] && $lca===substr($page['page'], 0, strlen($lca)) && isset($upages[$page['page']]))
				{
					//start of the ul
					if ($s===0)
					{
						$s=1;
						echo '<ul>',"\n";
					}
					//recurse through the next frame
					sitemap_loop($pages, $page['page'], $upages);
				}
				else if ($s===1 && $e===0 && $lca!==$page['page'] && isset($upages[$page['page']]))
				{
					//end of the ul
					$e=1;
					echo '</ul>',"\n";
				}
			}
			
			//done wit dis one
			unset($s, $e, $page, $lca);
			echo '</li>';
		}
		
		//our main ul, the home page
		echo '<ul id="sitemap">',"\n";
		$upages=$pages;
		//let's begin the madness, shall we?
		sitemap_loop($pages, '/', $upages);
		unset($pages, $upages);
		echo '</ul></ul>',"\n";

		//that was unexpected
		unset($pages);
	}
	
	//displays the xml google sitemap page
	function placeto_sitemap_xml_page()
	{
		global $prefix, $config;
		
		//fetch the content pages
		$query=mysql_query('SELECT * FROM '.$prefix.'content ORDER BY page');
		//order them in to an array
		while ($page=mysql_fetch_assoc($query))
		{
			$pages[$page['page']]=$page;
		}
		unset($page, $query);
		
		//xml header
		echo '<?xml version="1.0" encoding="utf-8"?>',"\n";
		echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',"\n";

		
		foreach ($pages as $page)
		{
			echo '	<url>',"\n";
			echo '		<loc>',$config['site'],$config['directory'],substr($page['page'], 1),'</loc>',"\n";
			echo '		<lastmod>',substr($page['lastmod'], 0, 10),'</lastmod>',"\n";
			echo '	</url>',"\n";
		}
		
		//end xml doc
		echo '</urlset>';
	}
?>