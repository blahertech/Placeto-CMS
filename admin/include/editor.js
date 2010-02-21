/**
*	Placeto CMS - Admin
*		The Placeto CMS Administration application.
*
*	Copyright (C) 2009-2010 BlaherTech
*
*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
*
*	Author: Benjamin Jay Young
*		http://www.blahertech.org/projects/placeto/
*
*	//////////////////////////////////////////////////
*
*	Handles the intitalization of the two textarea editors and the switching events.
*/

function placeto_editor(menuobj)
{
	//get the objects
	var selectmenu=document.getElementById("editorsel");
	var chosenoption=menuobj.options[menuobj.selectedIndex];
	
	if (selch=='cke')
	{
		CKEDITOR.instances.cnt.destroy();
	}
	else if (selch=='ea')
	{
		eAL.toggle("cnt");
	}
	
	if (chosenoption.value=="wysiwyg")
	{
		CKEDITOR.replace('cnt');
		selch='cke';
	}
	else if (chosenoption.value=="source")
	{
		if (!eaint)
		{
			//turn on EditArea
			editAreaLoader.init
			({
				id: "cnt"	
				,width: "auto"
				,start_highlight: true
				,allow_resize: "both"
				,allow_toggle: true
				,word_wrap: true
				,language: "en"
				,syntax: "html"
				,plugins: "charmap"
				,charmap_default: "arrows"
			});
			
			//set for toggle
			eaint=true;
		}
		else
		{
			eAL.toggle("cnt");
		}
		selch='ea';
	}
	else
	{
		selch='none';
	}
}

//turn on CKEditor
CKEDITOR.config.protectedSource.push(/<\?[\s\S]*?\?>/g);
CKEDITOR.replace('cnt');
var selch='cke';

//set for EditArea for later
var eaint=false;