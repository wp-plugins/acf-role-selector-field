<?php

class acf_field_role_selector extends acf_Field
{

	var $settings,
		$defaults;


	/*--------------------------------------------------------------------------------------
	*
	*	Constructor
	*	- This function is called when the field class is initalized on each page.
	*	- Here you can add filters / actions and setup any other functionality for your field
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	*
	*-------------------------------------------------------------------------------------*/

	function __construct($parent) {

	  	parent::__construct($parent);

	  	$this->name = 'role_selector';
	  	$this->title = __( 'User Role Selector', 'acf' );
		$this->defaults = array(
			'return_value' => 'name',
			'field_type'   => 'checkbox',
		);

		$this->settings = array(
			'path' => $this->helpers_get_path(__FILE__),
			'dir' => $this->helpers_get_dir(__FILE__),
			'version' => '1.0.0'
		);

  }


 /*
  *  helpers_get_path
  *
  *  @description: calculates the path (works for plugin / theme folders)
  *  @since: 3.6
  *  @created: 30/01/13
  */

  function helpers_get_path($file) {
    return trailingslashit(dirname($file));
  }


  /*
  *  helpers_get_dir
  *
  *  @description: calculates the directory (works for plugin / theme folders)
  *  @since: 3.6
  *  @created: 30/01/13
  */

  function helpers_get_dir($file)
  {
    $dir = trailingslashit(dirname($file));
    $count = 0;


    // sanitize for Win32 installs
    $dir = str_replace('\\', '/', $dir);


    // if file is in plugins folder
    $wp_plugin_dir = str_replace('\\', '/', WP_PLUGIN_DIR);
    $dir = str_replace($wp_plugin_dir, WP_PLUGIN_URL, $dir, $count);


    if($count < 1)
    {
      // if file is in wp-content folder
      $wp_content_dir = str_replace('\\', '/', WP_CONTENT_DIR);
      $dir = str_replace($wp_content_dir, WP_CONTENT_URL, $dir, $count);
    }


    if($count < 1)
    {
      // if file is in ??? folder
      $wp_dir = str_replace('\\', '/', ABSPATH);
      $dir = str_replace($wp_dir, site_url('/'), $dir);
    }

    return $dir;
  }


	/*--------------------------------------------------------------------------------------
	*
	*	create_options
	*	- this function is called from core/field_meta_box.php to create extra options
	*	for your field
	*
	*	@params
	*	- $key (int) - the $_POST obejct key required to save the options to the field
	*	- $field (array) - the field object
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	*
	*-------------------------------------------------------------------------------------*/

	function create_options($key, $field)
	{
		// defaults?
		$field = array_merge($this->defaults, $field);



		// Create Field Options HTML
		?>
			<tr class="field_option field_option_<?php echo $this->name; ?>">
				<td class="label">
					<label><?php _e( 'Return Format', 'acf' ); ?></label>
					<p class="description"><?php _e( 'Specify the returned value on front end', 'acf' ); ?></p>
				</td>
				<td>
					<?php

					do_action( 'acf/create_field', array(
						'type'    =>  'radio',
						'name'    =>  'fields[' . $key . '][return_value]',
						'value'   =>  $field['return_value'],
						'layout'  =>  'horizontal',
						'choices' =>  array(
							'name'   => __( 'Role Name', 'acf' ),
							'object' => __( 'Role Object', 'acf' ),
						)
					));

					?>
				</td>
			</tr>

			<tr class="field_option field_option_<?php echo $this->name; ?>">
				<td class="label">
					<label><?php _e( 'Field Type', 'acf' ); ?></label>
				</td>
				<td>
					<?php

					do_action('acf/create_field', array(
						'type'    =>  'select',
						'name'    =>  'fields[' . $key . '][field_type]',
						'value'   =>  $field['field_type'],
						'choices' => array(
							__( 'Multiple Values', 'acf' ) => array(
								'checkbox' => __( 'Checkbox', 'acf' ),
								'multi_select' => __( 'Multi Select', 'acf' )
							),
							__( 'Single Value', 'acf' ) => array(
								'radio' => __( 'Radio Buttons', 'acf' ),
								'select' => __( 'Select', 'acf' )
							)
						)
					));

					?>
				</td>
			</tr>
		<?php
	}


