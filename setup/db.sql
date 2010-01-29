
--	Placeto Setup
--		This is the installation process portion of Placeto CMS.
--
--	Copyright (C) 2009 BlaherTech
--
--	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
--	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
--	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
--
--	Author: Benjamin Jay Young
--		http://www.blahertech.org/projects/placeto
--
--	//////////////////////////////////////////////////
--
--	The SQL file to inject all of the structure and content.


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";;


-- content structure
CREATE TABLE IF NOT EXISTS `content`
(
	`page` varchar(256) COLLATE latin1_general_ci NOT NULL COMMENT 'Page URI',
	`title` mediumtext CHARACTER SET utf8 COMMENT 'Browser page title',
	`desc` mediumtext CHARACTER SET utf8 COMMENT 'META description',
	`keywords` mediumtext CHARACTER SET utf8 COMMENT 'META keywords',
	`header` mediumtext CHARACTER SET utf8 COMMENT 'Page header',
	`content` longtext CHARACTER SET utf8 NOT NULL COMMENT 'Content',
	`dependent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for dependent, 1 for independent and 2 for independent ONLY IF the param is set',
	`dependentparam` varchar(32) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Has to be an $_GET value',
	`dynamic` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Ignore caching or not to ignore, that is the question.',
	`lastmod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last modification date',

	PRIMARY KEY (`page`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Content pages';;

-- content samples
INSERT INTO `content` (`page`, `title`, `desc`, `keywords`, `header`, `content`, `dependent`, `dependentparam`, `dynamic`, `lastmod`) VALUES
	('/', 'Home Page', 'This is the home page', 'home, page', 'Welcome to your new Website!', 'Welcome to the Home page', 0, NULL, 0, NOW()),
	('/error', 'Page not found', 'This is the 40x error page', 'Page, Not Found, 404, Error, no result, search', 'Page Not Found:', 'This page was not found. Please go back.', 0, NULL, 0, NOW()),
	('/about', 'About Us', 'This is the about page', 'about, us', 'About Us', 'about us', 0, NULL, 0, NOW()),
	('/contact', 'Contact Us', 'This is the contact page', 'contact, us', 'Contact Us', 'contact', 0, NULL, 1, NOW()),
	('/images', 'Images', 'All the attached images can be found on this page.', 'image, svg, png, jpg, gif, bmp, grapic, directory', 'Image Directory', '<?php\r\n	if (isset($file))\r\n	{\r\n		ahobbler_images_show($file);\r\n	}\r\n	else\r\n	{\r\n		ahobbler_images($_GET[''sort''], $_GET[''way'']);\r\n	}\r\n?>', 2, 'file', 0, NOW());;
-- end content


-- prefs structre
CREATE TABLE IF NOT EXISTS `preferences`
(
	`name` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT 'Site Name Here' COMMENT 'Website Name',
	`owner` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT 'The Owner of the Site Here' COMMENT 'Author',
	`copyright` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT 'Your Copyright Message Here' COMMENT 'Copyright statement',
	`adminemail` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT 'admin@test.com' COMMENT 'Web admin email',
	`template` varchar(256) COLLATE latin1_general_ci NOT NULL DEFAULT 'default' COMMENT 'Placeto Template'
) ENGINE=MEMORY DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Placeto Preferences';;
-- end prefs


-- mods structure

CREATE TABLE IF NOT EXISTS `mods`
(
	`name` varchar(64) COLLATE latin1_general_ci NOT NULL COMMENT 'Mod name',
	`enable` tinyint(1) NOT NULL COMMENT 'If the mod is enabled',

  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Placeto Mods';;

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
	`mod` varchar(64) COLLATE latin1_general_ci NOT NULL COMMENT 'Mod name',
	`name` varchar(64) COLLATE latin1_general_ci NOT NULL COMMENT 'Var name',
	`value` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT 'Var value',

	PRIMARY KEY (`mod`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Any unique vars for a Placeto Mod';;

ALTER TABLE `mods_vars`
	ADD CONSTRAINT `mods_vars_ibfk_1` FOREIGN KEY (`mod`) REFERENCES `mods` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;;
-- end mods


-- mod_dns structure
CREATE TABLE IF NOT EXISTS `mod_dns`
(
	`subdomain` varchar(16) COLLATE latin1_general_ci NOT NULL COMMENT 'Subdomain only (no dots)',
	`link` varchar(32) COLLATE latin1_general_ci NOT NULL DEFAULT '/' COMMENT 'link to page (URI only optional)',

	PRIMARY KEY (`subdomain`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Placeto DNS Mod';;

-- mod_dns samples
INSERT INTO `mod_dns` (`subdomain`, `link`) VALUES
	('admin', '/admin'),
	('administrator', '/admin'),
	('home', '/');;
-- end mod_dns


-- mod_nav structure
CREATE TABLE IF NOT EXISTS `mod_nav`
(
	`id` int(11) NOT NULL COMMENT 'Nav order',
	`link` varchar(64) COLLATE latin1_general_ci NOT NULL COMMENT 'link to page (URI only optional)',
	`title` varchar(256) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Replacing title',

	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Placeto Navigation Mod';;

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
	`page` varchar(64) COLLATE latin1_general_ci NOT NULL COMMENT 'Page URI',
	`title` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT 'Replacing title',

	PRIMARY KEY (`page`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Placeto Breadcrum Mod';;

ALTER TABLE `mod_breadcrumb`
	ADD CONSTRAINT `mod_breadcrumb_ibfk_1` FOREIGN KEY (`page`) REFERENCES `content` (`page`) ON DELETE CASCADE ON UPDATE CASCADE;;

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
	`image` varchar(32) COLLATE latin1_general_ci NOT NULL COMMENT 'Image name',
	`content` blob NOT NULL COMMENT 'Image binary content',
	`type` varchar(32) COLLATE latin1_general_ci NOT NULL COMMENT 'Mime type',
	`size` bigint(20) NOT NULL COMMENT 'File size',
	`lastmod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last modification date'
) ENGINE=ARCHIVE DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Placeto Image Mod';;
-- end mod_images


-- mod_news structure
CREATE TABLE IF NOT EXISTS `mod_news`
(
	`id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'News ID',
	`title` mediumtext CHARACTER SET utf8 COMMENT 'New headline',
	`content` longtext CHARACTER SET utf8 NOT NULL COMMENT 'News content',
	`date` date NOT NULL COMMENT 'Date submitted',

	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Placeto News Mod' AUTO_INCREMENT=1;;
-- end mod_news