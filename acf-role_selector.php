<?php
/*
Plugin Name: Advanced Custom Fields: User Role Selector
Plugin URI: https://github.com/danielpataki/acf-role_selector
Description: A field for Advanced Custom Fields which allows you to select a user role
Version: 1.0.0
Author: Daniel Pataki
Author URI: http://danielpataki.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


class acf_field_role_selector_plugin
{
	/*
	*  Construct
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	*/

	function __construct()
	{
		// set text domain
		/*
		$domain = 'acf-role_selector';
		$mofile = trailingslashit(dirname(__File__)) . 'lang/' . $domain . '-' . get_locale() . '.mo';
		load_textdomain( $domain, $mofile );
		*/

		add_action('acf/register_fields', array($this, 'register_fields'));

		// version 3-
		add_action('init', array( $this, 'init' ), 5);

	}

	/*
	*  Init
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	*/

	function init()
	{
		if(function_exists('register_field'))
		{
			register_field('acf_field_role_selector', dirname(__File__) . '/role_selector-v3.php');
		}
	}


	/*
	*  register_fields
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	*/

	function register_fields()
	{
		include_once('role_selector-v4.php');
	}

}

new acf_field_role_selector_plugin();

?>