	/*--------------------------------------------------------------------------------------
	*
	*	create_field
	*	- this function is called on edit screens to produce the html for this field
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	*
	*-------------------------------------------------------------------------------------*/

	function create_field( $field )
	{
	    global $wp_roles;
	    $all_roles = $wp_roles->roles;

		$selected_roles = array();
		if( !empty( $field['value'] ) && $field['return_value'] == 'object' ) {
			foreach( $field['value'] as $value ) {
				$selected_roles[] = $value->name;
			}
		}
		else {
			$selected_roles = $field['value'];
		}


	    if( $field['field_type'] == 'select' || $field['field_type'] == 'multi_select' ) :
	    	$multiple = ( $field['field_type'] == 'multi_select' ) ? 'multiple="multiple"' : '';
		?>

			<select name='<?php echo $field['name'] ?>[]' <?php echo $multiple ?>>
				<?php
					foreach( $all_roles as $role => $data ) :
					$selected = ( in_array( $role, $selected_roles ) ) ? 'selected="selected"' : '';
				?>
					<option <?php echo $selected ?> value='<?php echo $role ?>'><?php echo $data['name'] ?></option>
				<?php endforeach; ?>

			</select>
		<?php
		elseif( $field['field_type'] == 'radio' ) :
			echo '<ul class="acf-radio-list radio vertical">';
			foreach( $all_roles as $role => $data ) :
				$checked = ( in_array( $role, $selected_roles ) ) ? 'checked="checked"' : '';
		?>
		<label><input <?php echo $checked ?> type="radio" name="<?php echo $field['name'] ?>" value="<?php echo $role ?>"><?php echo $data['name'] ?></label>
		<?php
			endforeach;
			echo '</ul>';
		else :
			echo '<ul class="acf-checkbox-list checkbox vertical">';
			foreach( $all_roles as $role => $data ) :
				$checked = ( in_array( $role, $selected_roles ) ) ? 'checked="checked"' : '';
		?>
			<li><label><input <?php echo $checked ?> type="checkbox" class="checkbox" name="<?php echo $field['name'] ?>[]" value="<?php echo $role ?>"><?php echo $data['name'] ?></label></li>
		<?php
			endforeach;
			echo '</ul>';
		endif;
	}


	/*--------------------------------------------------------------------------------------
	*
	*	get_value
	*	- called from the edit page to get the value of your field. This function is useful
	*	if your field needs to collect extra data for your create_field() function.
	*
	*	@params
	*	- $post_id (int) - the post ID which your value is attached to
	*	- $field (array) - the field object.
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	*
	*-------------------------------------------------------------------------------------*/

	function get_value($post_id, $field)
	{
		// Note: This function can be removed if not used

		// get value
		$value = parent::get_value($post_id, $field);

		if( $field['return_value'] == 'object' )
		{
			foreach( $value as $key => $name ) {
				$value[$key] = get_role( $name );
			}
		}
		return $value;

	}


	/*--------------------------------------------------------------------------------------
	*
	*	get_value_for_api
	*	- called from your template file when using the API functions (get_field, etc).
	*	This function is useful if your field needs to format the returned value
	*
	*	@params
	*	- $post_id (int) - the post ID which your value is attached to
	*	- $field (array) - the field object.
	*
	*	@author Elliot Condon
	*	@since 3.0.0
	*
	*-------------------------------------------------------------------------------------*/

	function get_value_for_api($post_id, $field)
	{
		// Note: This function can be removed if not used

		// get value
		$value = $this->get_value($post_id, $field);

		// format
		if( $field['return_value'] == 'object' )
		{
			foreach( $value as $key => $name ) {
				$value[$key] = get_role( $name );
			}
		}

		// return value
		return $value;

	}

}

?>