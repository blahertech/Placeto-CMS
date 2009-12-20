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
	if (substr($location, 0, 6)==='/news/' && (substr($location, 5, strrchr($location, '/'))>0 || substr($location, 6)>0))
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
	
	if (substr($location, 0, 6)==='/news/')
	{
		$content=mysql_fetch_assoc(mysql_query('SELECT * FROM '.$prefix.'content WHERE page="/news"'));
		$location='/news';
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
				echo '<h3><a href="',$news[$i]['link'],'" rel="friend" rev="friend">',$news[$i]['title'],"</a></h3>\n";
			}
			echo '<p>',strip_tags(substr($news[$i]['content'], 0, stripos($news[$i]['content'], '. ', 100))),"...</p>\n";
			echo '<a href="/news#news-',$news[$i]['id'],'" class="right" rel="alternative" rev="index">[Read More]</a><br />',"\n";
			echo "<br />\n";
		}
	}

	//page function
	function placeto_news_page()
	{
		global $prefix, $npage;

		$npage=floor($npage);
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
				echo '<li><h2><a href="',$news[$i]['link'],'" id="news-',$news[$i]['id'],'">',$news[$i]['title'].'</a></h2></li>',"\n";
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
			echo '&lt;&lt;First',"\n";
			echo '&lt;Previous',"\n";
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
				echo $pagen,"\n";
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
			echo 'Next&gt;',"\n";
			echo 'Last&gt;&gt;',"\n";
		}
		echo '</div>',"\n";
	}
?>