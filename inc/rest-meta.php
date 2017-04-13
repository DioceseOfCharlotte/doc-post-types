<?php
/**
 * Expose custom metadata to the wp-api.
 */

add_filter( 'rest_api_allowed_post_types', 'doc_jetpack_post_types');
add_action( 'rest_api_init', 'doc_add_to_rest' );
add_filter( 'gravityflow_webhook_args', 'doc_filter_gravityflow_webhook_args', 10, 3 );

function doc_jetpack_post_types( $allowed_post_types ) {
	$allowed_post_types = doc_posts_plugin()->cpt_names;

    return $allowed_post_types;
}

function doc_parish_rest_fields() {
	$fields = array(
		'doc_email',
		'doc_phone_number',
		'doc_fax',
		'doc_website',
		'doc_mass_schedule',
		'doc_street',
		'doc_city',
		'doc_state',
		'doc_zip',
	);
	return $fields;
}

function doc_register_parish_meta() {
	foreach ( doc_parish_rest_fields() as $field_name ) {
		register_meta( 'parish', $field_name, [ 'show_in_rest' => true ] );
	}
}
add_action( 'init', 'doc_register_parish_meta' );

function doc_add_to_rest() {
	foreach ( doc_parish_rest_fields() as $field_name ) {
		register_rest_field( 'parish', $field_name,
			array(
				'get_callback' => 'parish_get_field',
				'update_callback' => 'parish_update_field',
				'schema' => null,
			)
		);
	}
}

function parish_get_field( $data, $field_name ) {
	return get_post_meta( $data['id'], $field_name, true );
}

function parish_update_field( $value, $post, $field_name ) {
	if ( '' === $value ) {
		return;
	}
	$value = esc_html( $value );
	return update_post_meta( $post->ID, $field_name, wp_slash( $value ) );
}

// Allow the webhook to be modified before it's sent.
function doc_filter_gravityflow_webhook_args( $args, $entry, $current_step ) {

		$username = 'admin';
		$password = 'password';
		$args['headers'] = array(
			'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ),
		);

	return $args;
}




add_action( 'gform_admin_pre_render_19', 'add_merge_tags' );
function add_merge_tags( $form ) {
	?>
	<script type="text/javascript">
		gform.addFilter('gform_merge_tags', 'add_merge_tags');
		function add_merge_tags(mergeTags, elementId, hideAllFields, excludeFieldTypes, isPrepop, option){
			mergeTags["custom"].tags.push({ tag: '{post_meta:id=get(doc_pid)&meta_key=CUSTOM-FIELD}', label: 'Parish Meta' });

			return mergeTags;
		}
	</script>
	<?php
	// return the form object from the php hook
	return $form;
}









/**
 * Gravity Wiz // Gravity Forms // Advanced Merge Tags
 *
 * Adds support for several advanced merge tags:
 *   + post:id=xx&prop=xxx
 *       retrieve the desired property of the specified post (by ID)
 *   + post_meta:id=xx&meta_key=xxx
 *       retrieve the desired post meta value from the specified post and meta key
 *   + get() modifier
 *       retrieve the desired property from the query string ($_GET)
 *       Example: post_meta:id=get(xx)&meta_key=xxx
 *   + post() modifier
 *       retrieve the enclosed property from the $_POST
 *       Example: post_meta:id=post(xx)&meta_key=xxx
 *  + get:xxx
 *      retrieve property from query string
 *
 * Use Cases
 *
 *   + You have a multiple realtors each represented by their own WordPress page. On each page is a "Contact this Realtor"
 *       link. The user clicks the link and is directed to a contact form. Rather than creating a host of different
 *       contact forms for each realtor, you can use this snippet to populate a HTML field with a bit of text like:
 *       "You are contacting realtor Bob Smith" except instead of Bob Smith, you would use "{post:id=pid&prop=post_title}.
 *       In this example, "pid" would be passed via the query string from the contact link and "Bob Smith" would be the
 *       "post_title" of the post the user is coming from.
 *
 * @version 1.2
 * @author  David Smith <david@gravitywiz.com>
 * @license GPL-2.0+
 * @link    https://gravitywiz.com/
 *
 * Plugin Name: Gravity Forms Advanced Merge Tags
 * Plugin URI: https://gravitywiz.com
 * Description: Provides a host of new ways to work with Gravity Forms merge tags.
 * Version: 1.1
 * Author: Gravity Wiz
 * Author URI: https://gravitywiz.com/
 */
class GW_Advanced_Merge_Tags {

	/**
	 * @TODO:
	 *   - add support for validating based on the merge tag (to prevent values from being changed)
	 *   - add support for merge tags in dynamic population parameters
	 *   - add merge tag builder
	 */

	private $_args = null;

	public static $instance = null;

	public static function get_instance( $args ) {

		if ( null == self::$instance ) {
			self::$instance = new self( $args );
		}

		return self::$instance;
	}

