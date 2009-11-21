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

	function ahobbler_news_preview()
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
			echo '<p>',strip_tags(substr($news[$i]['content'], 0, stripos($news[$i]['content'], '. '))),"...</p>\n";
			echo '<a href="/news#news-',$news[$i]['id'],"\" class=\"readmore\" rel=\"alternative\" rev=\"index\">[Read More]</a><br />\n";
			echo "<br />\n";
		}
	}
?>