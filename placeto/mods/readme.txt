To create a mod, use the hello_world mod and it's containing files as a guideline.

If it's a mod that needs to be ran at runtime of request (such as anything that modifies header info), start the folder with a underscore "_".

The following must be contained in each mod folder:

*config.php - Any config settings you need your users to physically set.
data.php - A data array that contains info needed for the update system in the admin.
*end.php - If you need anything to run after the template, put it in here.
install.php - Anything you need to run at an install. If don't have anything, just echo "Done.". This file will be automatically deleted after install time.
mod.php - The actual core changes your mod will do. This will be ran when all mods are loaded at the beginning.
*prototype.php - If you have any functions that might be used in a template, in case they disable your mod, declare blank functions in this file.
uninstall.php - Make it clean up anything the install.php did. If nothing was installed, echo "Done.".

* - marks optional

When making a mod, you are free to use anything in the library resources.

A few guidelines to follow:

