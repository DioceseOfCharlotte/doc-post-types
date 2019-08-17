<?php
/**
 * Post parent control class.  This class is a specialty class meant for use in unique
 * scenarios where you're not using the core post parent drop-down.  This is often the
 * case with flat post types that have a parent post.  This control is not meant to be
 * used with a setting.  Core WP will store the data in the `post.post_parent` field.
 *
 * @package    ButterBean
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       https://github.com/justintadlock/butterbean
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Post parent control class.
 *
 * @since  1.0.0
 * @access public
 */
class ButterBean_Control_Doc_Parent extends ButterBean_Control {

	/**
	 * The type of control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'doc-parent';

	/**
	 * The post type to select posts from.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $post_type = '';

	/**
	 * Returns the HTML field name for the control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $setting
	 * @return array
	 */
	public function get_field_name( $setting = 'default' ) {

		return 'post_parent';
	}

	/**
	 * Get the value for the setting.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $setting
	 * @return mixed
	 */
	public function get_value( $setting = 'default' ) {

		return get_post( $this->manager->post_id )->post_parent;
	}

	/**
	 * Adds custom data to the json array. This data is passed to the Underscore template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		$_post = get_post( $this->manager->post_id );

		$posts = get_posts(
			array(
				'post_type'      => $this->post_type ? $this->post_type : get_post_type( $this->manager->post_id ),
				'post_status'    => 'any',
				'post__not_in'   => array( $this->manager->post_id ),
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'fields'         => array( 'ID', 'post_title' ),
			)
		);

		$this->json['choices'] = array(
			array(
				'value' => 0,
				'class' => '',
				'label' => '— Select —',
			),
		);

		foreach ( $posts as $post ) {
			$is_child = '';

			if ( 0 < absint( $post->post_parent ) ) {
				$is_child = true;
			}

			$this->json['choices'][] = array(
				'value' => $post->ID,
				'class' => $is_child,
				'label' => get_the_title( $post ),
			); }
	}

	public function get_template() {
		?>

<div class="form-wrap">

	<# if ( data.label ) { #>
		<label class="butterbean-label" for="{{ data.field_name }}">{{ data.label }}</label>
	<# } #>

	<select name="{{ data.field_name }}" id="{{ data.field_name }}">

		<# _.each( data.choices, function( choice ) { #>
			<option value="{{ choice.value }}" <# if ( choice.value === data.value ) { #> selected="selected" <# } #>> <# if ( choice.class ) { #>&nbsp;&nbsp;&nbsp;<# } #>{{ choice.label }}</option>
		<# } ) #>

	</select>

	<# if ( data.description ) { #>
		<span class="butterbean-description">{{{ data.description }}}</span>
	<# } #>

</div>
		<?php
	}
}
