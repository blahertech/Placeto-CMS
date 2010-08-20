To create a template, use the simple template and it's containing files as a guideline.

The following files are required for each template:

index.php - The default template theme.
data.php - A file that stores two main arrays, the first being info for the update system, the second being for any selectable theme files.

If you would like to include multiple themes in a template, just create another file and add it to the files array in data.php.

Remember, everything you put in the template folder (excluding anything in the data.php file array), will be reattached to the root of placeto. So if you have an /placeto/templates/your_temp/styles.css, it will show up virtually in /styles.css, if that template is selected.
