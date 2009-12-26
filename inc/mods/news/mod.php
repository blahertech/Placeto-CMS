<?php
	/**
	*	Placeto CMS - News
	*		Provides a library of News functions, such as: News widget, News page, RSS and ATOM.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto Mod - News (C) BlaherTech - Benjamin Jay Young 2009
    *	Placeto Mods are released under the GNU GPL 3.0 which is free and open source.
	*	You may edit or distrubute any Placeto Mod at your own free will, with the proper accreditation.
	**/

	//are we on the right page?
	if (substr($location, 6, 4)=='item')
	{
		if (substr($location, 11)>0)
		{
			$npage=substr($location, 11);
		}
		else
		{
			$npage=substr($location, 11, strrchr($location, '/'));
		}

		$item=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'mod_news WHERE id='.$npage));
		unset($npage);
	}
	else if (substr($location, 0, 6)==='/news/' && (substr($location, 5, strrchr($location, '/'))>0 || substr($location, 6)>0))
	{
		if (substr($location, 6)>0)
		{
			$npage=substr($location, 6);
		}
		else
		{
			$npage=substr($location, 6, strrchr($location, '/'));
		}
	}
	else
	{
		if (isset($_GET['page']) && $_GET['page']>0)
		{
			$npage=$_GET['page'];
		}
		else
		{
			$npage=1;
		}
	}
	
	if (substr($location, 0, 6)==='/news/' && substr($location, 0, 9)!=='/news/rss' && substr($location, 0, 10)!=='/news/atom')
	{
		$content=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'content WHERE page="/news"'));
		$location='/news';
		
		if (isset($item))
		{
			$content['header']=$item['title'];
		}
	}

	//Shows a news preview widget
	function placeto_news_preview()
	{
		//fetch data from the db
		$newsrows=mysql_num_rows(mysql_query('SELECT * FROM '.$prefix.'mod_news'));
		for ($i=1; $i<=$newsrows; $i++)
		{
			$news[$i-1]=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'mod_news WHERE id='.$i));
		}
		$news=array_reverse($news);
		
		//echo out the news widget
		for ($i=0; isset($news[$i]) && $i<3; $i++)
		{
			if (isset($news[$i][title]))
			{
				echo '<h3><a href="/news#news-',$news[$i]['id'],'" rel="friend" rev="friend">',$news[$i]['title'],"</a></h3>\n";
			}
			echo '<p>',strip_tags(substr($news[$i]['content'], 0, stripos($news[$i]['content'], '. ', 100))),"...</p>\n";
			echo '<a href="/news#news-',$news[$i]['id'],'" class="right" rel="alternative" rev="index">[Read More]</a><br />',"\n";
			echo "<br />\n";
		}
	}

	//page function
	function placeto_news_page()
	{
		global $prefix, $npage, $item;

		$npage=floor($npage);
		if (isset($item))
		{
			echo '<p>',$item['content'],'</p>',"\n";
			unset($item);
		}
		else
		{
			$newsrows=mysql_num_rows(mysql_query('SELECT * FROM '.$prefix.'mod_news'));
	
			for ($i=1; $i<=$newsrows; $i++)
			{
				$news[$i-1]=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'mod_news WHERE id='.$i));
			}
			$news=array_reverse($news);
	
			$totalarts=count($news)-1;
			$plusrem=0;
			if (($totalarts%5)>=1)
			{
				$plusrem=1;
			}
			$totalpages=($totalarts-($totalarts%5))/5+$plusrem;
	
			if ($npage>$totalpages)
			{
				$npage=$totalpages;
			}
			$npage--;
	
			echo '<ul id="news">',"\n";
			for ($i=$npage*5; isset($news[$i]) && $i!=$npage*5+5; $i++)
			{
				if (isset($news[$i]['title']))
				{
					echo '<li><h2><a href="/news/item-',$news[$i]['id'],'/" id="news-',$news[$i]['id'],'">',$news[$i]['title'].'</a></h2></li>',"\n";
				}
				echo '<li>',$news[$i]["content"],'</li>',"\n";
				echo '<li class="date">',date('d M\, Y', strtotime($news[$i]['date'])),'</li>',"\n";
				echo '<br class="clear" />',"\n";
			}
			echo '</ul>',"\n";
			$npage++;
	
			echo '<div id="pages">'."\n";
			if ($npage!=1)
			{
				echo '<a href="/news/1">&lt;&lt;First</a>',"\n";
				echo '<a href="/news/',$npage-1,'">&lt;Previous</a>',"\n";
			}
			else
			{
				echo '<span>&lt;&lt;First</span>',"\n";
				echo '<span>&lt;Previous</span>',"\n";
			}
	
			if ($npage==$totalpages)
			{
				$pagen=$npage-4;
			}
			else if ($npage==($totalpages-1))
			{
				$pagen=$page-3;
			}
			else
			{
				$pagen=$mpage-2;
			}
	
			if ($pagen<=0)
			{
				$pagen=1;
			}
			for ($i=0, $n=0; ($i<5) && isset($news[$n]) && ($pagen<=$totalpages); $i++)
			{
				if ($pagen!=$npage)
				{
					echo '<a href="/news/',$pagen,'">',$pagen,'</a>',"\n";
				}
				else
				{
					echo '<span>',$pagen,'</span>',"\n";
				}
	
				$n+=5;
				$pagen++;
			}
	
			if ($npage!=$totalpages)
			{
				echo '<a href="/news/',$npage+1,'">Next&gt;</a>',"\n";
				echo '<a href="/news/',$totalpages,'">Last&gt;&gt;</a>',"\n";
			}
			else
			{
				echo '<span>Next&gt;</span>',"\n";
				echo '<span>Last&gt;&gt;</span>',"\n";
			}
			echo '</div>',"\n";
		}
	}

	//rss page
	function placeto_news_rss_page()
	{
		echo '<?xml version="1.0" encoding="utf-8" ?>',"\n";
		echo '<rss version="2.0">',"\n\n";
		echo '<channel>',"\n";

		global $prefix, $config;
		$page=mysql_fetch_assoc(mysql_query('SELECT * from '.$prefix.'content WHERE page="/news/rss"'));
		echo '	<title>',$page['title'],'</title>',"\n";
		echo '	<link>',$config['site'],'</link>',"\n";
		echo '	<description>',$page['desc'],'</description>',"\n\n";

		$newsrows=mysql_num_rows(mysql_query('SELECT * FROM '.$prefix.'mod_news'));
		for ($i=1; $i<=$newsrows; $i++)
		{
			$news[$i-1]=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'mod_news WHERE id='.$i));
		}
		$news=array_reverse($news);
		
		$i=0;
		foreach ($news as $nws)
		{
			$i++;
			echo '	<item>',"\n";
			echo '		<title>',$nws['title'],'</title>',"\n";
			echo '		<link>',$config['site'],$config['directory'],'news/item-',$nws['id'],'/</link>',"\n";
			echo '		<description>',strip_tags($nws['content']),'</description>',"\n";
			echo '	</item>',"\n\n";
		}

		echo '</channel>',"\n";
		echo '</rss>',"\n";
	}
	
	//atom page
	function placeto_news_atom_page()
	{
		echo '<?xml version="1.0" encoding="utf-8" ?>',"\n";
		echo '<feed xmlns="http://www.w3.org/2005/Atom">',"\n\n";

		global $prefix, $config;
		$newsrows=mysql_num_rows(mysql_query('SELECT * FROM '.$prefix.'mod_news'));
		for ($i=1; $i<=$newsrows; $i++)
		{
			$news[$i-1]=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'mod_news WHERE id='.$i));
		}
		$news=array_reverse($news);
		$page=mysql_fetch_assoc(mysql_query('SELECT * from '.$prefix.'content WHERE page="/news/rss"'));
		
		echo '	<title type="text">',$page['title'],'</title>',"\n";
		echo '	<updated>',$news[1]['date'],'</updated>',"\n";
		echo '	<link>',$config['site'],'</link>',"\n";
		echo '	<description>',$page['desc'],'</description>',"\n\n";
		echo '	<generator uri="http://www.blahertech.org/projects/placeto/">Placeto CMS</generator>',"\n\n";
		
		$i=0;
		foreach ($news as $nws)
		{
			$i++;
			echo '	<entry>',"\n";
			echo '		<title>',$nws['title'],'</title>',"\n";
			echo '		<link rel="alternate">',$config['site'],$config['directory'],'news/item-',$nws['id'],'/</link>',"\n";
			echo '		<content type="xhtml" xml:lang="en" xml:base="http://diveintomark.org/">',"\n";
			echo '			<div xmlns="http://www.w3.org/1999/xhtml">',"\n";
			echo '				<p>',$nws['content'],'</p>',"\n";
			echo '			</div>',"\n";
			echo '		</content>',"\n";
			echo '		<updated>',$nws['date'],'</updated>',"\n";
			echo '	</entry>',"\n\n";
		}

		echo '</feed>',"\n";
	}
?>