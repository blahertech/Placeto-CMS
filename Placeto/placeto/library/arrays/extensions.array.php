<?php
   /**
	*	Placeto CMS.
	*		A lightweight, easy to use PHP content management system. Written
	*		to be as fast as possible and to use as little memory as possible.
	*		Placeto provides browser caching, server caching, deflating, and
	*		gzip compression, if necessary to cut down on bandwidth and cpu
	*		usage.
	*
	*	Arrays
    *		Muanally built arrays.
	*
	*	@package placeto
	*	@subpackage arrays
	*	@version 1.3
	*
	*	@author Benjamin Jay Young <blaher@blahertech.org>
	*	@link http://www.blahertech.org/projects/placeto/ Placeto CMS
	*	@link http://www.blahertech.org/ BlaherTech.org
	*	@license http://www.gnu.org/licenses/gpl.html GPL v3
	*	@copyright BlaherTech 2009-2011
	*
	*	This program is free software: you can redistribute it and/or modify it
	*	under the terms of the GNU General Public License as published by the
	*	Free Software Foundation, either version 3 of the License, or (at your
	*	option) any later version. This program is distributed in the hope that
	*	it will be useful,  but WITHOUT ANY WARRANTY; without even the implied
	*	warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See
	*	the GNU General Public License for more details. You should have
	*	received a copy of the GNU General Public License along with this
	*	program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*/

   /**
    * @name $aryExtensions
    * @global array $aryExtensions MIME type references of file extensions.
	*/
	$aryExtensions=array
	(
		'.css'=>'text/css',
		'.js'=>'text/javascript',
		'.png'=>'image/png',
		'.gif'=>'image/gif',
		'.jpg'=>'image/jpeg',
		'.jpeg'=>'image/jpeg', // use .jpg
		'.ico'=>'image/x-icon',
		'.tif'=>'image/tiff',
		'.tiff'=>'image/tiff', // use .tif
		'.dng'=>'image/x-dcraw',
		'.raw'=>'image/x-dcraw',
		'.svg'=>'image/svg+xml',
		'.htm'=>'text/html',
		'.html'=>'text/html',
		'.html4'=>'text/html', // use .htm
		'.html5'=>'text/html', // use .htm
		'.xhtml'=>'text/html', // use .htm
		'.xhtml2'=>'text/html', // use .htm
		'.xhtml5'=>'text/html', // use .htm
		'.shtml'=>'text/html', // use .htm
		'.xml'=>'text/xml',
		'.txt'=>'text/plain',
		'.xcf'=>'image/xcf',
		'.psd'=>'image/vnd.adobe.photoshop',
		'.swf'=>'application/x-shockwave-flash', // use html5/css3/jquery
		'.flv'=>'video/x-flv', // use html5/css3/jquery
		'.fla'=>'application/octet-stream', // use html5/css3/jquery
		'.tar'=>'application/x-tar',
		'.gz'=>'application/x-gzip',
		'.gzip'=>'application/x-gzip', // use .gz
		'.zip'=>'application/zip' // use gzip
	);
	//TODO: Add in video file support.
?>
