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
	public $upload      = 'Add document';
	public $set         = 'Set as document';
	public $choose      = 'Choose document';
	public $change      = 'Change document';
	public $remove      = '';
	public $placeholder = 'Add document';

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

		$this->json['upload']      = $this->upload;
		$this->json['set']         = $this->set;
		$this->json['choose']      = $this->choose;
		$this->json['change']      = $this->change;
		$this->json['remove']      = $this->remove;
		$this->json['placeholder'] = $this->placeholder;

		$this->json['value'] = $this->get_value();

		$value = $this->get_value();
		//$file = $alt = '';
		$doc_mime = '';
		$doc_url  = '';
		$doc_icon = '';
		$doc_ext  = '';
		$doc_name = '';

		if ( $value ) {
			$doc_mime = get_post_mime_type( $value );
			//$doc_icon = wp_get_attachment_image_url( $value, $size = NULL, $icon = true );
			$doc_url  = wp_get_attachment_image_url( $value );
			$doc_icon = wp_mime_type_icon( $doc_mime );
			$doc_ext  = wp_check_filetype( get_attached_file( $value ) );
			//$doc_name = get_the_title( $value );
			$doc_name = wp_basename( get_attached_file( $value ) );
		}

		$this->json['doc_icon'] = $doc_icon ? esc_url( $doc_icon ) : '';
		$this->json['doc_name'] = $doc_name ? esc_attr( $doc_name ) : '';
		$this->json['doc_mime'] = $doc_mime ? esc_attr( $doc_mime ) : '';
		$this->json['doc_ext']  = $doc_ext ? $doc_ext['ext'] : '';
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

		<# if ( data.value ) { #>
			<div class="u-flex u-flex-wrap u-flex-jc u-flex-center doc-file-label has-file {{ data.doc_ext }} u-mb1">
				<div class="image-wrap butterbean-change-media">
					<img class="mime-icon" src="{{ data.doc_icon }}" alt="{{ data.doc_mime }}" />
				</div>
				<div class="butterbean-change-media u-p1">{{ data.doc_name }}</div>

				<div class="doc-actions u-flex u-flex-wrap u-flex-center">
					<div class="change-file doc-actions-icon u-mr1 butterbean-change-media" title="change">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="v-icon icon-edit"><path d="M3 17.25V21h3.75L17.807 9.942l-3.75-3.75L3 17.251zM20.708 7.043a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
					</div>
					<div class="remove-file u-mr1 doc-actions-icon butterbean-remove-media" title="remove">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="v-icon icon-remove"><path d="M22 4.014L19.986 2 12 9.986 4.014 2 2 4.014 9.986 12 2 19.986 4.014 22 12 14.014 19.986 22 22 19.986 14.014 12z"/></svg>
					</div>
				</div>
			</div>
		<# } else { #>
			<div class="doc-file-label butterbean-add-media u-flex u-flex-wrap u-flex-center u-flex-jc no-file u-mb1">
				<div class="add-file doc-actions-icon u-mr1">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="v-icon icon-add"><path d="M22 13.429h-8.571V22H10.57v-8.571H2V10.57h8.571V2h2.858v8.571H22v2.858z"/></svg>
				</div>
					{{ data.placeholder }}
			</div>
		<# } #>
	<?php
	}
}
