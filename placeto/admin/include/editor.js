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
var editor=CKEDITOR.replace('cnt');
var selch='cke';

//set for EditArea for later
var eaint=false;