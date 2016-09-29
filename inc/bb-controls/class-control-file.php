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
	 * Array of text labels to use for the media upload frame.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $l10n = array();

	/**
	 * Image size to display.  If the size isn't found for the image,
	 * the full size of the image will be output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $size = 'large';

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
	public function __construct( $manager, $name, $args = array() ) {
		parent::__construct( $manager, $name, $args );

		$this->l10n = wp_parse_args(
			$this->l10n,
			array(
			'upload'      => esc_html__( 'Add image',         'butterbean' ),
			'set'         => esc_html__( 'Set as image',      'butterbean' ),
			'choose'      => esc_html__( 'Choose image',      'butterbean' ),
			'change'      => esc_html__( 'Change image',      'butterbean' ),
			'remove'      => esc_html__( 'Remove image',      'butterbean' ),
			'placeholder' => esc_html__( 'No image selected', 'butterbean' ),
			)
		);
	}

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

		$this->json['l10n'] = $this->l10n;
		$this->json['size'] = $this->size;

		$value = $this->get_value();
		$image = $alt = '';

		if ( $value ) {
			$image = wp_get_attachment_image_src( absint( $value ), $this->size );
			$alt   = get_post_meta( absint( $value ), '_wp_attachment_image_alt', true );
		}

		$this->json['src'] = $image ? esc_url( $image[0] ) : '';
		$this->json['alt'] = $alt   ? esc_attr( $alt )     : '';
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
		<div class="butterbean-placeholder">{{ data.l10n.placeholder }}</div>
	<# } #>

	<p>
		<# if ( data.src ) { #>
			<button type="button" class="button button-secondary butterbean-change-media">{{ data.l10n.change }}</button>
			<button type="button" class="button button-secondary butterbean-remove-media">{{ data.l10n.remove }}</button>
		<# } else { #>
			<button type="button" class="button button-secondary butterbean-add-media">{{ data.l10n.upload }}</button>
		<# } #>
	</p>
	<?php
	}
}