	private function __construct( $args ) {

		if ( ! class_exists( 'GFForms' ) ) {
			return;
		}

		$this->_args = wp_parse_args( $args, array(
			'save_source_post_id' => false,
		) );

		add_action( 'gform_pre_render', array( $this, 'support_default_value_and_html_content_merge_tags' ) );
		add_action( 'gform_pre_render', array( $this, 'support_dynamic_population_merge_tags' ) );
		add_action( 'gform_replace_merge_tags',     array( $this, 'replace_merge_tags' ), 10, 3 );
		add_action( 'gform_pre_replace_merge_tags', array( $this, 'replace_get_variables' ), 10, 5 );

		if ( $this->_args['save_source_post_id'] ) {
			add_filter( 'gform_entry_created', array( $this, 'save_source_post_id' ), 10, 2 );
		}

	}

	public function support_default_value_and_html_content_merge_tags( $form ) {

		$current_page = max( 1, (int) rgars( GFFormDisplay::$submission, "{$form['id']}/page_number" ) );
		$fields = array();

		foreach ( $form['fields'] as &$field ) {

			// $default_value = rgar( $field, 'defaultValue' );
			// preg_match_all( '/{.+}/', $default_value, $matches, PREG_SET_ORDER );
			// if( ! empty( $matches ) ) {
			// if( rgar( $field, 'pageNumber' ) != $current_page ) {
			// $field['defaultValue'] = '';
			// } else {
			// $field['defaultValue'] = $this->replace_merge_tags( $default_value, $form, null );
			// }
			// }
			// only run 'content' filter for fields on the current page
			// if( rgar( $field, 'pageNumber' ) != $current_page )
			// continue;
			//
			// $html_content = rgar( $field, 'content' );
			// preg_match_all( '/{.+}/', $html_content, $matches, PREG_SET_ORDER );
			// if( ! empty( $matches ) )
			// $field['content'] = $this->replace_merge_tags( $html_content, $form, null );
		}

		return $form;
	}

	public function support_dynamic_population_merge_tags( $form ) {

		$filter_names = array();

		foreach ( $form['fields'] as &$field ) {

			if ( ! rgar( $field, 'allowsPrepopulate' ) ) {
				continue;
			}

			// complex fields store inputName in the "name" property of the inputs array
			if ( is_array( rgar( $field, 'inputs' ) ) && $field['type'] != 'checkbox' ) {
				foreach ( $field['inputs'] as $input ) {
					if ( rgar( $input, 'name' ) ) {
						$filter_names[] = array( 'type' => $field['type'], 'name' => rgar( $input, 'name' ) );
					}
				}
			} else {
				$filter_names[] = array( 'type' => $field['type'], 'name' => rgar( $field, 'inputName' ) );
			}
		}

		foreach ( $filter_names as $filter_name ) {

			// do standard GF prepop replace first...
			$filtered_name = GFCommon::replace_variables_prepopulate( $filter_name['name'] );

			// if default prepop doesn't find anything, do our advanced replace
			if ( $filter_name['name'] == $filtered_name ) {
				$filtered_name = $this->replace_merge_tags( $filter_name['name'], $form, null );
			}

			if ( $filter_name['name'] == $filtered_name ) {
				continue;
			}

			add_filter( "gform_field_value_{$filter_name['name']}", create_function( '', "return '$filtered_name';" ) );
		}

		return $form;
	}

	public function replace_merge_tags( $text, $form, $entry ) {

	    // at some point GF started passing a pre-submission generated entry, it will have a null ID
		if ( $entry['id'] == null ) {
			$entry = null;
		}

	    // matches {Label:#fieldId#}
	    // {Label:#fieldId#:#options#}
	    // {Custom:#options#}
		while ( preg_match_all( '/{(\w+)(:([\w&,=)(\-]+)){1,2}}/mi', $text, $matches, PREG_SET_ORDER ) ) {

			foreach ( $matches as $match ) {

				list( $tag, $type, $args_match, $args_str ) = array_pad( $match, 4, false );
				parse_str( $args_str, $args );

				$args = array_map( array( $this, 'check_for_value_modifiers' ), $args );
				$value = '';

				switch ( $type ) {
					case 'post':
						$value = $this->get_post_merge_tag_value( $args );
						break;
					case 'post_meta':
					case 'custom_field':
						$value = $this->get_post_meta_merge_tag_value( $args );
						break;
					case 'entry':
						$args['entry'] = $entry;
						$value = $this->get_entry_merge_tag_value( $args );
						break;
					case 'entry_meta':
						$args['entry'] = $entry;
						$value = $this->get_entry_meta_merge_tag_value( $args );
						break;
					case 'callback':
						$args['callback'] = array_shift( array_keys( $args ) );
						unset( $args[ $args['callback'] ] );
						$args['entry'] = $entry;
						$value = $this->get_callback_merge_tag_value( $args );
						break;
				}

				// @todo: figure out if/how to support values that are not strings
				if ( is_array( $value ) || is_object( $value ) ) {
					$value = '';
				}

				$text = str_replace( $tag, $value, $text );

			}// End foreach().

		}// End while().

		return $text;
	}

