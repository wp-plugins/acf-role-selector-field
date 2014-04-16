=== Advanced Custom Fields: User Role Selector Field ===
Contributors: danielpataki
Requires at least: 3.4
Tested up to: 3.9
Stable tag: trunk
Tags: acf, custom fields
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A field for Advanced Custom Fields which allows you to select a user role

== Description ==

This plugin helps you out if you need to have the ability to select one or more user roles. Roles can be chosen with a select element (single or multiple choice), checkboxes or radio buttons. Roles can be returned as a role name or a role object.

= Compatibility =

This add-on will work with:

* version 4 and up
* version 3 and below

== Installation ==

This add-on can be treated as both a WP plugin and a theme include.

= Plugin =
1. Copy the 'acf-role_selector' folder into your plugins folder
2. Activate the plugin via the Plugins admin page

= Include =
1.	Copy the 'acf-role_selector' folder into your theme folder (can use sub folders). You can place the folder anywhere inside the 'wp-content' directory
2.	Edit your functions.php file and add the code below (Make sure the path is correct to include the acf-role_selector.php file)

`
add_action('acf/register_fields', 'my_register_fields');

function my_register_fields()
{
	include_once('acf-role_selector/acf-role_selector.php');
}
`

== Changelog ==

= 1.0 =
* Initial Release.
