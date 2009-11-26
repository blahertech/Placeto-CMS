
--	Placeto Setup
--		This is the installation process portion of Placeto CMS.
--
--	Author: Benjamin Jay Young
--		http://www.blahertech.org/projects/placeto
--
--	This source code is released under the GPL License.
--
--	//////////////////////////////////////////////////
--
--	The SQL file to inject all of the structure and content.


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";;


-- content structure
CREATE TABLE IF NOT EXISTS `content`
(
	`page` text NOT NULL COMMENT 'Page location',
	`title` text COMMENT 'title tage',
	`desc` mediumtext COMMENT 'meta description',
	`keywords` mediumtext COMMENT 'meta keywords',
	`header` text COMMENT 'h1, usally',
	`content` longtext NOT NULL COMMENT 'page content',
	`dependent` tinyint(1) NOT NULL default '0' COMMENT '0 for dependent, 1 for independent and 2 for independent ONLY IF the param is set',
	`dependentparam` varchar(32) default NULL COMMENT 'Has to be an $_GET value',
	`igcache` tinyint(1) NOT NULL default '0' COMMENT 'Ignore cache or not to ignore, that is the question.',
	`lastmod` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT 'last modified'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

	-- content samples
INSERT INTO `content` (`page`, `title`, `desc`, `keywords`, `header`, `content`, `dependent`, `dependentparam`, `igcache`, `lastmod`) VALUES
	('/', 'Home Page', 'This is the home page', 'home, page', 'Welcome to your new Website!', 'Welcome to the Home page', 0, NULL, 0, NOW()),
	('/error', 'Page not found', 'This is the 40x error page', 'Page, Not Found, 404, Error, no result, search', 'Page Not Found:', 'This page was not found. Please go back.', 0, NULL, 0, NOW()),
	('/about', 'About Us', 'This is the about page', 'about, us', 'About Us', 'about us', 0, NULL, 0, NOW()),
	('/contact', 'Contact Us', 'This is the contact page', 'contact, us', 'Contact Us', 'contact', 0, NULL, 1, NOW()),
	('/images', 'Images', 'All the attached images can be found on this page.', 'image, svg, png, jpg, gif, bmp, grapic, directory', 'Image Directory', '<?php\r\n	if (isset($file))\r\n	{\r\n		ahobbler_images_show($file);\r\n	}\r\n	else\r\n	{\r\n		ahobbler_images($_GET[''sort''], $_GET[''way'']);\r\n	}\r\n?>', 2, 'file', 0, NOW());;
-- end content


-- prefs structre
CREATE TABLE IF NOT EXISTS `preferences`
(
	`name` varchar(32) NOT NULL default 'Site Name Here' COMMENT 'Site\'s Name',
	`owner` varchar(32) NOT NULL default 'The Owner of the Site Here' COMMENT 'Owner\'s Full name',
	`copyright` varchar(64) NOT NULL default 'Your Copyright Message Here' COMMENT 'Copyright message',
	`adminemail` varchar(32) NOT NULL default 'admin@test.com' COMMENT 'Admin\'s Email'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;
-- end prefs


-- mods structure
CREATE TABLE IF NOT EXISTS `mods`
(
	`name` varchar(64) NOT NULL COMMENT 'Name of mod',
	`enable` tinyint(1) NOT NULL COMMENT 'Should this be used?'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

-- mods samples
INSERT INTO `mods` (`name`, `enable`) VALUES
	('hello_world', 0),
	('images', 1),
	('breadcrumb', 1),
	('nav', 1),
	('news', 0),
	('cache', 1),
	('btdeflate', 1),
	('adns', 0),
	('gzip', 0);;

-- mods vars
CREATE TABLE IF NOT EXISTS `mods_vars`
(
	`mod` varchar(64) NOT NULL COMMENT 'Name of Mod',
	`name` varchar(64) NOT NULL COMMENT 'Name of var',
	`value` varchar(64) NOT NULL COMMENT 'Value of var'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;
-- end mods


-- mod_dns structure
CREATE TABLE IF NOT EXISTS `mod_dns`
(
	`subdomain` varchar(16) NOT NULL COMMENT 'subdomain to be redirected',
	`link` varchar(32) NOT NULL default '/' COMMENT 'URI only' COMMENT 'redirect link'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

-- mod_dns samples
INSERT INTO `mod_dns` (`subdomain`, `link`) VALUES
	('admin', '/admin'),
	('administrator', '/admin'),
	('home', '/');;
-- end mod_dns


-- mod_nav structure
CREATE TABLE IF NOT EXISTS `mod_nav`
(
	`id` int(11) NOT NULL COMMENT 'placement',
	`link` varchar(64) NOT NULL COMMENT 'link location',
	`title` text NOT NULL COMMENT 'title to displayed in navbar'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

-- mod_nav samples
INSERT INTO `mod_nav` (`id`, `link`, `title`) VALUES
	(0, '/', 'Home'),
	(1, '/about', 'About Us'),
	(2, '/help', 'Get Help'),
	(3, '/contact', 'Contact Us');;
-- end mod_nav


-- mod_breadcrumb structure
CREATE TABLE IF NOT EXISTS `mod_breadcrumb`
(
	`page` text NOT NULL COMMENT 'page location',
	`title` text NOT NULL COMMENT 'title to be displayed'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

-- mod_breadcrumb samples
INSERT INTO `mod_breadcrumb` (`page`, `title`) VALUES
	('/', 'Home'),
	('/about', 'About Us'),
	('/contact', 'Contact Us'),
	('/images', 'Images');;
-- end mod_breadcrumb


-- mod_images structure
CREATE TABLE IF NOT EXISTS `mod_images`
(
	`image` varchar(32) NOT NULL COMMENT 'image/file name',
	`content` blob NOT NULL COMMENT 'bindary content',
	`type` varchar(32) NOT NULL COMMENT 'mime type',
	`size` bigint(20) NOT NULL COMMENT 'file size',
	`lastmod` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT 'last modified'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;
-- end mod_images


-- mod_news structure
CREATE TABLE IF NOT EXISTS `mod_news`
(
	`id` tinyint(4) NOT NULL COMMENT 'placement record',
	`title` mediumtext COMMENT 'news title',
	`link` varchar(64) NOT NULL COMMENT 'link locations, external or internal',
	`content` longtext NOT NULL COMMENT 'news content',
	`date` date NOT NULL COMMENT 'date of news'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;
-- end mod_news