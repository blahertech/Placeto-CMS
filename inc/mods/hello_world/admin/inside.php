<?php
	/**
	*	Placeto CMS - Hello_world Mod
	*		Provides a "Hello World" output and also demonstrates Placeto's mod protocal.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Placeto Mod - Hello_world (C) BlaherTech - Benjamin Jay Young 2009
    *	Placeto Mods are released under the GNU GPL 3.0 which is free and open source.
	*	You may edit or distrubute any Placeto Mod at your own free will, with the proper accreditation.
	*	
	*	//////////////////////////////////////////////////
	*
	*	admin/inside.php will be inserted within each individual page admin.
	**/
?>

<p>Hello World!</p>
<p>There isn't much you can do with the Hello World mod, it's just like a sdk example you can base your mod off of. It shows you all the features and standards you will use when writting a mod for placeto. However, here's a form as an example:</p>

<!-- No form tag is needed here -->

<?php
	if(isset($_POST['mod_hello_world']))
	{
		echo 'Looks like you submitted the form!<br />',"\n";
		
		$hello=$_POST['mod_hello_world_inputname'];
		str_replace("\n", '', $hello);
		echo $hello,'<br />',"\n";
		unset($hello);
	}
?>

<!-- try to follow this same naming scheme -->
<input name="mod_hello_world" type="hidden" value="true" />
<input name="mod_hello_world_inputname" type="text" value="Hello World!" />
<!-- NO Submit buttons! -->