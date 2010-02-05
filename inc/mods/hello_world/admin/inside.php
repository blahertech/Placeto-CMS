<?php
	/**
	*	Placeto CMS - Hello_world Mod
	*		Provides a "Hello World" output and also demonstrates Placeto's mod protocal.
	*
	*	Author: Benjamin Jay Young
	*		http://www.blahertech.org/projects/placeto
	*
	*	Copyright (C) 2009-2010 BlaherTech
	*
	*	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	*	This program is distributed in the hope that it will be useful,  but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	*	You should have received a copy of the GNU General Public License along with this program, as license.txt.  If not, see <http://www.gnu.org/licenses/>.
	*	
	*	//////////////////////////////////////////////////
	*
	*	admin/inside.php will be inserted within each individual page admin.
	**/
?>

<p>
<?php
	//prints Hello World
	$mods_class->placeto_hello_world();
?>
</p>
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