	public function save_source_post_id( $entry, $form ) {

		if ( is_singular() && ! rgget( 'gf_page' ) ) {
			$post_id = get_queried_object_id();
			gform_update_meta( $entry['id'], 'source_post_id', $post_id );
		}

	}

	public function check_for_value_modifiers( $text ) {

		// modifier regex (i.e. "get(value)")
		preg_match_all( '/([a-z]+)\(([a-z_\-]+)\)/mi', $text, $matches, PREG_SET_ORDER );
		if ( empty( $matches ) ) {
			return $text;
		}

		foreach ( $matches as $match ) {

			list( $tag, $type, $arg ) = array_pad( $match, 3, false );
			$value = '';

			switch ( $type ) {
				case 'get':
					$value = rgget( $arg );
				break;
				case 'post':
					$value = rgpost( $arg );
				break;
			}

			$text = str_replace( $tag, $value, $text );

		}

		return $text;
	}

	public function get_post_merge_tag_value( $args ) {

		extract( wp_parse_args( $args, array(
			'id' => false,
			'prop' => false,
		) ) );

		if ( ! $id || ! $prop ) {
			return '';
		}

		$post = get_post( $id );
		if ( ! $post ) {
			return '';
		}

		return isset( $post->$prop ) ? $post->$prop : '';
	}

	public function get_post_meta_merge_tag_value( $args ) {

		extract( wp_parse_args( $args, array(
			'id' => false,
			'meta_key' => false,
		) ) );

		if ( ! $id || ! $meta_key ) {
			return '';
		}

		$value = get_post_meta( $id, $meta_key, true );

		return $value;
	}

	public function get_entry_merge_tag_value( $args ) {

		extract( wp_parse_args( $args, array(
			'id' => false,
			'prop' => false,
			'entry' => false,
		) ) );

	    if ( ! $entry ) {

		    if ( ! $id ) {
			    $id = rgget( 'eid' );
		    }

		    if ( is_callable( 'gw_post_content_merge_tags' ) ) {
			    $id = gw_post_content_merge_tags()->maybe_decrypt_entry_id( $id );
		    }

		    $entry = GFAPI::get_entry( $id );

	    }

		if ( ! $prop ) {
	        $prop = key( $args );
		}

		if ( ! $entry || is_wp_error( $entry ) || ! $prop ) {
	        return '';
		}

		$value = rgar( $entry, $prop );

		return $value;
	}

	public function get_entry_meta_merge_tag_value( $args ) {

		extract( wp_parse_args( $args, array(
			'id' => false,
			'meta_key' => false,
			'entry' => false,
		) ) );

		if ( ! $id ) {
			if ( rgget( 'eid' ) ) {
				$id = rgget( 'eid' );
			} elseif ( isset( $entry['id'] ) ) {
				$id = $entry['id'];
			}
		}

		if ( ! $meta_key ) {
			$meta_key = key( $args );
		}

		if ( ! $id || ! $meta_key ) {
			return '';
		}

		if ( is_callable( 'gw_post_content_merge_tags' ) ) {
			$id = gw_post_content_merge_tags()->maybe_decrypt_entry_id( $id );
		}

		$value = gform_get_meta( $id, $meta_key );

		return $value;
	}

	public function get_callback_merge_tag_value( $args ) {

		$callback = $args['callback'];
		unset( $args['callback'] );

		extract( wp_parse_args( $args, array(
			'entry' => false,
		) ) );

		if ( ! is_callable( $callback ) ) {
			return '';
		}

		return call_user_func( $callback, $args );
	}

	/**
	 * Replace {get:xxx} merge tags. Thanks, Gravity View!
	 *
	 * @param       $text
	 * @param array $form
	 * @param array $entry
	 * @param bool  $url_encode
	 *
	 * @return mixed
	 */
	public function replace_get_variables( $text, $form, $entry, $url_encode, $esc_html, $get = null ) {

		if ( $get === null ) {
			$get = $_GET;
	    }

		preg_match_all( '/{get:(.*?)}/ism', $text, $matches, PREG_SET_ORDER );
		if ( empty( $matches ) ) {
			return $text;
		}

		foreach ( $matches as $match ) {

			list( $search, $property ) = $match;

			$value = stripslashes_deep( rgget( $property, $get ) );

			$glue  = gf_apply_filters( array( 'gpamt_get_glue', $property ), ', ', $property );
			$value = is_array( $value ) ? implode( $glue, $value ) : $value;
			$value = $url_encode ? urlencode( $value ) : $value;

			$esc_html = gf_apply_filters( array( 'gpamt_get_esc_html', $property ), $esc_html );
			$value    = $esc_html ? esc_html( $value ) : $value;

			$value = gf_apply_filters( array( 'gpamt_get_value', $property ), $value, $text, $form, $entry );

			$text = str_replace( $search, $value, $text );
		}

		return $text;
	}

}

function gw_advanced_merge_tags( $args = array() ) {
	return GW_Advanced_Merge_Tags::get_instance( $args );
}

gw_advanced_merge_tags( array(
	'save_source_post_id' => true,
) );
