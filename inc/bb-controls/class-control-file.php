<?php
/**
 * File control class.
 */

/**
 * Image control class.
 *
 * @since  1.0.0
 * @access public
 */
class ButterBean_Control_File extends ButterBean_Control {

	/**
	 * The type of control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'file';

	/**
	 * Adds custom data to the json array. This data is passed to the Underscore template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();
		$this->json['value'] = $this->get_value();
	}

public function get_template() {
?>
	<p>
		<label>
			<span class="butterbean-label">{{ data.label }}</span>
			<input type="file" class="u-1of1" name="{{ data.field_name }}" value="{{ data.value }}">
		</label>
	</p>
<?php	}
}
