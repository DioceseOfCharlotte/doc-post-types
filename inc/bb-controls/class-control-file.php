<?php

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
	 * Array of text labels to use for the media upload frame.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $l10n = array();

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
	public function __construct( $doc_manager, $name, $args = array() ) {
		parent::__construct( $doc_manager, $name, $args );

		$this->l10n = wp_parse_args(
			$this->l10n,
			array(
				'upload'      => esc_html__( 'Add file',         'butterbean' ),
				'set'         => esc_html__( 'Set as file',      'butterbean' ),
				'choose'      => esc_html__( 'Choose file',      'butterbean' ),
				'change'      => esc_html__( 'Change file',      'butterbean' ),
				'remove'      => esc_html__( 'Remove file',      'butterbean' ),
				'placeholder' => esc_html__( 'No file selected', 'butterbean' )
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

		wp_enqueue_script( 'media-views' );
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

		$value = $this->get_value();
		$image = $alt = '';

		if ( $value ) {
			$image = wp_get_attachment_image_src( absint( $value ), 'large' );
			$alt   = get_post_meta( absint( $value ), '_wp_attachment_image_alt', true );
		}

		$this->json['src'] = $image ? esc_url( $image[0] ) : '';
		$this->json['alt'] = $alt   ? esc_attr( $alt )     : '';
	}
}
