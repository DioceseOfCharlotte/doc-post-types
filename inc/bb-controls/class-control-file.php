<?php
/**
 * File control class.
 */

if ( ! class_exists( 'ButterBean_Control' ) ) {
		return; }

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
	public $type = 'document';


	/**
	 * Creates a new control object.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $name
	 * @param  array   $args
	 * @return void
	 */
	public $upload = 'Add document';
	public $set = 'Set as document';
	public $choose = 'Choose document';
	public $change = 'Change document';
	public $remove = 'Remove document';
	public $placeholder = 'No document selected';

	/**
	 * Enqueue scripts/styles for the control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_media();
		wp_enqueue_script( 'bb-file' );
	}

	/**
	 * Adds custom data to the json array.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		$this->json['upload'] = $this->upload;
		$this->json['set'] = $this->set;
		$this->json['choose'] = $this->choose;
		$this->json['change'] = $this->change;
		$this->json['remove'] = $this->remove;
		$this->json['placeholder'] = $this->placeholder;

		$this->json['value'] = esc_html( $this->get_value() );

		$value = $this->get_value();
		// $image = $alt = '';

		if ( $value ) {
			$image = wp_get_attachment_image_src( absint( $value ) );
		}

		$this->json['src'] = $image ? esc_url( $image[0] ) : '';
	}

	public function get_template() {
	?>
	<# if ( data.label ) { #>
		<span class="butterbean-label">{{ data.label }}</span>
	<# } #>

	<# if ( data.description ) { #>
		<span class="butterbean-description">{{{ data.description }}}</span>
	<# } #>

	<input type="hidden" class="butterbean-attachment-id" name="{{ data.field_name }}" value="{{ data.value }}" />

	<# if ( data.src ) { #>
		<img class="butterbean-img" src="{{ data.src }}" alt="{{ data.alt }}" />
	<# } else { #>
		<div class="butterbean-placeholder">{{ data.placeholder }}</div>
	<# } #>

	<p>
		<# if ( data.src ) { #>
			<button type="button" class="button button-secondary butterbean-change-media">{{ data.change }}</button>
			<button type="button" class="button button-secondary butterbean-remove-media">{{ data.remove }}</button>
		<# } else { #>
			<button type="button" class="button button-secondary butterbean-add-media">{{ data.upload }}</button>
		<# } #>
	</p>
	<?php
	}
}
